<?php

use App\Models\{Event, Inscription, Lesson, User};
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
        Schema::create('frequencies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class);
            $table->foreignIdFor(Lesson::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Inscription::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencies');
    }
};
