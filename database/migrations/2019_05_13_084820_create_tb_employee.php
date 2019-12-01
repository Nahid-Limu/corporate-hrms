<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employeeId',30)->nullable();
            $table->string('branch_id',30)->index()->nullable();
            $table->string('emp_first_name',20)->nullable();
            $table->string('emp_lastName',20)->nullable();
            $table->integer('emp_department_id')->index()->nullable();
            $table->integer('emp_designation_id')->index()->nullable();
            $table->integer('emp_gender_id')->nullable();
            $table->integer('emp_shift_id')->index()->nullable();
            $table->string('emp_email',50)->nullable();
            $table->string('emp_phone',20)->nullable();
            $table->text('emp_photo')->nullable();
            $table->date('emp_dob')->nullable();
            $table->date('emp_joining_date')->nullable();
            $table->integer('emp_probation_period')->nullable();
            $table->string('emp_religion',30)->nullable();
            $table->integer('emp_marital_status')->nullable();
            $table->string('emp_bank_account',30)->nullable();
            $table->text('emp_bank_info')->nullable();
            $table->string('emp_card_number',30)->nullable();
            $table->tinyInteger('emp_blood_group')->nullable();
            $table->date('date_of_discontinuation')->nullable();
            $table->text('reason_of_discontinuation')->nullable();
            $table->string('emp_nid',30)->nullable();
            $table->string('emp_nationality',40)->nullable();
            $table->tinyInteger('emp_ot_status')->nullable();
            $table->string('emp_parmanent_address',50)->nullable();
            $table->string('emp_current_address',50)->nullable();
            $table->string('emp_father_name',20)->nullable();
            $table->string('emp_mother_name',20)->nullable();
            $table->string('emp_emergency_phone',20)->nullable();
            $table->string('emp_emergency_address',50)->nullable();
            $table->tinyInteger('emp_account_status')->nullable();
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
        Schema::dropIfExists('tb_employee');
    }
}
