<?php

namespace Tests\Feature;

use App\Wfm\Managers\TimeSlotManager;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimeSlotTest extends TestCase
{
    protected $offset = 11 * 60;
    protected $minSlot = 1; // 11:00
    protected $maxSlot = 960; // 03:00

    public function testGetHourSlotPosition() {
        $slotPosition = TimeSlotManager::getHourSlotPosition(19);

        $this->assertEquals(480, $slotPosition);
    }

    public function testTimeStampFindsASlot() {

        $timeArray = TimeSlotManager::getTimeStampAsArray("11:15:00");
        $slot = TimeSlotManager::getTimeSlot($timeArray);

        $this->assertEquals(15, $slot);
    }

    public function testTimeStampSplitsIntoAssociativeArray() {
        $timeArray = TimeSlotManager::getTimeStampAsArray("11:15:00");

        $this->assertEquals(11, $timeArray['hours']);
        $this->assertEquals(15, $timeArray['minutes']);
        $this->assertEquals(00, $timeArray['seconds']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTimeSlotsAreWIthinSameDay()
    {
        $staffStartsAtSlot = 1; // which is "11:00";
        $staffWorkHours = 8;

        $slotSteps = 8*60;
        $staffFinishesAtSlot = $staffStartsAtSlot + $slotSteps;

        $boolean = $staffFinishesAtSlot <= $this->maxSlot;

        $this->assertTrue($boolean);
    }
}
