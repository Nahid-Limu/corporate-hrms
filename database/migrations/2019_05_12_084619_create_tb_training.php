<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_training', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('training_name', 150)->nullable();
            $table->string('branch_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('duration')->nullable();
            $table->string('training_attachment', 150)->nullable();
            $table->date('training_start')->nullable();
            $table->date('training_end')->nullable();
            $table->string('training_institution', 150)->nullable();
            $table->date('training_month', 150)->nullable();
            $table->tinyInteger('created_by')->nullable();
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
        Schema::dropIfExists('tb_training');
    }
}
