<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceMachineDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_machine_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_name');
            $table->string('door')->nullable();
            $table->string('emp_no')->nullable();
            $table->index('emp_no');
            $table->string('card_no')->nullable();
            $table->index('card_no');
            $table->timestamp('time')->nullable();
            $table->index('time');
            $table->string('event_explanation')->nullable();
            $table->integer('attendance_file_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_machine_data');
    }
}
