<?php

namespace App\Api\Shift;

use App\Api\Rota;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'rota_id',
        'day',
        'start_time',
        'end_time',
        'staff',
        'slot_type',
        'work_hours',
    ];

    public function rota() {
    	return $this->belongsTo('App\Api\Rota');
    }
}
