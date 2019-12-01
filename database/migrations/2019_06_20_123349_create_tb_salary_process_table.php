<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbSalaryProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_salary_process', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->index()->nullable();
            $table->date('salary_month_year')->nullable();
            $table->integer('grade_id')->index()->nullable();
            $table->double('basic_salary', 18, 2)->nullable();
            $table->double('house_rant', 18, 2)->nullable();
            $table->double('medical', 18, 2)->nullable();
            $table->double('transport', 18, 2)->nullable();
            $table->double('food', 18, 2)->nullable();
            $table->double('other', 18, 2)->nullable();
            $table->double('hour_amount', 18, 2)->comment('for overtime')->nullable();
            $table->double('bonus', 18, 2)->default('0')->nullable();
            $table->double('absent_deduction_amount', 8, 2)->nullable();
            $table->float('net_salary', 8, 2)->nullable();
            $table->float('bdtax', 8, 2)->comment('Personal Income Tax BDtax')->nullable();
            $table->float('working_day', 8, 2)->nullable();
            $table->float('festivalleave', 8, 2)->nullable();
            $table->float('present', 8, 2)->nullable();
            $table->float('weekend', 8, 2)->nullable();
            $table->float('leave', 8, 2)->nullable();
            $table->double('overtime', 8, 2)->comment('total overtime hour')->nullable();
            $table->double('late', 8, 2)->comment('total late days')->nullable();
            $table->double('absent', 8, 2)->comment('total absent days')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('tb_salary_process');
    }
}
