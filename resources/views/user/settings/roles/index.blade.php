@extends('layouts.user.app', ['pageTitle' => $pageTitle])

@section('content')
    @php
        $route = Request::is('user/settings/roles/edit/*');
    @endphp
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="{{ $errors->any() ? '' : ($route ? '' : 'multi-collapse collapse') }}" id="addNew">
                <div class="card card-body">
                    <div class="card-title">
                        <h2 class="text-center">{{ __('messages.role') }} {{ __('messages.create') }}</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ $route ? route('user.settings.roles.update', $role->id) : route('user.settings.roles.store') }}" method="POST">
                                        @if ($route)
                                            @csrf
                                            @method('PUT')
                                        @else
                                            @csrf
                                        @endif
                                        <div class="form-group">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $route ? $role->name : '') }}" placeholder="e.g. (manager)">
                                            <label for="name" class="animated-label {{ $route ? 'active-label' : '' }}">{{ __('messages.role_name') }}</label>
                                            @error('name')
                                                <span class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="guard">Guard Name</label>
                                            <select name="guard_name" id="guard" class="form-control">
                                                <option {{ $route ? ($role->guard_name == 'web' ? 'selected' : '') : '' }} value="web">Web</option>
                                            </select>
                                            @error('guard_name')
                                                <span class="text-danger small">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">{{ __('messages.add') }}</button>
                                            @if ($route)
                                                <a class="btn btn-danger" href="{{ route('user.settings.roles.index') }}">{{ __('messages.cancel') }}</a>
                                            @else
                                                <a class="btn btn-danger" data-bs-toggle="collapse" href="#addNew" role="button" aria-expanded="false" aria-controls="addNew">{{ __('messages.cancel') }}</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <div class="page-title">
                                {{ $pageTitle }}
                            </div>
                            <div class="">
                                @if ($route)
                                    <a class="btn btn-primary" href="{{ route('user.settings.roles.index') }}">Go Back</a>
                                @else
                                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#addNew" role="button" aria-expanded="false" aria-controls="addNew"><i class="fas fa-plus"></i> {{ __('messages.add') }}</a>
                                    <a class="btn btn-secondary" href="{{ url()->previous() }}">{{ __('messages.go_back') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-borderled border">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="border align-middle p-3">SL</th>
                                            <th class="border align-middle p-3">Title</th>
                                            <th class="border align-middle p-3">Created By</th>
                                            <th class="border align-middle p-3">Created At</th>
                                            <th class="border align-middle p-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr class="text-center">
                                                <td class="border">{{ $loop->iteration }}</td>
                                                <td class="border">{{ $role->name }}</td>
                                                <td class="border">{{ $role->created_by }}</td>
                                                <td class="border">{{ date('M d, Y, h:i a', strtotime($role->created_at)) }}</td>
                                                <td class="border">
                                                    @if ($role->name == 'Superuser')
                                                        <span class="btn btn-sm btn-dark" style="cursor: no-drop;">Not Accessible</span>
                                                    @else
                                                        <a href="{{ route('user.settings.roles.give.permission', $role->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-user-shield" style="font-size: 13px;"></i> Give Permissions
                                                        </a>
                                                        <a href="{{ route('user.settings.roles.edit', $role->id) }}" class="btn btn-sm btn-success">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        @if ($route)
                                                        @else
                                                            <a href="javascript:;" onClick="destroy('{{ $role->id }}')" class="btn btn-sm btn-danger">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    <script>
        function destroy(id) {
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data_id = id;
                    var url = '{{ route('user.settings.roles.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 0);
                        }
                    });
                }
            })
        }
    </script>
@endpush
