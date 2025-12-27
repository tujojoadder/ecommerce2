@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Blog Details</h4>
                    <div>
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-dark btn-sm">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>{{ $blog->title }}</h5>
                            @if($blog->image)
                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded mb-3" style="max-height: 300px; width: 100%; object-fit: cover;">
                            @endif

                            <div class="blog-content">
                                {!! $blog->description !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Blog Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>ID:</th>
                                            <td>{{ $blog->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category:</th>
                                            <td><span class="badge badge-info">{{ $blog->category }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Author:</th>
                                            <td>{{ $blog->post_author ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span class="badge badge-{{ $blog->is_published ? 'success' : 'warning' }}">
                                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Published At:</th>
                                            <td>{{ $blog->published_at ? $blog->published_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>{{ $blog->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At:</th>
                                            <td>{{ $blog->updated_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    </table>

                                    @if($blog->tags)
                                        <div class="mt-3">
                                            <h6>Tags:</h6>
                                            <div class="tags">
                                                @foreach(explode(',', $blog->tags) as $tag)
                                                    <span class="badge badge-secondary mr-1">{{ trim($tag) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
