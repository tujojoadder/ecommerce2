@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/account/edit*');
    @endphp
    <div class="main-content-body">
        <form action="{{ route('user.staff.attendance.store') }}" method="POST">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-2">
                        <div class="card-header">
                            <p class="my-0 card-title">{{ $pageTitle }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-3 text-center">
                                    <div class="form-group ms-1">
                                        <input name="date" id="date" type="text" class="form-control fc-datepicker text-center py-2 border" value="{{ date('d/m/Y') }}" placeholder="MM/DD/YYYY" required>
                                        <label class="animated-label active-label" for="date"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.date') }}</label>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.staff') }} {{ __('messages.name') }}</th>
                                        <th>{{ __('messages.phone_number') }}</th>
                                        <th>{{ __('messages.in_time') }}</th>
                                        <th>{{ __('messages.out_time') }}</th>
                                        <th>{{ __('messages.attendance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staffs as $staff)
                                        <tr>
                                            <td width="15%">{{ $staff->name }}</td>
                                            <td width="15%">{{ $staff->phone }}</td>
                                            <td width="20%" class="px-0">
                                                <input type="hidden" name="staff_id[]" value="{{ $staff->id }}">
                                                <input type="time" name="in_time[]" value="{{ date('H:i:s') }}" class="form-control form-control-sm d-block rounded-0 border-0" style="border-bottom: 0px !important;">
                                            </td>
                                            <td width="20%" class="px-0">
                                                <input type="time" name="out_time[]" value="{{ date('H:i:s') }}" class="form-control form-control-sm d-block rounded-0 border-0" style="border-bottom: 0px !important;">
                                            </td>
                                            <td width="20%" class="p-0">
                                                <select name="attendance[]" id="attendance" class="form-select form-select-sm px-2 rounded-0 border-0">
                                                    <option selected value="0">Absence</option>
                                                    <option value="1">Present</option>
                                                    <option value="2">Late</option>
                                                    <option value="3">Leave</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success w-50">{{ __('messages.attendance') }} {{ __('messages.create') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
@endpush
