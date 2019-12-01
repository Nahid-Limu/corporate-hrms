<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAssignTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_project_assign_task', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('task_title')->nullable();
            $table->text('task_description')->nullable();
            $table->date('due_date')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('tb_project_assign_task');
    }
}
