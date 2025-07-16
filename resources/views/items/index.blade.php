@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>My Items</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary">Add New Item</a>
</div>

@if($items->count() > 0)
    <div class="row">
        @foreach($items as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                        <p class="card-text">
                            <small class="text-muted">
                                Type: 
                                <span class="badge {{ $item->type === 'found' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </small>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                Status: 
                                <span class="badge {{ $item->status === 'active' ? 'bg-primary' : ($item->status === 'claimed' ? 'bg-success' : 'bg-secondary') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </small>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                Location: {{ $item->location }}
                            </small>
                        </p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{ $items->links() }}
@else
    <div class="text-center">
        <h3>No items found</h3>
        <p>You haven't posted any items yet.</p>
        <a href="{{ route('items.create') }}" class="btn btn-primary">Post Your First Item</a>
    </div>
@endif
@endsection