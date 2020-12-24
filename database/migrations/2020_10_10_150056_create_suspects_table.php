<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('finding_id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['wanted', 'in_custody'])->nullable();
            $table->enum('verdict', ['guilty', 'not_guilty', 'under_investigation'])->default('under_investigation');
            $table->timestamps();

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
        Schema::dropIfExists('suspects');
    }
}
