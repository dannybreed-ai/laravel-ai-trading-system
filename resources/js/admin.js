import './bootstrap';
import ApexCharts from 'apexcharts';

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin dashboard loaded');

    const chartElement = document.querySelector('#admin-chart');
    if (chartElement) {
        const options = {
            series: [{
                name: 'Revenue',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        };

        const chart = new ApexCharts(chartElement, options);
        chart.render();
    }
});
