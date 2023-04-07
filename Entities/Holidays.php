<?php

namespace Lumis\LeaveApplication\Entities;


use Illuminate\Support\Carbon;

class Holidays
{
    public static function getStaticHolidays(): array
    {
        $holidays = [
            "01 January",
            "15 January",
            "03 March",
            "07 April",
            "10 April",
            "01 May",
            "14 June",
            "06 July",
            "15 October",
            "25 December",
            "26 December"
        ];

        $converted = array();

        foreach ($holidays as $holiday) {
            $converted[] = Carbon::parse($holiday)->toDateString();
        }
        return $converted;
    }
}
