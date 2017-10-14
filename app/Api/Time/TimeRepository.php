<?php

namespace App\Api\Time;

use App\Wfm\Managers\TimeSlotManager;
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

    public function getBonusMinutesOnDay($shifts, $day) {
    	foreach ($shifts as $shift) {
            $startTimeArray = TimeSlotManager::getTimeStampAsArray($shift['starttime']);
            $endTimeArray = TimeSlotManager::getTimeStampAsArray($shift['endtime']);

            $startUnit = TimeSlotManager::getTimeSlot($startTimeArray);
            $endUnit = $startUnit + ($shift['workhours'] * 60);

            for($j = $startUnit; $j < $endUnit; $j++) {
                $day[$j] += 1;
            }
        }

        return count(array_where($day, function($value, $key) {
            return $value === 1;
        }));
    }
}