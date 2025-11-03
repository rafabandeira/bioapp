<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EvaluationController extends Controller
{
    /**
     * Validação centralizada de todos os campos da Anamnese (4 metaboxes).
     */
    private function validateEvaluation(Request $request)
    {
        return $request->validate([
            // Anamnese
            'qp' => 'nullable|string|max:255',
            'hda' => 'nullable|string',
            'objectives' => 'nullable|string',

            // Antecedentes
            'pathological_history' => 'nullable|string',
            'circulatory_disorder' => 'boolean',
            'circulatory_disorder_details' => 'nullable|string|max:255',
            'circulatory_family_history' => 'boolean',
            'endocrine_disorder' => 'boolean',
            'endocrine_disorder_details' => 'nullable|string|max:255',
            'endocrine_family_history' => 'boolean',
            'uses_medication' => 'boolean',
            'medication_time' => 'nullable|string|max:255',
            'medication_details' => 'nullable|string',

            // Ginecológico
            'menstruation' => ['nullable', Rule::in(['regular', 'irregular'])],
            'tpm' => 'nullable|boolean',
            'menopause' => 'nullable|boolean',
            'menopause_age' => 'nullable|string|max:50',
            'gestation' => 'nullable|boolean',
            'gestation_count' => 'nullable|integer|min:0',
            'children_count' => 'nullable|integer|min:0',
            'uses_gyno_medication' => 'nullable|boolean',
            'gyno_medication_details' => 'nullable|string',

            // Hábitos de Vida
            'consumes_alcohol' => 'boolean',
            'alcohol_frequency' => 'nullable|string|max:255',
            'is_smoker' => 'boolean',
            'smoking_frequency' => 'nullable|string|max:255',
            'physical_activity' => 'boolean',
            'physical_activity_details' => 'nullable|string|max:255',
            'physical_activity_frequency' => 'nullable|string|max:255',
            'diet_type' => ['nullable', Rule::in(['hipo', 'normal', 'hiper'])],
            'meals_per_day' => 'nullable|string|max:255',
            'daily_liquids' => 'nullable|string|max:255',
            'sleep_quality' => ['nullable', Rule::in(['ruim', 'bom', 'excelente'])],
            'sleep_time_bed' => 'nullable|date_format:H:i', // Espera o formato HH:MM
            'sleep_time_wake' => 'nullable|date_format:H:i', // Espera o formato HH:MM
            'intestinal_function' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Mostra o formulário para criar uma nova avaliação.
     */
    public function create(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }
        return view('evaluations.create', compact('patient'));
    }

    /**
     * Salva a nova avaliação no banco de dados.
     */
    public function store(Request $request, Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $this->validateEvaluation($request);
        
        $patient->evaluations()->create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Avaliação (Anamnese) salva com sucesso!');
    }

    /**
     * Mostra o formulário para editar uma avaliação.
     */
    public function edit(Evaluation $evaluation)
    {
        $patient = $evaluation->patient;
        
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }

        return view('evaluations.edit', compact('evaluation', 'patient'));
    }

    /**
     * Atualiza uma avaliação.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $patient = $evaluation->patient;

        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $this->validateEvaluation($request);
        
        $evaluation->update($validated);

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Avaliação (Anamnese) atualizada com sucesso!');
    }

    /**
     * Deleta uma avaliação.
     */
    public function destroy(Evaluation $evaluation)
    {
        $patient = $evaluation->patient;

        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }
        
        $evaluation->delete();

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Avaliação (Anamnese) deletada com sucesso!');
    }
}