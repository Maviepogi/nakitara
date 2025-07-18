@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Items</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <span>All Items ({{ $items->total() }} total)</span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <span class="badge bg-{{ $item->type == 'lost' ? 'danger' : 'success' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td>{{ $item->category->name ?? 'No Category' }}</td>
                            <td>{{ $item->user->name ?? 'Unknown' }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'active' ? 'primary' : ($item->status == 'claimed' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form method="POST" action="{{ route('items.destroy', $item) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No items found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $items->links() }}
    </div>
</div>
@endsection