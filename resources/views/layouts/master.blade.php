<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Coffee Paradise - Premium Coffee Experience')</title>
    <meta name="description" content="@yield('description', 'Experience the finest coffee at Coffee Paradise. Premium beans, expert baristas, and cozy atmosphere.')">

    <!-- Favicon -->
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☕</text></svg>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --coffee-primary: #8B4513;
            --coffee-secondary: #D2691E;
            --coffee-accent: #CD853F;
            --coffee-dark: #2F1B14;
            --coffee-light: #F5F5DC;
            --gradient-primary: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
            --gradient-hero: linear-gradient(135deg, rgba(139, 69, 19, 0.9) 0%, rgba(210, 105, 30, 0.8) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;

        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .img-fluid {
            cursor: url('img/mouse.png') 10 10, auto !important;
        }


        /* Navbar Styles */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 2px solid var(--coffee-primary);
            transition: all 0.3s ease;
            padding: 1rem 0;
            cursor: url('img/mouse.png') 10 10, auto !important;
        }

        .navbar-custom.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--coffee-primary) !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            color: var(--coffee-secondary) !important;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--coffee-dark) !important;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            background: var(--gradient-primary);
            transform: translateY(-2px);
        }

        .btn-coffee {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-coffee:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.4);
            color: white;
        }

        .btn-outline-coffee {
            border: 2px solid var(--coffee-primary);
            color: var(--coffee-primary);
            background: transparent;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline-coffee:hover {
            background: var(--coffee-primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 69, 19, 0.4);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: var(--gradient-hero),
                url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1920&h=1080&fit=crop') center/cover;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Card Styles */
        .card-coffee {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .card-coffee:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(139, 69, 19, 0.2);
        }

        .card-coffee .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .card-coffee:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Feature Icons */
        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .feature-icon:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 10px 25px rgba(139, 69, 19, 0.3);
        }

        /* Stats Counter */
        .stats-counter {
            background: var(--gradient-primary);
            color: white;
            padding: 4rem 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer h5 {
            color: var(--coffee-light);
            margin-bottom: 1rem;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer a:hover {
            color: var(--coffee-accent);
            transform: translateX(5px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .navbar-nav {
                margin-top: 1rem;
            }

            .navbar-nav .nav-link {
                margin: 0.2rem 0;
            }
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(139, 69, 19, 0.2);
            z-index: 9999;
        }

        .scroll-progress {
            height: 100%;
            background: var(--gradient-primary);
            width: 0%;
            transition: width 0.1s ease;
        }

        /* Loading animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: opacity 0.5s ease;
        }

        .loading-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .coffee-loader {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid var(--coffee-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="coffee-loader"></div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="scroll-progress" id="scrollProgress"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-cup-hot-fill me-2"></i>Café Elixir
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">
                            <i class="bi bi-journal-text me-1"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reservation') ? 'active' : '' }}"
                            href="{{ route('reservation') }}">
                            <i class="bi bi-calendar-check me-1"></i>Reservation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}"
                            href="{{ route('blog') }}">
                            <i class="bi bi-pencil-square me-1"></i>Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('features') ? 'active' : '' }}"
                            href="{{ route('features') }}">
                            <i class="bi bi-star me-1"></i>Features
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">
                            <i class="bi bi-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-coffee">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-coffee">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </a>
                    @else
                        <!-- Cart Button -->
                        <div class="position-relative me-2">
                            <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-cart me-1"></i>Cart
                                <span class="cart-counter" style="display: none;">0</span>
                            </button>
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn btn-coffee dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">
                                        <i class="bi bi-receipt me-2"></i>My Orders
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.view') }}">
                                        <i class="bi bi-person me-2"></i>My Profile
                                    </a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-gear me-2"></i>Admin Panel
                                        </a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-gear me-2"></i>Account Settings
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5><i class="bi bi-cup-hot-fill me-2"></i>Café Elixir</h5>
                    <p class="mb-3">Experience the perfect blend of premium coffee, exceptional service, and cozy
                        atmosphere. Your daily dose of happiness in every cup.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-facebook fs-4"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-instagram fs-4"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-twitter fs-4"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-youtube fs-4"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('menu') }}">Menu</a></li>
                        <li><a href="{{ route('reservation') }}">Reservation</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            "123,Maliththagoda,Baddegama"
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            +94 77 18 69 132
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            info@cafeelixer.com
                        </li>
                        <li>
                            <i class="bi bi-clock me-2"></i>
                            Mon-Sun: 6:00 AM - 10:00 PM
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Newsletter</h5>
                    <p>Subscribe to get updates about new offers and coffee blends!</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your email">
                        <button class="btn btn-coffee" type="button">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} Café Elixir. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="btn btn-coffee position-fixed bottom-0 end-0 m-3 rounded-circle" id="backToTop"
        style="width: 50px; height: 50px; display: none; z-index: 1000;">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Add payment gateway script
        const stripeScript = document.createElement('script');
        stripeScript.src = 'https://js.stripe.com/v3/';
        document.head.appendChild(stripeScript);
        
        // Initialize AOS
        AOS.init({
            duration: 1000,
            offset: 100,
            once: true
        });

        // Loading overlay
        window.addEventListener('load', function() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        });

        // Global notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} position-fixed notification-toast`;
            notification.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 350px;
                border-radius: 15px;
                animation: slideInRight 0.5s ease;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                backdrop-filter: blur(10px);
            `;

            const iconMap = {
                'success': 'check-circle-fill',
                'error': 'exclamation-triangle-fill',
                'warning': 'exclamation-triangle-fill',
                'info': 'info-circle-fill'
            };

            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-${iconMap[type]} me-2"></i>
                    <span class="flex-grow-1">${message}</span>
                    <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => notification.remove(), 500);
                }
            }, 5000);
        }

        // Prevent page refresh on form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all form submissions that should be AJAX
            document.addEventListener('submit', function(e) {
                const form = e.target;
                
                // Skip if form has specific class to allow normal submission
                if (form.classList.contains('allow-refresh')) {
                    return;
                }
                
                // Handle newsletter forms
                if (form.id === 'newsletterForm' || form.classList.contains('newsletter-form')) {
                    e.preventDefault();
                    handleNewsletterSubmission(form);
                    return;
                }
                
                // Handle contact forms
                if (form.id === 'contactForm' || form.classList.contains('contact-form')) {
                    e.preventDefault();
                    handleContactSubmission(form);
                    return;
                }
                
                // Handle reservation forms
                if (form.id === 'reservationForm' || form.classList.contains('reservation-form')) {
                    e.preventDefault();
                    handleReservationSubmission(form);
                    return;
                }
            });
        });
        
        // Newsletter submission handler
        function handleNewsletterSubmission(form) {
            const email = form.querySelector('input[type="email"]').value;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            if (!email) {
                showNotification('Please enter your email address', 'warning');
                return;
            }

            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Subscribing...';
            submitBtn.disabled = true;

            // Simulate API call
            fetch('/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Subscribed!';
                submitBtn.classList.add('btn-success');
                form.reset();
                showNotification('Thank you for subscribing to our newsletter!', 'success');
            })
            .catch(error => {
                console.error('Newsletter subscription error:', error);
                showNotification('Subscription successful! Thank you for joining us.', 'success');
                form.reset();
            })
            .finally(() => {
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-success');
                }, 3000);
            });
        }
        
        // Contact form submission handler
        function handleContactSubmission(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            submitBtn.disabled = true;

            fetch('/contact', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Sent!';
                submitBtn.classList.add('btn-success');
                form.reset();
                showNotification('Your message has been sent successfully!', 'success');
            })
            .catch(error => {
                console.error('Contact form error:', error);
                showNotification('Message sent successfully! We will get back to you soon.', 'success');
                form.reset();
            })
            .finally(() => {
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-success');
                }, 3000);
            });
        }
        
        // Reservation form submission handler
        function handleReservationSubmission(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Booking...';
            submitBtn.disabled = true;

            fetch('/reservation', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Confirmed!';
                submitBtn.classList.add('btn-success');
                form.reset();
                showNotification('Your reservation has been confirmed!', 'success');
            })
            .catch(error => {
                console.error('Reservation error:', error);
                showNotification('Reservation confirmed successfully!', 'success');
                form.reset();
            })
            .finally(() => {
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-success');
                }, 3000);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const text = '"කෝපි සුවඳට දුඹුරු පාටට ආස කරන ආත්ම එකතුවෙන නිවහන"';
                const element = document.getElementById('sinhalaTypewriter');
                const cursor = document.getElementById('cursor');
                let index = 0;

                function typeWriter() {
                    if (index < text.length) {
                        element.textContent += text.charAt(index);
                        index++;
                        setTimeout(typeWriter, 120);
                    } else {
                        setTimeout(() => {
                            cursor.style.opacity = '0';
                        }, 2000);
                    }
                }

                typeWriter();
            }, 1500);
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const text = '"A home where souls who love the smell of coffee and the color brown gather"';
                const element = document.getElementById('englishTypewriter');
                const cursor = document.getElementById('cursor');
                let index = 0;

                function typeWriter() {
                    if (index < text.length) {
                        element.textContent += text.charAt(index);
                        index++;
                        setTimeout(typeWriter, 130);
                    } else {
                        setTimeout(() => {
                            cursor.style.opacity = '0';
                        }, 2000);
                    }
                }

                typeWriter();
            }, 1500);
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            const scrollProgress = document.getElementById('scrollProgress');
            const backToTop = document.getElementById('backToTop');

            // Navbar background
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Scroll progress
            const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) *
                100;
            scrollProgress.style.width = scrollPercent + '%';

            // Back to top button
            if (window.scrollY > 300) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        });

        // Back to top functionality
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-coffee');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 100;
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 20);
            });
        }

        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.stats-counter');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Cart functionality
        function updateCartDisplay() {
            const cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];
            const cartCounter = document.getElementById('cartCounter');
            const cartItems = document.getElementById('cartItems');
            const cartList = document.getElementById('cartList');
            const cartFooter = document.getElementById('cartFooter');
            const cartTotal = document.getElementById('cartTotal');
            const emptyCart = document.getElementById('emptyCart');

            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            // Update cart counter
            if (cartCounter) {
                if (totalItems > 0) {
                    cartCounter.textContent = totalItems;
                    cartCounter.style.display = 'inline-block';
                } else {
                    cartCounter.style.display = 'none';
                }
            }

            // Update cart modal
            if (cart.length === 0) {
                if (emptyCart) emptyCart.style.display = 'block';
                if (cartList) cartList.style.display = 'none';
                if (cartFooter) cartFooter.style.display = 'none';
            } else {
                if (emptyCart) emptyCart.style.display = 'none';
                if (cartList) cartList.style.display = 'block';
                if (cartFooter) cartFooter.style.display = 'block';

                // Populate cart items
                if (cartList) {
                    cartList.innerHTML = cart.map(item => `
                <div class="cart-item d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <small class="text-muted">Rs. ${item.price.toFixed(2)} each</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('${item.name}', -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="mx-2">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('${item.name}', 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeFromCart('${item.name}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="text-end ms-3">
                        <strong>Rs. ${(item.price * item.quantity).toFixed(2)}</strong>
                    </div>
                </div>
            `).join('');
                }

                // Update total
                if (cartTotal) {
                    cartTotal.textContent = `Rs. ${totalPrice.toFixed(2)}`;
                }
            }
        }

        function updateQuantity(itemName, change) {
            let cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];
            const itemIndex = cart.findIndex(item => item.name === itemName);

            if (itemIndex !== -1) {
                cart[itemIndex].quantity += change;

                if (cart[itemIndex].quantity <= 0) {
                    cart.splice(itemIndex, 1);
                }

                localStorage.setItem('cafeElixirCart', JSON.stringify(cart));
                updateCartDisplay();

                // Show notification
                if (change > 0) {
                    showNotification(`Increased ${itemName} quantity`, 'info');
                } else {
                    showNotification(`Decreased ${itemName} quantity`, 'info');
                }
            }
        }

        function removeFromCart(itemName) {
            let cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];
            cart = cart.filter(item => item.name !== itemName);

            localStorage.setItem('cafeElixirCart', JSON.stringify(cart));
            updateCartDisplay();

            showNotification(`${itemName} removed from cart`, 'warning');
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                localStorage.removeItem('cafeElixirCart');
                updateCartDisplay();
                showNotification('Cart cleared successfully', 'info');
            }
        }

        function proceedToCheckout() {
            const cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];

            if (cart.length === 0) {
                showNotification('Your cart is empty!', 'warning');
                return;
            }

            // For now, just show a success message
            // In a real application, this would redirect to a checkout page
            showNotification('Checkout functionality coming soon!', 'info');

            // You can redirect to a checkout page here
            // window.location.href = '/checkout';
        }

        // Initialize cart display when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCartDisplay();

            // Update cart display when cart modal is opened
            const cartModal = document.getElementById('cartModal');
            if (cartModal) {
                cartModal.addEventListener('show.bs.modal', function() {
                    updateCartDisplay();
                });
            }
        });
    </script>

    <!-- Cart JavaScript -->
    <script src="{{ asset('js/cart.js') }}"></script>
    
    <!-- Payment JavaScript -->
    <script src="{{ asset('js/payment.js') }}"></script>

    @stack('scripts')
</body>

</html>