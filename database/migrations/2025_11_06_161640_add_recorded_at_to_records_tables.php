<?php

// AQUI ESTÁ A CORREÇÃO (note as barras invertidas \)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importante para o DB::raw

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Adiciona a coluna na tabela de bioimpedância
    Schema::table('bioimpedance_records', function (Blueprint $table) {
        // MUDANÇA: de timestamp() para date()
        // MUDANÇA: de CURRENT_TIMESTAMP para CURRENT_DATE
        $table->date('recorded_at')->default(DB::raw('CURRENT_DATE'))->after('patient_id');
    });

    // Adiciona a coluna na tabela de medições
    Schema::table('measurements', function (Blueprint $table) {
        $table->date('recorded_at')->default(DB::raw('CURRENT_DATE'))->after('patient_id');
    });

    // Adiciona a coluna na tabela de avaliações
    Schema::table('evaluations', function (Blueprint $table) {
        $table->date('recorded_at')->default(DB::raw('CURRENT_DATE'))->after('patient_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bioimpedance_records', function (Blueprint $table) {
            $table->dropColumn('recorded_at');
        });
        Schema::table('measurements', function (Blueprint $table) {
            $table->dropColumn('recorded_at');
        });
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn('recorded_at');
        });
    }
};