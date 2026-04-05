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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('address');
            $table->string('provinsi_id');
            $table->string('provinsi_name');
            $table->string('kabupaten_id');
            $table->string('kabupaten_name');
            $table->string('kecamatan_id');
            $table->string('kecamatan_name');
            $table->string('desa_id');
            $table->string('desa_name');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
