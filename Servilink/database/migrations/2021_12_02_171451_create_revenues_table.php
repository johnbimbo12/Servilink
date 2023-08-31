<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('txref')->nullable();
            $table->string('payerid')->nullable();
            $table->unsignedBigInteger('manager_user_id')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->tinyInteger('purchase_type')->default(0);
            $table->timestamps();
            $table->foreign('manager_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revenues');
    }
}