<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('product_category_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url');
            $table->integer('price');
            $table->integer('trade_price');
            $table->integer('discount'); // in percent
            $table->integer('order_count')->default(0)->nullable();
            $table->integer('view')->default(0)->nullable();
            $table->boolean('instock');
            $table->boolean('disable')->default(false)->nullable();
            $table->integer('action_taken')->nullable();
            $table->timestamps();

            $table->index('product_category_id');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products',function(Blueprint $table){
            $table->dropIndex(['product_category_id']);

            $table->dropForeign(['product_category_id']);
        });

        Schema::dropIfExists('products');
    }
};
