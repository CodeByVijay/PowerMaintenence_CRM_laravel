<?php

namespace Database\Seeders;

use App\Models\Retailer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetailersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
        [
            'name' => 'Origin Energy',
            'energy'=>1,
            'broadband'=>0,
            'active' => "Yes",
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'EnergyAustralia',
            'energy'=>1,
            'broadband'=>0,
            'active' => "Yes",
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'AGL',
            'energy'=>1,
            'broadband'=>0,
            'active' => "Yes",
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];
    Retailer::insert($data);
    }
}
