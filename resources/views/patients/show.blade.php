<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $patient->name }}
            </h2>
            <a href="{{ route('patients.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Voltar para Pacientes</a>
        </div>
    </x-slot>

    <div class="py-12" 
        data-bio-data='{{ $bio_chart_data }}' 
        data-measurements-data='{{ $measurements_chart_data }}'
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Composição Corporal Atual</h3>
                    <img src="{{ $avatarPath }}" alt="Avatar da composição corporal" class="mx-auto h-64 w-auto">
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-4 rounded-md shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Dados Cadastrais</h3>
                        <a href="{{ route('patients.edit', $patient) }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">
                            Editar Dados
                        </a>
                    </div>
                    
                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-3">
                        <div><dt class="text-sm font-medium text-gray-500">Email</dt><dd class="mt-1 text-sm text-gray-900">{{ $patient->email ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Telefone</dt><dd class="mt-1 text-sm text-gray-900">{{ $patient->phone ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Gênero</dt><dd class="mt-1 text-sm text-gray-900">{{ $patient->gender == 'M' ? 'Masculino' : ($patient->gender == 'F' ? 'Feminino' : 'N/A') }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Nascimento</dt><dd class="mt-1 text-sm text-gray-900">{{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Altura</dt><dd class="mt-1 text-sm text-gray-900">{{ $patient->height ? $patient->height . ' cm' : 'N/A' }}</dd></div>
                    </dl>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Classificação</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-3">
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Peso</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($latestBio)
                                    {{ $latestBio->weight }} kg
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">IMC</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($bmi)
                                    <span class="font-bold text-lg {{ $bmiColorClass }}">
                                        {{ $bmi }}
                                    </span>
                                    <span class="text-sm {{ $bmiColorClass }}">
                                        ({{ $bmiClassification }})
                                    </span>
                                @else
                                    N/A (Altura/Peso não registrados)
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Gordura Corporal</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($latestBio && $latestBio->body_fat_percentage)
                                    <span class="font-bold text-lg {{ $bfpColorClass }}">
                                        {{ $latestBio->body_fat_percentage }} %
                                    </span>
                                    <span class="text-sm {{ $bfpColorClass }}">
                                        ({{ $bfpClassification }})
                                    </span>
                                @else
                                    N/A (Bioimpedância não registrada)
                                @endif
                            </dd>
                        </div>

<div>
                            <dt class="text-sm font-medium text-gray-500">Músculo Esquelético</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($latestBio && $latestBio->skeletal_muscle_percentage)
                                    <span class="font-bold text-lg {{ $skmColorClass }}">
                                        {{ $latestBio->skeletal_muscle_percentage }} %
                                    </span>
                                    <span class="text-sm {{ $skmColorClass }}">
                                        ({{ $skmClassification }})
                                    </span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Gordura Visceral (Nível)</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($latestBio && $latestBio->visceral_fat_level)
                                    <span class="font-bold text-lg {{ $vflColorClass }}">
                                        {{ $latestBio->visceral_fat_level }}
                                    </span>
                                    <span class="text-sm {{ $vflColorClass }}">
                                        ({{ $vflClassification }})
                                    </span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>

<div>
                            <dt class="text-sm font-medium text-gray-500">Metabolismo Basal (TMB)</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($tmb)
                                    <span class="font-bold text-lg text-gray-900">
                                        {{ $tmb }} kcal
                                    </span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Idade Metabólica</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{-- Usar a propriedade body_age lida pelo Controller --}}
                                @if($latestBio && isset($latestBio->body_age))
                                    <span class="font-bold text-lg {{ $metabolicAgeColorClass }}">
                                        {{ $latestBio->body_age }} anos
                                    </span>
                                    <span class="text-sm {{ $metabolicAgeColorClass }}">
                                        ({{ $metabolicAgeClassification }})
                                    </span>
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Evolução do Paciente</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <div>
                            <h4 class="text-lg font-medium mb-3">Histórico de Bioimpedância</h4>
                            @if(count(json_decode($bio_chart_data, true)) > 0)
                                <canvas id="bioimpedanceChart"></canvas>
                            @else
                                <p class="text-gray-500">Adicione registros de bioimpedância para ver o gráfico.</p>
                            @endif
                        </div>

                        <div>
                            <h4 class="text-lg font-medium mb-3">Histórico de Medidas Corporais</h4>
                            @if(count(json_decode($measurements_chart_data, true)) > 0)
                                <canvas id="measurementsChart"></canvas>
                            @else
                                <p class="text-gray-500">Adicione registros de medidas para ver o gráfico.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Histórico de Bioimpedância</h3>
                        <a href="{{ route('patients.bioimpedance-records.create', $patient) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            + Adicionar
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peso (kg)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gordura (%)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Músculo (%)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">TMB (kcal)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Idade Corp.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gord. Visc.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($patient->bioimpedanceRecords as $record)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->weight ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->body_fat_percentage ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->skeletal_muscle_percentage ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->basal_metabolism_kcal ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->body_age ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->visceral_fat_level ?? 'N/A' }}</td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('bioimpedance-records.edit', $record) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                            <form action="{{ route('bioimpedance-records.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar este registro de bioimpedância?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Nenhum registro de bioimpedância encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Histórico de Medidas (cm)</h3>
                        <a href="{{ route('patients.measurements.create', $patient) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            + Adicionar
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pescoço</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tórax</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cintura</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quadril</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Braço D.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($patient->measurements as $record)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->neck ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->chest ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->waist ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->hip ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->arm_right ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('measurements.edit', $record) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                            <form action="{{ route('measurements.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar este registro de medidas?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Nenhum registro de medidas encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Histórico de Avaliações (Anamnese)</h3>
                        <a href="{{ route('patients.evaluations.create', $patient) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            + Adicionar Avaliação
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Queixa Principal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objetivos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($patient->evaluations as $record)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->qp ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($record->objectives, 50) ?? 'N/A' }}</td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('evaluations.edit', $record) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                            
                                            <form action="{{ route('evaluations.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar esta avaliação?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Nenhuma avaliação encontrada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Seleciona a div principal que contém os data-attributes
        const mainDiv = document.querySelector('.py-12[data-bio-data]');
        
        if (window.renderPatientCharts && mainDiv) {
            // Lê os dados JSON (que agora são strings JSON puras)
            const bioDataJson = mainDiv.dataset.bioData;
            const measurementsDataJson = mainDiv.dataset.measurementsData;

            // Chama a função global do JavaScript (definida em patient-charts.js)
            window.renderPatientCharts(
                bioDataJson,
                measurementsDataJson
            );
        } else {
            console.error('Falha ao carregar gráficos: renderPatientCharts não está definido ou div principal não encontrada.');
        }
    });
</script>
@endpush
</x-app-layout>