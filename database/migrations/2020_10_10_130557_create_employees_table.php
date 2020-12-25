<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->enum('role', ['POLICE', 'ATTORNEY', 'ADMIN', 'SUPERADMIN'])->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->boolean('is_available')->nullable();
            $table->boolean('password_changed')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('station_id')->references('id')->on('stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
