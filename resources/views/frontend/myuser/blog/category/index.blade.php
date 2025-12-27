@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $pageTitle }}</h4>
                    <div>
                        <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary btn-sm">
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
                                                <input type="checkbox" 
                                                       class="form-check-input status-toggle" 
                                                       data-id="{{ $category->id }}"
                                                       {{ $category->status == 1 ? 'checked' : '' }}
                                                       data-url="{{ route('admin.blog-categories.status', $category->id) }}">
                                                <label class="form-check-label"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-5">
                                                <a href="{{ route('admin.blog-categories.edit', $category->id) }}" class="btn btn-sm btn-warning w-40 tooltip-btn" data-tooltip="Edit Category">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form id="delete-form-{{ $category->id }}" action="{{ route('admin.blog-categories.destroy', $category->id) }}" method="POST" class="w-40">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger w-100 deleteBtn tooltip-btn" data-id="{{ $category->id }}" data-tooltip="Delete Category">
                                                        <i class="fa-regular fa-trash-can"></i>
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
@push('script')
<script>
    $(document).ready(function() {
        // Status toggle
        $('.status-toggle').on('change', function() {
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
                            showCloseButton:true,
                        });
                    }
                }
            });
        });

        // Delete confirmation
        $('.delete-form').on('submit', function(e) {
            if (!confirm(__('Are you sure you want to delete this category?'))) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush