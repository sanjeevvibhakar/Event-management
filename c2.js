const ctxDoughnut = document.getElementById('doughnut').getContext('2d');
const doughnutChart = new Chart(ctxDoughnut, {
    type: 'doughnut',
    data: {
        labels: ['A', 'B', 'C', 'D', 'E', 'F', 'H'], // Labels for the doughnut chart
        datasets: [{
            label: '# of Scores',
            data: [12, 19, 3, 5, 2, 7], 
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)', // Red
                'rgba(54, 162, 235, 0.8)', // Blue
                'rgba(255, 206, 86, 0.8)', // Yellow
                'rgba(75, 192, 192, 0.8)', // Green
                'rgba(153, 102, 255, 0.8)', // Purple
                'rgba(56, 205, 256, 0.80)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)', // Red border
                'rgba(54, 162, 235, 1)', // Blue border
                'rgba(255, 206, 86, 1)', // Yellow border
                'rgba(75, 192, 192, 1)', // Green border
                'rgba(153, 102, 255, 1)',
                'rgba(56, 205, 256, 0.80)'
                 // Purple border
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white', // Legend text color
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                bodyFont: {
                    size: 16
                },
                titleFont: {
                    size: 18
                },
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw;
                    }
                }
            }
        }
    }
});
