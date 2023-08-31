<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpaceLetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('space_lets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estate_id')->nullable();
            $table->unsignedBigInteger('manager_user_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('total_allocation')->nullable()->default(1);
            $table->integer('used_allocation')->nullable()->default(0);
            $table->decimal('cost', 10, 2)->nullable()->default(0);
            $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');            
            $table->foreign('manager_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('space_lets');
    }
}