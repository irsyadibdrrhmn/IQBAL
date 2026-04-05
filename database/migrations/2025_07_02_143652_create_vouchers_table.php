<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode voucher, misal: VOUCHER50
            $table->string('description')->nullable(); // Deskripsi promo
            $table->enum('discount_type', ['percent', 'fixed']); // Tipe diskon: persen atau potongan langsung
            $table->decimal('discount_value', 10, 2); // Nilai diskon
            $table->timestamp('expires_at')->nullable(); // Tanggal kadaluarsa
            $table->boolean('is_active')->default(true); // Status aktif / tidak
            $table->integer('max_usage_per_user')->default(1);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
