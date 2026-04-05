<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_voucher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
            $table->timestamp('assigned_at')->nullable(); // kapan voucher diberikan ke user
            $table->integer('usage_count')->default(0); 
            $table->timestamp('used_at')->nullable();     // kapan digunakan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_voucher');
    }
};
