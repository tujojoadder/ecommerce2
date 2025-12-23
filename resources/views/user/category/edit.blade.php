@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <div>
                            <a href="{{ route('user.category.index') }}" class="btn btn-success">
                                <i class="fas fa-plus d-inline"></i> {{ __('messages.category') }} {{ __('messages.list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                <form action="{{ route('user.category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" name="name" value="{{ $category->name ?? '' }}">
                                <label for="name" class="animated-label"><i class="fas fa-bars"></i> {{ __('messages.category') }} {{ __('messages.name') }}</label>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-0">
                                <input type="file" class="form-control" name="icon" data-bs-toggle="tooltip-primary" title data-bs-original-title="Icon">
                                <small class="text-danger" style="color: red !important">Better Size W:20Px * H:20PX</small>
                                @error('icon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mt-4">
                            <div class="form-group mb-0">
                                <input type="file" class="form-control" name="banner" data-bs-toggle="tooltip-primary" title data-bs-original-title="Banner">
                                <small class="text-danger" style="color: red !important">Better Size W:848Px * H:132PX</small>
                                @error('banner')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mt-4">
                            <div class="form-group mb-0">
                                <input type="file" class="form-control" name="banner2" data-bs-toggle="tooltip-primary" title data-bs-original-title="Banner2">
                                <small class="text-danger" style="color: red !important">Better Size W:370Px * H:348PX</small>
                                @error('banner2')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-success btn-block">{{ __('messages.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


