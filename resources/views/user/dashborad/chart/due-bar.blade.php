<script>
    /* basic bar chart */
    var dues = JSON.parse('{!! $dues !!}');
    var amounts = dues.map(due => parseFloat(due.amount));
    var dates = dues.map(due => due.date);
    var options = {
        series: [{
            data: amounts
        }],
        chart: {
            type: 'bar',
            height: 320
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        colors: ["#A89C29"],
        grid: {
            borderColor: '#f2f5f7',
        },
        dataLabels: {
            enabled: true
        },
        xaxis: {
            categories: dates,
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-xaxis-label',
                },
            }
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-yaxis-label',
                },
            }
        }
    };
    var chart = new ApexCharts(document.querySelector(".dueChart"), options);
    chart.render();
</script>
