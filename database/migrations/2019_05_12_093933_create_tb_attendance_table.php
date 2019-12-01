<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->comment('emp_id come from ("tb_employee") table')->nullable();
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->date('attendance_date')->nullable();
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
        Schema::dropIfExists('tb_attendance');
    }
}
