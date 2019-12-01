<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbEmployeeEducationInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_employee_education_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->comment('emp_id come from ("tb_employee") table')->nullable()->index();
            $table->string('emp_exam_title',50)->nullable();
            $table->string('emp_Institution_name',50)->nullable();
            $table->string('emp_result',50)->nullable();
            $table->string('emp_scale',50)->nullable();
            $table->string('emp_passing_year',50)->nullable();
            $table->string('emp_attachment',255)->nullable();
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
        Schema::dropIfExists('tb_employee_education_info');
    }
}
