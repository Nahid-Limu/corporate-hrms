<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbMeetings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('branch_id')->nullable();
            $table->string('meeting_subject', 100)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('venue')->nullable();
            $table->text('description')->nullable();
            $table->date('meeting_date')->nullable();
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
        Schema::dropIfExists('tb_meetings');
    }
}
