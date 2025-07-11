<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToKeranjangTable extends Migration
{
    public function up()
    {
        Schema::table('keranjang', function (Blueprint $table) {
            $table->string('status')->default('belum')->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

