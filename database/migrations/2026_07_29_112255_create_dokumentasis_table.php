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
    Schema::create('dokumentasis', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('deskripsi');
        $table->string('foto_path');
        $table->date('tanggal_kegiatan');
        $table->unsignedBigInteger('ekskul_id');
        $table->unsignedBigInteger('diunggah_oleh');
        $table->timestamps();
        
        $table->foreign('ekskul_id')->references('id')->on('ekstrakurikulers');
        $table->foreign('diunggah_oleh')->references('id')->on('users');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasis');
    }
};
