<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['cities_id', 'name', 'code'];

    public function city()
    {
        return $this->belongsTo(City::class, 'cities_id', 'code');
    }

    public function identify_cards()
    {
        return $this->hasMany(IdentifyCard::class, 'kecamatan', 'id');
    }
}
