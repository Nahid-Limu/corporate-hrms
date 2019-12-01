<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbProjectGroupChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_project_group_chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id')->nullable();
            $table->string('emp_id')->nullable();
            $table->text('conversation')->nullable();
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
        Schema::dropIfExists('tb_project_group_chat');
    }
}
