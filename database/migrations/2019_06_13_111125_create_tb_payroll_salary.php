<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPayrollSalary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_payroll_salary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->index()->nullable();
            $table->integer('grade_id')->index()->nullable();
            $table->double('basic_salary', 18, 2)->nullable();
            $table->double('house_rant', 18, 2)->nullable();
            $table->double('medical', 18, 2)->nullable();
            $table->double('transport', 18, 2)->nullable();
            $table->double('food', 18, 2)->nullable();
            $table->double('other', 18, 2)->nullable();
            $table->double('total_salary', 18, 2)->nullable();
            $table->double('provident_fund_percent', 18, 2)->nullable();
            $table->double('provident_fund_amount', 18, 2)->nullable();
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
        Schema::dropIfExists('tb_payroll_salary');
    }
}
