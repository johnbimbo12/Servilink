<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transacts', function (Blueprint $table) {
            $table->id();
            $table->string('payerid')->nullable();
            $table->longText('customer')->nullable();
            $table->string('merchant')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->decimal('charged_amt',10,2)->nullable();
            $table->decimal('vend_value',10,2)->nullable();
            $table->boolean('vend_statue')->default(false);
            $table->string('txref')->nullable();
            $table->string('payment_status')->nullable();
            $table->tinyInteger('path')->nullable();
            $table->integer('category')->default(0)->comment('0:power,1:charges');
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
        Schema::dropIfExists('payment_transacts');
    }
}