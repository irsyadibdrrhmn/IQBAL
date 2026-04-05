<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'expires_at',
        'is_active',
        'max_usage_per_user'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'expires_at' => 'datetime',
    ];


    public function users()
{
    return $this->belongsToMany(User::class)
                ->withTimestamps()
                ->withPivot('assigned_at', 'used_at');
}

}
