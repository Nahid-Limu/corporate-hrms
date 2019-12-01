<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbGroupEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_group_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_id')->comment('group_id come from ("tb_group") table')->index()->nullable();
            $table->bigInteger('emp_id')->comment('emp_id come from ("tb_employee") table')->index()->nullable();
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
        Schema::dropIfExists('tb_group_employee');
    }
}
