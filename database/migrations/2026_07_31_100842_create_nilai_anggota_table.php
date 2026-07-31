<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ekskul_id')->constrained('ekstrakurikulers')->onDelete('cascade');
            $table->foreignId('pelatih_id')->constrained('users')->onDelete('cascade');
            $table->integer('nilai_kehadiran')->default(0);
            $table->integer('nilai_keterampilan')->default(0);
            $table->integer('nilai_sikap')->default(0);
            $table->decimal('nilai_total', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->string('semester')->nullable();
            $table->year('tahun_ajaran')->nullable();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['pelatih_id', 'ekskul_id']);
            $table->index(['anggota_id', 'semester', 'tahun_ajaran']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_anggota');
    }
};