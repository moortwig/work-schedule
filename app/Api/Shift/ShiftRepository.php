<?php

namespace App\Api\Shift;

use Illuminate\Support\Collection;
use App\Api\Shift\Shift as Model;

class ShiftRepository
{
	protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function getShifts() {
    	return $this->model
	    	->where('staffId', '!=', null)
	        ->select(
	        	'daynumber',
	        	'endtime',
	        	'staffId',
	        	'starttime',
	        	'workhours'
	        )
	        ->orderBy('staffId')
	        ->orderBy('daynumber')
	        ->get();
    }

    public function getShiftsForHours() {
    	return $this->model
	        ->where('slottype', 'shift')
	        ->where('staffid', '!=', null)
	        ->select(
	        	'daynumber',
	        	'endtime',
	        	'starttime',
	        	'workhours'
	        )
	        ->get();
    }

    public function getShiftsOnDay(array $shifts, $day) {
        return array_where($shifts, function($value, $key) use($day) {
            return $value['daynumber'] === $day;
        });
    }

    public function prepareWorkShiftsArray(Collection $data) {
		$staffIds = $data->pluck('staffId')->unique();
		$totalShifts = [];

		foreach ($staffIds as $staffId) {
			$shifts = array_values($data->whereIn('staffId', $staffId)->toArray());

			$totalShifts[] = [
				'shifts' => $this->mapShiftsByDayPerStaff($shifts),
				'staff' => $staffId,
			];
		}

    	return $totalShifts;
    }

    protected function mapShiftsByDayPerStaff(array $shifts) {
    	return array_map(function($row) {
    		if (is_null($row['starttime']) || is_null($row['endtime'])) {
    			return null;
    		} else {
	    		return [
					"start" => $row['starttime'],
	                "end" => $row['endtime'],
	    		];
	    	}
    	}, $shifts);
    }
}