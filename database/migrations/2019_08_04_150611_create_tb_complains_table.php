<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_id')->nullable();
            $table->date('com_date')->nullable();
            $table->text('complain')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->tinyInteger('complain_to')->nullable();
            $table->string('com_token',191)->nullable();
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
        Schema::dropIfExists('tb_complains');
    }
}
