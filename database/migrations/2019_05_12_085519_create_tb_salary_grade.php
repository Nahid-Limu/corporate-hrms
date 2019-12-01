<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbSalaryGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_salary_grade', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('grade_name', 150)->nullable();
            $table->double('basic', 18, 2)->nullable();
            $table->double('house', 18, 2)->nullable();
            $table->double('medical', 18, 2)->nullable();
            $table->double('transportation', 18, 2)->nullable();
            $table->double('food', 18, 2)->nullable();
            $table->double('other', 18, 2)->default(0)->nullable();
            $table->tinyInteger('status')->comment('"1" is enable or  "0" disable')->default(1);
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
        Schema::dropIfExists('tb_salary_grade');
    }
}
