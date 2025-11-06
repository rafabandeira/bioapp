{{-- resources/views/evaluations/partials/form.blade.php --}}

<div class="space-y-8">
    
    {{-- Seção: Anamnese Básica (migrado de 'avaliacao/metaboxes/anamnese.php') --}}
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">1. Anamnese Básica</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Queixa Principal --}}
            <div>
                <x-input-label for="qp" :value="__('Queixa Principal')" />
                <x-text-input 
                    id="qp" 
                    name="qp" 
                    type="text" 
                    class="mt-1 block w-full" 
                    :value="old('qp', $evaluation->qp ?? '')"
                    autocomplete="off" 
                />
                <x-input-error class="mt-2" :messages="$errors->get('qp')" />
            </div>

            {{-- Objetivos --}}
            <div>
                <x-input-label for="objectives" :value="__('Objetivos do Paciente')" />
                <x-text-input 
                    id="objectives" 
                    name="objectives" 
                    type="text" 
                    class="mt-1 block w-full" 
                    :value="old('objectives', $evaluation->objectives ?? '')"
                    autocomplete="off" 
                />
                <x-input-error class="mt-2" :messages="$errors->get('objectives')" />
            </div>
        </div>

        {{-- Medicação Atual --}}
        <div class="mt-4">
            <x-input-label for="current_medication" :value="__('Medicação Atual / Suplementos')" />
            <x-text-area 
                id="current_medication" 
                name="current_medication" 
                rows="2"
                class="mt-1 block w-full"
            >{{ old('current_medication', $evaluation->current_medication ?? '') }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('current_medication')" />
        </div>
    </div>
    
    {{-- Seção: Históricos (migrado de 'avaliacao/metaboxes/antecedentes.php') --}}
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">2. Antecedentes</h4>

        {{-- Histórico Familiar --}}
        <div>
            <x-input-label for="family_history" :value="__('Histórico Familiar (Diabetes, Hipertensão, Obesidade...)')" />
            <x-text-area 
                id="family_history" 
                name="family_history" 
                rows="3"
                class="mt-1 block w-full"
            >{{ old('family_history', $evaluation->family_history ?? '') }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('family_history')" />
        </div>

        {{-- Histórico Pessoal --}}
        <div class="mt-4">
            <x-input-label for="personal_history" :value="__('Histórico Pessoal (Cirurgias, Doenças pré-existentes...)')" />
            <x-text-area 
                id="personal_history" 
                name="personal_history" 
                rows="3"
                class="mt-1 block w-full"
            >{{ old('personal_history', $evaluation->personal_history ?? '') }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('personal_history')" />
        </div>
    </div>

    {{-- Seção: Hábitos e Estilo de Vida (migrado de 'avaliacao/metaboxes/habitos.php') --}}
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">3. Hábitos e Estilo de Vida</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tabagismo --}}
            <div>
                <x-input-label for="smoking" :value="__('Tabagismo')" />
                <x-text-input id="smoking" name="smoking" type="text" class="mt-1 block w-full" :value="old('smoking', $evaluation->smoking ?? '')" />
                <x-input-error :messages="$errors->get('smoking')" />
            </div>

            {{-- Alcoolismo --}}
            <div>
                <x-input-label for="alcoholism" :value="__('Alcoolismo')" />
                <x-text-input id="alcoholism" name="alcoholism" type="text" class="mt-1 block w-full" :value="old('alcoholism', $evaluation->alcoholism ?? '')" />
                <x-input-error :messages="$errors->get('alcoholism')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            {{-- Atividade Física --}}
            <div>
                <x-input-label for="physical_activity" :value="__('Atividade Física')" />
                <x-text-input id="physical_activity" name="physical_activity" type="text" class="mt-1 block w-full" :value="old('physical_activity', $evaluation->physical_activity ?? '')" />
                <x-input-error :messages="$errors->get('physical_activity')" />
            </div>

            {{-- Qualidade do Sono --}}
            <div>
                <x-input-label for="sleep_quality" :value="__('Qualidade do Sono')" />
                <x-text-input id="sleep_quality" name="sleep_quality" type="text" class="mt-1 block w-full" :value="old('sleep_quality', $evaluation->sleep_quality ?? '')" />
                <x-input-error :messages="$errors->get('sleep_quality')" />
            </div>

            {{-- Ingestão de Água --}}
            <div>
                <x-input-label for="water_intake" :value="__('Ingestão de Água (L/dia)')" />
                <x-text-input id="water_intake" name="water_intake" type="text" class="mt-1 block w-full" :value="old('water_intake', $evaluation->water_intake ?? '')" />
                <x-input-error :messages="$errors->get('water_intake')" />
            </div>
        </div>

        {{-- Função Intestinal --}}
        <div class="mt-4">
            <x-input-label for="bowel_function" :value="__('Função Intestinal')" />
            <x-text-input id="bowel_function" name="bowel_function" type="text" class="mt-1 block w-full" :value="old('bowel_function', $evaluation->bowel_function ?? '')" />
            <x-input-error :messages="$errors->get('bowel_function')" />
        </div>
        
        {{-- Dietas Anteriores --}}
        <div class="mt-4">
            <x-input-label for="previous_diets" :value="__('Dietas Anteriores (Quais e Resultado)')" />
            <x-text-area 
                id="previous_diets" 
                name="previous_diets" 
                rows="2"
                class="mt-1 block w-full"
            >{{ old('previous_diets', $evaluation->previous_diets ?? '') }}</x-text-area>
            <x-input-error class="mt-2" :messages="$errors->get('previous_diets')" />
        </div>
    </div>

    {{-- Seção: Ginecológico (migrado de 'avaliacao/metaboxes/ginecologico.php') --}}
    @if ($patient->gender == 'F')
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">4. Histórico Ginecológico</h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Ciclo Menstrual --}}
            <div>
                <x-input-label for="menstrual_cycle" :value="__('Ciclo Menstrual')" />
                <x-text-input id="menstrual_cycle" name="menstrual_cycle" type="text" class="mt-1 block w-full" :value="old('menstrual_cycle', $evaluation->menstrual_cycle ?? '')" />
                <x-input-error :messages="$errors->get('menstrual_cycle')" />
            </div>
            
            {{-- Número de Gravidezes --}}
            <div>
                <x-input-label for="pregnancy_count" :value="__('Nº de Gravidezes')" />
                <x-text-input 
                    id="pregnancy_count" 
                    name="pregnancy_count" 
                    type="number" 
                    min="0"
                    class="mt-1 block w-full" 
                    :value="old('pregnancy_count', $evaluation->pregnancy_count ?? 0)" 
                />
                <x-input-error :messages="$errors->get('pregnancy_count')" />
            </div>

            {{-- Menopausa --}}
            <div>
                <x-input-label for="menopause" :value="__('Menopausa')" />
                <x-text-input id="menopause" name="menopause" type="text" class="mt-1 block w-full" :value="old('menopause', $evaluation->menopause ?? '')" />
                <x-input-error :messages="$errors->get('menopause')" />
            </div>
        </div>

        {{-- Uso de Contraceptivos --}}
        <div class="mt-4">
            <x-input-label for="contraceptive_use" :value="__('Uso de Contraceptivos (Qual)')" />
            <x-text-input id="contraceptive_use" name="contraceptive_use" type="text" class="mt-1 block w-full" :value="old('contraceptive_use', $evaluation->contraceptive_use ?? '')" />
            <x-input-error :messages="$errors->get('contraceptive_use')" />
        </div>
    </div>
    @endif
</div>

{{-- Dependências para Tailwind/Breeze (adaptar se necessário) --}}
@if (!isset($evaluation))
    @php
        // Simular um objeto vazio para a criação, se necessário
        $evaluation = new \App\Models\Evaluation();
        $evaluation->patient = $patient;
    @endphp
@endif