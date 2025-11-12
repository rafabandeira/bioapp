<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Um usuário (profissional) tem muitos pacientes.
     */
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    /**
     * Um usuário tem muitos registros de bioimpedância ATRAVÉS de seus pacientes.
     */
    public function bioimpedanceRecords()
    {
        return $this->hasManyThrough(BioimpedanceRecord::class, Patient::class);
    }

    /**
     * Um usuário tem muitas medições ATRAVÉS de seus pacientes.
     */
    public function measurements()
    {
        return $this->hasManyThrough(Measurement::class, Patient::class);
    }

    /**
     * Um usuário tem muitas avaliações ATRAVÉS de seus pacientes.
     */
    public function evaluations()
    {
        return $this->hasManyThrough(Evaluation::class, Patient::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}