<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Bioimpedância ({{ $bioimpedanceRecord->created_at->format('d/m/Y') }}) - {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('bioimpedance-records.update', $bioimpedanceRecord) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-2 gap-6 sm:grid-cols-4">

                            <div>
                                <x-input-label for="recorded_at" :value="__('Data da Aferição')" />

                                <x-text-input id="recorded_at" class="block mt-1 w-full"
                                            type="date"  {{-- MUDANÇA 1: de datetime-local para date --}}
                                            name="recorded_at"
                                            :value="old('recorded_at', $bioimpedanceRecord->recorded_at->format('Y-m-d'))"
                                            required />

                                <x-input-error :messages="$errors->get('recorded_at')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="weight" :value="__('Peso (kg)')" />
                                <x-text-input id="weight" class="block mt-1 w-full" type="number" step="0.1" name="weight" :value="old('weight', $bioimpedanceRecord->weight)" required />
                            </div>

                            <div>
                                <x-input-label for="body_fat_percentage" :value="__('Gordura Corporal (%)')" />
                                <x-text-input id="body_fat_percentage" class="block mt-1 w-full" type="number" step="0.1" name="body_fat_percentage" :value="old('body_fat_percentage', $bioimpedanceRecord->body_fat_percentage)" />
                            </div>

                            <div>
                                <x-input-label for="skeletal_muscle_percentage" :value="__('Músculo Esq. (%)')" />
                                <x-text-input id="skeletal_muscle_percentage" class="block mt-1 w-full" type="number" step="0.1" name="skeletal_muscle_percentage" :value="old('skeletal_muscle_percentage', $bioimpedanceRecord->skeletal_muscle_percentage)" />
                            </div>

                            <div>
                                <x-input-label for="basal_metabolism_kcal" :value="__('Metab. Basal (kcal)')" />
                                <x-text-input id="basal_metabolism_kcal" class="block mt-1 w-full" type="number" name="basal_metabolism_kcal" :value="old('basal_metabolism_kcal', $bioimpedanceRecord->basal_metabolism_kcal)" />
                            </div>

                            <div>
                                <x-input-label for="visceral_fat_level" :value="__('Gordura Visceral (Nível)')" />
                                <x-text-input id="visceral_fat_level" class="block mt-1 w-full" type="number" name="visceral_fat_level" :value="old('visceral_fat_level', $bioimpedanceRecord->visceral_fat_level)" />
                            </div>

                            <div>
                                <x-input-label for="body_age" :value="__('Idade Corporal (anos)')" />
                                <x-text-input id="body_age" class="block mt-1 w-full" type="number" name="body_age" :value="old('body_age', $bioimpedanceRecord->body_age)" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Atualizar Bioimpedância') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>