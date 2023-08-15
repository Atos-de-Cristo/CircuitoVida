<?php

use App\Enums\ChurchRelationship;
use App\Enums\HouMeet;
use App\Enums\MaritalStatus;
use App\Enums\Schooling;
use App\Models\User;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('cpf');
            $table->enum('sex', ['masculino', 'feminino']);
            $table->date('birth');
            $table->enum('marital_status', array_column(MaritalStatus::cases(), 'name'));
            $table->date('date_baptism')->nullable();
            $table->string('phone');
            $table->string('church')->nullable();
            $table->string('leader')->nullable();
            $table->string('deficiency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
