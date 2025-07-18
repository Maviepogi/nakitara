@extends('layouts.app')

@section('content')
<style>
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(255, 182, 193, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(255, 182, 193, 0.25);
    }
    
    .card-header {
        background: linear-gradient(135deg, #fff0f5, #ffe4e1);
        border-bottom: 1px solid rgba(255, 182, 193, 0.2);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem 2rem;
    }
    
    .card-header h4 {
        color: #d63384;
        font-weight: 600;
        margin: 0;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .item-preview {
        background: linear-gradient(135deg, #fff8fa, #ffeef2);
        border: 1px solid rgba(255, 182, 193, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        transition: background 0.3s ease;
    }
    
    .item-preview:hover {
        background: linear-gradient(135deg, #fff5f8, #ffebf0);
    }
    
    .item-preview h6 {
        color: #d63384;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .form-control {
        border: 2px solid rgba(255, 182, 193, 0.2);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.15);
    }
    
    .form-label {
        color: #d63384;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .btn {
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff1493, #dc143c);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #6c757d;
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.2);
    }
    
    .alert-info {
        background: linear-gradient(135deg, #e7f3ff, #cce7ff);
        border: 1px solid rgba(13, 110, 253, 0.2);
        border-radius: 12px;
        color: #0d6efd;
    }
    
    .img-thumbnail {
        border: 3px solid rgba(255, 182, 193, 0.3);
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
    
    .form-text {
        color: #ff69b4;
        font-style: italic;
        margin-top: 0.5rem;
    }
    
    .container {
        padding: 2rem 1rem;
    }
    
    .fas {
        margin-right: 0.5rem;
    }
    
    .text-danger {
        color: #ff1493 !important;
    }
    
    .text-muted {
        color: #999 !important;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>✉️ Send Message</h4>
                    <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Item
                    </a>
                </div>

                <div class="card-body">
                    <div class="item-preview">
                        <h6>💝 About This Item</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <strong>{{ $item->title }}</strong><br>
                                <span class="badge bg-{{ $item->type === 'lost' ? 'danger' : 'success' }}">
                                    {{ ucfirst($item->type) }}
                                </span><br>
                                <small class="text-muted">
                                    📂 {{ $item->category }} • 📍 {{ $item->location }}
                                </small><br>
                                <small class="text-muted">
                                    👤 Posted by {{ $item->user->name }} on {{ $item->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            @if($item->image)
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="{{ $item->title }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                        <div class="mb-3">
                            <label for="message" class="form-label">
                                💬 Your Message <span class="text-danger">*</span>
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
                            <div class="form-text">
                                @if($item->type === 'lost')
                                    ✨ Let the owner know if you've found their item or have any information about it.
                                @else
                                    🔍 Contact the finder if this is your lost item.
                                @endif
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Your message will be sent to {{ $item->user->name }}.
                            Make sure to include your contact information if you want them to reach you directly.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                            <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection