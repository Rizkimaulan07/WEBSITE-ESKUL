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
    Schema::create('surat_keluars', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('template_id');
        $table->unsignedBigInteger('dibuat_oleh');
        $table->string('nomor_surat');
        $table->string('tujuan');
        $table->date('tanggal_surat');
        $table->text('isi_surat');
        $table->string('file_hasil')->nullable();
        $table->timestamps();
        
        $table->foreign('template_id')->references('id')->on('template_surats');
        $table->foreign('dibuat_oleh')->references('id')->on('users');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
