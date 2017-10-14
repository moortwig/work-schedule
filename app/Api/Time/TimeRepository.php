<?php

namespace App\Api\Time;

use Illuminate\Support\Collection;

class TimeRepository
{

    public function getHoursPerDay($shifts) {
        $daysOfWeek = range(0,6);
    	$totalHoursPerDay = [];

        foreach ($daysOfWeek as $day) {
        	$shiftsPerDay = $shifts->where('daynumber', $day);
        	$totalHoursPerDay[] = $this->getTotalHoursOnDay($shiftsPerDay);
        }

        return $totalHoursPerDay;
    }

    protected function getTotalHoursOnDay($shiftsPerDay) {
    	$hours = $shiftsPerDay->pluck('workhours')->toArray();

    	return array_sum($hours);
    }
}