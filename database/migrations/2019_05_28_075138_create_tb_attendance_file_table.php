<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAttendanceFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_attendance_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',191)->nullable();
            $table->text('description')->nullable();
            $table->text('attendance_file')->nullable();
            $table->boolean('process_status')->nullable();
            $table->dateTime('process_date')->nullable();
            $table->dateTime('upload_date')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_attendance_file');
    }
}
