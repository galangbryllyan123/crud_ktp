<?php

namespace Database\Seeders;

use App\Models\IdentifyCard;
use App\Models\District;
use App\Models\Profession;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IdentifyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    function randomDate($start_date, $end_date)
    {
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        $val = rand($min, $max);
        return date('Y-m-d', $val);
    }

    function dateNik($tanggal)
    {
        return date('dmy', strtotime($tanggal));
    }

    function makeNik($code_nik, $tanggal_lahir, $i){
        $nik = $code_nik.strval($this->dateNik($tanggal_lahir)).'000'.$i;
        if (IdentifyCard::where('nik', $nik)->count()) {
            return $this->makeNik($code_nik, $tanggal_lahir, $i +1);
        }
        else{
            return $nik;
        }
    }

    public function run()
    {
        IdentifyCard::truncate();
        $faker = Faker::create('id_ID');
        for ($i=0; $i < 40000; $i++) { 
            $tanggal_lahir = $this->randomDate('2010-01-01', '2021-12-01');
            $district = District::where('id', rand(1, 7202))->firstOrFail();
            $code_nik = str_replace('.', '', $district->code);
            $nik = $this->makeNik($code_nik, $tanggal_lahir, 1);
            IdentifyCard::create([
                'nik' => $nik, 
                'nama' => $faker->name, 
                'tempat_lahir' => $district->city->name, 
                'tgl_lahir' => $tanggal_lahir, 
                'jenis_kelamin' => $faker->randomElement(['laki-laki', 'perempuan']),
                'provinsi' => $district->city->province->id, 
                'kabupaten' => $district->city->id, 
                'kecamatan' => $district->id, 
                'desa' => $faker->streetName, 
                'alamat' => $faker->address, 
                'rt' => rand(1, 20), 
                'rw' => rand(1, 20), 
                'agama' => $faker->randomElement(['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu']), 
                'status_perkawinan' => $faker->randomElement(['kawin', 'belum kawin']), 
                'pekerjaan' => Profession::select('name')->where('id', rand(1, 88))->firstOrFail()->name, 
                'kewarganegaraan' => 'WNI',  
            ]);
        }
    }
}
