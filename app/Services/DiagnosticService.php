<?php
// app/Services/DiagnosticService.php

namespace App\Services;

use Carbon\Carbon;

class DiagnosticService
{
    // ... (Métodos classifyBmi, getBmiColorClass, classifyBodyFat, getBfpColorClass, etc. ... permanecem iguais)
    
    /**
     * Classifica o Índice de Massa Corporal (IMC)
     */
    public static function classifyBmi($bmi)
    {
        if (!$bmi) return null;
        if ($bmi < 18.5) return 'Abaixo do peso';
        if ($bmi <= 24.9) return 'Peso normal';
        if ($bmi <= 29.9) return 'Sobrepeso';
        if ($bmi <= 34.9) return 'Obesidade Grau I';
        if ($bmi <= 39.9) return 'Obesidade Grau II';
        return 'Obesidade Grau III';
    }

    /**
     * Adiciona cor ao diagnóstico (para o frontend)
     */
    public static function getBmiColorClass($classification)
    {
        switch ($classification) {
            case 'Abaixo do peso': return 'text-blue-600';
            case 'Peso normal': return 'text-green-600';
            case 'Sobrepeso': return 'text-yellow-600';
            case 'Obesidade Grau I': return 'text-orange-600';
            case 'Obesidade Grau II':
            case 'Obesidade Grau III': return 'text-red-600';
            default: return 'text-gray-900';
        }
    }

    /**
     * Classifica o Percentual de Gordura Corporal (BFP) por género
     */
    public static function classifyBodyFat($bfp, $gender)
    {
        if (!$bfp || !$gender) return null;

        if ($gender == 'F') { // Feminino
            if ($bfp < 14) return 'Muito Baixo';
            if ($bfp <= 20) return 'Atleta';
            if ($bfp <= 24) return 'Bom';
            if ($bfp <= 31) return 'Normal';
            if ($bfp <= 38) return 'Elevado';
            return 'Muito Elevado';
        } 
        
        if ($gender == 'M') { // Masculino
            if ($bfp < 6) return 'Muito Baixo';
            if ($bfp <= 13) return 'Atleta';
            if ($bfp <= 17) return 'Bom';
            if ($bfp <= 24) return 'Normal';
            if ($bfp <= 30) return 'Elevado';
            return 'Muito Elevado';
        }
        return 'N/A';
    }

    /**
     * Retorna a cor para a classificação BFP
     */
    public static function getBfpColorClass($classification)
    {
        switch ($classification) {
            case 'Muito Baixo': return 'text-blue-600';
            case 'Atleta':
            case 'Bom': return 'text-green-600';
            case 'Normal': return 'text-yellow-600';
            case 'Elevado': return 'text-orange-600';
            case 'Muito Elevado': return 'text-red-600';
            default: return 'text-gray-900';
        }
    }

    /**
     * Classifica Músculo Esquelético (SKM) por género
     */
    public static function classifySkeletalMuscle($skm, $gender)
    {
        if (!$skm || !$gender) return null;

        if ($gender == 'F') { // Feminino
            if ($skm < 24.3) return 'Baixo';
            if ($skm <= 30.3) return 'Normal';
            if ($skm <= 35.3) return 'Elevado';
            return 'Muito Elevado';
        }

        if ($gender == 'M') { // Masculino
            if ($skm < 33.3) return 'Baixo';
            if ($skm <= 39.3) return 'Normal';
            if ($skm <= 44.0) return 'Elevado';
            return 'Muito Elevado';
        }
        return 'N/A';
    }

    /**
     * Retorna a cor para a classificação SKM
     */
    public static function getSkmColorClass($classification)
    {
        switch ($classification) {
            case 'Baixo': return 'text-red-600';
            case 'Normal': return 'text-green-600';
            case 'Elevado':
            case 'Muito Elevado': return 'text-blue-600';
            default: return 'text-gray-900';
        }
    }

    /**
     * Classifica Gordura Visceral (Nível 1-20)
     */
    public static function classifyVisceralFat($level)
    {
        if (!$level) return null;
        if ($level <= 9) return 'Normal';
        if ($level <= 14) return 'Elevado';
        return 'Muito Elevado';
    }

