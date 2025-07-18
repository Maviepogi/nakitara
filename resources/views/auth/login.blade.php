<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nakitara - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 25%, #ffeaa7 50%, #fd79a8 75%, #e17055 100%);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            25% { background-position: 100% 50%; }
            50% { background-position: 100% 100%; }
            75% { background-position: 0% 100%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Hearts Background */
        .hearts {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .heart {
            position: absolute;
            color: rgba(255, 192, 203, 0.6);
            font-size: 20px;
            animation: floatHeart 8s infinite linear;
        }

        @keyframes floatHeart {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Butterfly Animation */
        .butterfly {
            position: fixed;
            pointer-events: none;
            z-index: 2;
            font-size: 25px;
            color: #ff6b9d;
            animation: butterflyFly 15s infinite linear;
        }

        @keyframes butterflyFly {
            0% {
                transform: translateX(-50px) translateY(50vh) rotate(0deg);
            }
            25% {
                transform: translateX(25vw) translateY(30vh) rotate(90deg);
            }
            50% {
                transform: translateX(50vw) translateY(70vh) rotate(180deg);
            }
            75% {
                transform: translateX(75vw) translateY(20vh) rotate(270deg);
            }
            100% {
                transform: translateX(100vw) translateY(50vh) rotate(360deg);
            }
        }

        /* Sparkles */
        .sparkle {
            position: fixed;
            pointer-events: none;
            z-index: 1;
            color: #fff;
            font-size: 15px;
            animation: sparkleAnimation 3s infinite ease-in-out;
        }

        @keyframes sparkleAnimation {
            0%, 100% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            border-radius: 30px;
            padding: 45px;
            width: 100%;
            max-width: 450px;
            box-shadow: 
                0 8px 32px rgba(255, 182, 193, 0.4),
                0 0 60px rgba(255, 105, 180, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.4);
            animation: containerEntrance 1.5s ease-out, containerFloat 6s ease-in-out infinite;
            position: relative;
            z-index: 20;
        }

        @keyframes containerEntrance {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.8) rotate(-5deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0deg);
            }
        }

        @keyframes containerFloat {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(1deg);
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff9a9e, #fecfef, #ffeaa7, #fd79a8);
            border-radius: 32px;
            z-index: -1;
            animation: borderGlow 4s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% {
                opacity: 0.6;
                filter: blur(0px);
            }
            50% {
                opacity: 1;
                filter: blur(2px);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
            position: relative;
        }

        .login-header::before {
            content: '✨';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 30px;
            animation: sparkleRotate 3s ease-in-out infinite;
        }

        @keyframes sparkleRotate {
            0%, 100% {
                transform: translateX(-50%) rotate(0deg) scale(1);
            }
            50% {
                transform: translateX(-50%) rotate(180deg) scale(1.2);
            }
        }

        .login-header h1 {
            color: #2d1b3d;
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(45deg, #ff6b9d, #c44569, #fd79a8, #F5ADD8FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 3px;
            animation: titlePulse 4s ease-in-out infinite;
            text-shadow: 0 0 20px rgba(255, 107, 157, 0.3);
        }

        @keyframes titlePulse {
            0%, 100% {
                transform: scale(1);
                filter: hue-rotate(0deg);
            }
            50% {
                transform: scale(1.05);
                filter: hue-rotate(30deg);
            }
        }

        .subtitle {
            color: #2d1b3d;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 10px;
            animation: subtitleBounce 3s ease-in-out infinite;
        }

        @keyframes subtitleBounce {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-3px);
            }
        }

        .alert {
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            animation: alertSlide 0.5s ease-out;
        }

        @keyframes alertSlide {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 2px solid rgba(34, 197, 94, 0.4);
            color: #166534;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            border: 2px solid rgba(239, 68, 68, 0.4);
            color: #991b1b;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            color: #2d1b3d;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 0.95rem;
            animation: labelFloat 2s ease-in-out infinite;
        }

        @keyframes labelFloat {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-2px);
            }
        }

        .form-control {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid rgba(45, 27, 61, 0.3);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            color: #2d1b3d;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(10px);
            position: relative;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff6b9d;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.3);
            transform: translateY(-2px) scale(1.02);
        }

        .form-control:hover {
            border-color: #fd79a8;
            transform: translateY(-1px);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            animation: shakeInput 0.5s ease-in-out;
        }

        @keyframes shakeInput {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-control::placeholder {
            color: rgba(45, 27, 61, 0.6);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(220, 53, 69, 0.15);
            border-radius: 12px;
            border-left: 4px solid #dc3545;
            animation: errorBounce 0.5s ease-out;
        }

        @keyframes errorBounce {
            0% {
                transform: translateY(-10px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .btn {
            padding: 18px 30px;
            border: none;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-danger {
            background: linear-gradient(45deg, #ff6b9d, #fd79a8, #e17055);
            color: white;
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            animation: buttonPulse 3s ease-in-out infinite;
        }

        @keyframes buttonPulse {
            0%, 100% {
                box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            }
            50% {
                box-shadow: 0 8px 30px rgba(220, 53, 69, 0.6);
            }
        }

        .btn-danger:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.5);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ff6b9d, #c44569, #fd79a8);
            color: white;
            box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
            animation: buttonGlow 4s ease-in-out infinite;
        }

        @keyframes buttonGlow {
            0%, 100% {
                box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
            }
            50% {
                box-shadow: 0 8px 30px rgba(255, 107, 157, 0.6);
            }
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 30px rgba(255, 107, 157, 0.5);
            color: white;
        }

        .btn-lg {
            padding: 22px 35px;
            font-size: 1.1rem;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: rgba(45, 27, 61, 0.7);
            animation: dividerFloat 3s ease-in-out infinite;
        }

        @keyframes dividerFloat {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-2px);
            }
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 157, 0.3), transparent);
        }

        .divider span {
            background: rgba(255, 255, 255, 0.4);
            padding: 8px 20px;
            position: relative;
            z-index: 1;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-check {
            margin-bottom: 20px;
            animation: checkboxBounce 2s ease-in-out infinite;
        }

        @keyframes checkboxBounce {
            0%, 100% {
                transform: translateX(0px);
            }
            50% {
                transform: translateX(2px);
            }
        }

        .form-check-input {
            margin-right: 8px;
            accent-color: #ff6b9d;
        }

        .form-check-label {
            color: #2d1b3d;
            font-weight: 500;
        }

        .link-section {
            text-align: center;
            margin-top: 25px;
        }

        .link-section a {
            color: #2d1b3d;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 15px;
            border-radius: 15px;
            display: inline-block;
            margin: 5px;
        }

        .link-section a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(45deg, #ff6b9d, #fd79a8);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .link-section a:hover::before {
            width: 100%;
        }

        .link-section a:hover {
            color: #ff6b9d;
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .text-muted {
            color: rgba(45, 27, 61, 0.6) !important;
            font-size: 0.9rem;
            animation: textFloat 2s ease-in-out infinite;
        }

        @keyframes textFloat {
            0%, 100% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
        }

        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .login-header h1 {
                font-size: 2.2rem;
            }
            
            .btn {
                padding: 16px 25px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Hearts -->
    <div class="hearts"></div>

    <!-- Floating Butterflies -->
    <div class="butterfly" style="top: 20%; animation-delay: 0s;">🦋</div>
    <div class="butterfly" style="top: 60%; animation-delay: 3s;">🦋</div>
    <div class="butterfly" style="top: 80%; animation-delay: 6s;">🦋</div>
    <div class="butterfly" style="top: 40%; animation-delay: 9s;">🦋</div>
    <div class="butterfly" style="top: 40%; animation-delay: 9s;">🦋</div>
    <div class="butterfly" style="top: 40%; animation-delay: 9s;">🦋</div>

    <!-- Sparkles -->
    <div class="sparkle" style="top: 10%; left: 10%; animation-delay: 0s;">✨</div>
    <div class="sparkle" style="top: 80%; left: 80%; animation-delay: 1s;">✨</div>
    <div class="sparkle" style="top: 30%; left: 70%; animation-delay: 2s;">✨</div>
    <div class="sparkle" style="top: 70%; left: 20%; animation-delay: 3s;">✨</div>

    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1>NAKITARA</h1>
                <p class="subtitle">Sign in to your account</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Google OAuth Button -->
            <div class="text-center mb-4">
                <a href="{{ route('auth.google') }}" class="btn btn-danger btn-lg">
                    <i class="fab fa-google"></i> Sign in with Google
                </a>
                <p class="mt-2 text-muted">Quick and secure login</p>
            </div>

            <div class="divider">
                <span>OR</span>
            </div>

            <!-- Manual Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="Enter your email" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" 
                           placeholder="Enter your password" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    ✨ Sign In ✨
                </button>
            </form>

            <div class="link-section">
                <p>
                    <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                </p>
                <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </div>

    <script>
        // Create floating hearts
        function createHeart() {
            const heart = document.createElement('div');
            heart.className = 'heart';
            heart.innerHTML = '💖';
            heart.style.left = Math.random() * 100 + '%';
            heart.style.animationDelay = Math.random() * 2 + 's';
            heart.style.animationDuration = (Math.random() * 3 + 5) + 's';
            document.querySelector('.hearts').appendChild(heart);

            setTimeout(() => {
                heart.remove();
            }, 8000);
        }

        // Create hearts periodically
        setInterval(createHeart, 2000);

        // Enhanced focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
                this.style.boxShadow = '0 12px 25px rgba(255, 107, 157, 0.3)';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '';
            });
        });

        // Enhanced button hover effects
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });

            // Add click effect
            btn.addEventListener('click', function() {
                this.style.transform = 'translateY(-1px) scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                }, 100);
            });
        });

        // Add sparkle effects on form interaction
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                createSparkleEffect(this);
            });
        });

        function createSparkleEffect(element) {
            for (let i = 0; i < 5; i++) {
                const sparkle = document.createElement('div');
                sparkle.innerHTML = '✨';
                sparkle.style.position = 'absolute';
                sparkle.style.pointerEvents = 'none';
                sparkle.style.fontSize = '12px';
                sparkle.style.color = '#ff6b9d';
                sparkle.style.zIndex = '1000';
                
                const rect = element.getBoundingClientRect();
                sparkle.style.left = (rect.left + Math.random() * rect.width) + 'px';
                sparkle.style.top = (rect.top + Math.random() * rect.height) + 'px';
                
                document.body.appendChild(sparkle);
                
                sparkle.animate([
                    { transform: 'translateY(0) scale(0) rotate(0deg)', opacity: 1 },
                    { transform: 'translateY(-30px) scale(1) rotate(180deg)', opacity: 0 }
                ], {
                    duration: 1000,
                    easing: 'ease-out'
                });
                
                setTimeout(() => sparkle.remove(), 1000);
            }
        }

        // Add floating animation to the container
        const container = document.querySelector('.login-container');
        let mouseX = 0;
        let mouseY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        setInterval(() => {
            const rect = container.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            const deltaX = (mouseX - centerX) * 0.01;
            const deltaY = (mouseY - centerY) * 0.01;
            
            container.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
        }, 50);
    </script>
</body>
</html>