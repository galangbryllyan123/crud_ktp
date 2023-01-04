<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
  
        $json = File::get("database/data/data-kabupaten.json");
        $cities = json_decode($json);
  
        foreach ($cities as $key => $value) {
            City::create([
                "provinces_id" => $value->id_prov,
                "code" => $value->id_kab,
                "name" => $value->nm_kab
            ]);
        }
    }
}
