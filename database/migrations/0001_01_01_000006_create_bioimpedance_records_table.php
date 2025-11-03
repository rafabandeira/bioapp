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
        Schema::create('bioimpedance_records', function (Blueprint $table) {
            $table->id();

            // Link para o paciente
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();

            // Campos do metabox 'dados.php' (bioimpedancia)
            $table->decimal('weight', 5, 1)->nullable(); // pab_bi_peso (kg, ex: 70.5)
            $table->decimal('body_fat_percentage', 4, 1)->nullable(); // pab_bi_gordura_corporal (%)
            $table->decimal('skeletal_muscle_percentage', 4, 1)->nullable(); // pab_bi_musculo_esq (%)
            $table->integer('visceral_fat_level')->nullable(); // pab_bi_gordura_visc (nível)
            $table->integer('basal_metabolism_kcal')->nullable(); // pab_bi_metab_basal (kcal)
            $table->integer('body_age')->nullable(); // pab_bi_idade_corporal (anos)

            // A data do registro será o 'created_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bioimpedance_records');
    }
};