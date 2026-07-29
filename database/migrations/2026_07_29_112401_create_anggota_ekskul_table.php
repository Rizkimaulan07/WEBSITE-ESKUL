<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggota_ekskul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ekskul_id');
            $table->string('jabatan')->default('anggota');
            $table->year('tahun_masuk');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
            $table->foreign('ekskul_id')
                  ->references('id')
                  ->on('ekstrakurikulers')
                  ->onDelete('cascade');
            
            // Unique constraint biar ga double
            $table->unique(['user_id', 'ekskul_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_ekskul');
    }
};