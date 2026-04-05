<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo_name',
        'product_id',
        'discount_type',
        'discount_value',
        'final_price',
        'status',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Optional: hitung harga setelah diskon secara dinamis
    public function getCalculatedFinalPriceAttribute()
    {
        $originalPrice = $this->product->price ?? 0;

        if ($this->discount_type === 'percent') {
            return $originalPrice - ($originalPrice * ($this->discount_value / 100));
        }

        return $originalPrice - $this->discount_value;
    }
}
