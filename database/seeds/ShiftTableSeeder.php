<?php

use Illuminate\Database\Seeder;
use App\Api\Rota\Rota;
use App\Api\Shift\Shift;
use App\Wfm\ShiftHour;
//use Faker\Generator as Faker;
use Faker\Factory as Faker;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 9 hours
        $opensStart = ShiftHour::OPEN_START; // '09:30:00'
        $opensEnd = ShiftHour::OPEN_END;  // '18:30:00';

        // 9 hours
        $closesStart = ShiftHour::CLOSE_START;  // '10:30:00';
        $closesEnd = ShiftHour::CLOSE_END;  // '19:30:00';

        // 4 hours
        $lunchStart = ShiftHour::LUNCH_START;  // '11:00:00';
        $lunchEnd = ShiftHour::LUNCH_END;  // '15:00:00';

        // 7 hours
        $extraStart = ShiftHour::EXTRA_START;  // '12:00:00';
        $extraEnd = ShiftHour::EXTRA_END;  // '19:00:00';

        $faker = Faker::create();

        $worker1 = $faker->firstNameFemale . ' ' . strtoupper($faker->randomLetter);
        $worker2 = $faker->firstNameMale . ' ' . strtoupper($faker->randomLetter);
        $worker3 = $faker->firstNameFemale . ' ' . strtoupper($faker->randomLetter);
        $extra1 = $faker->firstNameMale . ' ' . strtoupper($faker->randomLetter);
        $extra2 = $faker->firstNameFemale . ' ' . strtoupper($faker->randomLetter);


        $worker1Data = [
            $this->getData(0, $worker1, 'shift', $opensStart, $opensEnd, 9.00),
            $this->getData(1, $worker1, 'shift', $opensStart, $opensEnd, 9.00),
            $this->getData(2, $worker1, 'shift', $opensStart, $opensEnd, 9.00),
            $this->getData(3, $worker1, 'shift', $opensStart, $opensEnd, 9.00),
            $this->getData(4, $worker1, 'shift', $opensStart, $opensEnd, 9.00),
            $this->getData(5, $worker1),
            $this->getData(6, $worker1),
        ];
        Shift::insert($worker1Data);

        $worker2Data = [
            $this->getData(0, $worker2, 'shift', $closesStart, $closesEnd, 9.00),
            $this->getData(1, $worker2, 'shift', $closesStart, $closesEnd, 9.00),
            $this->getData(2, $worker2, 'shift', $closesStart, $closesEnd, 9.00),
            $this->getData(3, $worker2, 'shift', $closesStart, $closesEnd, 9.00),
            $this->getData(4, $worker2, 'shift', $closesStart, $closesEnd, 9.00),
            $this->getData(5, $worker2),
            $this->getData(6, $worker2),
        ];
        Shift::insert($worker2Data);

        $worker3Data = [
            $this->getData(0, $worker3),
            $this->getData(1, $worker3),
            $this->getData(2, $worker3, 'shift', $lunchStart, $lunchEnd, 4.00),
            $this->getData(3, $worker3, 'shift', $lunchStart, $lunchEnd, 4.00),
            $this->getData(4, $worker3, 'shift', $lunchStart, $lunchEnd, 4.00),
            $this->getData(5, $worker3, 'shift', $closesStart, $closesEnd, 9.00),
            $this->getData(6, $worker3, 'shift', $closesStart, $closesEnd, 9.00),
        ];
        Shift::insert($worker3Data);

        $extra1Data = [
            $this->getData(0, $extra1, 'shift', $lunchStart, $lunchEnd, 4.00),
            $this->getData(1, $extra1, 'shift', $lunchStart, $lunchEnd, 4.00),
            $this->getData(2, $extra1),
            $this->getData(3, $extra1),
            $this->getData(4, $extra1, 'shift', $extraStart, $extraEnd, 7.00),
            $this->getData(5, $extra1, 'shift', $opensStart, $opensEnd, 9.00),
            $this->getData(6, $extra1, 'shift', $opensStart, $opensEnd, 9.00),
        ];
        Shift::insert($extra1Data);

        $extra2Data = [
            $this->getData(0, $extra2),
            $this->getData(1, $extra2),
            $this->getData(2, $extra2),
            $this->getData(3, $extra2),
            $this->getData(4, $extra2, 'shift', $extraStart, $extraEnd, 7.00),
            $this->getData(5, $extra2, 'shift', $extraStart, $extraEnd, 7.00),
            $this->getData(6, $extra2, 'shift', $extraStart, $extraEnd, 7.00),
        ];
        Shift::insert($extra2Data);
    }

    private function getData($day, $name, $type = 'off', $start = null, $end = null, $hours = 0) {
        $rota = Rota::first();
        return [
            'rota_id' => $rota->id,
            'day' => $day,
            'starts_at' => $start,
            'ends_at' => $end,
            'staff' => $name,
            'shift_type' => $type,
            'work_hours' => $hours,
        ];
    }
}