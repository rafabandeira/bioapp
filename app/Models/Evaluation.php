<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            // Antecedentes
            'circulatory_disorder' => 'boolean',
            'circulatory_family_history' => 'boolean',
            'endocrine_disorder' => 'boolean',
            'endocrine_family_history' => 'boolean',
            'uses_medication' => 'boolean',

            // Ginecológico
            'tpm' => 'boolean',
            'menopause' => 'boolean',
            'gestation' => 'boolean',
            'uses_gyno_medication' => 'boolean',
            'gestation_count' => 'integer',
            'children_count' => 'integer',

            // Hábitos
            'consumes_alcohol' => 'boolean',
            'is_smoker' => 'boolean',
            'physical_activity' => 'boolean',
            'sleep_time_bed' => 'datetime:H:i', // Salva como 'HH:MM'
            'sleep_time_wake' => 'datetime:H:i', // Salva como 'HH:MM'
        ];
    }

    /**
     * Uma avaliação pertence a um Paciente.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}