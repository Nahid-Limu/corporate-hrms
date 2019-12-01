<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name',255)->nullable();
            $table->bigInteger('client_id')->comment('client_id come from ("tb_clients") table')->nullable();
            $table->bigInteger('team_leader')->comment('team_leader come from ("tb_employee") table')->nullable();
            $table->bigInteger('branch_id')->comment('branch_id come from ("tb_branch") table')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('price', 18, 2)->nullable();
            $table->tinyInteger('priority')->comment('"1" is enable or  "0" disable')->default(1);
            $table->text('attachment')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('tb_project');
    }
}
