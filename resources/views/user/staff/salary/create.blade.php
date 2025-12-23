@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/account/edit*');
    @endphp
    <div class="main-content-body">
        <form action="{{ route('user.staff.salary.store') }}" method="POST">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-2">
                        <div class="card-header">
                            <p class="card-title mb-0">{{ $pageTitle }}</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8 mt-3">
                                <div class="d-flex align-items-end">
                                    <div class="input-group me-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.month') }}">
                                        <label class="text-white" for="month">{{ __('messages.month') }}</label>
                                        <select name="month" id="month" class="form-control select2 month" required>
                                            <option {{ date('m') == 1 ? 'selected' : '' }} value="1">January</option>
                                            <option {{ date('m') == 2 ? 'selected' : '' }} value="2">February</option>
                                            <option {{ date('m') == 3 ? 'selected' : '' }} value="3">March</option>
                                            <option {{ date('m') == 4 ? 'selected' : '' }} value="4">April</option>
                                            <option {{ date('m') == 5 ? 'selected' : '' }} value="5">May</option>
                                            <option {{ date('m') == 6 ? 'selected' : '' }} value="6">June</option>
                                            <option {{ date('m') == 7 ? 'selected' : '' }} value="7">July</option>
                                            <option {{ date('m') == 8 ? 'selected' : '' }} value="8">August</option>
                                            <option {{ date('m') == 9 ? 'selected' : '' }} value="9">September</option>
                                            <option {{ date('m') == 10 ? 'selected' : '' }} value="10">October</option>
                                            <option {{ date('m') == 11 ? 'selected' : '' }} value="11">November</option>
                                            <option {{ date('m') == 12 ? 'selected' : '' }} value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="input-group ms-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.year') }}">
                                        <label class="text-white" for="year">{{ __('messages.year') }}</label>
                                        <select name="year" id="year" class="form-control select2 year" required>
                                            @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                                <option {{ date('Y') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.staff') }} {{ __('messages.name') }}</th>
                                        <th>{{ __('messages.sallary') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staffs as $staff)
                                        <tr>
                                            <td width="50%">{{ $staff->name }}</td>
                                            <td width="50%" class="px-0">
                                                <input type="hidden" name="staff_id[]" value="{{ $staff->id }}">
                                                <input type="number" min="0" step="any" name="salary[]" value="{{ $staff->salary ?? 0 }}" class="bg-transparent rounded-0 border-0 p-2">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success w-50">{{ __('messages.sallary') }} {{ __('messages.create') }}</button>
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
