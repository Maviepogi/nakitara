@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Send Message</h4>
                    <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Item
                    </a>
                </div>

                <div class="card-body">
                    <!-- Item Details -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="card-title">About This Item</h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <strong>{{ $item->title }}</strong>
                                    <br>
                                    <span class="badge bg-{{ $item->type === 'lost' ? 'danger' : 'success' }}">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        {{ $item->category }} • {{ $item->location }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        Posted by {{ $item->user->name }} on {{ $item->created_at->format('M d, Y') }}
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
                    </div>

                    <!-- Message Form -->
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                        <div class="mb-3">
                            <label for="message" class="form-label">
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
                            <div class="form-text">
                                @if($item->type === 'lost')
                                    Let the owner know if you've found their item or have any information about it.
                                @else
                                    Contact the finder if this is your lost item.
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

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
@endsection