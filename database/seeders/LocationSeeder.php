<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Mumbai',
            'Delhi',
            'Bengaluru',
            'Hyderabad',
            'Chennai',
            'Kolkata',
            'Pune',
            'Ahmedabad',
            'Jaipur',
            'Kochi',
        ];

        foreach ($cities as $city) {
            Location::firstOrCreate(['city' => $city]);
        }
    }
}
