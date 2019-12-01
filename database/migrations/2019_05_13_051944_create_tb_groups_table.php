<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_leader_id')->comment('group_leader_id come from ("tb_employee") table')->nullable();
            $table->string('group_name',191)->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('tb_groups');
    }
}
