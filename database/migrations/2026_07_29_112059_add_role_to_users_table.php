<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pelatih', 'anggota'])->default('anggota');
            $table->string('no_hp')->nullable();
            $table->string('kelas')->nullable();
            $table->unsignedBigInteger('ekskul_id')->nullable();
            // ❌ HAPUS BARIS INI:
            // $table->foreign('ekskul_id')->references('id')->on('ekstrakurikulers');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_hp', 'kelas', 'ekskul_id']);
        });
    }
};