<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTaskEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_task_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_id',30)->index()->nullable();
            $table->string('task_id',30)->index()->nullable();
            $table->date('assign_date')->nullable();
            $table->tinyInteger('status');
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('tb_task_employee');
    }
}
