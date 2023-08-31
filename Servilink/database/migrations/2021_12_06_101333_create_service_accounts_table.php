<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_user_id')->nullable();
            $table->string('subaccount_id')->nullable();
            $table->string('account_number')->nullable();
            $table->tinyInteger('service_type')->default(0)-> comment('0:power, 1: service, 3: water, 4:other');
            $table->string('bank')->nullable();
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
        Schema::dropIfExists('service_accounts');
    }
}