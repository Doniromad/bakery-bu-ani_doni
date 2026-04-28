<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pesanans', function (Blueprint $table) {
        // Menambahkan kolom bukti_bayar setelah kolom metode_bayar
        $table->string('bukti_bayar')->nullable()->after('metode_bayar');
    });
}

public function down()
{
    Schema::table('pesanans', function (Blueprint $table) {
        $table->dropColumn('bukti_bayar');
    });
}
};
