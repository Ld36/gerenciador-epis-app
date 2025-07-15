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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf', 14)->unique();
            $table->string('matricula', 50)->unique();
            $table->date('data_nascimento');
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();
            $table->foreignId('cargo_id')->constrained('cargos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};