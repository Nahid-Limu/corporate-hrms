<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbLeaveTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_leave_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('leave_type',100)->nullable();
            $table->integer('total_days')->nullable();
            $table->text('policy')->nullable();
            $table->tinyInteger('status')->comment('"1" is active or  "0" deactive')->default(1);
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
        Schema::dropIfExists('tb_leave_type');
    }
}
