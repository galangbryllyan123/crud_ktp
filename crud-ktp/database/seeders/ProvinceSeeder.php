<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::truncate();
  
        $json = File::get("database/data/data-provinsi.json");
        $provinces = json_decode($json);
  
        foreach ($provinces as $key => $value) {
            Province::create([
                "code" => $value->id_prov,
                "name" => $value->nm_prov
            ]);
        }
    }
}
