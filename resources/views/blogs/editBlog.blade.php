@extends('layouts.app')

@section('title', 'Edit Blog')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        background: #ffffff;
        max-width: 800px;
        margin: auto;
    }
    .form-control, .form-select {
        border-radius: 8px;
        font-size: 14px;
        height: 45px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
    }
    .btn-custom, .btn-cancel {
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn-custom {
        background-color: #007bff;
        color: white;
    }
    .btn-custom:hover {
        background-color: #0056b3;
    }
    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }
    .btn-cancel:hover {
        background-color: #bd2130;
    }
    .preview-container {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f8f9fa;
        max-width: 800px;
        width: 100%;
    }
    .flex-container {
        display: flex;
        gap: 20px;
        justify-content: center;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    .preview-container, .card-custom {
        width: 45%;
    }
    @media (max-width: 768px) {
        .preview-container, .card-custom {
            width: 100%;
        }
    }
    #preview-title,
    #preview-category,
    #preview-tags,
    #preview-publish-date,
    #preview-content {
        word-break: break-word;
        overflow-wrap: break-word;
    }
</style>

<div class="content-container flex-grow-1">
    <div class="container py-5">
        <div class="flex-container" style="height: 75vh;">
            <div class="card card-custom" style="flex: 1 1 45%; height: 100%;">
                <h2 class="fw-bold text-center mb-4">Edit Blog</h2>
                <form action="{{ route('blog.update', $blog->blogID) }}" method="POST" enctype="multipart/form-data" style="height: 100%; overflow-y: auto;">
                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Blog Title" value="{{ old('title', $blog->title) }}" oninput="updatePreview()">
                        <label for="title">Title</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="category" name="category" placeholder="Category" value="{{ old('category', $blog->category) }}" oninput="updatePreview()">
                        <label for="category">Category</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Tags" value="{{ old('tags', $blog->tags) }}" oninput="updatePreview()">
                        <label for="tags">Tags (comma-separated)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="publish_date" name="publish_date" value="{{ old('publish_date', $blog->publish_date) }}" oninput="updatePreview()">
                        <label for="publish_date">Publish Date</label>
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image</label>
                        <input class="form-control" type="file" id="cover_image" name="cover_image">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content" class="tinymce-editor" rows="5">{{ old('content', $blog->content) }}</textarea>
                    </div>

                    <div class="form-floating mb-4">
                        <select class="form-select" id="status" name="status" onchange="updatePreview()">
                            <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archive" {{ old('status', $blog->status) == 'archive' ? 'selected' : '' }}>Archive</option>
                            <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('blog.index') }}" class="btn btn-cancel me-2">Cancel</a>
                        <button type="submit" class="btn btn-custom">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="preview-container" style="flex: 1 1 45%; height: 100%;">
                <h2 class="fw-bold text-center mb-4">Blog Preview</h2>
                <div class="p-4 rounded border bg-light overflow-auto" style="height: calc(100% - 60px);">
                    <h2 id="preview-title" style="font-weight: 800; font-size: 30px; margin-bottom: 8px; color: #222;">Title will appear here</h2>
                    <p id="preview-category" style="font-size: 14px; color: #6c757d; margin-bottom: 5px;">Category will appear here</p>
                    <p id="preview-tags" style="font-size: 14px; color: #6c757d; margin-bottom: 20px;">Tags will appear here</p>
                    <p id="preview-publish-date" style="font-size: 14px; color: #6c757d; margin-bottom: 20px;">Publish Date will appear here</p>
                    <img id="preview-image"
                        src="{{ $blog->cover_image ? asset('storage/' . $blog->cover_image) : asset('images/istockphoto-1147544807-612x612.jpg') }}"
                        alt="Cover Image Preview"
                        style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 25px; object-fit: cover;">
                    <div id="preview-content" style="font-size: 17px; line-height: 1.8; color: #4a4a4a; white-space: pre-wrap; word-break: break-word; overflow-wrap: break-word;">
                        Content will appear here
                    </div>
                    <p>{{ $blog->cover_image }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePreview() {
        const title = document.getElementById('title').value.trim();
        const category = document.getElementById('category').value.trim();
        const tags = document.getElementById('tags').value.trim();
        const content = tinymce.get('content') ? tinymce.get('content').getContent({ format: 'html' }).trim() : '';
        const publishDate = document.getElementById('publish_date').value;

        document.getElementById('preview-title').innerText = title || 'Title will appear here';
        document.getElementById('preview-category').innerText = category ? `Category: ${category}` : 'Category will appear here';
        document.getElementById('preview-tags').innerText = tags ? `Tags: ${tags}` : 'Tags will appear here';
        document.getElementById('preview-content').innerHTML = content || 'Content will appear here';

        if (publishDate) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('preview-publish-date').innerText = new Date(publishDate).toLocaleDateString(undefined, options);
        } else {
            document.getElementById('preview-publish-date').innerText = 'Publish Date will appear here';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    const fallbackImage = "{{ asset('images/istockphoto-1147544807-612x612.jpg') }}";
    const currentImage = "{{ asset('storage/' . $blog->cover_image) }}";

    const previewImg = document.getElementById('preview-image');

    // Check if the current image exists and is valid
    previewImg.src = currentImage && currentImage !== 'undefined' ? currentImage : fallbackImage;

    previewImg.onerror = () => previewImg.src = fallbackImage;

    document.getElementById('title').addEventListener('input', updatePreview);
    document.getElementById('category').addEventListener('input', updatePreview);
    document.getElementById('tags').addEventListener('input', updatePreview);
    document.getElementById('publish_date').addEventListener('input', updatePreview);

    document.getElementById('cover_image').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            document.getElementById('preview-image').src = fallbackImage;
        }
        console.log("Cover image changed:", event.target.files[0]);
    });

    updatePreview();
});
</script>
@endpush

