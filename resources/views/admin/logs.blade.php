@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-black: #0a0a0a;
        --primary-blue: #1e40af;
        --primary-purple: #7c3aed;
        --accent-pink: #ec4899;
        --pure-white: #ffffff;
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
        --success-green: #10b981;
        --warning-orange: #f59e0b;
        --danger-red: #ef4444;
    }

    body {
        background: linear-gradient(135deg, var(--primary-black) 0%, var(--primary-blue) 50%, var(--primary-purple) 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--pure-white);
    }

    .logs-container {
        padding: 2rem;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        animation: slideInLeft 0.6s ease-out;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(45deg, var(--pure-white), var(--accent-pink), var(--primary-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        animation: titleGlow 2s ease-in-out infinite alternate;
    }

    @keyframes titleGlow {
        from {
            filter: drop-shadow(0 0 10px rgba(236, 72, 153, 0.3));
        }
        to {
            filter: drop-shadow(0 0 20px rgba(236, 72, 153, 0.6));
        }
    }

    .back-btn {
        background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink));
        color: var(--pure-white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .back-btn:hover::before {
        width: 200px;
        height: 200px;
    }

    .back-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        color: var(--pure-white);
        text-decoration: none;
    }

    .filter-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        margin-bottom: 2rem;
        overflow: hidden;
        animation: slideInRight 0.6s ease-out;
    }

    .filter-header {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        padding: 1.5rem;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--pure-white);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-body {
        padding: 2rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        color: var(--pure-white);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .custom-select, .custom-input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--glass-border);
        border-radius: 15px;
        padding: 0.75rem 1rem;
        color: var(--pure-white);
        font-size: 1rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .custom-select:focus, .custom-input:focus {
        outline: none;
        border-color: var(--accent-pink);
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        background: rgba(255, 255, 255, 0.15);
    }

    .custom-select option {
        background: var(--primary-black);
        color: var(--pure-white);
    }

    .filter-btn {
        background: linear-gradient(45deg, var(--accent-pink), var(--primary-purple));
        color: var(--pure-white);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: fit-content;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .filter-btn:hover::before {
        width: 200px;
        height: 200px;
    }

    .filter-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 20px rgba(236, 72, 153, 0.4);
    }

    .logs-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        overflow: hidden;
        animation: slideInUp 0.8s ease-out;
    }

    .logs-header {
        background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink));
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logs-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--pure-white);
        margin: 0;
    }

    .logs-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .logs-body {
        padding: 0;
        overflow: hidden;
    }

    .table-container {
        overflow-x: auto;
        max-height: 600px;
    }

    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .table-container::-webkit-scrollbar-thumb {
        background: var(--accent-pink);
        border-radius: 10px;
    }

    .logs-table {
        width: 100%;
        border-collapse: collapse;
        color: var(--pure-white);
    }

    .logs-table th {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        padding: 1rem;
        font-weight: 600;
        text-align: left;
        border-bottom: 2px solid var(--glass-border);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .logs-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--glass-border);
        transition: all 0.3s ease;
    }

    .logs-table tr:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: scale(1.01);
    }

    .logs-table tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.02);
    }

    .action-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(236, 72, 153, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(236, 72, 153, 0);
        }
    }

    .badge-success {
        background: linear-gradient(45deg, var(--success-green), #059669);
        color: var(--pure-white);
    }

    .badge-danger {
        background: linear-gradient(45deg, var(--danger-red), #dc2626);
        color: var(--pure-white);
    }

    .badge-info {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        color: var(--pure-white);
    }

    .badge-warning {
        background: linear-gradient(45deg, var(--warning-orange), #d97706);
        color: var(--pure-white);
    }

    .details-btn {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        color: var(--pure-white);
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .details-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .details-btn:hover::before {
        width: 100px;
        height: 100px;
    }

    .details-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(30, 64, 175, 0.4);
    }

    .pagination-container {
        padding: 1.5rem;
        display: flex;
        justify-content: center;
        background: rgba(255, 255, 255, 0.02);
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        color: var(--pure-white);
        padding: 0.75rem 1rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        min-width: 45px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination .page-link::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: linear-gradient(45deg, var(--accent-pink), var(--primary-purple));
        border-radius: 50%;
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
        z-index: -1;
    }

    .pagination .page-link:hover::before {
        width: 100%;
        height: 100%;
        border-radius: 15px;
    }

    .pagination .page-link:hover {
        color: var(--pure-white);
        text-decoration: none;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);
        border-color: var(--accent-pink);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(45deg, var(--accent-pink), var(--primary-purple));
        border-color: var(--accent-pink);
        color: var(--pure-white);
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
        animation: activePagePulse 2s infinite;
    }

    @keyframes activePagePulse {
        0%, 100% {
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
        }
        50% {
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.6);
        }
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .pagination .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: none;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .pagination .page-item.disabled .page-link::before {
        display: none;
    }

    .pagination .page-link[aria-label*="Previous"] {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
    }

    .pagination .page-link[aria-label*="Next"] {
        background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink));
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
    }

    .pagination .page-link[aria-label*="Previous"]:hover,
    .pagination .page-link[aria-label*="Next"]:hover {
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .pagination-stats {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: var(--pure-white);
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-jump {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 25px;
        padding: 0.5rem 1rem;
    }

    .pagination-jump label {
        color: var(--pure-white);
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
    }

    .pagination-jump input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        color: var(--pure-white);
        padding: 0.4rem 0.8rem;
        width: 60px;
        text-align: center;
        font-size: 0.9rem;
    }

    .pagination-jump input:focus {
        outline: none;
        border-color: var(--accent-pink);
        box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.2);
    }

    .pagination-jump button {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        border: none;
        color: var(--pure-white);
        border-radius: 10px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination-jump button:hover {
        transform: scale(1.05);
        box-shadow: 0 3px 10px rgba(30, 64, 175, 0.4);
    }

    .custom-modal {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(10px);
    }

    .modal-content {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        color: var(--pure-white);
    }

    .modal-header {
        background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink));
        border-bottom: 1px solid var(--glass-border);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 700;
        color: var(--pure-white);
        margin: 0;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-body pre {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        padding: 1rem;
        color: var(--pure-white);
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.9rem;
        line-height: 1.4;
        overflow-x: auto;
    }

    .close-btn {
        background: transparent;
        border: none;
        color: var(--pure-white);
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        color: var(--accent-pink);
        transform: scale(1.2);
    }

    .floating-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: var(--accent-pink);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
            opacity: 0.7;
        }
        50% {
            transform: translateY(-30px) rotate(180deg);
            opacity: 0.3;
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .filter-row {
            grid-template-columns: 1fr;
        }

        .logs-table {
            font-size: 0.85rem;
        }

        .logs-table th,
        .logs-table td {
            padding: 0.7rem;
        }
    }
