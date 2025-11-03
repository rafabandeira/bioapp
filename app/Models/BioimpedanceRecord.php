<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioimpedanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'weight',
        'body_fat_percentage',
        'skeletal_muscle_percentage',
        'visceral_fat_level',
        'body_age', // CORRIGIDO
    ];

    /**
     * O paciente a que este registo pertence.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}