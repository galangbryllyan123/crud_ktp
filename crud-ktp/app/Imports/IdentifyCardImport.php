<?php

namespace App\Imports;

use App\Models\IdentifyCard;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class IdentifyCardImport implements ToModel,  WithStartRow, WithCustomCsvSettings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
        ];
    }
    public function startRow(): int
    {
        return 2;
    } 
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new IdentifyCard([
            'nik' => $row[0],
            'nama' => $row[1],
            'tempat_lahir' => $row[2],
            'tgl_lahir' => $row[3],
            'jenis_kelamin' => $row[4],
            'provinsi' => $row[5],
            'kabupaten' => $row[6],
            'kecamatan' => $row[7],
            'desa' => $row[8],
            'alamat' => $row[9],
            'rt' => $row[10],
            'rw' => $row[11],
            'agama' => $row[12],
            'status_perkawinan' => $row[13],
            'pekerjaan' => $row[14],
            'kewarganegaraan' => $row[15],
        ]);
    }
}
