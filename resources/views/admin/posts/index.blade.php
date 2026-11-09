@extends('layouts.admin')

@section('title', 'News & Announcements Control - Admin')

@push('styles')
<style>
    .admin-badge {
        background: linear-gradient(135deg, #008751 0%, #004d2e 100%);
        color: #fff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">News</h3>
            <p class="text-muted small mb-0">Publish official announcements, academic notices, event schedules, and engineering news.</p>
        </div>
        <div>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center btn-sm text-nowrap" style="background: linear-gradient(135deg, #008751 0%, #006038 100%); border: none;">
                <i class="fa fa-plus-circle me-2"></i>Create New Post
            </a>
        </div>
    </div>

    <!-- Posts List Table -->
    <div class="dash-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light extra-small text-uppercase">
                    <tr>
                        <th>Post Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Date Published</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="adminPostsTableBody">
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark small">{{ $post->title }}</div>
                                <div class="text-muted extra-small">{{ Str::limit($post->summary ?? strip_tags($post->body), 80) }}</div>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 extra-small">{{ $post->category }}</span></td>
                            <td class="small">{{ $post->author->name ?? 'EXCO PRO' }}</td>
                            <td class="small text-muted">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">PUBLISHED</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1">DRAFT</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-light btn-sm rounded-circle text-primary me-1" title="Edit Post"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No news announcements created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
