<?php

namespace Database\Seeders;

use App\Models\UnitType;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
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
                "longName" => "Unit",
                "shortName" => "U",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Apartment",
                "shortName" => "Apartment",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Suite",
                "shortName" => "Suite",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Factory",
                "shortName" => "FY",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "House",
                "shortName" => "HSE",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Flat",
                "shortName" => "F",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Shed",
                "shortName" => "SHED",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Office",
                "shortName" => "Office",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "longName" => "Townhouse",
                "shortName" => "TNHS",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];
        UnitType::insert($data);
    }
}
