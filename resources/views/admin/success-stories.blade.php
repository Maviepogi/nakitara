@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-dark: #0f172a;
        --secondary-dark: #1e293b;
        --accent-blue: #1e40af;
        --accent-blue-light: #3b82f6;
        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --border-color: #334155;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
    }

    body {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        color: var(--text-primary);
        min-height: 100vh;
    }

    .page-container {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .header-section {
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        animation: slideInRight 0.8s ease-out;
    }

    .header-section h2 {
        background: linear-gradient(45deg, var(--accent-blue-light), #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
        margin: 0;
        font-size: 2.5rem;
    }

    .btn-enhanced {
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-enhanced:hover::before {
        left: 100%;
    }

    .btn-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .btn-primary-enhanced {
        background: linear-gradient(45deg, var(--accent-blue), var(--accent-blue-light));
        color: white;
    }

    .btn-success-enhanced {
        background: linear-gradient(45deg, var(--success-color), #059669);
        color: white;
    }

    .btn-secondary-enhanced {
        background: linear-gradient(45deg, var(--secondary-dark), #475569);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-danger-enhanced {
        background: linear-gradient(45deg, var(--danger-color), #dc2626);
        color: white;
    }

    .modal-content {
        background: var(--secondary-dark);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        animation: scaleIn 0.3s ease-out;
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(45deg, var(--primary-dark), var(--secondary-dark));
    }

    .modal-title {
        color: var(--text-primary);
        font-weight: 600;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
    }

    .form-control, .form-select {
        background: var(--primary-dark);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: var(--primary-dark);
        border-color: var(--accent-blue-light);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        color: var(--text-primary);
    }

    .form-label {
        color: var(--text-secondary);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .card {
        background: rgba(30, 41, 59, 0.9);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .card-header {
        background: linear-gradient(45deg, var(--primary-dark), var(--secondary-dark));
        border-bottom: 1px solid var(--border-color);
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .table {
        color: var(--text-primary);
        --bs-table-bg: transparent;
    }

    .table-striped > tbody > tr:nth-of-type(odd) > td {
        background-color: rgba(15, 23, 42, 0.3);
    }

    .table th {
        border-color: var(--border-color);
        background: linear-gradient(45deg, var(--primary-dark), var(--secondary-dark));
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        padding: 1rem 0.75rem;
    }

    .table td {
        border-color: var(--border-color);
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table-row {
        transition: all 0.3s ease;
    }

    .table-row:hover {
        background: rgba(59, 130, 246, 0.1) !important;
        transform: scale(1.01);
    }

    .stats-badge {
        background: linear-gradient(45deg, var(--accent-blue), var(--accent-blue-light));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm-enhanced {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary-enhanced {
        border: 1px solid var(--accent-blue);
        color: var(--accent-blue);
        background: transparent;
    }

    .btn-outline-primary-enhanced:hover {
        background: var(--accent-blue);
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-danger-enhanced {
        border: 1px solid var(--danger-color);
        color: var(--danger-color);
        background: transparent;
    }

    .btn-outline-danger-enhanced:hover {
        background: var(--danger-color);
        color: white;
        transform: translateY(-1px);
    }

    .pagination .page-link {
        background: var(--secondary-dark);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: var(--accent-blue);
        border-color: var(--accent-blue);
        color: white;
        transform: translateY(-1px);
    }

    .pagination .page-item.active .page-link {
        background: var(--accent-blue);
        border-color: var(--accent-blue);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .story-preview {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .text-muted {
        color: var(--text-secondary) !important;
    }

    .btn-close {
        filter: invert(1);
    }

    .item-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .item-title {
        font-weight: 600;
        color: var(--text-primary);
    }

    .item-owner {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .fade-in {
        opacity: 0;
        animation: fadeIn 0.5s ease-in-out forwards;
    }

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    .fade-in:nth-child(4) { animation-delay: 0.4s; }
    .fade-in:nth-child(5) { animation-delay: 0.5s; }

    @keyframes fadeIn {
        to { opacity: 1; }
    }
</style>

<div class="page-container">
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Success Stories</h2>
            <div class="d-flex gap-3">
                <a href="{{ route('admin.download-success-stories') }}" class="btn btn-enhanced btn-success-enhanced">
                    <i class="fas fa-download me-2"></i>Download PDF
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-enhanced btn-secondary-enhanced">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Success Stories are now read-only -->

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center gap-3">
                <span class="fs-5 fw-bold">Success Stories</span>
                <span class="stats-badge">{{ $stories->total() }} total</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                            <th><i class="fas fa-box me-2"></i>Item</th>
                            <th><i class="fas fa-search me-2"></i>Finder</th>
                            <th><i class="fas fa-user me-2"></i>Owner</th>
                            <th><i class="fas fa-book me-2"></i>Story</th>
                            <th><i class="fas fa-calendar me-2"></i>Created</th>
                            <th><i class="fas fa-cog me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stories as $index => $story)
                            <tr class="table-row fade-in">
                                <td class="fw-bold">{{ $story->id }}</td>
                                <td>
                                    <div class="item-info">
                                        <span class="item-title">{{ $story->item->title ?? 'Unknown Item' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle me-2 text-primary"></i>
                                        {{ $story->finder->name ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle me-2 text-success"></i>
                                        {{ $story->owner->name ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="story-preview">{{ Str::limit($story->story, 50) }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt me-2 text-info"></i>
                                        {{ $story->created_at->format('Y-m-d') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm-enhanced btn-outline-primary-enhanced view-story-btn" 
                                                data-story-id="{{ $story->id }}" 
                                                data-story-content="{{ htmlspecialchars($story->story) }}">
                                            <i class="fas fa-eye me-1"></i>View
                                        </button>
                                        <form method="POST" action="{{ route('admin.success-stories.destroy', $story) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm-enhanced btn-outline-danger-enhanced" onclick="return confirm('Are you sure you want to delete this story?')">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <h5>No Success Stories Found</h5>
                                    <p>Create your first success story to get started!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $stories->links() }}
            </div>
        </div>
    </div>

    <!-- View Story Modal -->
    <div class="modal fade" id="viewStoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-book-open me-2"></i>Success Story
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3" style="background: rgba(15, 23, 42, 0.5); border-radius: 12px; border-left: 4px solid var(--accent-blue);">
                        <p id="fullStoryContent" class="mb-0" style="line-height: 1.6; font-size: 1.1rem;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-enhanced btn-secondary-enhanced" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced view story functionality
    document.querySelectorAll('.view-story-btn').forEach(button => {
        button.addEventListener('click', function() {
            const storyId = this.getAttribute('data-story-id');
            const storyContent = this.getAttribute('data-story-content');
            
            // Add loading state
            this.innerHTML = '<span class="loading-spinner me-2"></span>Loading...';
            this.disabled = true;
            
            setTimeout(() => {
                document.getElementById('fullStoryContent').textContent = storyContent;
                new bootstrap.Modal(document.getElementById('viewStoryModal')).show();
                
                // Reset button
                this.innerHTML = '<i class="fas fa-eye me-1"></i>View';
                this.disabled = false;
            }, 500);
        });
    });

    // Add hover effects to table rows
    document.querySelectorAll('.table-row').forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
    });

    // Form validation enhancements
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.innerHTML = '<span class="loading-spinner me-2"></span>Processing...';
                submitBtn.disabled = true;
            }
        });
    });
});
</script>
@endsection