
<script>
    /* pie chart */
    const balances = {
        labels: [
            'Receive',
            'Expense',
            'Balance'
        ],
        datasets: [{
            data: ["{{ siteSettings()->total_deposit ?? config('total_deposit') }}", "{{ siteSettings()->total_cost ?? config('total_cost') }}", "{{ siteSettings()->total_balance ?? config('balance') }}"],
            backgroundColor: [
                '#37AFE1',
                '#FF9D23',
                '#16C47F'
            ],
            hoverOffset: 10
        }]
    };
    const data = {
        type: 'pie',
        data: balances,
    };
    const balanceChart = new Chart(document.getElementById('balanceChart'), data);
</script>
