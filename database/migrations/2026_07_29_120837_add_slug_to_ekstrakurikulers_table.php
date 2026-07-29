<?php   

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('nama_ekskul');
        });
    }

    public function down()
    {
        Schema::table('ekstrakurikulers', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};