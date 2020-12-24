<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criminals', function (Blueprint $table) {
            $table->id();
            $table->string('citizen_id')->unique();
            $table->string('name');
            $table->date('birthdate');
            $table->string('address');
            $table->string('mugshot1');
            $table->string('mugshot2')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('occupation', ['employed', 'unemployed']);
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
        Schema::dropIfExists('criminals');
    }
}
