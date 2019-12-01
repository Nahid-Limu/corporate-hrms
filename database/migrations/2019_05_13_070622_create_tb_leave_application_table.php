<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbLeaveApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_leave_application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('unique_id')->nullable();
            $table->bigInteger('emp_id')->index()->nullable();
            $table->bigInteger('leave_type_id')->index()->nullable();
            $table->date('leave_starting_date')->nullable();
            $table->date('leave_ending_date')->nullable();
            $table->integer('actual_days')->nullable();
            $table->tinyInteger('approved_by')->nullable();
            $table->string('attachment')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('tb_leave_application');
    }
}
