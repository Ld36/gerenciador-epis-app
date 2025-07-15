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
        Schema::create('entrega_epis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colaborador_id')->constrained('colaboradores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('epi_id')->constrained('epis')->onDelete('restrict')->onUpdate('cascade');
            $table->date('data_entrega');
            $table->integer('quantidade_entregue');
            $table->string('motivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrega_epis');
    }
};