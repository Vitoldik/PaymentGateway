<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::table('second_gateway_payments', function (Blueprint $table) {
            $table->dropColumn('rand');
        });
    }

};
