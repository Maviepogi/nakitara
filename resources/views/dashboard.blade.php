@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="dashboard-title">
                <i class="fas fa-search"></i>
                Lost & Found Dashboard
            </h1>
            <p class="dashboard-subtitle">Find what you're looking for or help others find theirs</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('items.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i>
                Post New Item
            </a>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filters-card">
                <div class="filters-header">
                    <h3><i class="fas fa-filter"></i> Filter Items</h3>
                </div>
                <div class="filters-body">
                    <form method="GET" action="{{ route('dashboard.filter') }}" class="filters-form">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-tag"></i>
                                Category
                            </label>
                            <select name="category_id" class="filter-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-calendar"></i>
                                Date
                            </label>
                            <input type="date" name="date" class="filter-input" value="{{ request('date') }}">
                        </div>
                        
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-search"></i>
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Items Grid -->
        <div class="items-section">
            <div class="section-header">
                <h2><i class="fas fa-list"></i> Recent Items</h2>
                <div class="items-count">{{ $items->total() }} items found</div>
            </div>
            
            <div class="items-grid">
                @foreach($items as $item)
                    <div class="item-card" data-type="{{ $item->type }}">
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
                            <div class="item-type-badge badge-{{ $item->type }}">
                                <i class="fas fa-{{ $item->type === 'lost' ? 'search' : 'hand-holding' }}"></i>
                                {{ ucfirst($item->type) }}
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
                            
                            <div class="item-actions">
                                <a href="{{ route('items.show', $item) }}" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </a>
                                @if($item->user_id != auth()->id())
                                    <a href="{{ route('messages.create', $item) }}" class="btn-contact">
                                        <i class="fas fa-envelope"></i>
                                        Contact
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($items->count() === 0)
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>No items found</h3>
                    <p>Try adjusting your filters or check back later</p>
                </div>
            @endif
            
            <div class="pagination-wrapper">
                {{ $items->links() }}
            </div>
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
</script>

<style>
/* Modern Dashboard Styles */
.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #ffeef5 0%, #fff5f8 100%);
    padding: 0;
}

.dashboard-header {
    background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
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
    text-align: center;
    position: relative;
    z-index: 2;
}

.dashboard-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    animation: slideInDown 0.8s ease-out;
}

.dashboard-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    animation: slideInUp 0.8s ease-out;
}

.header-actions {
    text-align: center;
    position: relative;
    z-index: 2;
}

.btn-primary-custom {
    display: inline-block;
    background: linear-gradient(45deg, #ff4081, #e91e63);
    color: white;
    padding: 1rem 2rem;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 8px 25px rgba(255, 64, 129, 0.3);
    transition: all 0.3s ease;
    animation: pulse 2s infinite;
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(255, 64, 129, 0.4);
    color: white;
}

@keyframes pulse {
    0% { box-shadow: 0 8px 25px rgba(255, 64, 129, 0.3); }
    50% { box-shadow: 0 8px 25px rgba(255, 64, 129, 0.5); }
    100% { box-shadow: 0 8px 25px rgba(255, 64, 129, 0.3); }
}

.dashboard-content {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    padding: 0 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.filters-section {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.filters-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(255, 105, 157, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    animation: slideInLeft 0.8s ease-out;
}

.filters-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(255, 105, 157, 0.15);
}

.filters-header {
    background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
    color: white;
    padding: 1.5rem;
    text-align: center;
}

.filters-header h3 {
    margin: 0;
    font-weight: 600;
}

.filters-body {
    padding: 2rem;
}

.filters-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-select,
.filter-input {
    padding: 0.75rem;
    border: 2px solid #ffc0cb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.filter-select:focus,
.filter-input:focus {
    outline: none;
    border-color: #ff6b9d;
    box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
}

.filter-btn {
    background: linear-gradient(45deg, #ff4081, #e91e63);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 64, 129, 0.3);
}

.items-section {
    animation: slideInRight 0.8s ease-out;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.section-header h2 {
    color: #333;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.items-count {
    background: linear-gradient(45deg, #ff6b9d, #ff8fab);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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

/* Image Carousel Styles */
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

.item-type-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
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

.item-content {
    padding: 1.5rem;
}

.item-title {
    font-size: 1.2rem;
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
    margin-bottom: 1.5rem;
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

.item-actions {
    display: flex;
    gap: 1rem;
}

.btn-view,
.btn-contact {
    flex: 1;
    text-align: center;
    padding: 0.75rem;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-view {
    background: linear-gradient(45deg, #ff6b9d, #ff8fab);
    color: white;
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 107, 157, 0.3);
    color: white;
}

.btn-contact {
    background: linear-gradient(45deg, #e91e63, #ff4081);
    color: white;
}

.btn-contact:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(233, 30, 99, 0.3);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #666;
}

.empty-state i {
    font-size: 4rem;
    color: #ff6b9d;
    margin-bottom: 1rem;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Animations */
@keyframes slideInDown {
    from { transform: translateY(-100px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideInUp {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

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

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
    
    .items-grid {
        grid-template-columns: 1fr;
    }
    
    .item-actions {
        flex-direction: column;
    }
    
    .carousel-controls {
        opacity: 1; /* Always show controls on mobile */
    }
}
</style>
@endsection