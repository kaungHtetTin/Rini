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
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_type_id');
            $table->unsignedBigInteger('financial_category_id');
            $table->string('title');
            $table->integer('amount');
            $table->timestamps();
            $table->integer('action_taken')->nullable();

            $table->foreign('financial_type_id')->references('id')->on('financial_types')->onDelete('cascade');
            $table->foreign('financial_category_id')->references('id')->on('financial_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financials',function(Blueprint $table){
            $table->dropForeign(['financial_type_id']);
            $table->dropForeign(['financial_category_id']);
        });
        Schema::dropIfExists('financials');
    }
};
