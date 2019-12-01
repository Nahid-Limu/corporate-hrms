<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbCompanyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_company_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_logo',255)->nullable();
            $table->string('company_name',255)->nullable();
            $table->string('company_phone',30)->nullable();
            $table->string('company_email',255)->nullable();
            $table->text('company_address')->nullable();
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
        Schema::dropIfExists('tb_company_information');
    }
}
