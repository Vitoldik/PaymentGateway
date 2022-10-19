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
        Schema::create('second_gateway_payments', function (Blueprint $table) {
            $table->integer('project');
            $table->integer('invoice')->primary();
            $table->string('status');
            $table->integer('amount');
            $table->integer('amount_paid');
            $table->string('rand');
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
        Schema::dropIfExists('second_gateway_payments');
    }
};
