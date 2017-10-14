<?php

namespace App\Api\Time;

use App\Api\Time\TimeRepository as Repository;
use App\Api\Shift\ShiftRepository;
use App\Wfm\Managers\TimeSlotManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeController extends Controller
{
    protected $repo;
    protected $shiftRepo;

    public function __construct(
        Repository $repo,
        ShiftRepository $shiftRepo) {

        $this->repo = $repo;
        $this->shiftRepo = $shiftRepo;
    }

    public function hours() {
        $shifts = $this->shiftRepo->getShiftsForHours();
        $data = $this->repo->getHoursPerDay($shifts);

        return response()->json($data);
    }

    public function bonusMinutes() {
        $shifts = $this->shiftRepo->getShiftsForHours()->toArray();

        $totalLonely = [];
        for ($i = 0; $i < 7; $i++) {
            $workDay = TimeSlotManager::getWorkDayArray();
            $lonely = [];

            $shiftsOnCurrentDay = $this->shiftRepo->getShiftsOnDay($shifts, $i);

            foreach ($shiftsOnCurrentDay as $shift) {
                $startTimeArray = TimeSlotManager::getTimeStampAsArray($shift['starttime']);
                $endTimeArray = TimeSlotManager::getTimeStampAsArray($shift['endtime']);

                $startUnit = TimeSlotManager::getTimeSlot($startTimeArray);
                $endUnit = $startUnit + ($shift['workhours'] * 60);

                for($j = $startUnit; $j < $endUnit; $j++) {
                    $workDay[$j] += 1;
                }
            }

            $lonely = count(array_where($workDay, function($value, $key) {
                return $value === 1;
            }));

            $totalLonely[] = $lonely;
        }

        return response()->json($totalLonely);
    }
}
