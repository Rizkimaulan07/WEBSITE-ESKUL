<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            if (!Schema::hasColumn('ekstrakurikulers', 'status')) {
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('tempat_latihan');
            }
        });
    }

    public function down()
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};