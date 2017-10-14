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

        $response = [];
        for ($i = 0; $i < 7; $i++) {
            $workDay = TimeSlotManager::getWorkDaySlotArray();
            $shiftsOnCurrentDay = $this->shiftRepo->getShiftsOnDay($shifts, $i);
            $response[] = $this->repo->getBonusMinutesOnDay($shiftsOnCurrentDay, $workDay);
        }

        return response()->json($response);
    }
}
