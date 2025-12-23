@php
    // Get today's date
$today = date('d-m-Y');
// Create an array to store data for Morris.js chart
$chartData = [];

// weekly sales deposit due analysis line chart
// Add today's data to the array
    $chartData = [];

    // Loop for the last 7 days including today
    for ($i = 0; $i < 14; $i++) {
        $date = now()->subDays($i)->format('Y-m-d');
        $chartData[] = [
            'w' => $date,
            'a' => calculateData('invoice', $date),
            'b' => calculateData('deposit', $date),
            'c' => calculateData('cost', $date),
            'd' => calculateData('due', $date),
        ];
    }
    // Function to calculate data based on type and date
    function calculateData($type, $date = null)
    {
        if ($type == 'invoice') {
            $query = invoices(); // Use the invoices() function

            if ($date) {
                $filtered = $query->filter(function ($invoice) use ($date) {
                    return $invoice->created_at->format('Y-m-d') === $date;
                });

                return $filtered->sum('grand_total');
            }
        } elseif ($type == 'due') {
            if ($date) {
                $totalSales = invoices()->filter(fn($invoice) => $invoice->created_at->format('Y-m-d') === $date)->sum('grand_total');

                $totalDeposit = transactions()->whereDate('created_at', $date)->whereNot('transaction_type', 'account')->where('type', 'deposit')->sum('amount');

                return $totalDeposit - $totalSales;
            }
        } else {
            return transactions()->where('type', $type)->whereDate('created_at', $date)->sum('amount');
        }
    }

    $chartData = array_reverse($chartData);
    $chartDataJson = json_encode($chartData, JSON_UNESCAPED_UNICODE);

    // weekly sales deposit due analysis dount chart
    $chartData2 = [
        [
            'label' => 'SALES',
            'value' => abs(config('total_sales')),
        ],
        [
            'label' => 'DEPOSIT',
            'value' => abs(config('total_deposit')),
        ],
        [
            'label' => 'DUE',
            'value' => abs(config('total_due')),
        ],
    ];

    $chartDataJson2 = json_encode($chartData2, JSON_UNESCAPED_UNICODE);

@endphp


<script>
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const shortmonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    document.addEventListener('DOMContentLoaded', function() {
        // Directly embed the JSON data using json_encode
        var weekly_sales_deposit_due_analysis_line = {!! $chartDataJson !!};
        var weekly_sales_deposit_due_analysis_donut = {!! $chartDataJson2 !!};

        var monthly_sales_deposit_due_analysis_line = {!! $chartDataJson !!};
        var monthly_sales_deposit_due_analysis_donut = {!! $chartDataJson2 !!};

        new Morris.Line({
            element: 'weekly_sales_deposit_due_analysis_line',
            data: weekly_sales_deposit_due_analysis_line,
            xkey: 'w',
            ykeys: ['a', 'b', 'c', 'd'],
            xLabels: 'day',
            labels: ['{{ __('messages.sales') }} ', '{{ __('messages.receive') }} ', '{{ __('messages.expense') }} ', '{{ __('messages.due') }}'],
            lineColors: ['#00cccc', '#285cf7', '#FF0606', '#555'],
            lineWidth: 2,
            gridTextSize: 11,
            hideHover: 'auto',
            xLabelAngle: 30,
            resize: true,
            xLabelFormat: function(d) {
                var date = new Date(d);
                return date.getDate() + ' ' + (monthNames[date.getMonth()]);
            },
            dateFormat: function(ts) {
                var d = new Date(ts);
                return d.getDate() + ' ' + (monthNames[d.getMonth()]);
            }
        });

        // weekly sales deposit due analysis dount chart
        new Morris.Donut({
            element: 'weekly_sales_deposit_due_analysis_donut',
            data: weekly_sales_deposit_due_analysis_donut,
            colors: ['#00CCCC', '#285CF7', '#FF0606'],
            resize: true,
            labelColor: "#00CCCC"
        });
    });
</script>
