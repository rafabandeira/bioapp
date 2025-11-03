<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Paciente: {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('patients.update', $patient) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            
                            <div class="sm:col-span-2">
                                <x-input-label for="name" :value="__('Nome do Paciente')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $patient->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Gênero')" />
                                <select id="gender" name="gender" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Selecione</option>
                                    <option value="M" {{ old('gender', $patient->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('gender', $patient->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('Data Nascimento')" />
                                <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '')" />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <div>
                                <x-input-label for="height" :value="__('Altura (cm)')" />
                                <x-text-input id="height" class="block mt-1 w-full" type="number" step="0.1" name="height" :value="old('height', $patient->height)" />
                                <x-input-error class="mt-2" :messages="$errors->get('height')" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Celular/WhatsApp')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $patient->phone)" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>
                            
                            <div class="sm:col-span-2">
                                <x-input-label for="email" :value="__('E-mail')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $patient->email)" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Atualizar Paciente') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>