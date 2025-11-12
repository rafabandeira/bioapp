<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioimpedanceRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:1',
            'body_fat_percentage' => 'decimal:1',
            'skeletal_muscle_percentage' => 'decimal:1',
            'visceral_fat_level' => 'integer',
            'body_age' => 'integer',
            'basal_metabolism_kcal' => 'integer',
            'recorded_at' => 'date'
        ];
    }

    /**
     * O paciente a que este registo pertence.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}