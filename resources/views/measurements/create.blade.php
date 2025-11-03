<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novas Medidas Corporais para: {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('patients.measurements.store', $patient) }}">
                        @csrf
                        
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Medidas (em cm)</h3>
                        <div class="grid grid-cols-2 gap-6 sm:grid-cols-4">
                            
                            <div><x-input-label for="neck" :value="__('Pescoço')" /><x-text-input id="neck" class="block mt-1 w-full" type="number" step="0.1" name="neck" :value="old('neck')" /><x-input-error class="mt-2" :messages="$errors->get('neck')" /></div>
                            <div><x-input-label for="chest" :value="__('Tórax')" /><x-text-input id="chest" class="block mt-1 w-full" type="number" step="0.1" name="chest" :value="old('chest')" /><x-input-error class="mt-2" :messages="$errors->get('chest')" /></div>

                            <div><x-input-label for="arm_right" :value="__('Braço D.')" /><x-text-input id="arm_right" class="block mt-1 w-full" type="number" step="0.1" name="arm_right" :value="old('arm_right')" /><x-input-error class="mt-2" :messages="$errors->get('arm_right')" /></div>
                            <div><x-input-label for="arm_left" :value="__('Braço E.')" /><x-text-input id="arm_left" class="block mt-1 w-full" type="number" step="0.1" name="arm_left" :value="old('arm_left')" /><x-input-error class="mt-2" :messages="$errors->get('arm_left')" /></div>

                            <div><x-input-label for="waist" :value="__('Cintura')" /><x-text-input id="waist" class="block mt-1 w-full" type="number" step="0.1" name="waist" :value="old('waist')" /><x-input-error class="mt-2" :messages="$errors->get('waist')" /></div>
                            <div><x-input-label for="abdomen_upper" :value="__('Abd. Superior')" /><x-text-input id="abdomen_upper" class="block mt-1 w-full" type="number" step="0.1" name="abdomen_upper" :value="old('abdomen_upper')" /><x-input-error class="mt-2" :messages="$errors->get('abdomen_upper')" /></div>

                            <div><x-input-label for="abdomen_lower" :value="__('Abd. Inferior')" /><x-text-input id="abdomen_lower" class="block mt-1 w-full" type="number" step="0.1" name="abdomen_lower" :value="old('abdomen_lower')" /><x-input-error class="mt-2" :messages="$errors->get('abdomen_lower')" /></div>
                            <div><x-input-label for="hip" :value="__('Quadril')" /><x-text-input id="hip" class="block mt-1 w-full" type="number" step="0.1" name="hip" :value="old('hip')" /><x-input-error class="mt-2" :messages="$errors->get('hip')" /></div>

                            <div><x-input-label for="thigh_right" :value="__('Coxa D.')" /><x-text-input id="thigh_right" class="block mt-1 w-full" type="number" step="0.1" name="thigh_right" :value="old('thigh_right')" /><x-input-error class="mt-2" :messages="$errors->get('thigh_right')" /></div>
                            <div><x-input-label for="thigh_left" :value="__('Coxa E.')" /><x-text-input id="thigh_left" class="block mt-1 w-full" type="number" step="0.1" name="thigh_left" :value="old('thigh_left')" /><x-input-error class="mt-2" :messages="$errors->get('thigh_left')" /></div>

                            <div><x-input-label for="calf_right" :value="__('Pant. D.')" /><x-text-input id="calf_right" class="block mt-1 w-full" type="number" step="0.1" name="calf_right" :value="old('calf_right')" /><x-input-error class="mt-2" :messages="$errors->get('calf_right')" /></div>
                            <div><x-input-label for="calf_left" :value="__('Pant. E.')" /><x-text-input id="calf_left" class="block mt-1 w-full" type="number" step="0.1" name="calf_left" :value="old('calf_left')" /><x-input-error class="mt-2" :messages="$errors->get('calf_left')" /></div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>{{ __('Salvar Medidas') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>