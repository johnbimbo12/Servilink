<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vending_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('txref')->nullable();
            $table->string('meterPan')->nullable();
            $table->string('merchant_id')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->tinyInteger('purchase_type')->default(0);
            $table->longText('response')->nullable();
            $table->decimal('vend_value',10,2)->nullable();
            $table->string('token')->nullable();
            $table->string('tokenHex')->nullable();
            $table->string('tariff')->nullable();
            $table->string('unitsActual')->nullable();
            $table->tinyInteger('payment_channel')->default(0);
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('vending_transactions');
    }
}