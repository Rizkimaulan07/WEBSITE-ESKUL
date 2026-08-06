<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kehadiran_pelatih', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelatih_id');
            $table->unsignedBigInteger('ekskul_id');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('pelatih_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ekskul_id')->references('id')->on('ekstrakurikulers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kehadiran_pelatih');
    }
};