<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estateusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('housenum')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('meternumber')->nullable();
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estateusers');
    }
}