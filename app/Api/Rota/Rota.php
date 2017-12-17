<?php

namespace App\Api\Rota;

use App\Api\Shift;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    protected $fillable = [
        'shop',
        'start_date',
        'end_date',
        'budgeted_hours',
        'staffed_hours',
    ];
    
    public $timestamps = false;

    public function shifts() {
    	return $this->hasMany('App\Api\Shift');
    }
}
