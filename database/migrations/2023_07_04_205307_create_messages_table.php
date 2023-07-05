<?php

use App\Models\{Event, Lesson, User};
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_send');
            $table->foreignIdFor(User::class, 'user_for');
            $table->foreignIdFor(Event::class)->nullable();
            $table->foreignIdFor(Lesson::class)->nullable();
            $table->text('message');
            $table->boolean('read');
            $table->dateTime('date_send');
            $table->dateTime('date_read')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
