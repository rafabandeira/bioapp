// resources/js/charts/patient-charts.js

import Chart from 'chart.js/auto'; 

window.renderPatientCharts = function (bioDataJson, measurementsDataJson) {
    
    console.log("CHART SCRIPT: Função renderPatientCharts() foi chamada.");

    let bioData; // Array final
    let measurementsData; // Array final

    try {
        // CORREÇÃO: O JSON.parse agora deve funcionar
        bioData = JSON.parse(bioDataJson);
        measurementsData = JSON.parse(measurementsDataJson);
        
        console.log("CHART SCRIPT: Dados (Parse) de Bioimpedância:", bioData);
        console.log("CHART SCRIPT: Dados (Parse) de Medidas:", measurementsData);
        
    } catch (e) {
        console.error("CHART SCRIPT: ERRO AO PARSEAR O JSON!", e);
        return;
    }

    /// --- GRÁFICO 1: BIOIMPEDÂNCIA - Focado Apenas no Peso ---
    if (Array.isArray(bioData) && bioData.length > 0) {
        const dates = bioData.map(record => record.date);
        const weightData = bioData.map(record => record.weight);
        
        // As variáveis fatData e muscleData são calculadas, mas não usadas.

        const bioChartElement = document.getElementById('bioimpedanceChart');
        if (bioChartElement) {
            console.log("CHART SCRIPT: Renderizando Gráfico de Peso...");
            new Chart(bioChartElement, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        { 
                            label: 'Peso (kg)', 
                            data: weightData, 
                            borderColor: 'rgb(75, 192, 192)', // Mantive sua cor
                            backgroundColor: 'rgba(75, 192, 192, 0.5)', // Cor dos pontos
                            tension: 0.4, // Linha Curva (0.4 é uma boa suavidade)
                            yAxisID: 'yPeso',
                            fill: false, // Não preenche a área abaixo da linha
                            borderWidth: 3,
                            pointRadius: 4 // Deixa os pontos visíveis
                        }
                        // REMOVIDOS OS DATASETS DE GORDURA E MÚSCULO
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Permite controlar a altura no CSS
                    scales: {
                        // MANTIDO APENAS O EIXO Y PARA O PESO
                        yPeso: { 
                            type: 'linear', 
                            display: true, 
                            position: 'left', 
                            title: { 
                                display: true, 
                                text: 'Peso (kg)' 
                            },
                            beginAtZero: false // Não precisa começar em zero para peso
                        },
                        // REMOVIDO O EIXO yPercentual
                        x: { 
                            title: { display: true, text: 'Data de Aferição' }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Não precisa de legenda, pois é um dataset único
                        }
                    }
                }
            });
        }
    }
    
    // --- GRÁFICO 2: MEDIDAS ---
    if (Array.isArray(measurementsData) && measurementsData.length > 0) {
        const waistData = measurementsData.map(record => record.waist);
        const hipData = measurementsData.map(record => record.hip);
        const measurementDates = measurementsData.map(record => record.date);

        const measurementsChartElement = document.getElementById('measurementsChart');
        if (measurementsChartElement) {
            console.log("CHART SCRIPT: Renderizando Gráfico de Medidas...");
            new Chart(measurementsChartElement, {
                type: 'line',
                data: {
                    labels: measurementDates,
                    datasets: [
                        { label: 'Cintura (cm)', data: waistData, borderColor: 'rgb(255, 159, 64)', tension: 0.3 },
                        { label: 'Quadril (cm)', data: hipData, borderColor: 'rgb(153, 102, 255)', tension: 0.3 }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { title: { display: true, text: 'Medida (cm)' }},
                        x: { title: { display: true, text: 'Data' }}
                    }
                }
            });
        }
    }
};