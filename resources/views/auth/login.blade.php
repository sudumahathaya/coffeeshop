<x-guest-layout>
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
            <!-- Left Side - Coffee Hero Content -->
            <div class="col-lg-6 d-none d-lg-block login-hero">
                <div class="hero-content h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-white">
                        <div class="hero-animation mb-4">
                            <div class="coffee-cup-animation">
                                <i class="bi bi-cup-hot-fill" style="font-size: 6rem;"></i>
                                <div class="steam steam1"></div>
                                <div class="steam steam2"></div>
                                <div class="steam steam3"></div>
                            </div>
                        </div>
                        <h1 class="display-4 fw-bold mb-4">Welcome Back!</h1>
                        <p class="lead mb-4">Your favorite coffee is waiting for you. Sign in to continue your coffee journey with us.</p>

                        <!-- Customer Reviews -->
                        <div class="review-section mt-5">
                            <h5 class="mb-3">What our customers say:</h5>
                            <div class="review-carousel">
                                <div class="review-item active">
                                    <div class="stars mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </div>
                                    <p class="fst-italic">"Best coffee in town! The atmosphere is perfect."</p>
                                    <small>- Nirodha.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center py-5">
                <div class="login-form-container">
                    <div class="text-center mb-4">
                        <div class="logo-container mb-3">
                            <i class="bi bi-cup-hot-fill text-coffee pulse" style="font-size: 3rem;"></i>
                        </div>
                        <h2 class="fw-bold text-coffee mb-2">Sign In</h2>
                        <p class="text-muted">Welcome back to Café Elixir</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card auth-card shadow-lg border-0">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf

                                <!-- Email Address -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    <input id="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus
                                           autocomplete="username"
                                           placeholder="Enter your email address">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input id="password"
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               type="password"
                                               name="password"
                                               required
                                               autocomplete="current-password"
                                               placeholder="Enter your password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="passwordIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Remember Me and Forgot Password -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                        <label for="remember_me" class="form-check-label">
                                            <i class="bi bi-heart me-1"></i>Remember me
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="text-coffee text-decoration-none fw-semibold" href="{{ route('password.request') }}">
                                            <i class="bi bi-key me-1"></i>Forgot password?
                                        </a>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-coffee btn-lg" id="loginBtn">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        <span class="btn-text">Sign In</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Signing In...
                                        </span>
                                    </button>
                                </div>

                                <!-- Social Login -->
                                <div class="text-center mb-3">
                                    <div class="divider-with-text mb-3">
                                        <span class="divider-text">Or continue with</span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button type="button" class="btn btn-outline-danger flex-fill social-btn">
                                            <i class="bi bi-google me-2"></i>Google
                                        </button>
                                        <button type="button" class="btn btn-outline-primary flex-fill social-btn">
                                            <i class="bi bi-facebook me-2"></i>Facebook
                                        </button>
                                    </div>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="mb-0 text-muted">
                                        Don't have an account?
                                        <a href="{{ route('register') }}" class="text-coffee text-decoration-none fw-semibold">
                                            <i class="bi bi-person-plus me-1"></i>Create one here
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Info -->
                    <div class="security-info text-center mt-4">
                        <small class="text-muted">
                            <i class="bi bi-shield-lock me-1"></i>
                            Your information is secure and encrypted
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .login-form-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .form-control-lg {
            border-radius: 15px;
            border: 2px solid #e9ecef;
            padding: 0.875rem 1.25rem;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            border-color: var(--coffee-primary);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
            transform: translateY(-2px);
        }

        .btn-coffee {
            background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 15px;
            padding: 0.875rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-coffee:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.3);
            color: white;
        }

        .btn-coffee::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s;
        }

        .btn-coffee:hover::before {
            left: 100%;
        }

        .login-hero {
            background: linear-gradient(135deg,
                        rgba(139, 69, 19, 0.9),
                        rgba(210, 105, 30, 0.8)),
                        url('https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1200&h=800&fit=crop') center/cover;
            position: relative;
        }

        .login-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 3rem;
        }

        .coffee-cup-animation {
            position: relative;
            display: inline-block;
            animation: glow 2s ease-in-out infinite alternate;
        }

        .steam {
            position: absolute;
            width: 4px;
            height: 25px;
            background: linear-gradient(to top, transparent, rgba(255,255,255,0.8), transparent);
            border-radius: 2px;
            animation: steam 2s ease-in-out infinite;
        }

        .steam1 {
            left: 20px;
            top: -35px;
            animation-delay: 0s;
        }

        .steam2 {
            left: 30px;
            top: -40px;
            animation-delay: 0.5s;
        }

        .steam3 {
            left: 40px;
            top: -35px;
            animation-delay: 1s;
        }

        .review-section {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .review-item {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .review-item.active {
            opacity: 1;
            transform: translateY(0);
        }

        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        .quick-login {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.1), rgba(210, 105, 30, 0.1));
            border-radius: 15px;
            padding: 1rem;
            border: 1px solid rgba(139, 69, 19, 0.2);
        }



        .social-btn {
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .divider-with-text {
            position: relative;
            text-align: center;
        }

        .divider-with-text::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
        }

        .divider-text {
            background: white;
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .text-coffee {
            color: var(--coffee-primary) !important;
        }

        .btn-loading {
            display: none;
        }

        .btn-coffee.loading .btn-text {
            display: none;
        }

        .btn-coffee.loading .btn-loading {
            display: inline-block;
        }

        .security-info {
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        /* Animations */
        @keyframes glow {
            0% { text-shadow: 0 0 20px rgba(255,255,255,0.5); }
            100% { text-shadow: 0 0 30px rgba(255,255,255,0.8), 0 0 40px rgba(139, 69, 19, 0.5); }
        }

        @keyframes steam {
            0% { opacity: 0; transform: translateY(0) scaleX(1); }
            50% { opacity: 1; transform: translateY(-15px) scaleX(1.2); }
            100% { opacity: 0; transform: translateY(-30px) scaleX(0.8); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
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

        @media (max-width: 991.98px) {
            .login-form-container {
                max-width: 100%;
                padding: 1rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    passwordIcon.classList.toggle('bi-eye');
                    passwordIcon.classList.toggle('bi-eye-slash');
                });
            }

            // Form submission with loading state
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');

            loginForm.addEventListener('submit', function() {
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;
            });

            // Rotating reviews
            const reviews = [
                {
                    text: "Best coffee in town! The atmosphere is perfect.",
                    author: "Nirodha.",
                    stars: 5
                },
                {
                    text: "Amazing service and quality. Highly recommended!",
                    author: "Dinidu.",
                    stars: 5
                },
                {
                    text: "My daily dose of happiness. Love this place!",
                    author: "Chanul.",
                    stars: 5
                }
            ];

            let currentReview = 0;
            const reviewElement = document.querySelector('.review-item');

            function rotateReviews() {
                if (!reviewElement) return;

                reviewElement.classList.remove('active');

                setTimeout(() => {
                    currentReview = (currentReview + 1) % reviews.length;
                    const review = reviews[currentReview];

                    reviewElement.querySelector('p').textContent = `"${review.text}"`;
                    reviewElement.querySelector('small').textContent = `- ${review.author}`;

                    reviewElement.classList.add('active');
                }, 500);
            }

            // Start review rotation
            setInterval(rotateReviews, 4000);

            // Enhanced form validation
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Social login handlers (placeholder)
            document.querySelectorAll('.social-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const platform = this.textContent.trim();
                    alert(`${platform} login integration coming soon!`);
                });
            });
        });
    </script>
    @endpush
</x-guest-layout>
