@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>User Details</h2>
    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back to Users</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">User Information</div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> 
                    <span class="badge bg-{{ $user->is_admin ? 'danger' : 'primary' }}">
                        {{ $user->is_admin ? 'Admin' : 'User' }}
                    </span>
                </p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Items Count:</strong> {{ $user->items->count() }}</p>
                <p><strong>Logs Count:</strong> {{ $user->logs->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Recent Items</div>
            <div class="card-body">
                @if($user->items->count() > 0)
                    <ul class="list-group">
                        @foreach($user->items->take(5) as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->title }}</span>
                                <span class="badge bg-{{ $item->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ $item->status }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No items found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Recent Activity Logs</div>
            <div class="card-body">
                @if($user->logs->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->logs->take(10) as $log)
                                <tr>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No activity logs found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection