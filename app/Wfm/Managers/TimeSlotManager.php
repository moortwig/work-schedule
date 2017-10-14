<?php

namespace App\Wfm\Managers;

class TimeSlotManager
{
	// Offset is the first shift starting hour in minutes, from 00:00
    static protected $offset = 11 * 60; // 660
    static protected $minSlot = 0; // 11:00
    static protected $maxSlot = 960; // 03:00

	static public function getTimeSlot(array $timeArray) {
        $slot = self::getHourSlotPosition($timeArray['hours']);
        $slot += $timeArray['minutes'];
        $slot += $timeArray['seconds'] / 60;

        return $slot;
	}

	static public function getHourSlotPosition(int $hours) {
		// By subtracting the offset from hours, we "reset" hours, as if the day started at 11 o'clock (11 * 60 = 660)
		return ($hours * 60) - self::$offset;
	}

	static public function getTimeStampAsArray(string $timestamp) {
        $raw = explode(':', $timestamp);

        return [
            'hours' => (int)$raw[0],
            'minutes' => (int)$raw[1],
            'seconds' => (int)$raw[2],
        ];
	}

	static public function getWorkDaySlotArray() {
        $workDay = [];

		for($i = 0; $i < 960; $i++) {
            $workDay[$i] = 0;
        }

        return $workDay;
	}
}
