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
        Schema::create('financial_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_type_id');
            $table->string('category');
            $table->timestamps();

            $table->foreign('financial_type_id')->references('id')->on('financial_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_categories',function(Blueprint $table){
           
            $table->dropForeign(['financial_type_id']);
        });
        Schema::dropIfExists('financial_categories');
    }
};
