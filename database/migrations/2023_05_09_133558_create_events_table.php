<?php

use App\Enums\{EventStatus, EventType};
use App\Models\Category;
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
            $table->foreignIdFor(Category::class);
            $table->string('name');
            $table->string('image')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->string('local');
            $table->text('description');
            $table->integer('tickets_limit')->nullable();
            $table->decimal('value')->nullable();
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
