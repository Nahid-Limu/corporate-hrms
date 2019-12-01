<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('p_satatus_salary_month_year')->nullable();
             $table->tinyInteger('process_salary_status')->comment('"1" is enable or  "0" disable')->default(0);
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
        Schema::dropIfExists('process_status');
    }
}
