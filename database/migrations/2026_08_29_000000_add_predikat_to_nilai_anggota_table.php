<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilai_anggota', function (Blueprint $table) {
            if (!Schema::hasColumn('nilai_anggota', 'predikat')) {
                $table->char('predikat', 1)->nullable()->after('nilai_sikap');
            }
        });
    }

    public function down()
    {
        Schema::table('nilai_anggota', function (Blueprint $table) {
            if (Schema::hasColumn('nilai_anggota', 'predikat')) {
                $table->dropColumn('predikat');
            }
        });
    }
};