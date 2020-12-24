<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrimeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crime_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criminal_id');
            $table->unsignedBigInteger('finding_id');
            $table->timestamps();

            $table->foreign('criminal_id')->references('id')->on('criminals');
            $table->foreign('finding_id')->references('id')->on('findings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crime_records');
    }
}
