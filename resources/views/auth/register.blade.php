<x-guest-layout>
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
            <!-- Left Side - Registration Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center py-5">
                <div class="register-form-container">
                    <div class="text-center mb-4">
                        <div class="logo-container mb-3">
                            <i class="bi bi-cup-hot-fill text-coffee" style="font-size: 3rem;"></i>
                        </div>
                        <h2 class="fw-bold text-coffee mb-2">Join Café Elixire</h2>
                        <p class="text-muted">Create your account and start your coffee journey</p>
                    </div>

                    <div class="card auth-card shadow-lg border-0">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('register') }}" id="registerForm">
                                @csrf

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Full Name
                                    </label>
                                    <input id="name"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           type="text"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autofocus
                                           autocomplete="name"
                                           placeholder="Enter your full name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

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
                                               autocomplete="new-password"
                                               placeholder="Create a strong password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="passwordIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Password must be at least 8 characters long
                                        </small>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <input id="password_confirmation"
                                               class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                               type="password"
                                               name="password_confirmation"
                                               required
                                               autocomplete="new-password"
                                               placeholder="Confirm your password">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Terms and Privacy -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            I agree to the
                                            <a href="#" class="text-coffee text-decoration-none fw-semibold">Terms of Service</a>
                                            and
                                            <a href="#" class="text-coffee text-decoration-none fw-semibold">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <!-- Newsletter Subscription -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                                        <label class="form-check-label" for="newsletter">
                                            <i class="bi bi-envelope-heart me-1"></i>
                                            Subscribe to our newsletter for coffee tips and exclusive offers
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-coffee btn-lg" id="registerBtn">
                                        <i class="bi bi-person-plus me-2"></i>
                                        <span class="btn-text">Create Account</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Creating Account...
                                        </span>
                                    </button>
                                </div>

                                <!-- Social Registration -->
                                <div class="text-center mb-4">
                                    <div class="divider-with-text mb-3">
                                        <span class="divider-text">Or register with</span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button type="button" class="btn btn-outline-primary flex-fill">
                                            <i class="bi bi-google me-2"></i>Google
                                        </button>
                                        <button type="button" class="btn btn-outline-info flex-fill">
                                            <i class="bi bi-facebook me-2"></i>Facebook
                                        </button>
                                    </div>
                                </div>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="mb-0 text-muted">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="text-coffee text-decoration-none fw-semibold">
                                            Sign in here
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Coffee Image/Content -->
            <div class="col-lg-6 d-none d-lg-block register-hero">
                <div class="hero-content h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-white">
                        <div class="hero-animation mb-4">
                            <i class="bi bi-cup-hot floating" style="font-size: 5rem;"></i>
                        </div>
                        <h1 class="display-4 fw-bold mb-4">Welcome to Our Coffee Family</h1>
                        <p class="lead mb-4">Join thousands of coffee lovers who have made Café Elixir their daily ritual</p>

                        <!-- Features -->
                        <div class="row g-3 mt-4">
                            <div class="col-6">
                                <div class="feature-item">
                                    <i class="bi bi-gift-fill mb-2" style="font-size: 2rem;"></i>
                                    <h6>Welcome Bonus</h6>
                                    <small>Free coffee on your first order</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <i class="bi bi-star-fill mb-2" style="font-size: 2rem;"></i>
                                    <h6>Loyalty Rewards</h6>
                                    <small>Earn points with every purchase</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <i class="bi bi-bell-fill mb-2" style="font-size: 2rem;"></i>
                                    <h6>Exclusive Offers</h6>
                                    <small>Get notified about special deals</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <i class="bi bi-calendar-check-fill mb-2" style="font-size: 2rem;"></i>
                                    <h6>Easy Reservations</h6>
                                    <small>Book your table in advance</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .register-form-container {
            width: 100%;
            max-width: 480px;
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

        .btn-coffee:active {
            transform: translateY(0);
        }

        .register-hero {
            background: linear-gradient(135deg,
                        rgba(139, 69, 19, 0.9),
                        rgba(210, 105, 30, 0.8)),
                        url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&h=800&fit=crop') center/cover;
            position: relative;
        }

        .register-hero::before {
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

        .feature-item {
            padding: 1rem;
            border-radius: 15px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.2);
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
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

        @media (max-width: 991.98px) {
            .register-form-container {
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

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                passwordIcon.classList.toggle('bi-eye');
                passwordIcon.classList.toggle('bi-eye-slash');
            });

            // Confirm password toggle
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPassword = document.getElementById('password_confirmation');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                confirmPasswordIcon.classList.toggle('bi-eye');
                confirmPasswordIcon.classList.toggle('bi-eye-slash');
            });

            // Form submission with loading state
            const registerForm = document.getElementById('registerForm');
            const registerBtn = document.getElementById('registerBtn');

            registerForm.addEventListener('submit', function() {
                registerBtn.classList.add('loading');
                registerBtn.disabled = true;
            });

            // Real-time password validation
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');

            function validatePasswords() {
                if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Passwords do not match');
                    confirmPasswordInput.classList.add('is-invalid');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                    confirmPasswordInput.classList.remove('is-invalid');
                }
            }

            passwordInput.addEventListener('input', validatePasswords);
            confirmPasswordInput.addEventListener('input', validatePasswords);

            // Enhanced form validation
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    </script>
    @endpush
</x-guest-layout>
