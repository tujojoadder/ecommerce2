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
    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $pageTitle }}</h4>
                        <div>
                            <a href="{{ route('user.blog.category.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-plus"></i> Add New Category
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Created By') }} </th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($blogCategories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>Admin</td>
                                            <td>{{ $category->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input status-toggle"
                                                        data-id="{{ $category->id }}"
                                                        {{ $category->status == 1 ? 'checked' : '' }}
                                                        data-url="{{ route('user.blog.category.status', $category->id) }}">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td class="align-center">
                                                <div class="d-flex gap-3">
                                                    <a href="{{ route('user.blog.category.edit', $category->id) }}"
                                                        class="btn btn-sm btn-warning w-40 tooltip-btn"
                                                        data-tooltip="Edit Category">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $category->id }}"
                                                        action="{{ route('user.blog.category.destroy', $category->id) }}"
                                                        method="POST" class="w-40">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger w-100 deleteBtn tooltip-btn"
                                                            data-id="{{ $category->id }}" data-tooltip="Delete Category">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">{{ __('No categories found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $blogCategories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Status toggle
        $(document).on('change', '.status-toggle', function() {
            const categoryId = $(this).data('id');
            const url = $(this).data('url');
            const status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
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
                    }
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
    </script>
@endpush
