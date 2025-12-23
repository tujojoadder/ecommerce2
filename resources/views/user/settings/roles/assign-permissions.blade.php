@extends('layouts.user.app', ['pageTitle' => $pageTitle])

@section('content')
    @php
        $route = Request::is('user/roles/*');
    @endphp
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="page-title">
                            {{ $pageTitle }}
                        </div>
                        <a href="{{ route('user.staff.index') }}" class="btn btn-secondary">{{ __('messages.go_back') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.settings.roles.save.assigned.permission', $role->id) }}" method="POST">
                        @csrf
                        <div class="row mx-auto align-items-center">
                            @php
                                $currentGroup = '';
                            @endphp

                            @foreach ($permissions as $key => $permission)
                                @php
                                    $group = $permission['group'];
                                    // Remove spaces and convert to lowercase for the group label
                                    $groupLabel = Str::lower(str_replace(' ', '-', $group));
                                @endphp

                                @if ($group !== $currentGroup)
                                    <hr class="{{ $key == 0 ? 'd-none' : '' }} bg-dark my-2">
                                    {{-- Display a label when the group changes --}}
                                    <h5 class="mb-0 col-md-2 d-flex justify-content-between"><span>{{ $group }}</span> <i class="fas fa-arrow-right"></i></h5>
                                    @php
                                        // Update the current group
                                        $currentGroup = $group;
                                    @endphp
                                @endif
                                <div class="col-md-2 px-1">
                                    <label class="form-control mb-0">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission['name'] }}" {{ $role->hasPermissionTo($permission['name']) ? 'checked' : '' }}>
                                        @php
                                            // Extract the action from the permission name
                                            $parts = str_replace('-', ' ', $permission['name']);
                                            $action = Str::ucfirst($parts) ?? Str::ucfirst($permission['name']);
                                        @endphp
                                        {{ $action }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success w-100">{{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
