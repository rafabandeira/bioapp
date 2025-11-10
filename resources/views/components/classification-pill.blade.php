@props(['classification', 'colorClass'])

@php
    $classificationLower = strtolower($classification);
    $finalClasses = 'bg-gray-200 text-gray-800'; // Padrão seguro (Cinza)

    // --- Mapeamento de Cores Fortes ---
    
    // REGRA 1: VERDE (Excelente / Boa / Jovem)
    if (str_contains($classificationLower, 'normal') || str_contains($classificationLower, 'jovem') || str_contains($classificationLower, 'excelente') || str_contains($classificationLower, 'boa')) {
        $finalClasses = "bg-green-600 text-white";

    // REGRA 2: AMARELO/LARANJA (Sobrepeso / Normal - Zona de Atenção)
    } elseif (str_contains($classificationLower, 'na faixa') || str_contains($classificationLower, 'sobrepeso') || str_contains($classificationLower, 'acima')) {
        $finalClasses = "bg-yellow-600 text-white";

    // REGRA 3: VERMELHO (Risco Elevado / Perigo / Obesidade)
    } elseif (str_contains($classificationLower, 'obesidade') || str_contains($classificationLower, 'alto') || str_contains($classificationLower, 'elevado') || str_contains($classificationLower, 'perigo') || str_contains($classificationLower, 'mais velha')) {
        $finalClasses = "bg-red-700 text-white"; 
    } elseif (str_contains($classificationLower, 'abaixo')) {
        $finalClasses = "bg-blue-600 text-white";
    } 
    
    // Se o texto não for branco, force a cor do texto para ser escura para contraste
    if (!str_contains($finalClasses, 'text-white') && str_contains($finalClasses, 'bg-')) {
         $finalClasses .= ' text-gray-800';
    }

@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $finalClasses }}">
    {{ $classification }}
</span>