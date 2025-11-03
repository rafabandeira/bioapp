<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'height',
        // user_id is handled by the relation
    ];

    /**
     * NOVO: Converte automaticamente o campo birth_date para um objeto Carbon (data).
     * Isto corrige o cálculo da idade cronológica.
     */
    protected $casts = [
        'birth_date' => 'datetime',
    ];

    /**
     * O utilizador (profissional) a que este paciente pertence.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Todos os registos de bioimpedância deste paciente.
     */
    public function bioimpedanceRecords(): HasMany
    {
        return $this->hasMany(BioimpedanceRecord::class)->orderBy('created_at', 'desc');
    }

    /**
     * Todos os registos de medidas deste paciente.
     */
    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class)->orderBy('created_at', 'desc');
    }

    /**
     * Todas as avaliações (anamneses) deste paciente.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class)->orderBy('created_at', 'desc');
    }
}