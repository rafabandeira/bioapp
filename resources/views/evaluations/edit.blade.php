<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Avaliação (Anamnese) para: {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('evaluations.update', $evaluation) }}">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">1. Anamnese</h3>

                        <div class="grid grid-cols-1 gap-6 mb-8">
                            <div>
                                <x-input-label for="qp" :value="__('Queixa Principal (QP)')" />
                                <x-text-input id="qp" class="block mt-1 w-full" type="text" name="qp" :value="old('qp', $evaluation->qp)" />
                                <x-input-error class="mt-2" :messages="$errors->get('qp')" />
                            </div>

                            <div>
                                <x-input-label for="hda" :value="__('História da Doença Atual (HDA)')" />
                                <textarea id="hda" name="hda" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('hda', $evaluation->hda) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('hda')" />
                            </div>

                            <div>
                                <x-input-label for="objectives" :value="__('Objetivos do Tratamento')" />
                                <textarea id="objectives" name="objectives" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('objectives', $evaluation->objectives) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('objectives')" />
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">2. Antecedentes</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="md:col-span-2">
                                <x-input-label for="pathological_history" :value="__('Histórico Patológico (Doenças)')" />
                                <textarea id="pathological_history" name="pathological_history" rows="2" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('pathological_history', $evaluation->pathological_history) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('pathological_history')" />
                            </div>

                            <div class="md:col-span-2 space-y-3">
                                <p class="text-sm font-medium text-gray-700">Doenças Circulatórias?</p>
                                <label for="circulatory_disorder_yes" class="inline-flex items-center">
                                    <input id="circulatory_disorder_yes" type="checkbox" name="circulatory_disorder" value="1" {{ old('circulatory_disorder', $evaluation->circulatory_disorder) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ms-2 text-sm text-gray-600">Sim</span>
                                </label>

                                <x-input-label for="circulatory_disorder_details" :value="__('Quais?')" class="mt-2" />
                                <x-text-input id="circulatory_disorder_details" class="block mt-1 w-full" type="text" name="circulatory_disorder_details" :value="old('circulatory_disorder_details', $evaluation->circulatory_disorder_details)" />
                            
                                <x-input-label for="circulatory_family_history" :value="__('Histórico Familiar Circulatório?')" class="mt-4" />
                                <label for="circulatory_family_history_yes" class="inline-flex items-center">
                                    <input id="circulatory_family_history_yes" type="checkbox" name="circulatory_family_history" value="1" {{ old('circulatory_family_history', $evaluation->circulatory_family_history) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ms-2 text-sm text-gray-600">Sim</span>
                                </label>
                            </div>

                            <div class="md:col-span-2 space-y-3">
                                <p class="text-sm font-medium text-gray-700">Distúrbios Endócrinos?</p>
                                <label for="endocrine_disorder_yes" class="inline-flex items-center">
                                    <input id="endocrine_disorder_yes" type="checkbox" name="endocrine_disorder" value="1" {{ old('endocrine_disorder', $evaluation->endocrine_disorder) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ms-2 text-sm text-gray-600">Sim</span>
                                </label>

                                <x-input-label for="endocrine_disorder_details" :value="__('Quais?')" class="mt-2" />
                                <x-text-input id="endocrine_disorder_details" class="block mt-1 w-full" type="text" name="endocrine_disorder_details" :value="old('endocrine_disorder_details', $evaluation->endocrine_disorder_details)" />
                            
                                <x-input-label for="endocrine_family_history" :value="__('Histórico Familiar Endócrino?')" class="mt-4" />
                                <label for="endocrine_family_history_yes" class="inline-flex items-center">
                                    <input id="endocrine_family_history_yes" type="checkbox" name="endocrine_family_history" value="1" {{ old('endocrine_family_history', $evaluation->endocrine_family_history) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ms-2 text-sm text-gray-600">Sim</span>
                                </label>
                            </div>

                            <div class="md:col-span-2 space-y-3">
                                <p class="text-sm font-medium text-gray-700">Faz uso de medicação contínua?</p>
                                <label for="uses_medication_yes" class="inline-flex items-center">
                                    <input id="uses_medication_yes" type="checkbox" name="uses_medication" value="1" {{ old('uses_medication', $evaluation->uses_medication) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ms-2 text-sm text-gray-600">Sim</span>
                                </label>

                                <x-input-label for="medication_time" :value="__('Há quanto tempo?')" class="mt-2" />
                                <x-text-input id="medication_time" class="block mt-1 w-full" type="text" name="medication_time" :value="old('medication_time', $evaluation->medication_time)" />
                                
                                <x-input-label for="medication_details" :value="__('Quais medicamentos?')" class="mt-2" />
                                <textarea id="medication_details" name="medication_details" rows="2" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('medication_details', $evaluation->medication_details) }}</textarea>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2 mt-8">3. Ginecológico</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            
                            <div>
                                <x-input-label for="menstruation" :value="__('Menstruação')" />
                                <select id="menstruation" name="menstruation" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">N/A</option>
                                    <option value="regular" {{ old('menstruation', $evaluation->menstruation) == 'regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="irregular" {{ old('menstruation', $evaluation->menstruation) == 'irregular' ? 'selected' : '' }}>Irregular</option>
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="tpm" :value="__('Tem TPM?')" />
                                <select id="tpm" name="tpm" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">N/A</option>
                                    <option value="1" {{ old('tpm', $evaluation->tpm) == '1' ? 'selected' : '' }}>Sim</option>
                                    <option value="0" {{ old('tpm', $evaluation->tpm) == '0' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="menopause" :value="__('Está na Menopausa?')" />
                                <select id="menopause" name="menopause" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">N/A</option>
                                    <option value="1" {{ old('menopause', $evaluation->menopause) == '1' ? 'selected' : '' }}>Sim</option>
                                    <option value="0" {{ old('menopause', $evaluation->menopause) == '0' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="menopause_age" :value="__('Idade na Menopausa')" />
                                <x-text-input id="menopause_age" class="block mt-1 w-full" type="text" name="menopause_age" :value="old('menopause_age', $evaluation->menopause_age)" />
                            </div>

                            <div>
                                <x-input-label for="gestation" :value="__('Está Grávida/Lactante?')" />
                                <select id="gestation" name="gestation" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">N/A</option>
                                    <option value="1" {{ old('gestation', $evaluation->gestation) == '1' ? 'selected' : '' }}>Sim</option>
                                    <option value="0" {{ old('gestation', $evaluation->gestation) == '0' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="gestation_count" :value="__('Quantas gestações?')" />
                                <x-text-input id="gestation_count" class="block mt-1 w-full" type="number" name="gestation_count" :value="old('gestation_count', $evaluation->gestation_count)" />
                            </div>

                            <div>
                                <x-input-label for="children_count" :value="__('Qtde. de Filhos')" />
                                <x-text-input id="children_count" class="block mt-1 w-full" type="number" name="children_count" :value="old('children_count', $evaluation->children_count)" />
                            </div>
                            
                            <div class="md:col-span-3 space-y-3">
                                <p class="text-sm font-medium text-gray-700">Faz uso de medicação ginecológica (anticoncepcional, etc.)?</p>
                                <label for="uses_gyno_medication_yes" class="inline-flex items-center">
                                    <input id="uses_gyno_medication_yes" type="checkbox" name="uses_gyno_medication" value="1" {{ old('uses_gyno_medication', $evaluation->uses_gyno_medication) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ms-2 text-sm text-gray-600">Sim</span>
                                </label>

                                <x-input-label for="gyno_medication_details" :value="__('Quais?')" class="mt-2" />
                                <textarea id="gyno_medication_details" name="gyno_medication_details" rows="2" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('gyno_medication_details', $evaluation->gyno_medication_details) }}</textarea>
                            </div>
                        </div>


                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2 mt-8">4. Hábitos de Vida</h3>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                            
                            <div class="md:col-span-2">
                                <x-input-label for="consumes_alcohol" :value="__('Consome Bebida Alcoólica?')" />
                                <select id="consumes_alcohol" name="consumes_alcohol" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="0" {{ old('consumes_alcohol', $evaluation->consumes_alcohol) == '0' ? 'selected' : '' }}>Não</option>
                                    <option value="1" {{ old('consumes_alcohol', $evaluation->consumes_alcohol) == '1' ? 'selected' : '' }}>Sim</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="alcohol_frequency" :value="__('Frequência (Álcool)')" />
                                <x-text-input id="alcohol_frequency" class="block mt-1 w-full" type="text" name="alcohol_frequency" :value="old('alcohol_frequency', $evaluation->alcohol_frequency)" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="is_smoker" :value="__('Fumante?')" />
                                <select id="is_smoker" name="is_smoker" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="0" {{ old('is_smoker', $evaluation->is_smoker) == '0' ? 'selected' : '' }}>Não</option>
                                    <option value="1" {{ old('is_smoker', $evaluation->is_smoker) == '1' ? 'selected' : '' }}>Sim</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="smoking_frequency" :value="__('Frequência (Tabaco)')" />
                                <x-text-input id="smoking_frequency" class="block mt-1 w-full" type="text" name="smoking_frequency" :value="old('smoking_frequency', $evaluation->smoking_frequency)" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="physical_activity" :value="__('Pratica Atividade Física?')" />
                                <select id="physical_activity" name="physical_activity" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="0" {{ old('physical_activity', $evaluation->physical_activity) == '0' ? 'selected' : '' }}>Não</option>
                                    <option value="1" {{ old('physical_activity', $evaluation->physical_activity) == '1' ? 'selected' : '' }}>Sim</option>
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="physical_activity_details" :value="__('Quais atividades?')" />
                                <x-text-input id="physical_activity_details" class="block mt-1 w-full" type="text" name="physical_activity_details" :value="old('physical_activity_details', $evaluation->physical_activity_details)" />
                            </div>

                            <div>
                                <x-input-label for="physical_activity_frequency" :value="__('Frequência (Ativ. Física)')" />
                                <x-text-input id="physical_activity_frequency" class="block mt-1 w-full" type="text" name="physical_activity_frequency" :value="old('physical_activity_frequency', $evaluation->physical_activity_frequency)" />
                            </div>

                            <div>
                                <x-input-label for="diet_type" :value="__('Tipo de Dieta')" />
                                <select id="diet_type" name="diet_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">N/A</option>
                                    <option value="hipo" {{ old('diet_type', $evaluation->diet_type) == 'hipo' ? 'selected' : '' }}>Hipocalórica</option>
                                    <option value="normal" {{ old('diet_type', $evaluation->diet_type) == 'normal' ? 'selected' : '' }}>Normocalórica</option>
                                    <option value="hiper" {{ old('diet_type', $evaluation->diet_type) == 'hiper' ? 'selected' : '' }}>Hipercalórica</option>
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="meals_per_day" :value="__('Refeições/dia')" />
                                <x-text-input id="meals_per_day" class="block mt-1 w-full" type="text" name="meals_per_day" :value="old('meals_per_day', $evaluation->meals_per_day)" />
                            </div>

                            <div>
                                <x-input-label for="daily_liquids" :value="__('Líquidos Diários')" />
                                <x-text-input id="daily_liquids" class="block mt-1 w-full" type="text" name="daily_liquids" :value="old('daily_liquids', $evaluation->daily_liquids)" />
                            </div>
                            
                            <div>
                                <x-input-label for="sleep_quality" :value="__('Qualidade do Sono')" />
                                <select id="sleep_quality" name="sleep_quality" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Selecione</option>
                                    <option value="ruim" {{ old('sleep_quality', $evaluation->sleep_quality) == 'ruim' ? 'selected' : '' }}>Ruim</option>
                                    <option value="bom" {{ old('sleep_quality', $evaluation->sleep_quality) == 'bom' ? 'selected' : '' }}>Bom</option>
                                    <option value="excelente" {{ old('sleep_quality', $evaluation->sleep_quality) == 'excelente' ? 'selected' : '' }}>Excelente</option>
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="sleep_time_bed" :value="__('Hora de Deitar (HH:MM)')" />
                                <x-text-input id="sleep_time_bed" class="block mt-1 w-full" type="time" name="sleep_time_bed" :value="old('sleep_time_bed', $evaluation->sleep_time_bed ? \Carbon\Carbon::parse($evaluation->sleep_time_bed)->format('H:i') : '')" />
                            </div>
                            
                            <div>
                                <x-input-label for="sleep_time_wake" :value="__('Hora de Acordar (HH:MM)')" />
                                <x-text-input id="sleep_time_wake" class="block mt-1 w-full" type="time" name="sleep_time_wake" :value="old('sleep_time_wake', $evaluation->sleep_time_wake ? \Carbon\Carbon::parse($evaluation->sleep_time_wake)->format('H:i') : '')" />
                            </div>

                            <div>
                                <x-input-label for="intestinal_function" :value="__('Função Intestinal')" />
                                <x-text-input id="intestinal_function" class="block mt-1 w-full" type="text" name="intestinal_function" :value="old('intestinal_function', $evaluation->intestinal_function)" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Atualizar Avaliação (Anamnese)') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>