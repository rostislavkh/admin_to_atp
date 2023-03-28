<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Driver;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 25; $i++) {
            Driver::create([
                'first_name' => Str::random(10),
                'last_name' => Str::random(10),
                'birthday' => Carbon::now()->subYears(rand(21, 65))->addWeeks(rand(5, 10))->addDays(rand(5, 10))
            ]);
        }
    }
}
