<table class="table table-sm table-borderless mb-0">
    @if($row->supplier_name)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.name') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $row->supplier_name ?? null }}</td>
        </tr>
    @endif
    @if($row->phone)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.phone') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $row->phone . ', ' . $row->phone_optional }}</td>
        </tr>
    @endif
    @if($row->email)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.email') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $row->email ?? null }}</td>
        </tr>
    @endif
    @if($row->group)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.supplier_group') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $row->group->name ?? null }}</td>
        </tr>
    @endif
    @if($row->company_name)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.company') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $row->company_name ?? null }}</td>
        </tr>
    @endif
    @if($row->address)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.address') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $row->address ?? null }}</td>
        </tr>
    @endif
    <tr class="bg-transparent">
        <td width="20%" class="font-weight-bolder">{{ __('messages.created_at') }}</td>
        <td width="1%" class="font-weight-bolder">:</td>
        <td>{{ date('d M Y', strtotime($row->created_at)) }}</td>
    </tr>
</table>
