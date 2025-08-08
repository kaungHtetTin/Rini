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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('total_amount');
            $table->string('screenshot_url');
            $table->string('message');
            $table->boolean('payment_verified');
            $table->boolean('delivered');
            $table->boolean('trade');
            $table->timestamps();
            $table->integer('action_taken')->nullable();

            $table->index('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers',function(Blueprint $table){
            $table->dropIndex(['customer_id']);

            $table->dropForeign(['customer_id']);
        });
        Schema::dropIfExists('vouchers');
    }
};
