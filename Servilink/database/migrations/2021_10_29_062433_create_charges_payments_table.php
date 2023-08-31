<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estate_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('txref')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('payment_date')->nullable();
            $table->integer('no_of_month')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges_payments');
    }
}