<?php

namespace App\Services\OpenDart;

use ZipArchive;
use App\Entities\AcntEntity;
use App\Entities\CorpCodeEntity;
use App\Services\Libraries\Client;
use App\Entities\Abstracts\Entities;
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
     * 회사 고유 코드 가져오기
     *
     * @return Entities
     */
    public function getCorpCode()
    {
        $response = $this->client->get(config('opendart.method.corpCode.url'), ['crtfc_key' => config('opendart.api_key')]);
        if (is_null($response)) {
            return $this->client->getError();
        }

        Storage::disk('local')->put('opendart/', $response);

        $zip = new ZipArchive;
        $zip->open($response);
        $zip->extractTo(storage_path('app/opendart/'));
        $xml = simplexml_load_file(storage_path('app/opendart/CORPCODE.xml'));

        $list = [];
        foreach ($xml->children() as $corp) {
            if (!empty($corp->stock_code)) {
                $corpCode = new CorpCodeEntity;
                $corpCode->map($corp);
                $list[] = $corpCode;
            }
        }

        return (new Entities($list))->filter(function ($item) {
            if ($item instanceof CorpCodeEntity) {
                return !is_null($item->getStockCode());
            }
        });
    }

    /**
     * 단일 회사 주요 계정 가져오기
     *
     * @param integer $corpCode
     *
     * @return AcntEntity
     */
    public function getSinglAcnt(int $corpCode)
    {
        $response = $this->client->get(config('opendart.method.SinglAcnt.url'), [
            'crtfc_key' => config('opendart.api_key'),
            'corp_code' => $corpCode
        ]);

        if (is_null($response)) {
            return $this->client->getError();
        }

        $response;

        return (new AcntEntity)->map($response);
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