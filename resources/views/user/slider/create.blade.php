@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <div>
                            <a  href="{{ route('user.slider.create') }}" class="btn btn-success">
                                <i class="fas fa-plus d-inline"></i> {{ __('messages.add') }} {{ __('messages.slider') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                <form action="{{ route('user.slider.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row" id="client-group-form">
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="subtitle" id="subtitle">
                            <label for="subtitle" class="animated-label"><i class="fas fa-bars"></i> Sub Title</label>
                            <span class="text-danger small" id="subtitle_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto" style="margin-top: 10px !important; ">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="title" id="title">
                            <label for="title" class="animated-label"><i class="fas fa-bars"></i> Title</label>
                            <span class="text-danger small" id="title_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto" style="margin-top: 10px !important; ">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="des" id="des">
                            <label for="des" class="animated-label"><i class="fas fa-bars"></i> Description</label>
                            <span class="text-danger small" id="des_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto" style="margin-top: 10px !important; ">
                        <div class="form-group mb-0">
                            <label> Main Image (Width: 890px, height: 443px)</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <span class="text-danger small" id="image_Error"></span>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto" style="margin-top: 10px !important; ">
                        <div class="form-group mb-0">
                            <label> Sub Image (Width: 432px, height: 376px)</label>
                            <input type="file" class="form-control" name="subimage" id="subimage">
                            <span class="text-danger small" id="subimage_Error"></span>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto" style="margin-top: 20px !important; ">
                        <button type="submit" class="btn btn-success btn-block">Add</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

@endpush
