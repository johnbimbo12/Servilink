<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messagings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_user_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('request')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:pending, 1: processing, 2: resolved');
            $table->tinyInteger('category')->default(0)->comment('0: power, 1: servicefee,2:water,3:other');
            $table->boolean('isread')->default(0)->comment('0: unread, 1: read');
            $table->timestamps();
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
        Schema::dropIfExists('messagings');
    }
}