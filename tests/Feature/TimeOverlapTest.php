<?php

namespace Tests\Feature;

use App\Wfm\Managers\TimeSlotManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeOverlapTest extends TestCase
{
    public function testTimeDoesNotFullyOverlapWhenShiftsOnSameDay() {
        $workDay = TimeSlotManager::getWorkDayArray();

        $shifts = [
            [
                'endUnit' =>  960,
                'staff' => 1,
                'startUnit' => 480,
                'daynumber' => 0,
            ],
            [
                'endUnit' => 945,
                'staff' => 2,
                'startUnit' => 480,
                'daynumber' => 0,
            ],
            [
                'endUnit' => 945,
                'staff' => 3,
                'startUnit' => 480,
                'daynumber' => 0,
            ]
        ];

        foreach ($shifts as $shift) {
            for($i = $shift['startUnit']; $i < $shift['endUnit']; $i++) {
                $workDay[$i] += 1;
            }
        }

        $lonely = array_where($workDay, function($value, $key) {
            return $value === 1;
        });


        $this->assertEquals(15, count($lonely));
    }

    public function testTimeDoesNotFullyOverlapWhenShiftsOnDifferentDays() {
        $shifts = [
            [
                'endUnit' =>  960,
                'staff' => 1,
                'startUnit' => 480,
                'daynumber' => 0,
            ],
            [
                'endUnit' => 960,
                'staff' => 2,
                'startUnit' => 480,
                'daynumber' => 1,
            ],
            [
                'endUnit' => 945,
                'staff' => 3,
                'startUnit' => 480,
                'daynumber' => 0,
            ]
        ];

        $totalLonely = [];
        for ($i = 0; $i < 7; $i++) {
            $workDay = TimeSlotManager::getWorkDayArray();
            $lonely = [];

            $shiftsOnCurrentDay = array_where($shifts, function($value, $key) use($i) {
                return $value['daynumber'] === $i;
            });

            foreach ($shiftsOnCurrentDay as $shift) {
                for($j = $shift['startUnit']; $j < $shift['endUnit']; $j++) {
                    $workDay[$j] += 1;
                }
            }

            $lonely = count(array_where($workDay, function($value, $key) {
                return $value === 1;
            }));

            $totalLonely[] = $lonely;
        }

        $this->assertEquals(15, $totalLonely[0]);
        $this->assertEquals(480, $totalLonely[1]);
    }
}
