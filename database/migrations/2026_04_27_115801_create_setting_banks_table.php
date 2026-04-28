<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('setting_banks', function (Blueprint $table) {
        $table->id();
        $table->string('nama_bank');   // Contoh: BCA
        $table->string('no_rekening'); // Contoh: 123456789
        $table->string('atas_nama');   // Contoh: Khoirul Abdillah
        $table->boolean('is_active')->default(true); // Untuk mematikan/menghidupkan rekening
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_banks');
    }
};
