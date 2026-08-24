<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dokumentasis', function (Blueprint $table) {
            // Tambahkan kolom jenis, null boleh, defaultnya 'Lainnya'
            $table->string('jenis')->nullable()->default('Lainnya')->after('judul');
        });
    }

    public function down()
    {
        Schema::table('dokumentasis', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};