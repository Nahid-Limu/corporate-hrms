<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbRequestTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_request_training', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('branch_id')->nullable();
            $table->bigInteger('emp_id')->comment('emp_id come from ("tb_employee") table')->nullable();
            $table->bigInteger('training_id')->comment('training_id  come from ("tb_training") table')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('tb_request_training');
    }
}
