<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissingPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missing_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('woreda');
            $table->unsignedBigInteger('police_id')->nullable();
            $table->string('name');
            $table->text('description');
            $table->dateTime('time');
            $table->enum('status', ['found', 'missing', 'new', 'seen'])->default('new');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('police_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missing_people');
    }
}
