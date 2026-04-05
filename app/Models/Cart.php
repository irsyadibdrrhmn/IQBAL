<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'carts';

    // Tentukan kolom yang bisa diisi (mass assignment)
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Tentukan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class); // Relasi user_id ke model User
    }

    // Tentukan relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class); // Relasi product_id ke model Product
    }
}
