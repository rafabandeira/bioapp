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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();

            // Link para o paciente
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            
            // --- Anamnese ---
            $table->string('qp')->nullable(); // pab_av_qp (Queixa Principal)
            $table->text('hda')->nullable(); // pab_av_hda (História da Doença Atual)
            $table->text('objectives')->nullable(); // pab_av_obj

            // --- Antecedentes ---
            $table->text('pathological_history')->nullable(); // pab_av_patol
            $table->boolean('circulatory_disorder')->default(false); // pab_av_circ_sim
            $table->string('circulatory_disorder_details')->nullable(); // pab_av_circ_quais
            $table->boolean('circulatory_family_history')->default(false); // pab_av_circ_fam
            $table->boolean('endocrine_disorder')->default(false); // pab_av_end_sim
            $table->string('endocrine_disorder_details')->nullable(); // pab_av_end_quais
            $table->boolean('endocrine_family_history')->default(false); // pab_av_end_fam
            $table->boolean('uses_medication')->default(false); // pab_av_med_sim
            $table->string('medication_time')->nullable(); // pab_av_med_tempo
            $table->string('medication_details')->nullable(); // pab_av_med_quais

            // --- Ginecológico ---
            $table->enum('menstruation', ['regular', 'irregular'])->nullable(); // pab_av_mens
            $table->boolean('tpm')->default(false)->nullable(); // pab_av_tpm
            $table->boolean('menopause')->default(false)->nullable(); // pab_av_meno_sim
            $table->string('menopause_age')->nullable(); // pab_av_meno_idade
            $table->boolean('gestation')->default(false)->nullable(); // pab_av_gest_sim
            $table->integer('gestation_count')->nullable(); // pab_av_gest_qt
            $table->integer('children_count')->nullable(); // pab_av_filhos
            $table->boolean('uses_gyno_medication')->default(false)->nullable(); // pab_av_gine_med_sim
            $table->string('gyno_medication_details')->nullable(); // pab_av_gine_med_quais

            // --- Hábitos de Vida ---
            $table->boolean('consumes_alcohol')->default(false); // pab_av_alc_sim
            $table->string('alcohol_frequency')->nullable(); // pab_av_alc_freq
            $table->boolean('is_smoker')->default(false); // pab_av_tabag_sim
            $table->string('smoking_frequency')->nullable(); // pab_av_tabag_freq
            $table->boolean('physical_activity')->default(false); // pab_av_atv_sim
            $table->string('physical_activity_details')->nullable(); // pab_av_atv_quais
            $table->string('physical_activity_frequency')->nullable(); // pab_av_atv_freq
            $table->enum('diet_type', ['hipo', 'normal', 'hiper'])->nullable(); // pab_av_alim_tipo
            $table->string('meals_per_day')->nullable(); // pab_av_alim_ref
            $table->string('daily_liquids')->nullable(); // pab_av_liq
            $table->enum('sleep_quality', ['ruim', 'bom', 'excelente'])->nullable(); // pab_av_sono_qual
            $table->time('sleep_time_bed')->nullable(); // pab_av_sono_hd
            $table->time('sleep_time_wake')->nullable(); // pab_av_sono_ha
            $table->string('intestinal_function')->nullable(); // pab_av_intest

            // A data do registro será o 'created_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};