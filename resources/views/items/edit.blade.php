@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Item</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Item Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $item->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4" required>{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                        id="type" name="type" required>
                                    <option value="lost" {{ old('type', $item->type) == 'lost' ? 'selected' : '' }}>Lost</option>
                                    <option value="found" {{ old('type', $item->type) == 'found' ? 'selected' : '' }}>Found</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status', $item->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="claimed" {{ old('status', $item->status) == 'claimed' ? 'selected' : '' }}>Claimed</option>
                                    <option value="closed" {{ old('status', $item->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                               id="location" name="location" value="{{ old('location', $item->location) }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Item Image <small class="text-muted">(Optional - leave empty to keep current image)</small></label>
                        @if($item->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="img-thumbnail" style="max-width: 200px;">
                                <p class="text-muted small">Current image (will be replaced only if you upload a new one)</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Success Story Fields -->
                    <div id="successStoryFields" class="{{ old('status', $item->status) == 'claimed' ? '' : 'd-none' }}">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Success Story Details</h5>
                                <small class="text-muted">Fill this section when marking as claimed</small>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="finder_name" class="form-label">Finder's Name</label>
                                    <input type="text" class="form-control @error('finder_name') is-invalid @enderror"
                                           id="finder_name" name="finder_name" value="{{ old('finder_name') }}">
                                    @error('finder_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="finder_email" class="form-label">Finder's Email</label>
                                    <input type="email" class="form-control @error('finder_email') is-invalid @enderror"
                                           id="finder_email" name="finder_email" value="{{ old('finder_email') }}">
                                    @error('finder_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="success_story" class="form-label">Success Story</label>
                                    <textarea class="form-control @error('success_story') is-invalid @enderror"
                                              id="success_story" name="success_story" rows="4"
                                              placeholder="Describe how the item was found and returned...">{{ old('success_story') }}</textarea>
                                    @error('success_story')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSuccessStoryFields() {
    const statusSelect = document.getElementById('status');
    const successStoryFields = document.getElementById('successStoryFields');

    if (statusSelect.value === 'claimed') {
        successStoryFields.classList.remove('d-none');
    } else {
        successStoryFields.classList.add('d-none');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleSuccessStoryFields();
    document.getElementById('status').addEventListener('change', toggleSuccessStoryFields);
});
</script>
@endsection