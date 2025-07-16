@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>My Messages</h4>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>From</th>
                                        <th>Item</th>
                                        <th>Message Preview</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr class="{{ !$message->read ? 'table-warning' : '' }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-2">
                                                        {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $message->sender->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $message->sender->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $message->item->title }}</strong>
                                                <br>
                                                <span class="badge bg-{{ $message->item->type === 'lost' ? 'danger' : 'success' }}">
                                                    {{ ucfirst($message->item->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="message-preview">
                                                    {{ Str::limit($message->message, 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                <small>{{ $message->created_at->diffForHumans() }}</small>
                                                <br>
                                                <small class="text-muted">{{ $message->created_at->format('M d, Y H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($message->read)
                                                    <span class="badge bg-secondary">Read</span>
                                                @else
                                                    <span class="badge bg-primary">Unread</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('messages.show', $message) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-inbox fa-3x text-muted"></i>
                            </div>
                            <h5>No messages yet</h5>
                            <p class="text-muted">You haven't received any messages about your items.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Post an Item
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
}

.message-preview {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1);
}

.table-responsive {
    border-radius: 0.375rem;
}
</style>
@endsection