<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\CarBrand;
use App\Models\Driver;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 25; $i++) {
            Bus::create([
                'number' => Str::random(2) . rand(1000, 9999) . Str::random(2),
                'brand_id' => CarBrand::orderByRaw('RAND()')->limit(1)->get()[0]->id,
                'driver_id' => Driver::orderByRaw('RAND()')->limit(1)->get()[0]->id,
            ]);
        }
    }
}
