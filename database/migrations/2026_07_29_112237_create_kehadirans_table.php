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
    Schema::create('kehadirans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('anggota_id');
        $table->unsignedBigInteger('pelatih_id');
        $table->unsignedBigInteger('ekskul_id');
        $table->date('tanggal');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']);
        $table->text('keterangan')->nullable();
        $table->timestamps();
        
        $table->foreign('anggota_id')->references('id')->on('users');
        $table->foreign('pelatih_id')->references('id')->on('users');
        $table->foreign('ekskul_id')->references('id')->on('ekstrakurikulers');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};
