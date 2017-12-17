<?php

use Illuminate\Database\Seeder;
use App\Api\Rota\Rota;
use Faker\Factory as Faker;

class RotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Rota::create([
	    	'shop' => 'Foo London',
	        'start_date' => '2018-02-12',
	        'end_date' => '2018-02-18',
	        'budgeted_hours' => 215,
	        'staffed_hours' => 135.25,
	    ]);

	    Rota::create([
	    	'shop' => 'Foo London',
	        'start_date' => '2018-02-19',
	        'end_date' => '2018-02-25',
	        'budgeted_hours' => 164,
	        'staffed_hours' => 0,
	    ]);
	}
}