<?php

namespace App\Api\Shift\Interfaces;

use Illuminate\Support\Collection;

interface ShiftRepositoryInterface
{
	public function getShifts();
	public function getShiftsForHours();
	public function getShiftsOnDay(array $shifts, $day);
	public function prepareWorkShiftsArray(Collection $data);

	public function mapShiftsByDayPerStaff(array $shifts);
}