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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Dados Cadastrais</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nome</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-bold">{{ $patient->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Idade / Gênero</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-bold">{{ $patient->birth_date ? $patient->birth_date->age : 'N/A' }} anos / {{ $patient->gender === 'M' ? 'Masculino' : ($patient->gender === 'F' ? 'Feminino' : 'Outro') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Altura</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-bold">{{ $patient->height ? $patient->height . ' cm' : 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-bold">{{ $patient->phone ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">E-mail</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-bold truncate">{{ $patient->email ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Avatar - Composição</h3>
                        <img src="{{ asset('avatars/' . $avatarName . '.png') }}" alt="Composição Corporal" class="block mx-auto">
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Classificações de Risco</h3>
                        <dl class="space-y-3">

                            <dl class="mt-4 text-left">
                                <dt class="text-sm font-medium text-gray-500">IMC</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($bmi)
                                        <span class="font-bold text-lg {{ $bmiColorClass }}">
                                            {{ $bmi }}
                                        </span>
                                        <x-classification-pill :classification="$bmiClassification" :color-class="$bmiColorClass" />
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </dl>

                            {{-- Classificação de Gordura Corporal --}}
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Gordura Corporal (%)</dt>
                                <dd class="font-bold text-lg {{ $bfpColorClass }}">
                                    {{ $latestRecord?->body_fat_percentage ?? 'N/A' }} 
                                    @if ($bfpClassification) <x-classification-pill :classification="$bfpClassification" :color-class="$bfpColorClass" />@endif
                                </dd>
                            </div>
                            
                            {{-- Classificação de Músculo Esquelético --}}
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Músculo Esquelético (%)</dt>
                                <dd class="font-bold text-lg {{ $skmColorClass }}">
                                    {{ $latestRecord?->skeletal_muscle_percentage ?? 'N/A' }}
                                    @if ($skmClassification) <x-classification-pill :classification="$skmClassification" :color-class="$skmColorClass" />@endif
                                </dd>
                            </div>

                            {{-- Classificação de Gordura Visceral --}}
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Gordura Visceral (Nível)</dt>
                                <dd class="font-bold text-lg {{ $vflColorClass }}">
                                    {{ $latestRecord?->visceral_fat_level ?? 'N/A' }}
                                    @if ($vflClassification) <x-classification-pill :classification="$vflClassification" :color-class="$vflColorClass" />@endif
                                </dd>
                            </div>

                            {{-- Idade Metabólica --}}
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Idade Metabólica</dt>
                                <dd class="font-bold text-lg {{ $metabolicAgeColorClass }}">
                                    {{ $latestRecord?->body_age ?? 'N/A' }} anos
                                    @if ($metabolicAgeClassification) <x-classification-pill :classification="$metabolicAgeClassification" :color-class="$metabolicAgeColorClass" />@endif
                                </dd>
                            </div>
                            
                            {{-- TMB --}}
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Taxa Metabólica</dt>
                                <dd class="font-bold text-lg">
                                    {{ $tmb ? number_format($tmb, 0) . ' kcal' : 'N/A' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </div>

            





            




            @if ($previousRecord && $firstRecord)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Comparativo de Bioimpedância</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Indicador</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Última ({{ $previousRecord->recorded_at->format('d/m/Y') }})</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Primeira ({{ $firstRecord->recorded_at->format('d/m/Y') }})</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                
                                {{-- Linha 1: Tempo (Calcula a diferença em dias) --}}
                                @php
                                    // Cálculo da diferença de tempo entre a última e a primeira aferição
                                    $dateDiff = $latestRecord->recorded_at->diffInDays($previousRecord->recorded_at);
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Tempo</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm" colspan="2">
                                        {{ $dateDiff }} dias
                                    </td>
                                </tr>
                                
                                {{-- Linha 2: Peso --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Peso (kg)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($latestRecord->weight, 1) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($firstRecord->weight, 1) }}</td>
                                </tr>

                                {{-- Linha 3: IMC (Assume-se que o IMC é calculado no Controller e está disponível como $bmi) --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">IMC</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $bmi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{-- Calcula o IMC do primeiro registro (Peso / Altura²). Altura é estática no Paciente. --}}
                                        @php
                                            $heightMeters = $patient->height / 100;
                                            $firstBmi = $heightMeters ? number_format($firstRecord->weight / ($heightMeters * $heightMeters), 2) : 'N/A';
                                        @endphp
                                        {{ $firstBmi }}
                                    </td>
                                </tr>
                                
                                {{-- Linha 4: Gordura Corporal --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Gordura Corporal (%)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($latestRecord->body_fat_percentage, 1) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($firstRecord->body_fat_percentage, 1) }}</td>
                                </tr>
                                
                                {{-- Linha 5: Músculo Esquelético --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Músculo Esquelético (%)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($latestRecord->skeletal_muscle_percentage, 1) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($firstRecord->skeletal_muscle_percentage, 1) }}</td>
                                </tr>

                                {{-- Linha 6: Gordura Visceral --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Gordura Visceral (Nível)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $latestRecord->visceral_fat_level }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $firstRecord->visceral_fat_level }}</td>
                                </tr>
                                
                                {{-- Linha 7: Metabolismo Basal (TMB) --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Metabolismo Basal (kcal)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $latestRecord->basal_metabolism_kcal }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $firstRecord->basal_metabolism_kcal }}</td>
                                </tr>
                                
                                {{-- Linha 8: Idade Corporal (Idade Metabólica) --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">Idade Corporal (Anos)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $latestRecord->body_age }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $firstRecord->body_age }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif











            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Evolução do Paciente</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <div class="relative h-96">
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
                        <h3 class="text-lg font-medium text-gray-900">Histórico de Bioimpedância </h3>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->recorded_at->format('d/m/Y') }}</td>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->recorded_at->format('d/m/Y') }}</td>
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
                            + Adicionar
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->recorded_at->format('d/m/Y H:i') }}</td>
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