<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-sm font-medium text-gray-500 uppercase">Pacientes</h4>
                        <p class="mt-1 text-3xl font-bold text-blue-600">
                            {{ $totalPatients }}
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-sm font-medium text-gray-500 uppercase">Anamneses</h4>
                        <p class="mt-1 text-3xl font-bold text-blue-600">
                            {{ $totalEvaluations }}
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-sm font-medium text-gray-500 uppercase">Bioimpedâncias</h4>
                        <p class="mt-1 text-3xl font-bold text-blue-600">
                            {{ $totalBioimpedanceRecords }}
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-sm font-medium text-gray-500 uppercase">Medidas</h4>
                        <p class="mt-1 text-3xl font-bold text-blue-600">
                            {{ $totalMeasurements }}
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-sm font-medium text-gray-500 uppercase">Ação Rápida</h4>
                        <a href="{{ route('patients.create') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            + Novo Paciente
                        </a>
                    </div>
                </div>
                
                </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Pacientes Adicionados Recentemente</h4>
                    
                    <ul class="divide-y divide-gray-200">
                        @forelse ($recentPatients as $patient)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('patients.show', $patient) }}" class="text-md font-medium text-blue-600 hover:text-blue-900">
                                        {{ $patient->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">
                                        Adicionado em: {{ $patient->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                <a href="{{ route('patients.show', $patient) }}" class="text-sm text-gray-600 hover:text-gray-900">Ver Perfil &rarr;</a>
                            </li>
                        @empty
                            <li class="py-3">
                                <p class="text-gray-500">Nenhum paciente registado ainda.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>