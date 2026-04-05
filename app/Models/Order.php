<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'midtrans_order_id',
        'address',
        'payment_method',
        'shipping_cost',
        'image',
        'total',
        'resi',
        'note',
        'status',
        'payment_status',
        'provinsi_id',
        'provinsi_name',
        'kabupaten_id',
        'kabupaten_name',
        'kecamatan_id',
        'kecamatan_name',
        'desa_id',
        'desa_name',

    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Dapatkan nama provinsi, kabupaten, kecamatan, dan desa
     * menggunakan WilayahService (tanpa model database lokal)
     */
    public function getWilayah()
    {
        $service = app(\App\Services\WilayahService::class);

        return [
            'provinsi' => $this->getWilayahName($service->getProvinsi(), $this->provinsi_id),
            'kabupaten' => $this->getWilayahName($service->getKabupaten($this->provinsi_id), $this->kabupaten_id),
            'kecamatan' => $this->getWilayahName($service->getKecamatan($this->kabupaten_id), $this->kecamatan_id),
            'desa' => $this->getWilayahName($service->getDesa($this->kecamatan_id), $this->desa_id),
        ];
    }

    /**
     * Fungsi bantu untuk mencari nama wilayah berdasarkan ID
     */
    protected function getWilayahName(array $wilayahList, ?int $id): ?string
    {
        foreach ($wilayahList as $item) {
            if ((int)$item['id'] === (int)$id) {
                return $item['name'];
            }
        }
        return null;
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
