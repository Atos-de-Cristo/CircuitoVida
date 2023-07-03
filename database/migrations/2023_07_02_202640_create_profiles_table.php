<?php

use App\Enums\ChurchRelationship;
use App\Enums\HouMeet;
use App\Enums\MaritalStatus;
use App\Enums\Schooling;
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
            $table->string('rg');
            $table->enum('sex', ['masculino', 'feminino']);
            $table->date('birth');
            $table->enum('marital_status', array_column(MaritalStatus::cases(), 'name'));
            $table->date('date_wedding');
            $table->string('country');
            $table->string('zip_code');
            $table->string('address');
            $table->string('number');
            $table->string('complement');
            $table->string('district');
            $table->string('city');
            $table->string('uf');
            $table->string('phone')->nullable();
            $table->string('cell_phone');
            $table->enum('church_relationship', array_column(ChurchRelationship::cases(), 'name'));
            $table->date('entry_date');
            $table->enum('hou_meet', array_column(HouMeet::cases(), 'name'));
            $table->string('church_from')->nullable();
            $table->enum('baptized', ['sim', 'não']);
            $table->enum('accepted_jesus', ['sim', 'não']);
            $table->date('date_accepted_jesus')->nullable();
            $table->enum('leader', ['sim', 'não']);
            $table->enum('pastor', ['sim', 'não']);
            $table->enum('Schooling', array_column(Schooling::cases(), 'name'));
            $table->string('profession');
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
