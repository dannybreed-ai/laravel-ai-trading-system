import ApexCharts from 'apexcharts';

// Admin dashboard chart initialization
document.addEventListener('DOMContentLoaded', () => {
    // Check if chart container exists
    const chartContainer = document.querySelector('[data-chart="users-chart"]');
    if (chartContainer) {
        const options = {
            series: [{
                name: 'Users',
                data: JSON.parse(chartContainer.dataset.series || '[]')
            }],
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: JSON.parse(chartContainer.dataset.categories || '[]')
            },
            colors: ['#1DA1F2']
        };

        const chart = new ApexCharts(chartContainer, options);
        chart.render();
    }

    // Volume chart
    const volumeChart = document.querySelector('[data-chart="volume-chart"]');
    if (volumeChart) {
        const options = {
            series: [{
                name: 'Volume',
                data: JSON.parse(volumeChart.dataset.series || '[]')
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: JSON.parse(volumeChart.dataset.categories || '[]')
            },
            colors: ['#4CAF50']
        };

        const chart = new ApexCharts(volumeChart, options);
        chart.render();
    }
});
