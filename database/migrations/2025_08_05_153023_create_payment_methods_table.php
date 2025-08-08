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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mobile_banking_id');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('mobile_banking_id')->references('id')->on('mobile_bankings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_methods',function(Blueprint $table){
            $table->dropForeign(['mobile_banking_id']);
        });
        Schema::dropIfExists('payment_methods');
    }
};
