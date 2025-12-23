@php
    $name = $row->client_name;
    $companyName = $row->company_name;
    $fathersName = $row->fathers_name;
    $mothersName = $row->mothers_name;
    $phone = $row->phone . ', ' . $row->phone_optional;
    $email = $row->email;
    $group = $row->group_name;
    $address = $row->address;
    $transport = $row->transport;
    $status = $row->status ? '<span class="text-success">Activated</span>' : '<span class="text-danger">Deactivated</span>';
@endphp

<table class="table table-sm table-borderless my-2">
    @if($name)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.name') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $name }}</td>
        </tr>
    @endif
    @if($companyName)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.company') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $companyName }}</td>
        </tr>
    @endif
    @if($fathersName)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.fathers_name') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $fathersName }}</td>
        </tr>
    @endif
    @if($mothersName)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.mothers_name') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $mothersName }}</td>
        </tr>
    @endif
    @if($phone)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.phone') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $phone }}</td>
        </tr>
    @endif
    @if($email)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.email') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $email }}</td>
        </tr>
    @endif
    @if($group)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.client_group') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $group }}</td>
        </tr>
    @endif
    @if($address)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.address') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $address }}</td>
        </tr>
    @endif
    @if($transport)
        <tr class="bg-transparent">
            <td width="20%" class="font-weight-bolder">{{ __('messages.transport') }}</td>
            <td width="1%" class="font-weight-bolder">:</td>
            <td>{{ $transport }}</td>
        </tr>
    @endif
    <tr class="bg-transparent">
        <td width="20%" class="font-weight-bolder">{{ __('messages.status') }}</td>
        <td width="1%" class="font-weight-bolder">:</td>
        <td>{!! $status !!}</td>
    </tr>
    <tr class="bg-transparent">
        <td width="20%" class="font-weight-bolder">{{ __('messages.created_at') }}</td>
        <td width="1%" class="font-weight-bolder">:</td>
        <td>{{ date('d M Y', strtotime($row->created_at)) }}</td>
    </tr>
</table>
