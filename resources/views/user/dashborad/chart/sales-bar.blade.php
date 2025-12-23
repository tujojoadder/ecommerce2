<script>
    /* basic bar chart */
    var invoices = JSON.parse('{!! $invoices !!}');
    var amounts = invoices.map(invoice => parseFloat(invoice.amount));
    var dates = invoices.map(invoice => invoice.date);
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
        colors: ["#006BFF"],
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
    var chart = new ApexCharts(document.querySelector(".salesChart"), options);
    chart.render();
    var chart2 = new ApexCharts(document.querySelector(".salesChart2"), options);
    chart2.render();
</script>
