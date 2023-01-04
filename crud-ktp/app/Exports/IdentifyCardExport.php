<?php

namespace App\Exports;

use App\Models\IdentifyCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class IdentifyCardExport implements FromCollection, WithCustomCsvSettings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return IdentifyCard::select('nik','nama','tempat_lahir','tgl_lahir','jenis_kelamin','provinsi','kabupaten','kecamatan','desa','alamat','rt','rw','agama','status_perkawinan','pekerjaan','kewarganegaraan')
                ->get();
    }
}
