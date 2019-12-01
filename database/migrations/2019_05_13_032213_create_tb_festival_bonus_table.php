<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbFestivalBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_festival_bonus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->comment('emp_id come from ("tb_employee") table')->nullable();
            $table->string('bonus_title')->nullable();
            $table->float('amount', 18, 2)->nullable();
            $table->float('percent', 5, 2)->nullable();
            $table->float('festival_bonus', 18, 2)->nullable();
            $table->date('date',30)->nullable();
            $table->tinyInteger('bonus_type')->comment('"1" is performance bonus or  "2" festival bonus')->default(1);
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
        Schema::dropIfExists('tb_festival_bonus');
    }
}
