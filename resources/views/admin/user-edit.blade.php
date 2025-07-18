@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit User</h2>
    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back to Users</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit User Information</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin" 
                                   value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_admin">
                                Admin User
                            </label>
                        </div>
                        <small class="form-text text-muted">Check this box to give the user admin privileges.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info">View User</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">User Statistics</div>
            <div class="card-body">
                <p><strong>User ID:</strong> {{ $user->id }}</p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
                <p><strong>Items:</strong> {{ $user->items->count() }}</p>
                <p><strong>Activity Logs:</strong> {{ $user->logs->count() }}</p>
                <p><strong>Current Role:</strong> 
                    <span class="badge bg-{{ $user->is_admin ? 'danger' : 'primary' }}">
                        {{ $user->is_admin ? 'Admin' : 'User' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection