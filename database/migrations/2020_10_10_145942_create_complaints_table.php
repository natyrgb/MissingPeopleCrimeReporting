<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('police_id')->nullable();
            $table->enum('type', ['robbery', 'homicide', 'assault', 'burglary', 'others']);
            $table->text('details');
            $table->enum('status', ['new', 'under_investigation', 'in_court', 'solved'])->default('new');
            $table->boolean('is_spam')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('police_id')->references('id')->on('employees');
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
        Schema::dropIfExists('complaints');
    }
}
