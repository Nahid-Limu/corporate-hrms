<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAnnouncementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_announcement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('branch_id');
            $table->string('announcement_title',191)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('status')->comment('"1" is enable or  "0" disable')->default(1);
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_announcement');
    }
}
