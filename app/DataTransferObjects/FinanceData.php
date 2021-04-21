<?php

namespace App\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use App\DataTransferObjects\Abstracts\Dynamic;

// 동적으로 속성을 관리
class FinanceData extends Dynamic
{
    /**
     * set 가능한 필드명 정의
     *
     * @var array
     */
    protected static array $fillable = ['date', 'current_assets', 'total_assets', 'floating_debt', 'total_debt', 'net_income', 'flow_rate', 'debt_rate'];

    /**
     * @var array
     */
    protected static array $mapTable;

    /**
     * Undocumented function
     *
     * @param array $mapTable
     *
     * @return void
     */
    public static function setMapTable(array $mapTable)
    {
        self::$mapTable = $mapTable;
    }

    /**
     * mapping
     *
     * @return array
     */
    public static function map($arrayAble)
    {
        if ($arrayAble instanceof Arrayable) {
            $arrayAble = $arrayAble->toArray();
        }

        $table = self::$mapTable;
        $rsList = collect();

        $current = (new static);
        $prev = (new static);
        $preprev = (new static);

        // 데이터는 기본적으로 {계정 명}:[당기, 전기, 전전기] 형식의 데이터로 구성되어 있음
        // 하지만 데이터가 항상 3기 모두 존재하지 않으므로 루프문으로 처리
        foreach ($arrayAble as $origin) {
            foreach ($table as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($origin[$key] == $v) {
                        // 당기
                        $current->setAttribute($k, $origin['thstrm_amount'] ?? null);
                        $current->setAttribute('date', $origin['thstrm_dt'] ?? null);

                        // 전기
                        $prev->setAttribute($k, $origin['frmtrm_amount'] ?? null);
                        $prev->setAttribute('date', $origin['frmtrm_dt'] ?? null);

                        // 전전기
                        $preprev->setAttribute($k, $origin['bfefrmtrm_amount'] ?? null);
                        $preprev->setAttribute('date', $origin['bfefrmtrm_dt'] ?? null);
                    }
                }

                $current->setFlowRate();
                $current->setDebtRate();

                $prev->setFlowRate();
                $prev->setDebtRate();

                $preprev->setFlowRate();
                $preprev->setDebtRate();
            }
        }

        $rsList->add($current->toArray());
        $rsList->add($prev->toArray());
        $rsList->add($preprev->toArray());

        return $rsList->toArray();
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    protected function setFlowRate()
    {
        $flowRate = $this->getAttribute('total_assets') / $this->getAttribute('floating_debt') * 100;
        return $this->setAttribute('flow_rate', $flowRate);
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    protected function setDebtRate()
    {
        $debtRate = ($this->getAttribute('total_dept') / $this->getAttribute('total_assets')) * 100;
        return $this->setAttribute('debt_rate', $debtRate);
    }
}
