<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_assign_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->nullable()->index();
            $table->integer('project_id')->nullable()->index();
            $table->string('member_id',100)->nullable()->index();
            $table->integer('assign_by')->nullable();
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
        Schema::dropIfExists('tb_assign_project');
    }
}
