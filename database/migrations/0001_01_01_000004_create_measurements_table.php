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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();

            // Link para o paciente
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            
            // Campos do metabox 'corporais.php' (todos em cm, com 1 casa decimal)
            $table->decimal('neck', 5, 1)->nullable(); // pab_med_pescoco
            $table->decimal('chest', 5, 1)->nullable(); // pab_med_torax
            $table->decimal('arm_right', 5, 1)->nullable(); // pab_med_braco_direito
            $table->decimal('arm_left', 5, 1)->nullable(); // pab_med_braco_esquerdo
            $table->decimal('abdomen_upper', 5, 1)->nullable(); // pab_med_abd_superior
            $table->decimal('waist', 5, 1)->nullable(); // pab_med_cintura
            $table->decimal('abdomen_lower', 5, 1)->nullable(); // pab_med_abd_inferior
            $table->decimal('hip', 5, 1)->nullable(); // pab_med_quadril
            $table->decimal('thigh_right', 5, 1)->nullable(); // pab_med_coxa_direita
            $table->decimal('thigh_left', 5, 1)->nullable(); // pab_med_coxa_esquerda
            $table->decimal('calf_right', 5, 1)->nullable(); // pab_med_panturrilha_direita
            $table->decimal('calf_left', 5, 1)->nullable(); // pab_med_panturrilha_esquerda
            
            // A data do registro será o 'created_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};