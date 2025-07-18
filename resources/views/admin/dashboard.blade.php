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
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: var(--primary-black);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        overflow-x: hidden;
    }

    .dashboard-container {
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

    .dashboard-title {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(45deg, var(--pure-white), var(--accent-pink), var(--primary-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
        margin-bottom: 3rem;
        animation: titleGlow 2s ease-in-out infinite alternate;
    }

    @keyframes titleGlow {
        from {
            filter: drop-shadow(0 0 20px rgba(236, 72, 153, 0.3));
        }
        to {
            filter: drop-shadow(0 0 30px rgba(236, 72, 153, 0.6));
        }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        animation: slideInLeft 0.6s ease-out;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

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

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .stat-card:hover::before {
        left: 100%;
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .stat-card.users {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-purple));
    }

    .stat-card.items {
        background: linear-gradient(135deg, var(--primary-purple), var(--accent-pink));
    }

    .stat-card.active {
        background: linear-gradient(135deg, var(--accent-pink), var(--primary-blue));
    }

    .stat-card.stories {
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-pink));
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    .stat-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--pure-white);
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--pure-white);
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .content-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        overflow: hidden;
        animation: slideInRight 0.6s ease-out;
        transition: all 0.3s ease;
    }

    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
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

    .card-header {
        background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink));
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--glass-border);
    }

    .card-header h3 {
        color: var(--pure-white);
        margin: 0;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .card-body {
        padding: 1.5rem;
        max-height: 300px;
        overflow-y: auto;
    }

    .card-body::-webkit-scrollbar {
        width: 8px;
    }

    .card-body::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .card-body::-webkit-scrollbar-thumb {
        background: var(--accent-pink);
        border-radius: 10px;
    }

    .item-row {
        padding: 1rem;
        margin-bottom: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border-left: 4px solid var(--accent-pink);
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-out;
    }

    .item-row:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(10px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .item-title {
        color: var(--pure-white);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }

    .item-meta {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
    }

    .action-section {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2rem;
        animation: slideInUp 0.8s ease-out;
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

    .action-title {
        color: var(--pure-white);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }

    .action-btn {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
        color: var(--pure-white);
        border: none;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .action-btn::before {
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

    .action-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .action-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .action-btn.users-btn {
        background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
    }

    .action-btn.items-btn {
        background: linear-gradient(45deg, var(--primary-purple), var(--accent-pink));
    }

    .action-btn.logs-btn {
        background: linear-gradient(45deg, var(--accent-pink), var(--primary-blue));
    }

    .action-btn.stories-btn {
        background: linear-gradient(45deg, var(--primary-blue), var(--accent-pink));
    }

    .action-btn.download-btn {
        background: linear-gradient(45deg, var(--accent-pink), var(--primary-purple));
    }

    .view-all-btn {
        background: linear-gradient(45deg, var(--accent-pink), var(--primary-purple));
        color: var(--pure-white);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .view-all-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(236, 72, 153, 0.4);
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
        width: 4px;
        height: 4px;
        background: var(--accent-pink);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 0.5;
        }
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .dashboard-title {
            font-size: 2rem;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .action-btn {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }
    }
</style>

<div class="floating-particles" id="particles"></div>

<div class="dashboard-container">
    <h1 class="dashboard-title">Admin Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card users">
            <div class="stat-icon">👥</div>
            <div class="stat-title">Total Users</div>
            <div class="stat-number">{{ $stats['total_users'] }}</div>
        </div>
        <div class="stat-card items">
            <div class="stat-icon">📦</div>
            <div class="stat-title">Total Items</div>
            <div class="stat-number">{{ $stats['total_items'] }}</div>
        </div>
        <div class="stat-card active">
            <div class="stat-icon">⚡</div>
            <div class="stat-title">Active Items</div>
            <div class="stat-number">{{ $stats['active_items'] }}</div>
        </div>
        <div class="stat-card stories">
            <div class="stat-icon">🌟</div>
            <div class="stat-title">Success Stories</div>
            <div class="stat-number">{{ $stats['success_stories'] }}</div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3>Recent Items</h3>
                <a href="{{ route('admin.items') }}" class="view-all-btn">View All</a>
            </div>
            <div class="card-body">
                @foreach($recentItems as $item)
                    <div class="item-row">
                        <div class="item-title">{{ $item->title }}</div>
                        <div class="item-meta">{{ ucfirst($item->type) }} • by {{ $item->user->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3>Recent Users</h3>
                <a href="{{ route('admin.users') }}" class="view-all-btn">View All</a>
            </div>
            <div class="card-body">
                @foreach($recentUsers as $user)
                    <div class="item-row">
                        <div class="item-title">{{ $user->name }}</div>
                        <div class="item-meta">{{ $user->email }} • {{ $user->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="action-section">
        <h2 class="action-title">Quick Actions</h2>
        <div class="action-buttons">
            <a href="{{ route('admin.users') }}" class="action-btn users-btn">
                <span>👥</span>
                Manage Users
            </a>
            <a href="{{ route('admin.items') }}" class="action-btn items-btn">
                <span>📦</span>
                Manage Items
            </a>
            <a href="{{ route('admin.logs') }}" class="action-btn logs-btn">
                <span>📊</span>
                View Logs
            </a>
            <a href="{{ route('admin.success-stories') }}" class="action-btn stories-btn">
                <span>🌟</span>
                Success Stories
            </a>
            <a href="{{ route('admin.download-success-stories') }}" class="action-btn download-btn">
                <span>📥</span>
                Download PDF
            </a>
        </div>
    </div>
</div>

<script>
    // Create floating particles
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 6 + 's';
            particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
            particlesContainer.appendChild(particle);
        }
    }

    // Add click effects to stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.action-btn').forEach(btn => {
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
    document.addEventListener('DOMContentLoaded', createParticles);

    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection