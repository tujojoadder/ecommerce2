@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <div>
                            <a href="{{ route('user.subsubcategory.index') }}" class="btn btn-success">
                                <i class="fas fa-plus d-inline"></i> {{ __('messages.subsubcategory') }}
                                {{ __('messages.list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                <form action="{{ route('user.subsubcategory.update', $subsubcategory->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                    title="{{ __('messages.select') }} {{ __('messages.category') }}">
                                    <select name="category_id" id="category_id" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                    title="{{ __('messages.select') }} {{ __('messages.subcategory') }}">
                                    <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12">
                            <div class="d-flex">
                               <input type="text" class="form-control" name="name" value="{{ $subsubcategory->name }}" required>
                                <label for="name" class="animated-label"><i class="fas fa-bars"></i>{{ __('messages.subcategory') }} {{ __('messages.name') }}</label>
                            </div>
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
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchCategories();
            setTimeout(() => {
                getCategoryInfo('/get-cateogry-info', {{ $subsubcategory->category_id }});
                getSubCategoryInfo('/get-sub-cateogry-info', {{ $subsubcategory->subcategory_id }});
            }, 500);
        });
    </script>
@endpush
