@extends('layouts.app')

@section('content')
<style>
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(255, 182, 193, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(255, 182, 193, 0.25);
    }
    
    .carousel-item img {
        border-radius: 0;
        filter: brightness(0.9);
        transition: filter 0.3s ease;
    }
    
    .carousel-item img:hover {
        filter: brightness(1);
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        background: linear-gradient(135deg, rgba(255, 105, 180, 0.8), rgba(255, 20, 147, 0.8));
        border-radius: 50%;
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .carousel-control-prev {
        left: 20px;
    }
    
    .carousel-control-next {
        right: 20px;
    }
    
    .carousel-indicators {
        bottom: 20px;
    }
    
    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.7);
        border: 2px solid rgba(255, 105, 180, 0.8);
        transition: all 0.3s ease;
    }
    
    .carousel-indicators button.active {
        background: #ff69b4;
        transform: scale(1.2);
    }
    
    .card-body {
        padding: 2rem;
        background: linear-gradient(135deg, #fff8fa, #ffeef2);
    }
    
    .card-title {
        color: #d63384;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 2rem;
    }
    
    .card-text {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.6rem 1rem;
        border-radius: 15px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-section {
        background: linear-gradient(135deg, #fff0f5, #ffe4e1);
        border: 1px solid rgba(255, 182, 193, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    
    .info-section strong {
        color: #d63384;
        font-weight: 600;
    }
    
    .message-section {
        background: linear-gradient(135deg, #e7f3ff, #cce7ff);
        border: 1px solid rgba(13, 110, 253, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    
    .message-section h5 {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .message-section p {
        color: #495057;
        line-height: 1.6;
        margin: 0;
        font-style: italic;
    }
    
    .btn {
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff1493, #dc143c);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
        color: white;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #6c757d;
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.2);
        color: #6c757d;
    }
    
    .row {
        margin: 0;
    }
    
    .col-md-6 {
        padding: 0.5rem 0;
    }
    
    hr {
        border: none;
        height: 2px;
        background: linear-gradient(135deg, rgba(255, 182, 193, 0.3), rgba(255, 105, 180, 0.3));
        border-radius: 1px;
        margin: 2rem 0;
    }
    
    .fas {
        font-size: 1rem;
    }
    
    .container {
        padding: 2rem 1rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: flex-start;
        margin-top: 2rem;
    }
    
    @media (max-width: 576px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($message->item->images && count($message->item->images) > 0)
                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($message->item->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="{{ $message->item->title }}" style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        
                        @if(count($message->item->images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            
                            <div class="carousel-indicators">
                                @foreach($message->item->images as $index => $image)
                                    <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="{{ $index }}" {{ $index === 0 ? 'class="active"' : '' }} aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
                
                <div class="card-body">
                    <h1 class="card-title">✨ {{ $message->item->title }}</h1>
                    <p class="card-text">{{ $message->item->description }}</p>

                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>🏷️ Type:</strong> 
                                <span class="badge {{ $message->item->type === 'found' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $message->item->type === 'found' ? '✅' : '🔍' }} {{ ucfirst($message->item->type) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>📍 Location:</strong> {{ $message->item->location }}
                            </div>
                        </div>

                        <div class="mt-3">
                            <strong>📂 Category:</strong> {{ $message->item->category->name ?? $message->item->category }}
                        </div>
                    </div>

                    <hr>

                    <div class="message-section">
                        <h5>💌 Message:</h5>
                        <p>"{{ $message->message }}"</p>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Messages
                        </a>
                        <a href="{{ route('items.show', $message->item) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> View Item
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection