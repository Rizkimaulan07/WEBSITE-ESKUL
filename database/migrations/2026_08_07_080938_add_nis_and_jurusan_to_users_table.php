<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nis')) {
                $table->string('nis', 20)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan', 50)->nullable()->after('kelas');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'jurusan']);
        });
    }
};