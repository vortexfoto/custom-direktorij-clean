@extends('layouts.admin')
@section('title', get_phrase('Update Blog'))
@section('admin_layout')

    <link href="{{ asset('plugin/summernote/summernote-lite.min.css') }}" rel="stylesheet">
    <style>
        .pl-0 {
            padding-left: 0;
        }
    </style>
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-2 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Update Blog') }}
                </h4>

                <a href="{{ route('admin.blogs', ['type' => 'all']) }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span> {{ get_phrase('Back') }} </span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card mt-3">
        <div class="ol-card-body p-3">
            <form action="{{ route('admin.blog.update', ['id' => $blog->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label ol-form-label"> {{ get_phrase('Blog Title') }} </label>
                    <input type="text" class="form-control ol-form-control" name="title" id="title" value="{{ $blog->title }}" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label ol-form-label"> {{ get_phrase('Blog Category') }} </label>
                    <select name="category" id="category" class="ol-select2" data-minimum-results-for-search="Infinity" required>
                        <option value=""> {{ get_phrase('Select blog category') }} </option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ $blog->category == $item->id ? 'selected' : '' }}> {{ $item->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label ol-form-label"> {{ get_phrase('Blog Description') }} </label>
                    <textarea id="summernote" name="description" required>{!! htmlspecialchars($blog->description, ENT_QUOTES, 'UTF-8') !!}</textarea>

                </div>
                <div class="mb-3">
                    <label for="keyword" class="form-label ol-form-label"> {{ get_phrase('Blog Keyword') }} </label>
                    <input type="text" class="form-control ol-form-control" name="keyword" id="keyword" value="{{ $blog->keyword }}" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label ol-form-label"> {{ get_phrase('Blog Banner') }} </label>
                    <input type="file" class="form-control form-control-file" name="image" id="image">
                </div>
                <div class="mb-3">
                    <p class="column-title ol-form-label">{{ get_phrase('Do you want to mark it as popular') }}?</p>
                    <div class="eCheckbox">
                        <div class="form-check pl-0">
                            <input class="form-check-label" type="checkbox" value="1" id="is_popular" name="is_popular" @if ($blog->is_popular == 1) checked @endif />
                            <label class="form-check-label ol-form-label" for="is_popular">
                                {{ get_phrase('Mark as popular') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn ol-btn-primary px-4"> {{ get_phrase('Update') }} </button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('plugin/summernote/summernote-lite.min.js') }}"></script>
    <script>
        "use strict";
        $('#summernote').summernote({
            placeholder: "{{ get_phrase('Write Blog description') }}",
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']]
            ]
        });
    </script>
@endsection
