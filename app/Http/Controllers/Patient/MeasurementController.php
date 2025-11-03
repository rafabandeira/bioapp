<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
{
    /**
     * Validação baseada nos campos de 'corporais.php'
     */
    private function validateMeasurement(Request $request)
    {
        return $request->validate([
            'neck' => 'nullable|numeric|min:0|max:100',
            'chest' => 'nullable|numeric|min:0|max:300',
            'arm_right' => 'nullable|numeric|min:0|max:100',
            'arm_left' => 'nullable|numeric|min:0|max:100',
            'abdomen_upper' => 'nullable|numeric|min:0|max:300',
            'waist' => 'nullable|numeric|min:0|max:300',
            'abdomen_lower' => 'nullable|numeric|min:0|max:300',
            'hip' => 'nullable|numeric|min:0|max:300',
            'thigh_right' => 'nullable|numeric|min:0|max:100',
            'thigh_left' => 'nullable|numeric|min:0|max:100',
            'calf_right' => 'nullable|numeric|min:0|max:100',
            'calf_left' => 'nullable|numeric|min:0|max:100',
        ]);
    }

    /**
     * Mostra o formulário para criar um novo registro de medidas.
     */
    public function create(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }
        return view('measurements.create', compact('patient'));
    }

    /**
     * Salva o novo registro de medidas no banco.
     */
    public function store(Request $request, Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $this->validateMeasurement($request);

        // Salva o registro usando o relacionamento Eloquent
        $patient->measurements()->create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Novas medidas salvas com sucesso!');
    }

    /**
     * Mostra o formulário para editar um registro de medidas.
     */
    public function edit(Measurement $measurement)
    {
        // Carrega o paciente para garantir a verificação de segurança
        $patient = $measurement->patient;
        
        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }

        return view('measurements.edit', compact('measurement', 'patient'));
    }

    /**
     * Atualiza um registro de medidas no banco.
     */
    public function update(Request $request, Measurement $measurement)
    {
        $patient = $measurement->patient;

        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $this->validateMeasurement($request);
        
        $measurement->update($validated);

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Medidas atualizadas com sucesso!');
    }

    /**
     * Deleta um registro de medidas.
     */
    public function destroy(Measurement $measurement)
    {
        $patient = $measurement->patient;

        if ($patient->user_id !== Auth::id()) {
            abort(403);
        }
        
        $measurement->delete();

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Registro de medidas deletado com sucesso!');
    }
}