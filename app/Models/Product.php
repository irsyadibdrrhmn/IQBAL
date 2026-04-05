<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock', 'image','is_premium', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getTotalOrdersAttribute()
    {
        return $this->orderItems->sum('quantity');
    }
    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
//     public function bundles()
// {
//     return $this->belongsToMany(Bundle::class, 'bundle_product')
//                 ->withPivot('quantity')
//                 ->withTimestamps();
// }

    
}
