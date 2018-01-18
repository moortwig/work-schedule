<?php

namespace App\Api\Shift;

use Illuminate\Support\Collection;
use App\Api\Shift\Interfaces\ShiftRepositoryInterface;
use App\Api\Shift\Shift as Model;

class ShiftRepository implements ShiftRepositoryInterface
{
	protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function getShifts() {
    	return $this->model
	    	->where('staff', '!=', null)
	        ->select(
	        	'id',
	        	'staff',
	        	'rota_id',
	        	'day',
	        	'starts_at',
	        	'ends_at',
	        	'shift_type',
	        	'work_hours'
	        )
	        ->orderBy('staff')
	        ->orderBy('day')
	        ->get();
    }

    public function getShiftsForHours() {
    	return $this->model
	        ->where('shift_type', 'shift')
	        ->where('staff', '!=', null)
	        ->select(
	        	'day',
	        	'ends_at',
	        	'starts_at',
	        	'work_hours'
	        )
	        ->get();
    }

    public function getShiftsOnDay(array $shifts, $day) {
        return array_where($shifts, function($value, $key) use($day) {
            return $value['day'] === $day;
        });
    }

    public function prepareWorkShiftsArray(Collection $data) {
		$staffNames = $data->pluck('staff')->unique();
		$totalShifts = [];

		foreach ($staffNames as $staffName) {
			$shifts = array_values($data->whereIn('staff', $staffName)->toArray());

			$totalShifts[] = [
				'shifts' => $this->mapShiftsByDayPerStaff($shifts),
				'staff' => $staffName,
			];
		}

    	return $totalShifts;
    }

    public function mapShiftsByDayPerStaff(array $shifts) {
    	return array_map(function($row) {
    		if (is_null($row['starts_at']) || is_null($row['ends_at'])) {
    			return null;
    		} else {
	    		return [
					"start" => $row['starts_at'],
	                "end" => $row['ends_at'],
	    		];
	    	}
    	}, $shifts);
    }
}