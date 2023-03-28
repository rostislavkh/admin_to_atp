<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 25; $i++) {
            CarBrand::create([
                'name' => Str::random(10)
            ]);
        }
    }
}
