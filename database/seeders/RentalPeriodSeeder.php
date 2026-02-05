<?php

namespace Database\Seeders;

use App\Models\RentalPeriod;
use Illuminate\Database\Seeder;

class RentalPeriodSeeder extends Seeder
{
    public function run(): void
    {
        RentalPeriod::create([
            'name' => 'day',
            'label' => 'Día',
            'order_column' => 1,
        ]);

        RentalPeriod::create([
            'name' => 'week',
            'label' => 'Semana',
            'order_column' => 2,
        ]);

        RentalPeriod::create([
            'name' => 'month',
            'label' => 'Mes',
            'order_column' => 3,
        ]);
    }
}
