<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    protected $table = 'user_voucher';

    protected $fillable = [
        'user_id',
        'voucher_id',
        'usage_count',
        'assigned_at',
    ];

    public $timestamps = true;

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
