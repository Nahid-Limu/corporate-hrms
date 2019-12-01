<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbFileSharingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_file_sharing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyinteger('shared_group_type');
            $table->string('referenceId')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('designation_id')->nullable();
            $table->string('emp_id')->nullable();
            $table->date('shared_date')->nullable();
            $table->string('attachment')->nullable();
            $table->string('shared_by')->nullable();
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
        Schema::dropIfExists('tb_file_sharing');
    }
}
