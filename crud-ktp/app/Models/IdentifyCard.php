<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentifyCard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinsi', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'kabupaten', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'kecamatan', 'id');
    }
}
