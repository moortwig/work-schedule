<?php

namespace Tests\Unit;

use TypeError;
use Tests\TestCase;
use App\Wfm\ShiftHour;
use Carbon\Carbon;
use App\Wfm\Managers\TimeManager;


class TimeTest extends TestCase
{

    public function testGettingHourDifferenceSucceeds()
    {
        $startTime = Carbon::parse('09:00:00');
        $endTime = Carbon::parse('18:00:00');

        $diff = TimeManager::getHourDifference($startTime, $endTime);
        $this->assertEquals(9.0, $diff);
    }

    public function testGettingHourDifferenceFails()
    {
        $startTime = Carbon::parse('09:00:00');
        $endTime = Carbon::parse('14:00:00');

        $diff = TimeManager::getHourDifference($startTime, $endTime);
        $this->assertFalse(9.0 === $diff);
    }

    /**
    * @expectedException TypeError
    */
    public function testGettingHourDifferenceFailsOnType()
    {
        TimeManager::getHourDifference('09:00:00', '14:00:00');
        $this->assertInternalType(Carbon::class, 'string');
    }

}