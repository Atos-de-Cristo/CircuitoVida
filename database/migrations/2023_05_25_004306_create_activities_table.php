<?php

use App\Models\{Activity, Event, Lesson, User};
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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class)->nullable();
            $table->foreignIdFor(Lesson::class)->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['G', 'E'])->default('G');
            $table->timestamps();
        });

        Schema::create('activity_user', function (Blueprint $table) {
            $table->foreignIdFor(Activity::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
        Schema::dropIfExists('activity_user');
    }
};
