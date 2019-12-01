<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbFestivalLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_festival_leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('remarks');
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
        Schema::dropIfExists('tb_festival_leave');
    }
}