</style>

<div class="floating-particles" id="particles"></div>

<div class="logs-container">
    <div class="header-section">
        <h1 class="page-title">User Activity Logs</h1>
        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            <span>🏠</span>
            Back to Dashboard
        </a>
    </div>

    <div class="filter-card">
        <div class="filter-header">
            <span>🔍</span>
            Filter Logs
        </div>
        <div class="filter-body">
            <form method="GET" action="{{ route('admin.logs') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">👤 User</label>
                        <select name="user_id" class="custom-select">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">⚡ Action</label>
                        <select name="action" class="custom-select">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $action)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">📅 From Date</label>
                        <input type="date" name="date_from" class="custom-input" value="{{ request('date_from') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">📅 To Date</label>
                        <input type="date" name="date_to" class="custom-input" value="{{ request('date_to') }}">
                    </div>
                    <div class="filter-group">
                        <button type="submit" class="filter-btn">
                            <span>🔍</span>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="logs-card">
        <div class="logs-header">
            <div class="logs-title">
                <span>📊</span>
                Activity Logs ({{ $logs->total() }} total)
            </div>
            <div class="logs-subtitle">
                <span>🔒</span>
                Secure & tamper-proof logging
            </div>
        </div>
        <div class="logs-body">
            <div class="table-container">
                <table class="logs-table">
                    <thead>
                        <tr>
                            <th>🕒 Date/Time</th>
                            <th>👤 User</th>
                            <th>⚡ Action</th>
                            <th>📝 Description</th>
                            <th>🌐 IP Address</th>
                            <th>🔍 Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $log->user ? $log->user->name : 'System' }}</td>
                                <td>
                                    <span class="action-badge badge-{{ $log->action == 'login_failed' ? 'danger' : ($log->action == 'login_success' ? 'success' : 'info') }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>
                                    @if($log->data)
                                        <button class="details-btn" data-log='@json($log->data)' onclick="showDetails(this)">
                                            View
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-container">
                <div class="pagination-info">
                    <div class="pagination-stats">
                        <span>📊</span>
                        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} results
                    </div>
                    @if($logs->hasPages())
                        <div class="pagination-jump">
                            <label for="pageJump">🔍 Jump to page:</label>
                            <input type="number" id="pageJump" min="1" max="{{ $logs->lastPage() }}" value="{{ $logs->currentPage() }}">
                            <button onclick="jumpToPage()">Go</button>
                        </div>
                    @endif
                </div>
                
                @if($logs->hasPages())
                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($logs->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">« Previous</span>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $logs->previousPageUrl() }}" rel="prev" aria-label="Previous">
                                        <span aria-hidden="true">« Previous</span>
                                    </a>
                                </li>
                            @endif

                            {{-- First Page --}}
                            @if($logs->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $logs->url(1) }}">1</a>
                                </li>
                                @if($logs->currentPage() > 4)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Page Numbers --}}
                            @foreach(range(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page)
                                @if ($page == $logs->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $logs->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Last Page --}}
                            @if($logs->currentPage() < $logs->lastPage() - 2)
                                @if($logs->currentPage() < $logs->lastPage() - 3)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $logs->url($logs->lastPage()) }}">{{ $logs->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($logs->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $logs->nextPageUrl() }}" rel="next" aria-label="Next">
                                        <span aria-hidden="true">Next »</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Next">
                                        <span aria-hidden="true">Next »</span>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Modal for log details -->
<div class="modal fade custom-modal" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span>🔍</span>
                    Log Details
                </h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <pre id="logDetailsContent"></pre>
            </div>
        </div>
    </div>
</div>

<script>
    // Create floating particles
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 8 + 's';
            particle.style.animationDuration = (Math.random() * 4 + 4) + 's';
            particlesContainer.appendChild(particle);
        }
    }

    // Show log details function
    function showDetails(button) {
        const data = JSON.parse(button.getAttribute('data-log'));
        document.getElementById('logDetailsContent').textContent = JSON.stringify(data, null, 2);
        
        // Create modal instance
        const modal = new bootstrap.Modal(document.getElementById('logDetailsModal'));
        modal.show();
    }

    // Add ripple effect to buttons
    document.querySelectorAll('.filter-btn, .details-btn, .back-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Initialize particles when page loads
    document.addEventListener('DOMContentLoaded', function() {
        createParticles();
        
        // Add stagger animation to table rows
        const tableRows = document.querySelectorAll('.logs-table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.1}s`;
            row.style.animation = 'fadeInUp 0.5s ease-out forwards';
        });
    });

    // Add smooth hover effects to form elements
    document.querySelectorAll('.custom-select, .custom-input').forEach(element => {
        element.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        element.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });
</script>
@endsection