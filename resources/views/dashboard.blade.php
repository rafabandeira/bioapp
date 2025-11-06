<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Total de Pacientes</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $patientCount }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Bioimpedâncias</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $bioimpedanceCount }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Medições</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $measurementCount }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 truncate">Avaliações</h3>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $evaluationCount }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Novos Pacientes (Últimos 6 Meses)</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="newPatientsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Distribuição de IMC dos Pacientes</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="patientImcChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Pacientes por Gênero</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="patientGenderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Últimas Bioimpedâncias</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse ($latestBios as $bio)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $bio->patient->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $bio->weight }} kg | {{ $bio->body_fat_percentage }}% GC</p>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $bio->created_at->format('d/m/y') }}</span>
                                </li>
                            @empty
                                <li class="py-3 text-sm text-gray-500">Nenhum registro encontrado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Últimas Medições</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse ($latestMeasurements as $measurement)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $measurement->patient->name }}</p>
                                        <p class="text-sm text-gray-500">Cintura: {{ $measurement->waist }} cm</p>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $measurement->created_at->format('d/m/y') }}</span>
                                </li>
                            @empty
                                <li class="py-3 text-sm text-gray-500">Nenhum registro encontrado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-800 mb-4">Últimas Avaliações</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse ($latestEvaluations as $evaluation)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $evaluation->patient->name }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ Str::limit($evaluation->complaints, 30) }}</p>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $evaluation->created_at->format('d/m/y') }}</span>
                                </li>
                            @empty
                                <li class="py-3 text-sm text-gray-500">Nenhum registro encontrado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('scripts')
        @vite('resources/js/charts/dashboard-charts.js')
    @endpush
</x-app-layout>