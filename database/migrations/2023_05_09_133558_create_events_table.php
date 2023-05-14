<?php

use App\Enums\{EventStatus, EventType};
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array_column(EventType::cases(), 'name'));
            $table->string('name');
            $table->string('image')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('local');
            $table->text('description');
            $table->string('tickets_limit')->nullable();
            $table->string('value')->nullable();
            $table->enum('status', array_column(EventStatus::cases(), 'name'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
