<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cars')->insert([
            [
                'name' => 'Car 1',
                'gps_lat' => 47.497913,
                'gps_lon' => 19.040236, ### Király utca környéke
            ],
            [
                'name' => 'Car 2',
                'gps_lat' => 47.506075,
                'gps_lon' => 19.054341, ### Eötvös utca környéke
            ],
            [
                'name' => 'Car 3',
                'gps_lat' => 47.516245,
                'gps_lon' => 19.055126, ### Balzac utca környéke
            ],
            [
                'name' => 'Car 4',
                'gps_lat' => 47.498405,
                'gps_lon' => 19.065383, ### egy további pont
            ],
            [
                'name' => 'Car 5',
                'gps_lat' => 47.507500,
                'gps_lon' => 19.045000, ### még egy további pont
            ],
        ]);
    }
}
