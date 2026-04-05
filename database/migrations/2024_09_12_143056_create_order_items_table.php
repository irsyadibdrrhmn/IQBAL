<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Kolom product_id dan bundle_id dibuat nullable karena hanya salah satu yang akan digunakan
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
    

            $table->integer('quantity');
            $table->decimal('price', 10, 3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
