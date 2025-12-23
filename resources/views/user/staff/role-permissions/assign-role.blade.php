@extends('layouts.user.app', ['pageTitle' => $pageTitle])

@section('content')
    @php
        $route = Request::is('user/staffs/roles/*');
    @endphp
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="page-title">
                            {{ $pageTitle }}
                        </div>
                        <a href="{{ route('user.staff.index') }}" class="btn btn-success">{{ __('messages.go_back') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.staff.assing.role.store', $staff->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-md-2" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ $role->name }}">
                                    <label class="form-control d-flex">
                                        <input type="checkbox" class="me-2" name="role[]" value="{{ $role->name }}" {{ $staff->hasRole($role->name) ? 'checked' : '' }}>
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success w-25">{{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
