<?php
// app/Exports/PatientsExport.php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retorna apenas os pacientes do utilizador logado
        return Auth::user()->patients()->get();
    }

    /**
     * Define os cabeçalhos das colunas (Linha 1 do CSV/Excel)
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Email',
            'Telefone',
            'Gênero',
            'Data de Nascimento',
            'Altura (cm)',
            'Data de Criação',
        ];
    }

    /**
     * Mapeia os dados do Paciente para as colunas
     */
    public function map($patient): array
    {
        return [
            $patient->id,
            $patient->name,
            $patient->email,
            $patient->phone,
            $patient->gender,
            $patient->birth_date ? $patient->birth_date->format('Y-m-d') : null,
            $patient->height,
            $patient->created_at->format('Y-m-d H:i:s'),
        ];
    }
}