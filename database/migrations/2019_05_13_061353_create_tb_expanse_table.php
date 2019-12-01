<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbExpanseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_expanse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->comment('category_id come from ("tb_expanse_category") table')->nullable();
            $table->double('amount', 18, 2)->nullable();
            $table->date('expanse_date')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->text('attachment')->nullable();
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->comment('"1" is enable or  "0" disable')->default(1);
            $table->bigInteger('approved_by')->comment('approved By')->nullable();
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
        Schema::dropIfExists('tb_expanse');
    }
}
