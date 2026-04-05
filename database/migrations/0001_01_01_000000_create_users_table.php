<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Untuk keamanan verifikasi email
            $table->string('password');
            $table->enum('role', ['admin', 'owner', 'customer'])->default('customer'); // Multi user
            $table->string('image')->nullable();
           
            $table->text('alamat')->nullable();
            $table->string('nomor_telpon')->nullable();

            // Kolom points yang nullable
            $table->integer('points')->nullable(); 
            $table->rememberToken(); // Untuk remember me saat login
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
