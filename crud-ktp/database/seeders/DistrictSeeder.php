<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::truncate();
  
        $json = File::get("database/data/data-kecamatan.json");
        $districs = json_decode($json);
  
        foreach ($districs as $key => $value) {
            District::create([
                "cities_id" => $value->id_kab,
                "code" => $value->id_kec,
                "name" => $value->nm_kec
            ]);
        }
    }
}
