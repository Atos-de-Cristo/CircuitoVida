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
        Schema::table('frequencies', function (Blueprint $table) {
            $table->text('justification')->nullable()->after('inscription_id');
            $table->boolean('is_justified')->default(false)->after('justification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frequencies', function (Blueprint $table) {
            $table->dropColumn(['justification', 'is_justified']);
        });
    }
};
