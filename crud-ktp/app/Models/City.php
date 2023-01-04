<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['provinces_id', 'name', 'code'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinces_id', 'code');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'cities_id', 'code');
    }

    public function identify_cards()
    {
        return $this->hasMany(IdentifyCard::class, 'kabupaten', 'id');
    }
}
