<script>
    var products = @json($products);
    var productNames = products.map(product => product.product); // Product names as labels
    var amounts = products.map(product => product.amount); // Corresponding amounts
    var quantity = products.map(product => product.total_quantity); // Corresponding amounts

    const data1 = {
        labels: productNames, // Set product names as labels
        datasets: [{
            label: 'Total Sales by Product',
            data: quantity,
            backgroundColor: [
                'rgba(0, 144, 172, 0.2)',
                'rgba(35, 183, 229, 0.2)',
                'rgba(245, 184, 73, 0.2)',
                'rgba(73, 182, 245, 0.2)',
                'rgba(230, 83, 60, 0.2)',
                'rgba(38, 191, 148, 0.2)',
                'rgba(35, 35, 35, 0.2)'
            ],
            borderColor: [
                'rgb(0, 144, 172)',
                'rgb(35, 183, 229)',
                'rgb(245, 184, 73)',
                'rgb(73, 182, 245)',
                'rgb(230, 83, 60)',
                'rgb(38, 191, 148)',
                'rgb(35, 35, 35)'
            ],
            borderWidth: 1
        }]
    };

    const config1 = {
        type: 'bar',
        data: data1,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    document.getElementById('productBar').height = 100;
    const myChart1 = new Chart(
        document.getElementById('productBar'),
        config1
    );
</script>
