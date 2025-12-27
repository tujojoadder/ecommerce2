@extends('layouts.user.app')


@section('content')
    <link rel="stylesheet" href="{{ asset('backend/css/tagify.css') }}">
    <div class="container-fluid my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $pageTitle }}</h4>
                        <div>
                            <a href="{{ route('user.blog.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.blog.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title">{{ __('Title') }}<span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="10" required>
                                {{ old('description') }}
                            </textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <input type="text" name="tags" id="tagsInput"
                                    class="form-control @error('tags') is-invalid @enderror" value="{{ old('tags') }}"
                                    placeholder="technology, business, career">
                                <small class="text-muted">Separate tags using commas</small>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Blog Image <span class="text-danger">*</span></label>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                                <small class="text-muted">Recommended size: 1200x800px. Max size: 2MB. Leave empty to keep
                                    current image.</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="custom-checkbox">
                                    <input type="checkbox" name="is_published" id="is_published" value="1" checked>
                                    <span class="checkmark"></span>
                                    Publish Now
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Blog</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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

        var input = document.querySelector('#tagsInput');
        new Tagify(input, {
            delimiters: ",| ",
            trim: true
        });
    </script>
@endpush
