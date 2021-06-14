<?php

namespace App\Services\OpenDart;

use Illuminate\Support\Carbon;

class ReportCode
{
    const FIRST_QUARTER = '11013';
    const HALF_QUARTER = '11012';
    const THIRD_QUARTER = '11014';
    const ALL = '11011';
    private const MONTHS = [3, 5, 8, 11];
    public string $year;
    public string $code;

    /**
     * @return ReportCode
     */
    public static function now(): ReportCode
    {
        $currentMonth = self::recent();

        return self::getQuarter(Carbon::now()->year, $currentMonth);
    }

    /**
     * @return int
     */
    private static function recent(): int
    {
        $nowDate = Carbon::now();
        $currentMonth = $nowDate->month;
        $currentWeek = $nowDate->weekNumberInMonth;

        if ($currentMonth >= self::MONTHS[0] && $currentMonth < self::MONTHS[1]) {
            if ($currentMonth == self::MONTHS[0] && $currentWeek < 3) {
                $currentMonth = self::controlQuarter(self::MONTHS[0]);
            } else {
                $currentMonth = self::MONTHS[0];
            }
        } else if ($currentMonth >= self::MONTHS[1] && $currentMonth < self::MONTHS[2]) {
            if ($currentMonth == self::MONTHS[1] && $currentWeek < 3) {
                $currentMonth = self::controlQuarter(self::MONTHS[1]);
            } else {
                $currentMonth = self::MONTHS[1];
            }
        } else if ($currentMonth >= self::MONTHS[2] && $currentMonth < self::MONTHS[3]) {
            if ($currentMonth == self::MONTHS[2] && $currentWeek < 3) {
                $currentMonth = self::controlQuarter(self::MONTHS[2]);
            } else {
                $currentMonth = self::MONTHS[2];
            }
        } else if ($currentMonth >= self::MONTHS[3]) {
            if ($currentMonth == self::MONTHS[3] && $currentWeek < 3) {
                $currentMonth = self::controlQuarter(self::MONTHS[3]);
            } else {
                $currentMonth = self::MONTHS[3];
            }
        }

        return $currentMonth;
    }

    /**
     * @param int $currentMonth
     * @return int
     */
    private static function controlQuarter(int $currentMonth): int
    {
        $currentSeq = array_search($currentMonth, self::MONTHS);

        if ($currentSeq == 0) {
            $currentSeq = count(self::MONTHS);
        }

        return self::MONTHS[$currentSeq - 1];
    }

    /**
     * @param int $currentYear
     * @param int $currentMonth
     * @return static
     */
    public static function getQuarter(int $currentYear, int $currentMonth): ReportCode
    {
        $result = new static;

        switch ($currentMonth) {
            case 3:
                $result->year = $currentYear - 1;
                $result->code = self::ALL;
                break;
            case 5:
                $result->year = $currentYear;
                $result->code = self::FIRST_QUARTER;
                break;
            case 8:
                $result->year = $currentYear;
                $result->code = self::HALF_QUARTER;
                break;
            case 11:
                $result->year = $currentYear;
                $result->code = self::THIRD_QUARTER;
                break;
        }

        return $result;
    }
}
