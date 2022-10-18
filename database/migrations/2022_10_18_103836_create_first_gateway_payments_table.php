<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_gateway_payments', function (Blueprint $table) {
            $table->integer('merchant_id');
            $table->integer('payment_id')->primary();
            $table->string('status');
            $table->integer('amount');
            $table->integer('amount_paid');
            $table->dateTime('timestamp');
            $table->string('sign');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_gateway_payments');
    }
};
