@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
            @endif
            <div class="card-body">
                <h1 class="card-title">{{ $item->title }}</h1>
                <p class="card-text">{{ $item->description }}</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <strong>Type:</strong> 
                        <span class="badge {{ $item->type === 'found' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($item->type) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong> 
                        <span class="badge {{ $item->status === 'active' ? 'bg-primary' : ($item->status === 'claimed' ? 'bg-success' : 'bg-secondary') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Location:</strong> {{ $item->location }}
                    </div>
                    <div class="col-md-6">
                        <strong>Category:</strong> {{ $item->category->name ?? 'N/A' }}
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Date Posted:</strong> {{ $item->created_at->format('M d, Y') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Last Updated:</strong> {{ $item->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Contact Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Posted by:</strong> {{ $item->user->name }}</p>
                
                @if(auth()->check() && auth()->id() !== $item->user_id)
                    <a href="{{ route('messages.create', ['item' => $item->id]) }}" class="btn btn-primary w-100">
                        Contact Owner
                    </a>
                @endif
                
                @if(auth()->check() && auth()->id() === $item->user_id)
                    <div class="d-grid gap-2">
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">Edit Item</a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this item?')">Delete Item</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back to My Items</a>
</div>
@endsection