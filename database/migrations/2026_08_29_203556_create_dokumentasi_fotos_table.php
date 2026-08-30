<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumentasi_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumentasi_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('filename');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumentasi_fotos');
    }
};