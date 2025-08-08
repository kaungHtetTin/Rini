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
        Schema::create('voucher_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('price'); // final price after calculating for discount
            $table->integer('quantity');
            $table->integer('amount');
            $table->timestamps();

            $table->index('voucher_id');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher_items',function(Blueprint $table){
            $table->dropIndex(['voucher_id']);

            $table->dropForeign(['voucher_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('voucher_items');
    }
};
