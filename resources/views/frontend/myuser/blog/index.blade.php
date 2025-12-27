@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $pageTitle }}</h4>
                    <div>
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.blogs.index') }}" class="mb-3">
                        <div class="row g-2 align-items-end">

                            <!-- Title -->
                            <div class="col-md-3">
                                <label class="form-label">Title</label>
                                <input type="text"
                                    name="title"
                                    class="form-control"
                                    placeholder="Search by title"
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
                                <input type="date"
                                    name="published_date"
                                    class="form-control"
                                    value="{{ request('published_date') }}">
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa-solid fa-filter"></i> Filter
                                </button>

                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger w-100">
                                    <i class="fa-solid fa-broom"></i> Clear
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
                                    <th>Published</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($blog->image)
                                                <img src="{{ asset($blog->image) }}" alt="Blog Image" class="table-img">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($blog->title, 50) }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $blog->category->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $blog->is_published ? 'success' : 'danger' }}">
                                                {{ $blog->is_published == 1 ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $blog->published_at ? $blog->published_at->format('d-m-Y') : 'N/A' }}
                                            <div class="form-check form-switch">
                                                <input type="checkbox" 
                                                       class="form-check-input status-toggle" 
                                                       data-id="{{ $blog->id }}"
                                                       {{ $blog->is_published == 1 ? 'checked' : '' }}
                                                       data-url="{{ route('admin.blog.status', $blog->id) }}">
                                                <label class="form-check-label"></label>
                                            </div>
                                        </td>
                                        <td>{{ $blog->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-5">
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning w-40 tooltip-btn" data-tooltip="Edit Blog">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form id="delete-form-{{ $blog->id }}" action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="w-40">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger w-100 deleteBtn tooltip-btn" data-id="{{ $blog->id }}" data-tooltip="Delete Blog">
                                                        <i class="fa-regular fa-trash-can"></i>
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

@push('script')
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
                        showCloseButton:true,
                    });
                    location.reload();
                }
            },
            error: function(xhr) {
                toastr.error('Error updating status');
                location.reload();
            }
        });
    });
});
</script>
@endpush