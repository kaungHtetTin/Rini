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
        Schema::create('salary_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('financial_id');
            $table->timestamps();
            $table->integer('action_taken')->nullable();
            $table->index('employee_id');

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('financial_id')->references('id')->on('financials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_records',function(Blueprint $table){
            $table->dropIndex(['employee_id']);
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['financial_id']);
        });
        Schema::dropIfExists('salary_records');
    }
};
