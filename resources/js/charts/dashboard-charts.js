import Chart from 'chart.js/auto';

// Espera o DOM carregar
document.addEventListener('DOMContentLoaded', () => {
    
    // Inicia os dois gráficos
    initializeNewPatientsChart();
    initializePatientGenderChart();
    initializePatientImcChart();

});

/**
 * GRÁFICO 1: Novos Pacientes (Gráfico de Barras)
 */
async function initializeNewPatientsChart() {
    const ctx = document.getElementById('newPatientsChart');
    if (!ctx) return; // Sai se o canvas não estiver na página

    // Busca os dados da API
    const response = await fetch('api/charts/new-patients');
    const chartData = await response.json();

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Novos Pacientes',
                data: chartData.data,
                backgroundColor: 'rgba(59, 130, 246, 0.5)', 
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: {
                    display: false // Não precisa de legenda para um único dataset
                }
            }
        }
    });
}

/**
 * GRÁFICO 2: Pacientes por Gênero (Gráfico de Rosca/Doughnut)
 */
async function initializePatientGenderChart() {
    const ctx = document.getElementById('patientGenderChart');
    if (!ctx) return; // Sai se o canvas não estiver na página

    // Busca os dados da API
    const response = await fetch('api/charts/patient-gender');
    const chartData = await response.json();

    new Chart(ctx, {
        type: 'doughnut', // Tipo "Rosca"
        data: {
            labels: chartData.labels, // ['Masculino', 'Feminino']
            datasets: [{
                data: chartData.data, // [10, 15, 1]
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)', // Azul
                    'rgba(236, 72, 153, 0.7)', // Rosa
                    'rgba(107, 114, 128, 0.7)'  // Cinza
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(236, 72, 153, 1)',
                    'rgba(107, 114, 128, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'left', 
                }
            }
        }
    });
}

/**
 * GRÁFICO 3: Distribuição de IMC (Gráfico de Barras)
 */
async function initializePatientImcChart() {
    const ctx = document.getElementById('patientImcChart');
    if (!ctx) return; // Sai se o canvas não estiver na página

    // Chama a nova rota da API (caminho relativo, sem /)
    const response = await fetch('api/charts/patient-imc-distribution');
    const chartData = await response.json();

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartData.labels, // ['Abaixo do Peso', 'Normal', ...]
            datasets: [{
                label: 'Nº de Pacientes',
                data: chartData.data,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)', // Azul (Abaixo)
                    'rgba(75, 192, 192, 0.7)',  // Verde (Normal)
                    'rgba(255, 206, 86, 0.7)', // Amarelo (Sobrepeso)
                    'rgba(255, 99, 132, 0.7)'   // Vermelho (Obesidade)
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'left', 
                }
            }
        }
    });
}