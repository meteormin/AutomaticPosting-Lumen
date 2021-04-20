<?php

namespace App\Services\OpenDart;

use ZipArchive;
use Illuminate\Support\Arr;
use App\DataTransferObjects\Acnt;
use App\Services\Libraries\Client;
use Illuminate\Support\Collection;
use App\DataTransferObjects\CorpCode;
use App\DataTransferObjects\Utils\Dtos;
use Illuminate\Support\Facades\Storage;
use App\DataTransferObjects\Paginator as SimplePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class OpenDartClient
{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    protected $client;

    /**
     * disk
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * path
     *
     * @var string
     */
    protected $path;

    /**
     * acnt entity
     *
     * @var Acnt
     */
    protected $acnt;

    /**
     * corpCode entity
     *
     * @var CorpCode $corpCode
     */
    protected $corpCode;

    /**
     * @param Client $client
     * @param Acnt $acnt
     * @param CorpCode $corpCode
     */
    public function __construct(Client $client, Acnt $acnt, CorpCode $corpCode)
    {
        $this->client = $client->setHost(config('opendart.host'));
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
    public function requestCorpCodes()
    {
        $response = $this->client->get(config('opendart.method.corpCode.url') . '?crtfc_key=' . config('opendart.api_key'));
        if (is_null($response)) {
            return $this->client->getError();
        }

        $this->disk->put($this->path . '/CORPCODE.zip', $response);

        $zip = new ZipArchive;
        $zip->open(storage_path('app/' . $this->path . '/CORPCODE.zip'));
        $zip->extractTo(storage_path('app/' . $this->path));
        $xml = simplexml_load_file(storage_path('app/' . $this->path . '/CORPCODE.xml'));

        return Storage::disk('local')->put($this->path . '/codes.json', json_encode($xml, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 회사 고유 코드 가져오기
     * @param string|null $code
     * @return Collection|Paginator
     */
    public function getCorpCode(string $code = null)
    {
        $json = '';

        if (!$this->disk->exists($this->path . '/codes.json')) {
            if ($this->requestCorpCodes()) {
                $json = $this->disk->get($this->path . '/codes.json');
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

            $paginator = new Paginator($list->forPage($page, $perPage), count($dtos), $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'query' => request()->query()
            ]);

            $simplePaginator = new SimplePaginator($paginator, 'corp_codes', $this->corpCode->newInstance());

            return $simplePaginator;
        }

        return $list;
    }

    /**
     * 단일 회사 주요 계정 가져오기
     *
     * @param string $corpCode
     * @param string $year
     * @param string $reprtCode
     * @return Dtos|Acnt[]
     */
    public function getSinglAcnt(string $corpCode, string $year, string $reprtCdoe = '11011')
    {
        $query = Arr::query([
            'crtfc_key' => config('opendart.api_key'),
            'corp_code' => $corpCode,
            'bsns_year' => $year,
            'reprt_code' => $reprtCdoe
        ]);

        $response = $this->client->get(config('opendart.method.SinglAcnt.url') . '?' . $query);

        if (is_null($response)) {
            return $this->client->getError();
        }

        return $this->acnt->mapList($response['list']);
    }

    /**
     * 다중 회사 주요 계정 가져오기
     *
     * @param string[] $corpCode
     * @param string $year
     * @param string $reprtCode
     * @return Collection
     */
    public function getMultiAcnt(array $corpCode, string $year, string $reprtCode = '11011')
    {
        $codeStr = implode(',', $corpCode);

        $response = $this->client->get(config('opendart.method.MultiAcnt.url'), [
            'crtfc_key' => config('opendart.api_key'),
            'corp_code' => $codeStr,
            'bsns_year' => $year,
            'reprt_code' => $reprtCode
        ]);

        if (is_null($response)) {
            return $this->client->getError();
        }

        $dtos = $this->acnt->mapList($response['list']);

        $rsList = collect();

        $dtos->each(function ($acnt) use (&$rsList) {
            if ($acnt instanceof Acnt) {
                if (!$rsList->has($acnt->getStockCode())) {
                    $rsList->put($acnt->getStockCode(), new Dtos());
                }

                $rsList->get($acnt->getStockCode())->add($acnt);
            }
        });

        return $rsList;
    }
}
