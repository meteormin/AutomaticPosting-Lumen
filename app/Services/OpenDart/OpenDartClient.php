<?php

namespace App\Services\OpenDart;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JsonMapper_Exception;
use ZipArchive;
use Illuminate\Filesystem\FilesystemAdapter;
use App\Data\DataTransferObjects\Acnt;
use App\Services\Libraries\Client;
use Illuminate\Support\Collection;
use App\Data\DataTransferObjects\CorpCode;
use Illuminate\Support\Facades\Storage;
use App\Data\DataTransferObjects\Paginator as SimplePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class OpenDartClient extends Client
{
    /**
     * disk
     *
     * @var FilesystemAdapter|Filesystem
     */
    protected $disk;

    /**
     * path
     *
     * @var string
     */
    protected string $path;

    /**
     * acnt object
     *
     * @var Acnt
     */
    protected Acnt $acnt;

    /**
     * corpCode object
     *
     * @var CorpCode $corpCode
     */
    protected CorpCode $corpCode;

    /**
     * @param Acnt $acnt
     * @param CorpCode $corpCode
     */
    public function __construct(Acnt $acnt, CorpCode $corpCode)
    {
        parent::__construct(config('opendart.host'));
        $this->path = 'opendart';
        $this->disk = Storage::disk('local');
        $this->acnt = $acnt;
        $this->corpCode = $corpCode;
    }

    /**
     * 회사 고유코드 xml -> json 저장
     *
     * @return bool
     */
    public function requestCorpCodes(): bool
    {
        $response = $this->response(
            Http::get($this->getHost() . config('opendart.method.corpCode.url'), [
                'crtfc_key' => config('opendart.api_key')
            ])
        );

        if (is_null($response)) {
            return $this->getError();
        }

        if (!$this->disk->exists($this->path)) {
            $this->disk->makeDirectory($this->path);
        }

        $this->disk->put($this->path . '/CORPCODE.zip', $response);

        $zip = new ZipArchive;
        $zip->open(storage_path('app/' . $this->path . '/CORPCODE.zip'));

        $zip->extractTo(storage_path('app/' . $this->path));
        $xml = simplexml_load_file(storage_path('app/' . $this->path . '/CORPCODE.xml'));

        return $this->disk->put($this->path . '/codes.json', json_encode($xml, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * 회사 고유 코드 가져오기
     * @param string|null $code
     * @return SimplePaginator|Collection|null
     * @throws JsonMapper_Exception|FileNotFoundException
     */
    public function getCorpCode(string $code = null)
    {
        if (!$this->disk->exists($this->path . '/codes.json')) {
            if (!$this->requestCorpCodes()) {
                return null;
            }
        }

        $json = $this->disk->get($this->path . '/codes.json');
        $jsonObject = json_decode($json);

        $list = collect();

        foreach ($jsonObject->list as $value) {
            if (!is_object($value->stock_code)) {
                if (is_null($code)) {
                    $list->add($value);
                } else if ($value->stock_code == $code) {
                    $list->add($value);
                }
            }
        }

        $dtos = $this->corpCode->mapList($list->all());

        if (!$dtos->isEmpty() && request()->has('page')) {
            $page = request()->get('page');
            $perPage = 15;

            $paginator = new Paginator($list->forPage($page, $perPage), $dtos->count(), $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'query' => request()->query()
            ]);

            return new SimplePaginator($paginator, $this->corpCode->newInstance(), 'corp_codes');
        }

        return $dtos;
    }

    /**
     * 단일 회사 주요 계정 가져오기
     *
     * @param string $corpCode
     * @param string $year
     * @param string $reportCode
     * @return array|Collection|string
     * @throws JsonMapper_Exception
     */
    public function getSingleAcnt(string $corpCode, string $year, string $reportCode = ReportCode::ALL)
    {
        $response = $this->response(
            Http::get($this->getHost() . config('opendart.method.SinglAcnt.url'), [
                'crtfc_key' => config('opendart.api_key'),
                'corp_code' => $corpCode,
                'bsns_year' => $year,
                'reprt_code' => $reportCode
            ])
        );

        if (is_null($response)) {
            return $this->getError();
        }

        return $this->acnt->mapList($response['list']);
    }

    /**
     * 다중 회사 주요 계정 가져오기
     *
     * @param string[] $corpCode
     * @param string $year
     * @param string $reportCode
     * @return Collection
     * @throws JsonMapper_Exception
     * @throws FileNotFoundException
     */
    public function getMultiAcnt(array $corpCode, string $year, string $reportCode = ReportCode::ALL): Collection
    {
        if (count($corpCode) == 0) {
            return collect();
        }

        ['acnts' => $acnts, 'corpCodes' => $corpCodes] = $this->get($corpCode, $year, $reportCode);

        if ($acnts->isNotEmpty() && $corpCodes->isEmpty()) {
            return $acnts;
        }

        $codeStr = implode(',', $corpCodes->all());

        $response = $this->response(
            Http::get($this->getHost() . config('opendart.method.MultiAcnt.url'), [
                'crtfc_key' => config('opendart.api_key'),
                'corp_code' => $codeStr,
                'bsns_year' => $year,
                'reprt_code' => $reportCode
            ])
        );

        Log::info(json_encode([
            'host'=>$this->getHost(),
            'parameter'=>[
                'crtfc_key' => config('opendart.api_key'),
                'corp_code' => $codeStr,
                'bsns_year' => $year,
                'reprt_code' => $reportCode
            ]
        ],JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        if (is_null($response)) {
            return collect(['error' => $this->getError()]);
        }

        $rsList = collect();

        if (!isset($response['list'])) {
            return collect(['error' => $response]);
        }

        $dtos = $this->acnt->mapList($response['list']);

        $dtos->each(function ($acnt) use (&$rsList) {
            if ($acnt instanceof Acnt) {
                if ($acnt->getFsDiv() == "CFS") { // 연결 재무재표만
                    if (!$rsList->has($acnt->getStockCode())) {
                        $rsList->put($acnt->getStockCode(), collect());
                    }

                    $rsList->get($acnt->getStockCode())->add($acnt);
                }
            }
        });

        $rsList->each(function (Acnt $acnt, $code) {
            $this->disk->put("opendart/acnts/{$code}.json", $acnt->toJson());
        });

        if ($acnts->isNotEmpty()) {
            $acnts->each(function (Collection $acnt,$code) use (&$rsList) {
                if (!$rsList->has($code)) {
                    $rsList->put($code,$acnt);
                }
            });
        }

        return $rsList;
    }

    /**
     * @param array $corpCodes
     * @param string $year
     * @param string $reportCode
     * @return array<Collection,Collection>
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function get(array $corpCodes, string $year, string $reportCode = ReportCode::ALL): array
    {
        $path = 'opendart/acnts';
        if (!$this->disk->exists($path)) {
            $this->disk->makeDirectory($path);
        }

        $acnts = collect();
        $reqCodes = collect();
        $list = $this->getCorpCode();

        /** @var Collection<CorpCode>|CorpCode[] $stockCodes */
        $stockCodes = $list->filter(function (CorpCode $item) use ($corpCodes) {
            return in_array($item->getCorpCode(), $corpCodes);
        });

        foreach ($stockCodes as $stockCode) {
            if ($this->disk->exists("{$path}/{$stockCode->getStockCode()}.json")) {
                $jsonObject = json_decode($this->disk->get("{$path}/{$stockCode->getStockCode()}.json"));
                $acnts->put($stockCode->getStockCode(), Acnt::newInstance()->mapList($jsonObject));
            } else {
                $corpCodes = $this->getCorpCode($stockCode->getStockCode());

                if (!is_null($corpCodes) && $corpCodes->isNotEmpty()) {
                    /** @var CorpCode $corpCode */
                    $corpCode = $corpCodes->first();
                    $reqCodes->add($corpCode->getCorpCode());
                }
            }
        }

        return [
            'acnts' => $acnts,
            'corpCodes' => $reqCodes
        ];
    }
}
