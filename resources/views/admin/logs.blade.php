@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>User Activity Logs</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>

<div class="card mb-4">
    <div class="card-header">Filter Logs</div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.logs') }}">
            <div class="row">
                <div class="col-md-3">
                    <label>User</label>
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Action</label>
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>From Date</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label>To Date</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <span>Activity Logs ({{ $logs->total() }} total)</span>
            <small class="text-muted">Secure & tamper-proof logging</small>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $log->user ? $log->user->name : 'System' }}</td>
                            <td>
                                <span class="badge bg-{{ $log->action == 'login_failed' ? 'danger' : ($log->action == 'login_success' ? 'success' : 'info') }}">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>
                                @if($log->data)
                                    <button class="btn btn-sm btn-outline-info" data-log='@json($log->data)' onclick="showDetails(this)">
                                        View
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    </div>
</div>

<!-- Modal for log details -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="logDetailsContent"></pre>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(button) {
    const data = JSON.parse(button.getAttribute('data-log'));
    document.getElementById('logDetailsContent').textContent = JSON.stringify(data, null, 2);
    new bootstrap.Modal(document.getElementById('logDetailsModal')).show();
}
</script>
@endsection
