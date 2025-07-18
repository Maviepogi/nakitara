@extends('layouts.app')

@section('content')
<style>
    .fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        border: none;
        box-shadow: 0 8px 32px rgba(255, 182, 193, 0.15);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(255, 182, 193, 0.25);
    }
    
    .card-header {
        background: linear-gradient(135deg, #ffb6c1, #ffc0cb);
        color: #2c3e50;
        border-radius: 16px 16px 0 0 !important;
        border: none;
        padding: 1.5rem;
        font-weight: 600;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .item-info-card {
        background: linear-gradient(135deg, #fff0f5, #ffeef8);
        border: 1px solid rgba(255, 182, 193, 0.3);
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .item-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ff69b4, #ffc0cb, #ffb6c1);
    }
    
    .item-info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 182, 193, 0.2);
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    .bg-danger {
        background: linear-gradient(135deg, #ff6b9d, #ff8fab) !important;
    }
    
    .bg-success {
        background: linear-gradient(135deg, #ff69b4, #ffa0d6) !important;
    }
    
    .form-control {
        border: 2px solid rgba(255, 182, 193, 0.3);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }
    
    .form-control:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
        background: rgba(255, 255, 255, 1);
        transform: translateY(-1px);
    }
    
    .btn {
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }
    
    .btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #ff69b4, #ffa0d6);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff1493, #ff69b4);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #6c757d;
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    
    .alert-info {
        background: linear-gradient(135deg, #e7f3ff, #f0f8ff);
        border: 1px solid rgba(255, 182, 193, 0.3);
        border-radius: 12px;
        border-left: 4px solid #ff69b4;
        animation: slideIn 0.5s ease-out;
    }
    
    @keyframes slideIn {
        from { 
            opacity: 0; 
            transform: translateX(-20px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }
    
    .img-thumbnail {
        border: 3px solid rgba(255, 182, 193, 0.3);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .img-thumbnail:hover {
        transform: scale(1.05);
        border-color: #ff69b4;
        box-shadow: 0 8px 25px rgba(255, 105, 180, 0.3);
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
    }
    
    .form-text {
        color: #6c757d;
        font-style: italic;
    }
    
    .text-danger {
        color: #ff1493 !important;
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .container {
        animation: fadeIn 0.8s ease-in-out;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card fade-in">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>
                        Send Message
                    </h4>
                    <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Item
                    </a>
                </div>

                <div class="card-body">
                    <div class="card item-info-card mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                About This Item
                            </h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="mb-2">{{ $item->title }}</h5>
                                    <span class="badge bg-{{ $item->type === 'lost' ? 'danger' : 'success' }} mb-2">
                                        {{ ucfirst($item->type) }}
                                    </span><br>
                                    <div class="mb-2">
                                        <i class="fas fa-tag me-1"></i>
                                        <span class="text-muted">{{ $item->category }}</span>
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <span class="text-muted">{{ $item->location }}</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        Posted by <strong>{{ $item->user->name }}</strong> on {{ $item->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                                @if($item->image)
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $item->image) }}" 
                                             alt="{{ $item->title }}" 
                                             class="img-thumbnail pulse" 
                                             style="max-width: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                        <div class="mb-4">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment me-2"></i>
                                Your Message <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="6" 
                                      placeholder="Write your message here..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text mt-2">
                                @if($item->type === 'lost')
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Let the owner know if you've found their item or have any information about it.
                                @else
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Contact the finder if this is your lost item.
                                @endif
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> Your message will be sent to <strong>{{ $item->user->name }}</strong>.
                            Make sure to include your contact information if you want them to reach you directly.
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Send Message
                            </button>
                            <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection