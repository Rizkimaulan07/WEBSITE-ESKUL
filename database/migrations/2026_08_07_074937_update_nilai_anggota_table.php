<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilai_anggota', function (Blueprint $table) {
            // Tambahkan kolom untuk komponen nilai
            if (!Schema::hasColumn('nilai_anggota', 'nilai_kehadiran')) {
                $table->decimal('nilai_kehadiran', 5, 2)->default(0)->after('nilai');
            }
            if (!Schema::hasColumn('nilai_anggota', 'nilai_tugas')) {
                $table->decimal('nilai_tugas', 5, 2)->default(0)->after('nilai_kehadiran');
            }
            if (!Schema::hasColumn('nilai_anggota', 'nilai_ujian')) {
                $table->decimal('nilai_ujian', 5, 2)->default(0)->after('nilai_tugas');
            }
            if (!Schema::hasColumn('nilai_anggota', 'nilai_total')) {
                $table->decimal('nilai_total', 5, 2)->default(0)->after('nilai_ujian');
            }
            if (!Schema::hasColumn('nilai_anggota', 'catatan')) {
                $table->text('catatan')->nullable()->after('nilai_total');
            }
        });
    }

    public function down()
    {
        Schema::table('nilai_anggota', function (Blueprint $table) {
            $table->dropColumn(['nilai_kehadiran', 'nilai_tugas', 'nilai_ujian', 'nilai_total', 'catatan']);
        });
    }
};