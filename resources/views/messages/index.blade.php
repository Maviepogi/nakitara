@extends('layouts.app')

@section('content')
<style>
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(255, 182, 193, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(255, 182, 193, 0.25);
    }
    
    .card-header {
        background: linear-gradient(135deg, #fff0f5, #ffe4e1);
        border-bottom: 1px solid rgba(255, 182, 193, 0.2);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem 2rem;
    }
    
    .card-header h4 {
        color: #d63384;
        font-weight: 600;
        margin: 0;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(255, 182, 193, 0.1);
    }
    
    .table thead th {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(135deg, #fff8fa, #ffeef2);
        transform: scale(1.02);
    }
    
    .table tbody td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid rgba(255, 182, 193, 0.1);
        vertical-align: middle;
    }
    
    .table-warning {
        background: linear-gradient(135deg, #fff8e1, #fff3cd) !important;
        border-left: 4px solid #ff69b4;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .btn {
        border-radius: 12px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff1493, #dc143c);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #6c757d;
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.2);
    }
    
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }
    
    .alert {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }
    
    .empty-state h5 {
        color: #d63384;
        margin-bottom: 1rem;
    }
    
    .empty-state .emoji {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .container {
        padding: 2rem 1rem;
    }
    
    .fas {
        margin-right: 0.5rem;
    }
    
    .text-muted {
        color: #999 !important;
    }
    
    .pagination {
        margin-top: 2rem;
    }
    
    .page-link {
        color: #ff69b4;
        border: 1px solid rgba(255, 182, 193, 0.3);
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.3s ease;
    }
    
    .page-link:hover {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        color: white;
        transform: translateY(-2px);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        border-color: #ff69b4;
    }
    
    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>💌 My Messages</h4>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>👤 From</th>
                                        <th>📦 Item</th>
                                        <th>💬 Message</th>
                                        <th>📅 Date</th>
                                        <th>📊 Status</th>
                                        <th>⚡ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr class="{{ !$message->read ? 'table-warning' : '' }}">
                                            <td>
                                                <strong>{{ $message->sender->name }}</strong>
                                                <br>
                                                <small class="text-muted">📧 {{ $message->sender->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $message->item->title }}</strong>
                                                <br>
                                                <span class="badge bg-{{ $message->item->type === 'lost' ? 'danger' : 'success' }}">
                                                    {{ $message->item->type === 'lost' ? '🔍' : '✅' }} {{ ucfirst($message->item->type) }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($message->message, 50) }}</td>
                                            <td>{{ $message->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($message->read)
                                                    <span class="badge bg-secondary">👁️ Read</span>
                                                @else
                                                    <span class="badge bg-primary">✨ Unread</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $messages->links() }}
                    @else
                        <div class="empty-state">
                            <div class="emoji">📭</div>
                            <h5>No messages yet</h5>
                            <p class="text-muted">You haven't received any messages about your items.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Go to Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection