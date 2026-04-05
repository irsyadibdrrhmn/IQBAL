<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'address',
        'provinsi_id','provinsi_name',
        'kabupaten_id','kabupaten_name',
        'kecamatan_id','kecamatan_name',
        'desa_id','desa_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

