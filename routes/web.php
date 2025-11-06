<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Patient\BioimpedanceRecordController;
use App\Http\Controllers\Patient\MeasurementController;
use App\Http\Controllers\Patient\EvaluationController;
use App\Http\Controllers\DashboardController;

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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Gráfico Novos PACIENTES
    Route::get('/api/charts/new-patients', [DashboardController::class, 'newPatientsChart'])
         ->name('api.charts.new-patients');
         
    // Gráfico de GÊNERO
    Route::get('/api/charts/patient-gender', [DashboardController::class, 'patientGenderChart'])
         ->name('api.charts.patient-gender');

    // Gráfico de distribuição de IMC
    Route::get('/api/charts/patient-imc-distribution', [DashboardController::class, 'patientImcDistributionChart'])
         ->name('api.charts.patient-imc-distribution');

    // 1. Pacientes (Recurso Pai)
    Route::resource('patients', PatientController::class);

    // 2. Bioimpedância (Recurso Filho)
    Route::resource('patients.bioimpedance-records', BioimpedanceRecordController::class)
        ->shallow(); 

    // 3. Medidas (Recurso Filho)
    Route::resource('patients.measurements', MeasurementController::class)
        ->shallow(); 

    // 4. Avaliações (Recurso Filho - Anamnese)
    Route::resource('patients.evaluations', EvaluationController::class)
        ->shallow(); 

}); 

require __DIR__.'/auth.php';