@extends('layouts.admin.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/css/tagify.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $pageTitle }}</h4>
                    <div>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> __('Back to List')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">{{ __('Title') }}<span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Content <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="10" required>{{ old('description', $blog->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text"
                                name="tags"
                                id="tagsInput"
                                class="form-control @error('tags') is-invalid @enderror"
                                value='@json($blog->tags)'
                                placeholder="Enter tags">
                            <small class="text-muted">Separate tags using commas</small>

                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Blog Image</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @if($blog->image)
                                <div class="mt-2">
                                    <img src="{{ asset($blog->image) }}" alt="Current Blog Image" style="max-height: 100px; max-width: 200px; object-fit: cover;">
                                    <small class="text-muted d-block">Current image</small>
                                </div>
                            @endif
                            <small class="text-muted">Recommended size: 1200x800px. Max size: 2MB. Leave empty to keep current image.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ $blog->is_published == 1 ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                Publish Now
                            </label>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('backend/js/ckeditor.js') }}"></script>
<script src="{{ asset('backend/js/tagify.js') }}"></script>
<script>
    ClassicEditor.create(document.querySelector('#description'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'blockQuote', 'undo', 'redo'
            ]
        },
        language: 'en'
    })
    .then(editor => {
        editor.ui.view.editable.element.style.height = "200px";
    })
    .catch(error => console.error(error));

    const input = document.querySelector('#tagsInput');

    const tagify = new Tagify(input, {
        delimiters: ",| ",
        trim: true
    });

    // Prefill tags on edit
    if (input.value) {
        try {
            tagify.addTags(JSON.parse(input.value));
        } catch (e) {
            console.error('Invalid tag data');
        }
    }
</script>
@endpush