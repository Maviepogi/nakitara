@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Filter Items</div>
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard.filter') }}">
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-select">
                            <option value="">All</option>
                            <option value="lost" {{ request('type') == 'lost' ? 'selected' : '' }}>Lost</option>
                            <option value="found" {{ request('type') == 'found' ? 'selected' : '' }}>Found</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="d-flex justify-content-between mb-3">
            <h2>Recent Items</h2>
            <a href="{{ route('items.create') }}" class="btn btn-success">Post New Item</a>
        </div>
        
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    {{ ucfirst($item->type) }} • {{ $item->category->name }} • {{ $item->location }}
                                </small>
                            </p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('items.show', $item) }}" class="btn btn-primary btn-sm">View</a>
                                @if($item->user_id != auth()->id())
                                    <a href="{{ route('messages.create', $item) }}" class="btn btn-outline-primary btn-sm">Contact</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{ $items->links() }}
    </div>
</div>
@endsection