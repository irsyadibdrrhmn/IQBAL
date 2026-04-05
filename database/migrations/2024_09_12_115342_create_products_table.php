<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 3);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('is_premium')->default(0); // Kolom baru
            $table->timestamps();
        
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
