<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbWeekLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_week_leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day',60)->nullable();
            $table->integer('day_id')->nullable();
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
        Schema::dropIfExists('tb_week_leave');
    }
}
