@extends('layouts.admin.app', ['pageTitle' => $pageTitle])

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $pageTitle }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.managers.update') }}" method="GET">
                @csrf
                @foreach ($managers->groupBy('type') as $type => $typeManagers)
                    <h4>{{ ucfirst($type) }} {{ $type == 'clients' ? 'Fields' : '' }} {{ $type == 'marketers' ? 'Fields' : '' }}</h4>
                    <div class="row mb-3">
                        @foreach ($typeManagers as $manager)
                            <div class="col-md-3">
                                <label class="form-control d-flex align-items-center">
                                    <input type="checkbox" class="me-1" name="managers[{{ $manager->id }}][status]" {{ $manager->status ? 'checked' : '' }}>
                                    {{ Str::upper(str_replace('_', ' ', $manager->section)) }}
                                    <input type="hidden" name="managers[{{ $manager->id }}][id]" value="{{ $manager->id }}">
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success w-25">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
