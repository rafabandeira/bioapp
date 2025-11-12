<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Patient\BioimpedanceRecordController;
use App\Http\Controllers\Patient\MeasurementController;
use App\Http\Controllers\Patient\EvaluationController;

use Illuminate\Support\Facades\Auth;

// NOVAS IMPORTAÇÕES DE MODELS NECESSÁRIAS PARA O DASHBOARD
use App\Models\BioimpedanceRecord;
use App\Models\Measurement;
use App\Models\Evaluation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rotas que EXIGEM autenticação
Route::middleware('auth')->group(function () {

    // CORREÇÃO: Rota do Dashboard agora usa nomes de variáveis que a view exige
    Route::get('/dashboard', function () {
        
        $userPatientsQuery = Auth::user()->patients();
        $patientIds = $userPatientsQuery->pluck('id'); 
        
        $totalPatients = $userPatientsQuery->count();
        $recentPatients = $userPatientsQuery->orderBy('created_at', 'desc')->take(5)->get();

        // Variáveis renomeadas para a view:
        $totalBioimpedanceRecords = BioimpedanceRecord::whereIn('patient_id', $patientIds)->count(); // Variável que faltava
        $totalMeasurements = Measurement::whereIn('patient_id', $patientIds)->count();
        $totalEvaluations = Evaluation::whereIn('patient_id', $patientIds)->count(); 

        return view('dashboard', [
            'totalPatients' => $totalPatients,
            'recentPatients' => $recentPatients,
            // Variáveis renomeadas para corresponder ao dashboard.blade.php:
            'totalBioimpedanceRecords' => $totalBioimpedanceRecords, 
            'totalMeasurements' => $totalMeasurements,
            'totalEvaluations' => $totalEvaluations,
        ]);
    })->name('dashboard');

    Route::resource('patients', PatientController::class);

    Route::resource('patients.bioimpedance-records', BioimpedanceRecordController::class)
        ->shallow(); 

    Route::resource('patients.measurements', MeasurementController::class)
        ->shallow(); 

    Route::resource('patients.evaluations', EvaluationController::class)
        ->shallow(); 

}); 

require __DIR__.'/auth.php';