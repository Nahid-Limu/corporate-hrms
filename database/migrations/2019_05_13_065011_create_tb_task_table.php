<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_task', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',100)->nullable();
            $table->string('description')->nullable();
            $table->text('attachment')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->tinyInteger('status')->comment('"1" is enable or  "0" disable')->default(1);
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
        Schema::dropIfExists('tb_task');
    }
}
