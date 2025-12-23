@php
    $client_id = $row->id;
    $totalBillAmount = ($row->sales ?? $row->total_sale) + $row->previous_due; // Total Sale + Previous Due == Total Bill

    if (($row->due ?? $row->total_due) > 0) {
        $dueOrAdvTitle = '<span class="text-white mb-1 bg-danger px-2 rounded">' . __('messages.due') . '</span>';
        $dueOrAdv = '<span class="text-danger small">' . ($row->due ?? $row->total_due) . '</span>';
    } elseif (($row->due ?? $row->total_due) < 0) {
        $dueOrAdvTitle = '<span class="text-white mb-1 bg-success px-2 rounded">' . __('messages.advance') . '</span>';
        $dueOrAdv = '<span class="text-success">' . abs($row->due ?? $row->total_due) . '</span>';
    } elseif ($totalBillAmount == ($row->receive ?? $row->total_deposit)) {
        $dueOrAdvTitle = '<span class="text-white mb-1 bg-secondary px-2 rounded">' . __('messages.due') . '</span>';
        $dueOrAdv = '<span class="text-success">' . 0 . '</span>';
    } else {
        if (($row->due ?? $row->total_due) < 0) {
            $amount = abs($row->due ?? $row->total_due);
            $title = __('messages.advance');
        } elseif ($totalBillAmount == ($row->receive ?? $row->total_deposit)) {
            $amount = 0;
            $title = __('messages.due');
        } else {
            $amount = $row->due ?? $row->total_due;
            $title = __('messages.due');
        }
        $dueOrAdvTitle = '<span class="text-white mb-1 bg-success px-2 rounded">' . $title . '</span>';
        $dueOrAdv = '<span class="text-danger small"> ' . ($amount ?? '0.00') . '</span>';
    }

    $showAdjustBtn = config('client.client_balance_adjustment') == 1 ? '' : 'd-none';
    $showDueDateBtn = config('client.remaining_due_date') == 1 ? '' : 'd-none';
@endphp

<table class="table table-sm table-bordered my-1 bg-transparent">
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.previous_due') }}</td>
        <td class="py-0 align-middle">{{ $row->previous_due ?? '0.00' }}</td> <!-- Previous Due -->
    </tr>
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.invoice_bill') }}</td>
        <td class="py-0">{{ $row->sales ?? $row->total_sale }}</td> <!-- Total Sale == Bill -->
    </tr>
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.total_bill') }}</td>
        <td class="py-0">{{ numberFormat($totalBillAmount, 2) ?? '0.00' }}</td> <!-- Total Sale + Previous Due == Total Bill -->
    </tr>
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.receive') }}</td>
        <td class="py-0">{{ ($row->receive) }}</td> <!-- Total Deposit -->
    </tr>
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.sales') . ' ' . __('messages.return') }}</td>
        <td class="py-0">{{ $row->sales_return ?? $row->total_sales_return }}</td> <!-- Total Return -->
    </tr>
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.money') }} {{ __('messages.return') }}</td>
        <td class="py-0">{{ $row->money_return ?? $row->total_money_return }}</td> <!-- Total Return -->
    </tr>
    <tr class="bg-transparent">
        <td class="py-0 w-50">{{ __('messages.sales') . ' ' . __('messages.return') . ' ' . __('messages.adjusting_amount') }}</td>
        <td class="py-0">{{ $row->sales_return_adjustment ?? $row->total_sales_return_adjustment }}</td> <!-- Total Sales Return Adjustment -->
    </tr>
    <tr class="bg-transparent {{ $showAdjustBtn }}">
        <td class="w-50">{{ __('messages.balance_adjustment') }}</td>
        <td class="py-0">
            <div>
                {{ $row->adjustment ?? $row->total_adjustment }}
                <a href="javascript:;" onclick="adjustDue({{ $row->id }});" title="{{ __('messages.balance_adjustment') }}"><i class="bg-info p-1 my-1 rounded fas fa-adjust"></i></a>
                <a href="javascript:;" onclick="balanceAdjustmentStatement({{ $row->id }});" title="{{ __('messages.balance_adjustment') . ' ' . __('messages.statement') }}"><i class="bg-dark p-1 my-1 rounded fas fa-list-ul"></i></a>
            </div>
        </td> <!-- Due/Advance -->
    </tr>
    <tr class="bg-transparent">
        <td class="w-50">{!! $dueOrAdvTitle !!}</td>
        <td class="py-0">
            {!! $dueOrAdv !!}
        </td> <!-- Due/Advance -->
    </tr>
    <tr class="bg-transparent {{ $showDueDateBtn }}">
        <td class="w-50">{{ __('messages.remaining_due_date') }}</td>
        <td class="py-0">
            <a href="javascript:;" class="">
                <i style="font-size: 16px !important;" class="py-1 fas fa-calendar-check"></i>
                {{ $row->remaining_due_date == !null ? enToBnDate($row->remaining_due_date) : '00/00/0000' }}
            </a>
            <a href="javascript:;" onclick="remainingDueDate({{ $row->id }});" title="{{ $row->remaining_due_date == !null ? enToBnDate($row->remaining_due_date) : '00/00/0000' }}" class="{{ $showDueDateBtn }}"><i class="bg-warning p-1 my-1 rounded fas fa-pen"></i></a>
        </td> <!-- Due/Advance -->
    </tr>
</table>
