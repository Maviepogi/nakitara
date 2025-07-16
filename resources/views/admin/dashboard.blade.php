@extends('layouts.app')

@section('content')
<h2>Admin Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Users</h5>
                <h3>{{ $stats['total_users'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Items</h5>
                <h3>{{ $stats['total_items'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Active Items</h5>
                <h3>{{ $stats['active_items'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5>Success Stories</h5>
                <h3>{{ $stats['success_stories'] }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>Recent Items</span>
                    <a href="{{ route('admin.items') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body">
                @foreach($recentItems as $item)
                    <div class="mb-2">
                        <strong>{{ $item->title }}</strong> - {{ ucfirst($item->type) }}
                        <small class="text-muted">by {{ $item->user->name }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>Recent Users</span>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body">
                @foreach($recentUsers as $user)
                    <div class="mb-2">
                        <strong>{{ $user->name }}</strong> - {{ $user->email }}
                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">Manage Users</a>
                <a href="{{ route('admin.items') }}" class="btn btn-success me-2">Manage Items</a>
                <a href="{{ route('admin.logs') }}" class="btn btn-info me-2">View Logs</a>
                <a href="{{ route('admin.success-stories') }}" class="btn btn-warning me-2">Success Stories</a>
                <a href="{{ route('admin.download-success-stories') }}" class="btn btn-danger">Download PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection