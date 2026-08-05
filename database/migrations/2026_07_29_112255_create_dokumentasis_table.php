<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumentasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('foto_path')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->unsignedBigInteger('ekskul_id');
            $table->unsignedBigInteger('diunggah_oleh');
            $table->timestamps();
            
            $table->foreign('ekskul_id')->references('id')->on('ekstrakurikulers')->onDelete('cascade');
            $table->foreign('diunggah_oleh')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumentasis');
    }
};