<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWantedCriminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wanted_criminals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id');
            $table->enum('status', ['caught', 'wanted'])->default('wanted');
            $table->timestamps();

            $table->foreign('criminal_id')->references('id')->on('criminals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wanted_criminals');
    }
}
