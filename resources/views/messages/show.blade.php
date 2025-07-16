@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Message Details</h4>
                    <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Messages
                    </a>
                </div>

                <div class="card-body">
                    <!-- Message Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">From</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $message->sender->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $message->sender->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">About Item</h6>
                                    <strong>{{ $message->item->title }}</strong>
                                    <br>
                                    <span class="badge bg-{{ $message->item->type === 'lost' ? 'danger' : 'success' }}">
                                        {{ ucfirst($message->item->type) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">Message</h6>
                                <small class="text-muted">{{ $message->created_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $message->message }}</p>
                        </div>
                    </div>

                    <!-- Item Details -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">Item Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Title:</strong> {{ $message->item->title }}
                                    <br>
                                    <strong>Type:</strong> 
                                    <span class="badge bg-{{ $message->item->type === 'lost' ? 'danger' : 'success' }}">
                                        {{ ucfirst($message->item->type) }}
                                    </span>
                                    <br>
                                    <strong>Category:</strong> {{ $message->item->category }}
                                    <br>
                                    <strong>Location:</strong> {{ $message->item->location }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Description:</strong>
                                    <p>{{ $message->item->description }}</p>
                                </div>
                            </div>
                            
                            @if($message->item->image)
                                <div class="mt-3">
                                    <strong>Image:</strong>
                                    <br>
                                    <img src="{{ asset('storage/' . $message->item->image) }}" 
                                         alt="{{ $message->item->title }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('items.show', $message->item) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-eye"></i> View Item
                        </a>
                        
                        @if($message->item->type === 'lost')
                            <a href="{{ route('messages.create', $message->item) }}" 
                               class="btn btn-success">
                                <i class="fas fa-reply"></i> Reply
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
@endsection