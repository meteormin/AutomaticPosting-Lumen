<?php

namespace App\Services\OpenDart;

use ZipArchive;
use App\Entities\AcntEntity;
use App\Entities\CorpCodeEntity;
use App\Services\Libraries\Client;
use App\Entities\Utils\Entities;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class OpenDartClient
{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client(config('opendart.host'));
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

        Storage::disk('local')->put('opendart/CORPCODE.zip', $response);

        $zip = new ZipArchive;
        $zip->open(storage_path('app/opendart/CORPCODE.zip'));
        $zip->extractTo(storage_path('app/opendart/'));
        $xml = simplexml_load_file(storage_path('app/opendart/CORPCODE.xml'));

        return Storage::disk('local')->put('opendart/codes.json', json_encode($xml, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 회사 고유 코드 가져오기
     * @param string|null $code
     * @return Entities
     */
    public function getCorpCode(string $code = null)
    {
        $json = '';

        if (!Storage::disk('local')->exists('opendart/codes.json')) {
            if ($this->requestCorpCodes()) {
                $json = Storage::disk('local')->get('opendart/codes.json');
            }
        }

        $json = Storage::disk('local')->get('opendart/codes.json');
        $jsonObject = json_decode($json);

        $list = [];
        $corpCode = new CorpCodeEntity;
        $entities = $corpCode->mapList($jsonObject->list);

        $list = $entities->filter(function ($item) use ($code) {
            if ($item instanceof CorpCodeEntity) {
                if (!is_object($item->getStockCode())) {
                    if (is_null($code)) {
                        return true;
                    }

                    if ($code == $item->getCorpCode()) {
                        return true;
                    }
                }
            }

            return false;
        })->values();

        return $list;
    }

    /**
     * 단일 회사 주요 계정 가져오기
     *
     * @param integer $corpCode
     *
     * @return AcntEntity
     */
    public function getSinglAcnt(string $corpCode)
    {
        $query = Arr::query([
            'crtfc_key' => config('opendart.api_key'),
            'corp_code' => $corpCode,
            'bsns_year' => '2020',
            'reprt_code' => '11011'
        ]);

        $response = $this->client->get(config('opendart.method.SinglAcnt.url') . '?' . $query);

        if (is_null($response)) {
            return $this->client->getError();
        }

        return (new AcntEntity)->mapList($response['list']);
    }

    /**
     * 다중 회사 주요 계정 가져오기
     *
     * @param integer[] $corpCode
     *
     * @return Entities|AcntEntity[]
     */
    public function getMultiAcnt(array $corpCode)
    {
        $codeStr = implode(',', $corpCode);

        $response = $this->client->get(config('opendart.method.MultiAcnt.url'), [
            'crtfc_key' => config('opendart.api_key'),
            'corp_code' => $codeStr
        ]);

        if (is_null($response)) {
            return $this->client->getError();
        }

        return (new AcntEntity)->mapList($response);
    }
}
