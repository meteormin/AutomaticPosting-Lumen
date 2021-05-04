<?php

namespace App\Services\Kiwoom;

use App\Services\Service;
use App\Response\ErrorCode;
use Illuminate\Support\Collection;

class KoaService extends Service
{
    /**
     * Undocumented variable
     *
     * @var Stocks
     */
    protected $module;

    public function __construct(Stocks $module)
    {
        $this->module = $module;
    }

    /**
     * Undocumented function
     * @param string $name
     * @param Collection $stocks
     *
     * @return Collection
     */
    public function storeStock(string $name, Collection $stocks)
    {
        $rs = collect();

        $stocks->each(function ($item) use ($name, &$rs) {
            $rs->add($this->module->put($name, $item));
        });

        if ($rs->count() == 0) {
            $this->throw(ErrorCode::CONFLICT, '섹터 별 주가정보 저장 실패, ' . $stocks->get('stock_code'));
        }

        return $rs;
    }

    /**
     *
     * @param string $name
     * @param array $codes
     *
     * @return Collection
     */
    public function showStock(string $name, array $codes = null)
    {
        if (empty($codes)) {
            return $this->module->get($name);
        }

        $rs = collect();
        foreach ($codes as $code) {
            $rs->add($this->module->get($name, $code)->first());
        }

        return $rs;
    }

    /**
     * Undocumented function
     *
     * @param string $sector
     *
     * @return collection
     */
    public function showBySector(string $sector)
    {
        $rs = $this->module->getBySector($sector);
        if (is_null($rs)) {
            $this->throw(ErrorCode::RESOURCE_NOT_FOUND, 'not found sector: ' . $sector);
        }

        return $rs;
    }

    /**
     * Undocumented function
     *
     * @param string $theme
     *
     * @return collection
     */
    public function showByTheme(string $theme)
    {
        $rs = $this->module->getByTheme($theme);
        if (is_null($rs)) {
            $this->throw(ErrorCode::RESOURCE_NOT_FOUND, 'not found theme: ' . $theme);
        }

        return $rs;
    }

    public function storeThemes(?array $data)
    {
        if (is_null($data)) {
            $this->throw(ErrorCode::VALIDATION_FAIL, ['data' => ['data는 필수항목입니다.']]);
        }

        $file = 'config/themes.php';

        $contents = "<?php\nreturn [\n";

        foreach ($data as $key => $value) {
            $contents .= "\t[";
            foreach ($value as $k => $v) {
                $contents .= "'{$k}' => '{$v}', ";
            }
            $contents .= "],\n";
        }

        $contents .= "];";

        return file_put_contents(base_path($file), $contents);
    }
}
