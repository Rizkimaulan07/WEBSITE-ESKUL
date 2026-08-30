<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('dokumentasis')) {
            return;
        }

        Schema::create('dokumentasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekskul_id')->constrained('ekstrakurikulers')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->foreignId('diunggah_oleh')->constrained('users')->onDelete('cascade');
            $table->string('foto_path')->nullable();
            $table->json('foto_lainnya')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumentasis');
    }
};