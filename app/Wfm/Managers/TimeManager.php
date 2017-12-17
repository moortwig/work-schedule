<?php

namespace App\Wfm\Managers;


use Carbon\Carbon;

class TimeManager
{
    static public function getHourDifference(Carbon $start, Carbon $end) {
        return (float)$end->diff($start)->format('%H.%I');
    }
}
