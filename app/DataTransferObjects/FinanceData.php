<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Collection;
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
    protected array $fillable = [
        'date', 'current_assets', 'total_assets', 'floating_debt', 'total_debt', 'net_income', 'flow_rate', 'debt_rate'
    ];

    /**
     * set MapTable
     * account_nm의 값이 [유동자산,자산총계,유동부채,부채총계,당기순이익]인, 객체를
     * 필요한 값만 뽑아, 객체가 아닌 하나의 속성(필드)로 재구성
     *
     * @var array
     */
    protected array $mapTable = [
        'account_nm' => [
            'current_assets' => '유동자산',
            'total_assets' => '자산총계',
            'floating_debt' => '유동부채',
            'total_debt' => '부채총계',
            'net_income' => '당기순이익'
        ]
    ];

    /**
     * Undocumented function
     *
     * @param array $mapTable
     *
     * @return void
     */
    public function setMapTable(array $mapTable)
    {
        $this->mapTable = $mapTable;
        return $this;
    }

    public function getMapTable()
    {
        return $this->mapTable;
    }

    /**
     * mapping
     *
     * @return Collection
     */
    public static function map($arrayAble)
    {
        if ($arrayAble instanceof Arrayable) {
            $arrayAble = $arrayAble->toArray();
        }

        $current = (new static);
        $table = $current->getMapTable();

        $prev = (new static);
        $preprev = (new static);

        // 데이터는 기본적으로 {계정 명}:[당기, 전기, 전전기] 형식의 데이터로 구성되어 있음
        // 하지만 데이터가 항상 3기 모두 존재하지 않으므로 루프문으로 처리
        foreach ($arrayAble as $origin) {
            foreach ($table as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($origin[$key] == $v) {
                        // 당기
                        $currentPrice = preg_replace('/[^0-9]/', '', $origin['thstrm_amount'] ?? null);

                        $current->setAttribute($k, $currentPrice ? (int)$currentPrice : null);
                        $current->setAttribute('date', $origin['thstrm_dt'] ?? null);

                        // 전기
                        $prevPrice = preg_replace('/[^0-9]/', '', $origin['frmtrm_amount'] ?? null);

                        $prev->setAttribute($k, $prevPrice ? (int)$prevPrice : null);
                        $prev->setAttribute('date', $origin['frmtrm_dt'] ?? null);

                        // 전전기
                        $preprevPrice = preg_replace('/[^0-9]/', '', $origin['bfefrmtrm_amount'] ?? null);

                        $preprev->setAttribute($k, $preprevPrice ? (int)$preprevPrice : null);
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

        $rsList = collect();

        if (!empty($current->toArray())) {
            $rsList->add($current);
        }

        if (!empty($prev->toArray())) {
            $rsList->add($prev);
        }

        if (!empty($preprev->toArray())) {
            $rsList->add($preprev);
        }

        return $rsList;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    protected function setFlowRate()
    {
        $currentAssets = $this->getAttribute('current_assets');
        $floatingDebt = $this->getAttribute('floating_debt');
        if (is_numeric($currentAssets) && is_numeric($floatingDebt)) {
            $flowRate = (int)($currentAssets / $floatingDebt * 100);
        }
        return $this->setAttribute('flow_rate', $flowRate ?? '');
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    protected function setDebtRate()
    {
        $totalDebt = $this->getAttribute('total_debt');
        $totalAssets = $this->getAttribute('total_assets');
        if (is_numeric($totalDebt) && is_numeric($totalAssets)) {
            $debtRate = (int)($totalDebt / $totalAssets * 100);
        }

        return $this->setAttribute('debt_rate', $debtRate ?? '');
    }

    public function toArray(bool $allowNull = true): ?array
    {
        return parent::toArray($allowNull);
    }
}
