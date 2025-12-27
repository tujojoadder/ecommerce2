@extends('layouts.user.app')
@push('head')
    <style>
        /* Toggle Switch Custom Styling */
        .form-check-input.status-toggle {
            width: 50px !important;
            height: 25px !important;
            cursor: pointer;
            border: none;
            background-color: #6c757d !important;
            /* Gray for unchecked */
            transition: all 0.3s ease;
            position: relative;
        }

        .form-check-input.status-toggle:checked {
            background-color: #0d6efd !important;
            /* Bootstrap primary blue */
        }

        .form-check-input.status-toggle:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
            /* Blue glow */
            outline: none;
        }

        /* Switch Circle/Handle */
        .form-check-input.status-toggle::after {
            content: '';
            position: absolute;
            width: 21px;
            height: 21px;
            background-color: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-check-input.status-toggle:checked::after {
            left: 27px;
        }

        /* Form Check Container */
        .form-check.form-switch {
            padding-left: 0;
            min-height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hover Effect */
        .form-check-input.status-toggle:hover {
            opacity: 0.9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Active/Pressed Effect */
        .form-check-input.status-toggle:active::after {
            width: 26px;
        }

        /* Table Image Styling */
        .table-img {
            border-radius: 8px;
            object-fit: cover;
            height: 60px;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid my-4 ">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $pageTitle }}</h4>
                        <div>
                            <a href="{{ route('user.blog.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus-square"></i> Add new
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('user.blog.index') }}" class="mb-3">
                            <div class="row g-2 align-items-end">

                                <!-- Title -->
                                <div class="col-md-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Search by title"
                                        value="{{ request('title') }}">
                                </div>

                                <!-- Status -->
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                                            Published
                                        </option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                                            Draft
                                        </option>
                                    </select>
                                </div>

                                <!-- Published Date -->
                                <div class="col-md-3">
                                    <label class="form-label">Published Date</label>
                                    <input type="date" name="published_date" class="form-control"
                                        value="{{ request('published_date') }}">
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>

                                    <a href="{{ route('user.blog.index') }}" class="btn btn-danger w-100">
                                        <i class="fas fa-redo-alt"></i> Clear
                                    </a>
                                </div>

                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($blogs as $blog)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($blog->image)
                                                    <img width="100px" src="{{ asset('storage/blog/' . $blog->image) }}"
                                                        alt="Blog Image" class="table-img">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($blog->title, 50) }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-success text-dark">{{ $blog->category->name ?? 'N/A' }}</span>
                                            </td>


                                            <td class="text-center">
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input status-toggle"
                                                        data-id="{{ $blog->id }}"
                                                        {{ $blog->is_published == 1 ? 'checked' : '' }}
                                                        data-url="{{ route('user.blog.status', $blog->id) }}">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>




                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('user.blog.edit', $blog->id) }}"
                                                        class="btn btn-sm btn-warning w-40 tooltip-btn"
                                                        data-tooltip="Edit Blog">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $blog->id }}"
                                                        action="{{ route('user.blog.destroy', $blog->id) }}" method="POST"
                                                        class="w-40">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger w-100 deleteBtn tooltip-btn"
                                                            data-id="{{ $blog->id }}" data-tooltip="Delete Blog">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No blogs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $blogs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Status toggle
            $('.status-toggle').on('change', function() {
                const categoryId = $(this).data('id');
                const url = $(this).data('url');
                const is_published = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_published: is_published
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: "top-end",
                                text: response.message,
                                icon: "success",
                                toast: true,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                            });
                            /* location.reload(); */
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error updating status');
                        /* location.reload(); */
                    }
                });
            });

            // Delete confirmation - using event delegation
            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('id');
                const form = $('#delete-form-' + categoryId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });


        });
    </script>
@endpush
