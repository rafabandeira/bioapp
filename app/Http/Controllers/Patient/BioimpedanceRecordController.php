<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\BioimpedanceRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BioimpedanceRecordController extends Controller
{
    /**
     * Validação baseada nos campos da Bioimpedância.
     */
    private function validateBioimpedance(Request $request)
    {
        return $request->validate([
            'weight' => 'required|numeric|min:0|max:500',
            'body_fat_percentage' => 'nullable|numeric|min:0|max:100',
            'skeletal_muscle_percentage' => 'nullable|numeric|min:0|max:100',
            'visceral_fat_level' => 'nullable|integer|min:0|max:100',
            'basal_metabolism_kcal' => 'nullable|integer|min:0|max:10000',
            'body_age' => 'nullable|integer|min:0|max:150',
        ]);
    }

    /**
     * Mostra o formulário para criar um novo registro de bioimpedância.
     */
    public function create(Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('bioimpedance.create', compact('patient'));
    }

    /**
     * Salva o novo registro de bioimpedância no banco de dados.
     */
    public function store(Request $request, Patient $patient)
    {
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $validated = $this->validateBioimpedance($request);

        // Salva o registro usando o relacionamento Eloquent
        $patient->bioimpedanceRecords()->create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Registro de bioimpedância salvo com sucesso!');
    }

    /**
     * Mostra o formulário para editar um registro de bioimpedância.
     * Note que a rota 'shallow' usa apenas $bioimpedanceRecord.
     */
    public function edit(BioimpedanceRecord $bioimpedanceRecord)
    {
        $patient = $bioimpedanceRecord->patient;
        
        // Garante que o usuário logado possui este paciente (segurança)
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('bioimpedance.edit', compact('bioimpedanceRecord', 'patient'));
    }

    /**
     * Atualiza o registro de bioimpedância no banco.
     */
    public function update(Request $request, BioimpedanceRecord $bioimpedanceRecord)
    {
        $patient = $bioimpedanceRecord->patient;
        
        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $validated = $this->validateBioimpedance($request);

        $bioimpedanceRecord->update($validated);

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Bioimpedância atualizada com sucesso!');
    }

    /**
     * Deleta um registro de bioimpedância.
     */
    public function destroy(BioimpedanceRecord $bioimpedanceRecord)
    {
        $patient = $bioimpedanceRecord->patient;

        if ($patient->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $bioimpedanceRecord->delete();

        return redirect()->route('patients.show', $patient)
            ->with('status', 'Registro de bioimpedância deletado com sucesso!');
    }
}