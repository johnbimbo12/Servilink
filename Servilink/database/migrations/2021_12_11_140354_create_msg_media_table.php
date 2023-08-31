<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsgMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('messaging_id')->nullable();
            $table->string('path')->nullable();
            $table->foreign('messaging_id')->references('id')->on('messagings')->onDelete('cascade');
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
        Schema::dropIfExists('msg_media');
    }
}