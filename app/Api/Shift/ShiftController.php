<?php

namespace App\Api\Shift;

use App\Api\Shift\ShiftRepository as Repository;
use App\Http\Controllers\Controller;
use App\Wfm\Managers\TimeSlotManager;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    protected $repo;

    public function __construct(Repository $repo) {
        $this->repo = $repo;
    }

    public function index() {
        $shifts = $this->repo->getShifts();
        $preparedData = $this->repo->prepareWorkShiftsArray($shifts);

        return response()->json($preparedData);
    }
}
