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

    // --- GRÁFICO 1: BIOIMPEDÂNCIA ---
    if (Array.isArray(bioData) && bioData.length > 0) {
        const dates = bioData.map(record => record.date);
        const weightData = bioData.map(record => record.weight);
        const fatData = bioData.map(record => record.body_fat_percentage);
        const muscleData = bioData.map(record => record.skeletal_muscle_percentage);

        const bioChartElement = document.getElementById('bioimpedanceChart');
        if (bioChartElement) {
            console.log("CHART SCRIPT: Renderizando Gráfico de Bioimpedância...");
            new Chart(bioChartElement, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        { label: 'Peso (kg)', data: weightData, borderColor: 'rgb(75, 192, 192)', tension: 0.3, yAxisID: 'yPeso' },
                        { label: 'Gordura (%)', data: fatData, borderColor: 'rgb(255, 99, 132)', tension: 0.3, yAxisID: 'yPercentual', hidden: true },
                        { label: 'Músculo (%)', data: muscleData, borderColor: 'rgb(54, 162, 235)', tension: 0.3, yAxisID: 'yPercentual', hidden: true }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        yPeso: { type: 'linear', display: 'auto', position: 'left', title: { display: true, text: 'Peso (kg)' }},
                        yPercentual: { type: 'linear', display: 'auto', position: 'right', title: { display: true, text: 'Percentual (%)' }, grid: { drawOnChartArea: false }},
                        x: { title: { display: true, text: 'Data' }}
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