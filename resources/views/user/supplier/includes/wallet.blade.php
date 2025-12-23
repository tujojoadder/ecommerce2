@php
    if ($row->due != 0) {
        $dueOrAdvTitle = '<span class="text-white mb-1 bg-' . ($row->due > 0 ? 'danger' : 'success') . ' px-2 rounded">' . ($row->due > 0 ? __('messages.due') : __('messages.advance')) . '</span>';
        $dueOrAdv = '<span class="text-' . ($row->due > 0 ? 'danger' : 'success') . '"> ' . abs($row->due) . '</span>';
    } else {
        $dueOrAdvTitle = '<span class="text-white mb-1 bg-secondary px-2 rounded">' . __('messages.due') . '</span>';
        $dueOrAdv = '<span class="text-success">0</span>';
    }
@endphp

<table class="table table-sm table-bordered mb-0">
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.previous_due') }}</td>
        <td class="py-0">{{ $row->previous_due ?? '0.00' }}</td> <!-- Previous Due -->
    </tr>
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.purchase') }} {{ __('messages.bill') }}</td>
        <td class="py-0">{{ $row->purchase }}</td> <!-- Total Sale == Bill -->
    </tr>
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.total_bill') }}</td>
        <td class="py-0">{{ numberFormat($row->purchase + $row->previous_due, 2) }}</td> <!-- Total Sale + Previous Due == Total Bill -->
    </tr>
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.payment') }}</td>
        <td class="py-0">{{ $row->payment }}</td> <!-- Total Return -->
    </tr>
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.total') . ' ' . __('messages.purchase') . ' ' . __('messages.return') }}</td>
        <td class="py-0">{{ $row->purchase_return }}</td> <!-- Total Sale + Previous Due == Total Bill -->
    </tr>
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.money') . ' ' . __('messages.receive') }}</td>
        <td class="py-0">{{ $row->receive }}</td> <!-- Total Sale + Previous Due == Total Bill -->
    </tr>
    <tr class="bg-white">
        <td class="py-0 w-50">{{ __('messages.adjusting_amount') }}</td>
        <td class="py-0">{{ $row->adjustment }}</td> <!-- Total Sale + Previous Due == Total Bill -->
    </tr>
    <tr class="bg-white">
        <td class="w-50">{!! $dueOrAdvTitle !!}</td>
        <td class="py-0">{{ $row->due }}</td> <!-- Due/Advance -->
    </tr>
    <tr class="bg-white">
        <td class="w-50">{{ __('messages.remaining_due_date') }}</td>
        <td class="py-0">
            <a href="javascript:;" onclick="remainingDueDate({{ $row->id }});" class=""><i style="font-size: 16px !important;" class="py-1 fas fa-calendar-check"></i></a>
            {{ $row->remaining_due_date != null ? enToBnDate($row->remaining_due_date) : '' }}
        </td> <!-- Due/Advance -->
    </tr>
</table>
