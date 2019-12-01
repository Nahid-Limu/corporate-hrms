<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbIncrementSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_increment_salary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->comment('emp_id come from ("tb_employee") table')->nullable();
            $table->integer('percent')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->date('incr_date')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_increment_salary');
    }
}
