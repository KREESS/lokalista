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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->bigInteger('amount');
            $table->string('status');
            $table->unsignedBigInteger('id_pesanan')->after('id')->nullable();

            // Menambahkan foreign key ke tabel pesanan
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('set null');
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
        Schema::dropIfExists('transactions');
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['id_pesanan']);
            $table->dropColumn('id_pesanan');
        });
    }
};
