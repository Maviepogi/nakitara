@extends('layouts.app')

@section('content')
<div class="items-index-container">
    <!-- Header Section -->
    <div class="items-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-box"></i>
                    My Items
                </h1>
                <p class="page-subtitle">Manage your lost and found items</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn-secondary-custom">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="{{ route('items.create') }}" class="btn-primary-custom">
                    <i class="fas fa-plus"></i>
                    Add New Item
                </a>
            </div>
        </div>
    </div>

    <div class="items-content">
        <!-- Items Section -->
        <div class="items-section">
            @if($items->count() > 0)
                <div class="items-grid">
                    @foreach($items as $item)
                        <div class="item-card" data-type="{{ $item->type }}" data-status="{{ $item->status }}">
                            <div class="item-image">
                                @if($item->images && count($item->images) > 0)
                                    <div class="image-carousel">
                                        @foreach($item->images as $index => $image)
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="{{ $item->title }}"
                                                 class="carousel-image {{ $index === 0 ? 'active' : '' }}"
                                                 style="display: {{ $index === 0 ? 'block' : 'none' }}">
                                        @endforeach
                                        
                                        @if(count($item->images) > 1)
                                            <div class="carousel-controls">
                                                <button class="carousel-btn prev" onclick="changeImage(this, -1)">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button class="carousel-btn next" onclick="changeImage(this, 1)">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                                <div class="image-counter">
                                                    <span class="current-image">1</span> / <span class="total-images">{{ count($item->images) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                                
                                <div class="item-badges">
                                    <div class="item-type-badge badge-{{ $item->type }}">
                                        <i class="fas fa-{{ $item->type === 'lost' ? 'search' : 'hand-holding' }}"></i>
                                        {{ ucfirst($item->type) }}
                                    </div>
                                    <div class="item-status-badge status-{{ $item->status }}">
                                        <i class="fas fa-{{ $item->status === 'active' ? 'eye' : ($item->status === 'claimed' ? 'check-circle' : 'times-circle') }}"></i>
                                        {{ ucfirst($item->status) }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item-content">
                                <h3 class="item-title">{{ $item->title }}</h3>
                                <p class="item-description">{{ Str::limit($item->description, 80) }}</p>
                                
                                <div class="item-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-folder"></i>
                                        {{ $item->category->name }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $item->location }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                @if($item->status === 'claimed' && $item->successStory)
                                    <div class="success-story-preview">
                                        <div class="success-badge">
                                            <i class="fas fa-trophy"></i>
                                            Success Story
                                        </div>
                                        <p class="success-text">{{ Str::limit($item->successStory->story, 60) }}</p>
                                    </div>
                                @endif
                                
                                <div class="item-actions">
                                    <a href="{{ route('items.show', $item) }}" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="pagination-wrapper">
                    {{ $items->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3>No items found</h3>
                    <p>You haven't posted any items yet. Start by posting your first item!</p>
                    <a href="{{ route('items.create') }}" class="btn-primary-custom">
                        <i class="fas fa-plus"></i>
                        Post Your First Item
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function changeImage(button, direction) {
    const card = button.closest('.item-card');
    const images = card.querySelectorAll('.carousel-image');
    const counter = card.querySelector('.current-image');
    
    let currentIndex = 0;
    images.forEach((img, index) => {
        if (img.style.display === 'block') {
            img.style.display = 'none';
            currentIndex = index;
        }
    });
    
    let newIndex = currentIndex + direction;
    if (newIndex >= images.length) newIndex = 0;
    if (newIndex < 0) newIndex = images.length - 1;
    
    images[newIndex].style.display = 'block';
    counter.textContent = newIndex + 1;
}

// Add loading animation
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.item-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>

<style>
/* Modern Items Index Styles */
.items-index-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #ffeef5 0%, #fff5f8 100%);
    padding: 0;
}

.items-header {
    background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.items-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    animation: float 20s infinite linear;
}

@keyframes float {
    0% { transform: translateX(0); }
    100% { transform: translateX(100px); }
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    position: relative;
    z-index: 2;
}

.header-left {
    flex: 1;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    animation: slideInLeft 0.8s ease-out;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    animation: slideInLeft 0.8s ease-out 0.2s both;
}

.header-actions {
    display: flex;
    gap: 1rem;
    animation: slideInRight 0.8s ease-out;
}

.btn-primary-custom,
.btn-secondary-custom {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary-custom {
    background: linear-gradient(45deg, #ff4081, #e91e63);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 64, 129, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 64, 129, 0.4);
    color: white;
}

.btn-secondary-custom {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.btn-secondary-custom:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
}

.items-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Items Section */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.item-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(255, 105, 157, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease-out;
}

.item-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(255, 105, 157, 0.2);
}

.item-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.item-card:hover .item-image img {
    transform: scale(1.05);
}

/* Image Carousel */
.image-carousel {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.carousel-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    transition: opacity 0.3s ease;
}

.carousel-controls {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(0, 0, 0, 0.7);
    padding: 5px 10px;
    border-radius: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.item-card:hover .carousel-controls {
    opacity: 1;
}

.carousel-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-btn:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: scale(1.1);
}

.image-counter {
    color: white;
    font-size: 12px;
    font-weight: 600;
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: linear-gradient(135deg, #ffeef5 0%, #fff5f8 100%);
    color: #ff6b9d;
}

.no-image i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.item-badges {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.item-type-badge,
.item-status-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    backdrop-filter: blur(10px);
}

.badge-lost {
    background: rgba(255, 152, 0, 0.9);
    color: white;
}

.badge-found {
    background: rgba(76, 175, 80, 0.9);
    color: white;
}

.status-active {
    background: rgba(33, 150, 243, 0.9);
    color: white;
}

.status-claimed {
    background: rgba(76, 175, 80, 0.9);
    color: white;
}

.status-closed {
    background: rgba(158, 158, 158, 0.9);
    color: white;
}

.item-content {
    padding: 1.5rem;
}

.item-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.item-description {
    color: #666;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.item-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #888;
    font-size: 0.9rem;
}

.meta-item i {
    color: #ff6b9d;
    width: 12px;
}

.success-story-preview {
    background: linear-gradient(45deg, #e8f5e8, #f0f8f0);
    border: 2px solid #4CAF50;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    animation: pulse 2s infinite;
}

.success-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4CAF50;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.success-text {
    color: #2e7d32;
    font-size: 0.9rem;
    margin: 0;
    font-style: italic;
}

.item-actions {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 0.5rem;
}

.btn-view,
.btn-edit,
.btn-delete {
    padding: 0.5rem 1rem;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    border: none;
    cursor: pointer;
}

.btn-view {
    background: linear-gradient(45deg, #2196F3, #21CBF3);
    color: white;
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
    color: white;
}

.btn-edit {
    background: linear-gradient(45deg, #FF9800, #FFC107);
    color: white;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
    color: white;
}

.btn-delete {
    background: linear-gradient(45deg, #f44336, #e57373);
    color: white;
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #666;
    animation: fadeIn 0.8s ease-out;
}

.empty-icon {
    font-size: 4rem;
    color: #ff6b9d;
    margin-bottom: 1rem;
    animation: bounce 2s infinite;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Animations */
@keyframes slideInLeft {
    from { transform: translateX(-100px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInRight {
    from { transform: translateX(100px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-20px); }
    60% { transform: translateY(-10px); }
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
    100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
        max-width: 300px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .items-grid {
        grid-template-columns: 1fr;
    }
    
    .item-actions {
        grid-template-columns: 1fr;
    }
    
    .carousel-controls {
        opacity: 1;
    }
}

@media (max-width: 480px) {
    .items-content {
        padding: 0 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}
</style>
@endsection