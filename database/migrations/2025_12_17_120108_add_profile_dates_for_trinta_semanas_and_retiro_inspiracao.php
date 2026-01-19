<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->date('trinta_semanas_data')->nullable()->after('trinta_semanas');
            $table->date('retiro_inspiracao_data')->nullable()->after('retiro_inspiracao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['trinta_semanas_data', 'retiro_inspiracao_data']);
        });
    }
};
