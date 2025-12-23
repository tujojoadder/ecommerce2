<script>
    /* basic bar chart */
    var receives = JSON.parse('{!! $receives !!}');
    var amounts = receives.map(receive => parseFloat(receive.amount));
    var dates = receives.map(receive => receive.date);
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
        colors: ["#00879E"],
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
    var chart = new ApexCharts(document.querySelector(".receiveChart"), options);
    chart.render();
    var chart2 = new ApexCharts(document.querySelector(".receiveChart2"), options);
    chart2.render();
</script>
