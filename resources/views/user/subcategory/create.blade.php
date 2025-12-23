@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <div>
                            <a href="{{ route('user.subcategory.index') }}" class="btn btn-success">
                                <i class="fas fa-plus d-inline"></i> {{ __('messages.subcategory') }}
                                {{ __('messages.list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                <form action="{{ route('user.subcategory.store') }}" method="post">
                    @csrf
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
                        <div class="col-md-12 mt-4">
                            <button type="button" class="btn btn-success mb-3" id="addNewRow">
                                <i class="fa fa-plus"></i> Add New
                            </button>

                            <div id="subcatContainer">
                                <div class="card mb-3" style="border: 1px dashed skyblue;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-10">
                                                <input type="text" class="form-control" name="name[]" required>
                                                <label for="name" class="animated-label"><i class="fas fa-bars"></i>
                                                    {{ __('messages.subcategory') }} {{ __('messages.name') }}</label>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-danger removeRow">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-success btn-block">{{ __('messages.add') }}
                            {{ __('messages.new') }}</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchCategories();
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#addNewRow").click(function() {
                let clone = $("#subcatContainer .card:first").clone();
                clone.find("input").val(""); // clear inputs
                clone.find("select").val(""); // clear select
                $("#subcatContainer").append(clone);
            });

            // Remove button for dynamically added cards
            $(document).on("click", ".removeRow", function() {
                if ($("#subcatContainer .card").length > 1) {
                    $(this).closest(".card").remove();
                } else {
                    alert("At least one question is required!");
                }
            });
        });
    </script>
@endpush
