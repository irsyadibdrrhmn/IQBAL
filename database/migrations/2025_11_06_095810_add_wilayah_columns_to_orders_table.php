<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->string('provinsi_id')->nullable()->after('address');
        $table->string('provinsi_name')->nullable()->after('provinsi_id');
        $table->string('kabupaten_id')->nullable()->after('provinsi_name');
        $table->string('kabupaten_name')->nullable()->after('kabupaten_id');
        $table->string('kecamatan_id')->nullable()->after('kabupaten_name');
        $table->string('kecamatan_name')->nullable()->after('kecamatan_id');
        $table->string('desa_id')->nullable()->after('kecamatan_name');
        $table->string('desa_name')->nullable()->after('desa_id');
    });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['provinsi_id', 'kabupaten_id', 'kecamatan_id', 'desa_id']);
        });
    }
};
