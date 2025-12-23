<script>
    /* multiple y-axes chart */
    var balances = JSON.parse('{!! $balances !!}');
    var balanceAmounts = balances.map(balance => parseFloat(balance.amount));
    var balancesDates = balances.map(balance => balance.date);

    var expenses = JSON.parse('{!! $expenses !!}');
    var expenseAmounts = expenses.map(due => parseFloat(due.amount));
    var expenseDates = expenses.map(due => due.date);

    var receives = JSON.parse('{!! $receives !!}');
    var receiveAmounts = receives.map(receive => parseFloat(receive.amount));
    var receiveDates = receives.map(receive => receive.date);

    // Merge and sort unique dates
    var allDates = Array.from(new Set([...balancesDates, ...receiveDates, ...expenseDates])).sort();

    // Helper to map amounts by date
    function mapDataByDate(dates, amounts) {
        const map = {};
        dates.forEach((date, index) => map[date] = amounts[index]);
        return allDates.map(date => parseFloat(map[date] || 0));
    }

    // Fill data series
    var balanceSeries = mapDataByDate(balancesDates, balanceAmounts);
    var expenseSeries = mapDataByDate(expenseDates, expenseAmounts);
    var receiveSeries = mapDataByDate(receiveDates, receiveAmounts);

    // Chart options
    var options = {
        series: [{
            name: 'Income',
            type: 'column',
            data: receiveSeries
        }, {
            name: 'Expense',
            type: 'column',
            data: expenseSeries
        }, {
            name: 'Balance',
            type: 'line',
            data: balanceSeries
        }],
        chart: {
            height: 320,
            type: 'line',
            stacked: false
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            width: [1, 1, 4]
        },
        grid: {
            borderColor: '#f2f5f7',
        },
        colors: ["#00879E", "#FF9D23", "#16C47F"],
        xaxis: {
            categories: allDates,
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
        yaxis: [
            {
                axisTicks: { show: true },
                axisBorder: { show: true, color: '#00879E' },
                labels: { style: { colors: '#00879E' } },
                tooltip: { enabled: true }
            },
            {
                seriesName: 'Income',
                opposite: true,
                axisTicks: { show: true },
                axisBorder: { show: true, color: '#FF9D23' },
                labels: { style: { colors: '#FF9D23' } },
                title: {
                    text: "Income (thousand crores)",
                    style: { color: '#FF9D23' }
                }
            },
            {
                seriesName: 'Balance',
                opposite: true,
                axisTicks: { show: true },
                axisBorder: { show: true, color: '#16C47F' },
                labels: { style: { colors: '#16C47F' } },
                title: {
                    text: "Balance (thousand crores)",
                    style: { color: '#16C47F' }
                }
            }
        ],
        tooltip: {
            fixed: {
                enabled: true,
                position: 'topLeft',
                offsetY: 30,
                offsetX: 60
            }
        },
        legend: {
            horizontalAlign: 'left',
            offsetX: 40
        }
    };

    var chart = new ApexCharts(document.querySelector(".balances"), options);
    chart.render();
</script>
