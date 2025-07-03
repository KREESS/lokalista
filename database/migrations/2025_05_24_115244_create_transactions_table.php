<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->bigInteger('amount');
            $table->string('status');
            $table->unsignedBigInteger('id_pesanan')->nullable(); // ✅ tanpa after()
            $table->timestamps();

            // Foreign key ke tabel pesanan
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['id_pesanan']);
        });

        Schema::dropIfExists('transactions');
    }
};
