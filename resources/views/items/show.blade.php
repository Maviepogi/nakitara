@extends('layouts.app')

@section('content')
<div class="item-show-container">
    <div class="item-detail-card">
        <!-- Image Gallery Section -->
        <div class="image-gallery">
            @if($item->images && count($item->images) > 0)
                <div class="main-image">
                    <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->title }}" id="mainImage">
                    <div class="image-type-badge badge-{{ $item->type }}">
                        <i class="fas fa-{{ $item->type === 'lost' ? 'search' : 'hand-holding' }}"></i>
                        {{ ucfirst($item->type) }}
                    </div>
                </div>
                @if(count($item->images) > 1)
                    <div class="thumbnail-gallery">
                        @foreach($item->images as $index => $image)
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                 onclick="changeMainImage(this, {{ $index }})">
                        @endforeach
                    </div>
                @endif
            @elseif($item->image)
                <div class="main-image">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    <div class="image-type-badge badge-{{ $item->type }}">
                        <i class="fas fa-{{ $item->type === 'lost' ? 'search' : 'hand-holding' }}"></i>
                        {{ ucfirst($item->type) }}
                    </div>
                </div>
            @else
                <div class="main-image no-image">
                    <div class="no-image-content">
                        <i class="fas fa-image"></i>
                        <span>No Image Available</span>
                    </div>
                    <div class="image-type-badge badge-{{ $item->type }}">
                        <i class="fas fa-{{ $item->type === 'lost' ? 'search' : 'hand-holding' }}"></i>
                        {{ ucfirst($item->type) }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="item-content">
            <div class="item-header">
                <h1 class="item-title">{{ $item->title }}</h1>
                <div class="status-badge status-{{ $item->status }}">
                    <i class="fas fa-{{ $item->status === 'active' ? 'circle' : ($item->status === 'claimed' ? 'check-circle' : 'times-circle') }}"></i>
                    {{ ucfirst($item->status) }}
                </div>
            </div>

            <div class="item-description">
                <p>{{ $item->description }}</p>
            </div>

            <div class="item-meta">
                <div class="meta-grid">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $item->location }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-folder"></i>
                        <span>{{ $item->category->name ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $item->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $item->user->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Success Story -->
            @if($item->status === 'claimed' && $item->successStory)
                <div class="success-story">
                    <div class="success-header">
                        <i class="fas fa-heart"></i>
                        <h3>Success Story</h3>
                    </div>
                    <div class="success-content">
                        <p><strong>Found by:</strong> {{ $item->successStory->finder->name }}</p>
                        <p>{{ $item->successStory->story }}</p>
                        <small>Completed on {{ $item->successStory->created_at->format('M d, Y') }}</small>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="item-actions">
                @if(auth()->check() && auth()->id() !== $item->user_id && $item->status === 'active')
                    <a href="{{ route('messages.create', ['item' => $item->id]) }}" class="btn-contact">
                        <i class="fas fa-envelope"></i>
                        Contact Owner
                    </a>
                @endif
                
                @if(auth()->check() && auth()->id() === $item->user_id)
                    <a href="{{ route('items.edit', $item) }}" class="btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit Item
                    </a>
                    <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="back-button">
        <a href="{{ route('items.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Items
        </a>
    </div>
</div>

<script>
function changeMainImage(thumbnail, index) {
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    // Remove active class from all thumbnails
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    
    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
    
    // Change main image with fade effect
    mainImage.style.opacity = '0';
    setTimeout(() => {
        mainImage.src = thumbnail.src;
        mainImage.style.opacity = '1';
    }, 200);
}

// Add animation classes on load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.item-detail-card').classList.add('animate-in');
});
</script>

<style>
.item-show-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    animation: fadeIn 0.6s ease-out;
}

.item-detail-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(255, 105, 157, 0.15);
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
}

.item-detail-card.animate-in {
    opacity: 1;
    transform: translateY(0);
}

.image-gallery {
    position: relative;
    background: linear-gradient(135deg, #ffeef5 0%, #fff5f8 100%);
    padding: 2rem;
}

.main-image {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    aspect-ratio: 4/3;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.main-image:hover {
    transform: scale(1.02);
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.3s ease;
}

.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.no-image-content {
    text-align: center;
    color: #6c757d;
}

.no-image-content i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.image-type-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    backdrop-filter: blur(10px);
    animation: slideInRight 0.8s ease-out;
}

.badge-lost {
    background: rgba(255, 152, 0, 0.9);
    color: white;
}

.badge-found {
    background: rgba(76, 175, 80, 0.9);
    color: white;
}

.thumbnail-gallery {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    overflow-x: auto;
    padding: 0.5rem 0;
}

.thumbnail {
    width: 80px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    cursor: pointer;
    opacity: 0.6;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.thumbnail:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

.thumbnail.active {
    opacity: 1;
    border-color: #ff6b9d;
    box-shadow: 0 4px 12px rgba(255, 107, 157, 0.3);
}

.item-content {
    padding: 3rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    animation: slideInLeft 0.8s ease-out;
}

.item-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.status-badge {
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: bounceIn 1s ease-out;
}

.status-active {
    background: linear-gradient(45deg, #2196f3, #21cbf3);
    color: white;
}

.status-claimed {
    background: linear-gradient(45deg, #4caf50, #8bc34a);
    color: white;
}

.status-closed {
    background: linear-gradient(45deg, #9e9e9e, #757575);
    color: white;
}

.item-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #555;
    animation: slideInUp 0.8s ease-out 0.2s both;
}

.item-meta {
    animation: slideInUp 0.8s ease-out 0.4s both;
}

.meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: linear-gradient(135deg, #ffeef5 0%, #fff5f8 100%);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.meta-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 105, 157, 0.1);
}

.meta-item i {
    color: #ff6b9d;
    font-size: 1.1rem;
}

.success-story {
    background: linear-gradient(135deg, #e8f5e8 0%, #f0fdf4 100%);
    padding: 2rem;
    border-radius: 16px;
    border-left: 4px solid #4caf50;
    animation: slideInUp 0.8s ease-out 0.6s both;
}

.success-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.success-header i {
    color: #4caf50;
    font-size: 1.5rem;
}

.success-header h3 {
    color: #2e7d32;
    margin: 0;
}

.success-content p {
    margin-bottom: 0.5rem;
}

.item-actions {
    display: flex;
    gap: 1rem;
    animation: slideInUp 0.8s ease-out 0.8s both;
}

.btn-contact,
.btn-edit,
.btn-delete {
    padding: 1rem 2rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-contact {
    background: linear-gradient(45deg, #ff6b9d, #ff8fab);
    color: white;
}

.btn-edit {
    background: linear-gradient(45deg, #ffc107, #ff9800);
    color: white;
}

.btn-delete {
    background: linear-gradient(45deg, #f44336, #e91e63);
    color: white;
}

.btn-contact:hover,
.btn-edit:hover,
.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    color: white;
}

.back-button {
    margin-top: 2rem;
    text-align: center;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(45deg, #6c757d, #495057);
    color: white;
    text-decoration: none;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    color: white;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInLeft {
    from { transform: translateX(-50px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInRight {
    from { transform: translateX(50px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes bounceIn {
    0% { transform: scale(0.5); opacity: 0; }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .item-detail-card {
        grid-template-columns: 1fr;
    }
    
    .item-title {
        font-size: 2rem;
    }
    
    .meta-grid {
        grid-template-columns: 1fr;
    }
    
    .item-actions {
        flex-direction: column;
    }
    
    .image-gallery {
        padding: 1rem;
    }
    
    .item-content {
        padding: 2rem;
    }
}
</style>
@endsection