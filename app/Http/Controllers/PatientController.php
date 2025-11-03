<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // <-- MUITO IMPORTANTE para o Update
use App\Services\DiagnosticService;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Mostra a lista de pacientes
     */
    public function index()
    {
        $patients = Auth::user()->patients()->latest()->get();


        return view('patients.index', [
            'patients' => $patients,
        ]);
    }


    /**
     * Mostra o formulário de cadastro
     */
    public function create()
    {
        return view('patients.create');
    }


    /**
     * Salva o novo paciente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('patients')],
            'phone' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => ['nullable', Rule::in(['M', 'F'])],
            'height' => 'nullable|numeric|min:0.1|max:300',
        ]);


        Auth::user()->patients()->create($validated);


        return redirect()->route('patients.index')
            ->with('status', 'Paciente criado com sucesso!');
    }


    /**
     * Display the specified resource.
     * Mostra o dashboard de um paciente, carregando todos os históricos, calculando o IMC e formatando dados para gráficos.
     */
    public function show(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $patient->load('bioimpedanceRecords', 'measurements', 'evaluations');
        
        $latestBio = $patient->bioimpedanceRecords->first();
        
        // Variáveis de Diagnóstico
        $bmi = null;
        $bmiClassification = null;
        $bmiColorClass = 'text-gray-900';
        $bfpClassification = null;
        $bfpColorClass = 'text-gray-900';
        $skmClassification = null;
        $skmColorClass = 'text-gray-900';
        $vflClassification = null;
        $vflColorClass = 'text-gray-900';
        $tmb = null;
        $metabolicAgeClassification = null;
        $metabolicAgeColorClass = 'text-gray-900';
        $avatarPath = DiagnosticService::generateAvatarPath(null, $patient->gender);

        // Idade Cronológica
        $chronologicalAge = $patient->birth_date ? $patient->birth_date->age : null;

        // 1. CÁLCULO DO IMC
        if ($patient->height && $latestBio && isset($latestBio->weight)) {
            $height_m = $patient->height / 100;
            $weight = $latestBio->weight;
            $bmi_value = $weight / ($height_m * $height_m);
            $bmi = round($bmi_value, 2);

            // 2. CLASSIFICAÇÃO IMC
            $bmiClassification = DiagnosticService::classifyBmi($bmi);
            $bmiColorClass = DiagnosticService::getBmiColorClass($bmiClassification);
        }

        if ($latestBio && $patient->gender && $chronologicalAge) {
            $gender = $patient->gender;
            $currentBfp = $latestBio->body_fat_percentage ?? null;

            // 3. GERAÇÃO DO AVATAR
            $avatarPath = DiagnosticService::generateAvatarPath($currentBfp, $gender);

            // 4. CLASSIFICAÇÃO BFP (Gordura Corporal)
            if (isset($currentBfp)) {
                $bfpClassification = DiagnosticService::classifyBodyFat($currentBfp, $gender);
                $bfpColorClass = DiagnosticService::getBfpColorClass($bfpClassification);
            }

            // 5. CLASSIFICAÇÃO SKM (Músculo Esquelético)
            if (isset($latestBio->skeletal_muscle_percentage)) {
                $skm = $latestBio->skeletal_muscle_percentage;
                $skmClassification = DiagnosticService::classifySkeletalMuscle($skm, $gender);
                $skmColorClass = DiagnosticService::getSkmColorClass($skmClassification);
            }

            // 6. CLASSIFICAÇÃO VFL (Gordura Visceral)
            if (isset($latestBio->visceral_fat_level)) {
                $vfl = $latestBio->visceral_fat_level;
                $vflClassification = DiagnosticService::classifyVisceralFat($vfl);
                $vflColorClass = DiagnosticService::getVisceralFatColorClass($vflClassification);
            }

            // 7. CÁLCULO TMB
            if (isset($latestBio->weight) && $patient->height) {
                $tmb = DiagnosticService::calculateTmb(
                    $latestBio->weight, 
                    $patient->height, 
                    $chronologicalAge, 
                    $gender
                );
            }

            // 8. CLASSIFICAÇÃO IDADE METABÓLICA (CORRIGIDO)
            if (isset($latestBio->body_age)) { 
                $metabolicAge = $latestBio->body_age; // <-- LÊ DA COLUNA CORRETA
                $metabolicAgeClassification = DiagnosticService::classifyMetabolicAge($metabolicAge, $chronologicalAge);
                $metabolicAgeColorClass = DiagnosticService::getMetabolicAgeColorClass($metabolicAgeClassification);
            }
        }

        // 9. FORMATAÇÃO DE DADOS PARA GRÁFICOS
        $bio_chart_data = $patient->bioimpedanceRecords
            ->reverse()
            ->map(fn($record) => [
                'date' => $record->created_at->format('d/m/Y'),
                'weight' => $record->weight,
                'body_fat_percentage' => $record->body_fat_percentage,
                'skeletal_muscle_percentage' => $record->skeletal_muscle_percentage,
            ])
            ->values()
            ->toJson();

        $measurements_chart_data = $patient->measurements
            ->reverse()
            ->map(fn($record) => [
                'date' => $record->created_at->format('d/m/Y'),
                'waist' => $record->waist,
                'hip' => $record->hip,
            ])
            ->values()
            ->toJson();


        return view('patients.show', [
            'patient' => $patient,
            'latestBio' => $latestBio,
            'bmi' => $bmi,
            'bmiClassification' => $bmiClassification,
            'bmiColorClass' => $bmiColorClass,
            'bfpClassification' => $bfpClassification,
            'bfpColorClass' => $bfpColorClass,
            'skmClassification' => $skmClassification,
            'skmColorClass' => $skmColorClass,
            'vflClassification' => $vflClassification,
            'vflColorClass' => $vflColorClass,
            'tmb' => $tmb,
            'metabolicAgeClassification' => $metabolicAgeClassification,
            'metabolicAgeColorClass' => $metabolicAgeColorClass,
            'avatarPath' => $avatarPath,
            'bio_chart_data' => $bio_chart_data,
            'measurements_chart_data' => $measurements_chart_data,
        ]);
    }

    /**
     * NOVO: Mostra o formulário de edição
     */
    public function edit(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }


        return view('patients.edit', compact('patient'));
    }


    /**
     * NOVO: Atualiza o paciente no banco
     */
    public function update(Request $request, Patient $patient)
    {
        // 1. Segurança: Garante que o usuário só pode editar seus próprios pacientes
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }


        // 2. Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                // Regra de "único", ignorando o ID do próprio paciente
                Rule::unique('patients')->ignore($patient->id)
            ],
            'phone' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => ['nullable', Rule::in(['M', 'F'])],
            'height' => 'nullable|numeric|min:0.1|max:300',
        ]);


        // 3. Atualiza o registro
        $patient->update($validated);


        // 4. Redireciona de volta para o dashboard do paciente
        return redirect()->route('patients.show', $patient)
            ->with('status', 'Paciente atualizado com sucesso!');
    }


    /**
     * Deleta um paciente
     */
    public function destroy(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }


        $patient->delete();


        return redirect()->route('patients.index')
            ->with('status', 'Paciente deletado com sucesso!');
    }
}

