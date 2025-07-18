<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nakitara - Lost and Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Nakitara</a>

        <div class="navbar-nav ms-auto">
            @auth
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('items.index') }}">My Items</a>
                <a class="nav-link position-relative" href="{{ route('messages.index') }}">
                    Messages
                    <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                        <span id="unread-count">0</span>
                    </span>
                </a>
                @if(auth()->user()->is_admin)
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@if(auth()->check())
<script>
function checkUnreadMessages() {
    fetch('{{ route("messages.unread-count") }}')
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            const badge = document.getElementById('notification-badge');
            const count = document.getElementById('unread-count');
            if (data.count > 0) {
                count.textContent = data.count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
}
document.addEventListener('DOMContentLoaded', checkUnreadMessages);
setInterval(checkUnreadMessages, 30000);
</script>
@endif

{{-- The Google Maps API script now uses the variable from your .env file --}}
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('Maps_API_KEY') }}&callback=initMap"></script>

</body>
</html>