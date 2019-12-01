<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbProvidentFundAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_provident_fund_amount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->index()->nullable();
            $table->date('salary_month_year')->nullable();
            $table->float('provident_fund_amount', 8, 2)->nullable();
            $table->float('provident_fund_percent', 8, 2)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * 
     * juopioo
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_provident_fund_amount');
    }
}
