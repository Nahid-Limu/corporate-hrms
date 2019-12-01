<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_name',60)->nullable();
            $table->string('branch_id',60)->nullable();
            $table->string('client_email',150)->nullable();
            $table->string('client_phone',20)->nullable();
            $table->text('client_address')->nullable();
            $table->integer('created_by')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('tb_clients');
    }
}
