<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Patient\BioimpedanceRecordController;
use App\Http\Controllers\Patient\MeasurementController;
use App\Http\Controllers\Patient\EvaluationController; // <-- NOVO

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

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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