    /**
     * Retorna a cor para a classificação de Gordura Visceral
     */
    public static function getVisceralFatColorClass($classification)
    {
        switch ($classification) {
            case 'Normal': return 'text-green-600';
            case 'Elevado': return 'text-orange-600';
            case 'Muito Elevado': return 'text-red-600';
            default: return 'text-gray-900';
        }
    }

    /**
     * Calcula a Taxa Metabólica Basal (TMB) - Fórmula Harris-Benedict
     */
    public static function calculateTmb($weight, $height, $age, $gender)
    {
        if (!$weight || !$height || !$age || !$gender) {
            return null;
        }

        if ($gender == 'M') {
            // TMB = 66 + (13.7 * peso(kg)) + (5 * altura(cm)) - (6.8 * idade(anos))
            return round(66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age));
        }

        if ($gender == 'F') {
            // TMB = 655 + (9.6 * peso(kg)) + (1.8 * altura(cm)) - (4.7 * idade(anos))
            return round(655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age));
        }
        
        return null;
    }

    /**
     * Classifica a Idade Metabólica
     */
    public static function classifyMetabolicAge($metabolicAge, $chronologicalAge)
    {
        if (!$metabolicAge || !$chronologicalAge) return null;

        $diff = $metabolicAge - $chronologicalAge;

        if ($diff <= -10) return 'Excelente (Muito Jovem)';
        if ($diff <= -5) return 'Boa (Jovem)';
        if ($diff <= 4) return 'Normal';
        if ($diff <= 9) return 'Elevada (Mais Velha)';
        return 'Muito Elevada (Perigo)';
    }

    /**
     * Retorna a cor para a Idade Metabólica
     */
    public static function getMetabolicAgeColorClass($classification)
    {
        switch ($classification) {
            case 'Excelente (Muito Jovem)':
            case 'Boa (Jovem)': return 'text-green-600';
            case 'Normal': return 'text-yellow-600';
            case 'Elevada (Mais Velha)': return 'text-orange-600';
            case 'Muito Elevada (Perigo)': return 'text-red-600';
            default: return 'text-gray-900';
        }
    }

    /**
     * NOVO: Gera o caminho da imagem do avatar com base no %GC e género
     * Lógica migrada de 'includes/bioimpedancia/metaboxes/avatares.php'
     */
    public static function generateAvatarPath($bfp, $gender)
    {
        $basePath = 'avatars/'; // Caminho base em public/avatars/
        $avatar = $gender == 'M' ? 'm-normal.png' : 'f-normal.png'; // Default

        if (!$bfp || !$gender) {
            return asset($basePath . $avatar);
        }

        if ($gender == 'M') {
            if ($bfp < 14) $avatar = 'm-abaixo.png';
            elseif ($bfp <= 17) $avatar = 'm-normal.png';
            elseif ($bfp <= 20) $avatar = 'm-alto1.png';
            elseif ($bfp <= 23) $avatar = 'm-alto2.png';
            elseif ($bfp <= 29) $avatar = 'm-alto3.png';
            elseif ($bfp <= 34) $avatar = 'm-acima1.png';
            elseif ($bfp <= 39) $avatar = 'm-acima2.png';
            else $avatar = 'm-acima3.png';
        } 
        
        if ($gender == 'F') {
            if ($bfp < 21) $avatar = 'f-abaixo.png';
            elseif ($bfp <= 24) $avatar = 'f-normal.png';
            elseif ($bfp <= 27) $avatar = 'f-alto1.png';
            elseif ($bfp <= 30) $avatar = 'f-alto2.png';
            elseif ($bfp <= 34) $avatar = 'f-alto3.png';
            elseif ($bfp <= 39) $avatar = 'f-acima1.png';
            elseif ($bfp <= 44) $avatar = 'f-acima2.png';
            else $avatar = 'f-acima3.png';
        }

        return asset($basePath . $avatar);
    }
}