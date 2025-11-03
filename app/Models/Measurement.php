<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'neck' => 'decimal:1',
            'chest' => 'decimal:1',
            'arm_right' => 'decimal:1',
            'arm_left' => 'decimal:1',
            'abdomen_upper' => 'decimal:1',
            'waist' => 'decimal:1',
            'abdomen_lower' => 'decimal:1',
            'hip' => 'decimal:1',
            'thigh_right' => 'decimal:1',
            'thigh_left' => 'decimal:1',
            'calf_right' => 'decimal:1',
            'calf_left' => 'decimal:1',
        ];
    }

    /**
     * Um registro de medidas pertence a um Paciente.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}