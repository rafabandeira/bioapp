<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Patient; // Necessário
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostra o dashboard principal com todos os dados.
     */
    public function index()
    {
        // Pega o usuário logado
        $user = Auth::user();

        // 1. CARDS DE ESTATÍSTICAS
        // Graças ao Passo 1, podemos fazer isso de forma limpa:
        $patientCount = $user->patients()->count();
        $bioimpedanceCount = $user->bioimpedanceRecords()->count();
        $measurementCount = $user->measurements()->count();
        $evaluationCount = $user->evaluations()->count();

        // 2. HISTÓRICOS RECENTES
        // Usamos with('patient') para "Eager Load" - carregar o paciente junto
        // Isso evita 100 consultas ao banco (problema N+1)
        $latestBios = $user->bioimpedanceRecords()
                            ->with('patient') // Pega os dados do paciente junto
                            ->latest('recorded_at') // Ordena pelo mais novo
                            ->take(5) // Pega os 5 últimos
                            ->get();

        $latestMeasurements = $user->measurements()
                            ->with('patient')
                            ->latest('recorded_at')
                            ->take(5)
                            ->get();
        
        $latestEvaluations = $user->evaluations()
                            ->with('patient')
                            ->latest('recorded_at')
                            ->take(5)
                            ->get();

        // 3. Envia tudo para a View
        return view('dashboard', [
            'patientCount' => $patientCount,
            'bioimpedanceCount' => $bioimpedanceCount,
            'measurementCount' => $measurementCount,
            'evaluationCount' => $evaluationCount,
            'latestBios' => $latestBios,
            'latestMeasurements' => $latestMeasurements,
            'latestEvaluations' => $latestEvaluations,
        ]);
    }

    /**
     * Fornece dados para o gráfico de Pacientes por Gênero.
     */
    public function patientGenderChart()
    {
        $maleCount = Auth::user()->patients()->where('gender', 'M')->count();
        $femaleCount = Auth::user()->patients()->where('gender', 'F')->count();
        // (Bônus) Contar qualquer um que não seja 'M' ou 'F'
        $otherCount = Auth::user()->patients()->whereNotIn('gender', ['M', 'F'])->count();

        return response()->json([
            'labels' => ['Masculino', 'Feminino', 'Outro'],
            'data' => [$maleCount, $femaleCount, $otherCount],
        ]);
    }

    /**
     * Fornece dados para o gráfico de novos pacientes (você já tinha).
     */
    public function newPatientsChart()
    {
        $months = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $labels = []; 
        $data = [];   

        foreach ($months as $month) {
            $labels[] = $month->format('M/y'); 

            $count = Patient::where('user_id', Auth::id())
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $data[] = $count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

/**
     * Fornece dados para o gráfico de distribuição de IMC.
     */
    public function patientImcDistributionChart()
    {
        // 1. Pega todos os pacientes do usuário com seu ÚLTIMO registro
        $patients = Auth::user()->patients()
                        ->with('latestBioimpedanceRecord') // Usa a relação que criamos
                        ->get();

        // 2. Prepara as categorias da OMS
        $categories = [
            'Abaixo do Peso' => 0,
            'Normal' => 0,
            'Sobrepeso' => 0,
            'Obesidade' => 0,
        ];

        // 3. Itera em cada paciente para calcular e classificar
        foreach ($patients as $patient) {
            
            // Só podemos calcular se tivermos altura E um último registro com peso
            if ($patient->height && $patient->latestBioimpedanceRecord && $patient->latestBioimpedanceRecord->weight) {
                
                $height_m = $patient->height / 100;
                $weight = $patient->latestBioimpedanceRecord->weight;
                
                // Evita divisão por zero se a altura for 0
                if ($height_m > 0) {
                    $imc = $weight / ($height_m * $height_m);

                    // 4. Classifica o IMC
                    if ($imc < 18.5) {
                        $categories['Abaixo do Peso']++;
                    } elseif ($imc < 25) { // 18.5 - 24.9
                        $categories['Normal']++;
                    } elseif ($imc < 30) { // 25.0 - 29.9
                        $categories['Sobrepeso']++;
                    } else { // >= 30
                        $categories['Obesidade']++;
                    }
                }
            }
            // (Pacientes sem altura ou bioimpedância são ignorados no gráfico)
        }

        // 5. Retorna o JSON para o gráfico
        return response()->json([
            'labels' => array_keys($categories),
            'data' => array_values($categories),
        ]);
    }


}