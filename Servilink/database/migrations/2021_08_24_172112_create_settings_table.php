<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_user_id')->nullable();
            $table->integer('type')->nullable();
            $table->decimal('transaction_fee', 10, 2)->nullable();
            $table->boolean('isPertrans')->default(true);
            $table->decimal('on_credit_fee', 10, 2)->nullable()->comment('in percentage');
            $table->decimal('min_vend', 10, 2)->nullable()->comment('in NGN');
            $table->decimal('wallet', 10, 2)->nullable()->comment('in NGN');
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
        Schema::dropIfExists('settings');
    }
}