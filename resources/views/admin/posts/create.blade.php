@extends('layouts.admin')

@section('title', 'Create News Announcement - Admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    /* Profile Style Input Group Formatting */
    .profile-input-group .input-group-text {
        background-color: #f8f9fa !important;
        border-color: #e2e8f0 !important;
        color: #64748b !important;
        border-top-left-radius: 14px !important;
        border-bottom-left-radius: 14px !important;
    }

    .profile-input-group .form-control,
    .profile-input-group .form-select {
        background-color: #f8f9fa !important;
        border-color: #e2e8f0 !important;
        border-top-right-radius: 14px !important;
        border-bottom-right-radius: 14px !important;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: #1e293b;
    }

    .profile-input-group .form-control:focus,
    .profile-input-group .form-select:focus {
        background-color: #ffffff !important;
        border-color: #008751 !important;
        box-shadow: 0 0 0 4px rgba(0, 135, 81, 0.1) !important;
    }

    /* Quill Editor Custom Styling */
    .ql-toolbar.ql-snow {
        border-color: #e2e8f0 !important;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        background-color: #f8fafc;
        padding: 12px !important;
    }

    .ql-container.ql-snow {
        border-color: #e2e8f0 !important;
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 14px;
        min-height: 300px;
        font-size: 0.95rem;
        font-family: inherit;
        background: #ffffff;
    }
</style>
@endpush

@section('content')
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <a href="{{ route('admin.posts') }}" class="text-decoration-none text-muted small fw-bold mb-1 d-inline-block"><i class="fa fa-arrow-left me-1"></i>Back to News Posts</a>
            <h3 class="fw-bold text-dark mb-0">Create Official Announcement</h3>
        </div>
    </div>

    <!-- CREATE POST CARD -->
    <div class="dash-card p-4 p-md-5 bg-white border">
        @if($errors->any())
            <div class="alert alert-danger rounded-3 p-3 mb-4">
                <div class="fw-bold mb-1"><i class="fa fa-exclamation-triangle me-2"></i>Please resolve the following errors:</div>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="form-label small fw-bold">Post Title</label>
                <div class="input-group profile-input-group">
                    <span class="input-group-text"><span class="material-symbols-outlined">title</span></span>
                    <input type="text" class="form-control bg-light" name="title" value="{{ old('title') }}" placeholder="e.g., NUESA UNIMAID General Elections Accreditation & Guidelines" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Category</label>
                    <div class="input-group profile-input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">category</span></span>
                        <select class="form-select bg-light" name="category" required>
                            <option value="Elections" {{ old('category') === 'Elections' ? 'selected' : '' }}>Elections & Accreditation</option>
                            <option value="Academic" {{ old('category') === 'Academic' ? 'selected' : '' }}>Academic Notice</option>
                            <option value="SIWES / Industrial" {{ old('category') === 'SIWES / Industrial' ? 'selected' : '' }}>SIWES & Industrial</option>
                            <option value="Events" {{ old('category') === 'Events' ? 'selected' : '' }}>Faculty Events</option>
                            <option value="Press Release" {{ old('category') === 'Press Release' ? 'selected' : '' }}>Official Press Release</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Publishing Status</label>
                    <div class="input-group profile-input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">published_with_changes</span></span>
                        <select class="form-select bg-light" name="is_published">
                            <option value="PUBLISHED" {{ old('is_published', 'PUBLISHED') === 'PUBLISHED' ? 'selected' : '' }}>PUBLISHED (Live on Web & Portal)</option>
                            <option value="DRAFT" {{ old('is_published') === 'DRAFT' ? 'selected' : '' }}>DRAFT (Save as Private Draft)</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold">Featured Image (Optional)</label>
                    <div class="input-group profile-input-group">
                        <span class="input-group-text"><span class="material-symbols-outlined">image</span></span>
                        <input type="file" class="form-control bg-light" name="image" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Brief Excerpt / Summary</label>
                <div class="input-group profile-input-group">
                    <span class="input-group-text"><span class="material-symbols-outlined">short_text</span></span>
                    <input type="text" class="form-control bg-light" name="summary" value="{{ old('summary') }}" placeholder="Brief 1-2 sentence overview of the announcement...">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Post content</label>
                <div id="quillEditor"></div>
                <input type="hidden" name="body" id="postBodyInput" value="{{ old('body') }}">
            </div>

            <div class="d-flex align-items-center justify-content-end gap-3 pt-3 border-top">
                <a href="{{ route('admin.posts') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                <button type="submit" class="btn btn-success rounded-pill px-5 py-3 fw-bold shadow-sm" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                    <i class="fa fa-paper-plane me-2"></i>Publish
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Write comprehensive post content, details, and guidelines here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    const oldBody = {!! json_encode(old('body', '')) !!};
    if (oldBody) {
        quill.root.innerHTML = oldBody;
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const html = quill.root.innerHTML;
        if (html === '<p><br></p>' || !html.trim()) {
            document.getElementById('postBodyInput').value = '';
        } else {
            document.getElementById('postBodyInput').value = html;
        }
    });
</script>
@endpush
