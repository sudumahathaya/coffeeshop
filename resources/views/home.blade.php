@extends('layouts.master')

@section('title', 'Cafe Elixir - Home')
@section('description', 'Welcome to Cafe Elixir. Experience premium coffee, cozy atmosphere, and exceptional service.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content" data-aos="fade-up">
                    <h1 class="hero-title">Welcome to Café Elixir</h1>
                    <p class="hero-subtitle">Where every cup tells a story of passion, quality, and exceptional taste. Experience the perfect blend of premium coffee and warm hospitality.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('menu') }}" class="btn btn-coffee btn-lg">
                            <i class="bi bi-journal-text me-2"></i>Explore Menu
                        </a>
                        <a href="{{ route('reservation') }}" class="btn btn-outline-coffee btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Make Reservation
                        </a>
                    </div>
                    <div class="text-center mt-5 mb-4">
                        <p id="sinhalaTypewriter" style="font-size: 1.3rem; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); font-weight: 500; min-height: 2em; font-family: 'Noto Sans Sinhala', serif; display: inline;">
                        </p>
                        <span id="cursor" style="color: #fff; font-size: 20px; animation: blink 1s infinite;">|</span>
                    </div>
                    <div class="text-center mt-2 mb-2">
                        <p id="englishTypewriter" style="font-size: 1.3rem; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); font-weight: 500; min-height: 2em; font-family: 'Noto Sans Sinhala', serif; display: inline;">
                        </p>
                        <span id="cursor" style="color: #fff; font-size: 20px; animation: blink 1s infinite;">|</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="text-center">
                    <img src="img/cup.png"
                         alt="Coffee Cup"
                         class="img-fluid rounded-circle floating"
                         style="max-width: 650px; box-shadow: 10px 90px 90px rgba(0,0,0,0.3);margin-top:50px:">

                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="text-center position-absolute bottom-0 start-50 translate-middle-x mb-4">
        <a href="#features" class="text-white text-decoration-none">
            <i class="bi bi-chevron-down fs-2" style="animation: bounce 2s infinite;"></i>
        </a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">Why Choose Café Elixir?</h2>
                <p class="lead text-muted">We're passionate about delivering exceptional coffee experiences that awaken your senses</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                    <h4 class="mb-3">Premium Beans</h4>
                    <p class="text-muted">Sourced directly from the finest coffee farms around the world, ensuring every cup delivers exceptional flavor and aroma that coffee lovers crave.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="mb-3">Expert Baristas</h4>
                    <p class="text-muted">Our skilled and passionate baristas craft each drink with precision, artistry, and love, creating the perfect cup tailored to your taste preferences.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-house-heart"></i>
                    </div>
                    <h4 class="mb-3">Cozy Atmosphere</h4>
                    <p class="text-muted">Relax in our warm, welcoming space designed for comfort - perfect for work, study, meetings, or simply enjoying quality time with friends and family.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h4 class="mb-3">Extended Hours</h4>
                    <p class="text-muted">Open early and staying late to serve your coffee needs from sunrise to sunset. Whether you're an early bird or night owl, we're here for you.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-wifi"></i>
                    </div>
                    <h4 class="mb-3">Free WiFi</h4>
                    <p class="text-muted">Stay connected with complimentary high-speed internet access throughout our café. Perfect for remote work, online meetings, or staying in touch.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h4 class="mb-3">Community Focus</h4>
                    <p class="text-muted">More than just coffee - we're a community hub where neighbors become friends, ideas flourish, and memories are made over great conversations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">Featured Coffee Selection</h2>
                <p class="lead text-muted">Discover our most beloved coffee creations, crafted with passion and served with pride</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $index => $product)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card card-coffee">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-star-fill"></i> {{ number_format(4.5 + (rand(0, 50) / 100), 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-coffee">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-coffee mb-0">Rs. {{ number_format($product->price, 2) }}</span>
                            @auth
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" 
                                        data-price="{{ $product->price }}"
                                        data-image="{{ $product->image }}">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-coffee btn-sm">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Login to Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('menu') }}" class="btn btn-outline-coffee btn-lg">
                <i class="bi bi-journal-text me-2"></i>View Full Menu
            </a>
        </div>
    </div>
</section>

<!-- Stats Counter Section -->
<section class="stats-counter">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <span class="stat-number" data-target="15000">0</span>
                    <span class="stat-label">Happy Customers</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <span class="stat-number" data-target="50">0</span>
                    <span class="stat-label">Coffee Varieties</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <span class="stat-number" data-target="25">0</span>
                    <span class="stat-label">Expert Baristas</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <span class="stat-number" data-target="5">0</span>
                    <span class="stat-label">Years of Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=600&h=400&fit=crop"
                     alt="Coffee Shop Interior"
                     class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-4">
                    <h2 class="display-5 fw-bold text-coffee mb-4">Our Story</h2>
                    <p class="lead mb-4">Café Elixir began as a simple dream - to create a space where exceptional coffee meets genuine community connection.</p>
                    <p class="mb-4">Founded in 2019 by coffee enthusiasts Avindu and Mahesh, we've grown from a small neighborhood café to a beloved community gathering place. Our commitment to quality, sustainability, and customer satisfaction drives everything we do.</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Ethically Sourced</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Freshly Roasted</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Expert Crafted</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                <span>Community Driven</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('features') }}" class="btn btn-coffee">
                            <i class="bi bi-arrow-right me-2"></i>Learn More About Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">What Our Customers Say</h2>
                <p class="lead text-muted">Don't just take our word for it - hear from our amazing coffee community</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"The best coffee in town! The atmosphere is perfect for getting work done, and the baristas always remember my order. Coffee Paradise has become my second home."</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="img/niroda.jpg"
                                 class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Nirodha Sampath</h6>
                                <small class="text-muted">Regular Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"Amazing coffee quality and friendly service! I've tried coffee shops all over the city, but nothing compares to the passion and dedication here."</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="img/dinidu.png"
                                 class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Dinidu Madusanka</h6>
                                <small class="text-muted">Coffee Enthusiast</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"Perfect spot for meetings and catching up with friends. Great coffee, comfortable seating, and excellent WiFi. What more could you ask for?"</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="img/chanul.jpg"
                                 class="rounded-circle me-3" alt="Customer">
                            <div>
                                <h6 class="mb-0">Chanul Ranasinghe</h6>
                                <small class="text-muted">Business Owner</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="py-5 bg-coffee text-white">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold mb-3">Special Offers</h2>
                <p class="lead">Don't miss out on these amazing deals and exclusive offers</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body text-center">
                        <div class="bg-coffee text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-percent fs-2"></i>
                        </div>
                        <h4 class="card-title">Happy Hour</h4>
                        <p class="card-text">Get 20% off all coffee drinks from 2 PM to 5 PM, Monday through Friday.</p>
                        <span class="badge bg-coffee fs-6">2 PM - 5 PM</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body text-center">
                        <div class="bg-coffee text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-gift fs-2"></i>
                        </div>
                        <h4 class="card-title">Loyalty Program</h4>
                        <p class="card-text">Buy 10 drinks, get the 11th free! Sign up today and start earning points.</p>
                        <span class="badge bg-coffee fs-6">Free Registration</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body text-center">
                        <div class="bg-coffee text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-people fs-2"></i>
                        </div>
                        <h4 class="card-title">Group Discounts</h4>
                        <p class="card-text">Bring 4 or more friends and enjoy 15% off your entire order. Perfect for study groups!</p>
                        <span class="badge bg-coffee fs-6">4+ People</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
@guest
<section class="py-5" style="background: var(--gradient-primary);">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-4">Join Our Coffee Community Today!</h2>
                <p class="lead mb-4">Create an account to unlock exclusive benefits, earn rewards, and get personalized recommendations from our expert baristas.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Sign Up Now
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Already a Member?
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest

<!-- Newsletter Section -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h3 class="mb-3">Stay Updated with Café Elixir</h3>
                <p class="mb-0">Get the latest updates on new coffee blends, special offers, and exclusive events delivered straight to your inbox.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <form class="row g-3">
                    <div class="col">
                        <input type="email" class="form-control form-control-lg" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-coffee btn-lg">
                            <i class="bi bi-send me-1"></i>Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
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

    .bg-coffee {
        background-color: var(--coffee-primary) !important;
    }
</style>
@endpush

@push('scripts')
    <script>
        // Typewriter effect for Sinhala text
        const sinhalaTexts = [
            "කෝපි ප්‍රේමීන්ගේ ස්වර්ගය",
            "සෑම කෝපි කෝප්පයක්ම කතාවක්",
            "ගුණාත්මක කෝපි අත්දැකීම"
        ];

        // Typewriter effect for English text
        const englishTexts = [
            "Paradise for Coffee Lovers",
            "Every Cup Tells a Story",
            "Premium Coffee Experience"
        ];

        let sinhalaIndex = 0;
        let englishIndex = 0;
        let sinhalaCharIndex = 0;
        let englishCharIndex = 0;
        let isDeleting = false;

        function typewriterEffect() {
            const sinhalaElement = document.getElementById('sinhalaTypewriter');
            const englishElement = document.getElementById('englishTypewriter');

            if (!sinhalaElement || !englishElement) return;

            const currentSinhalaText = sinhalaTexts[sinhalaIndex];
            const currentEnglishText = englishTexts[englishIndex];

            if (!isDeleting) {
                // Typing
                if (sinhalaCharIndex < currentSinhalaText.length) {
                    sinhalaElement.textContent = currentSinhalaText.substring(0, sinhalaCharIndex + 1);
                    sinhalaCharIndex++;
                }

                if (englishCharIndex < currentEnglishText.length) {
                    englishElement.textContent = currentEnglishText.substring(0, englishCharIndex + 1);
                    englishCharIndex++;
                }

                if (sinhalaCharIndex === currentSinhalaText.length && englishCharIndex === currentEnglishText.length) {
                    // Both texts are complete, wait then start deleting
                    setTimeout(() => {
                        isDeleting = true;
                    }, 2000);
                }
            } else {
                // Deleting
                if (sinhalaCharIndex > 0) {
                    sinhalaElement.textContent = currentSinhalaText.substring(0, sinhalaCharIndex - 1);
                    sinhalaCharIndex--;
                }

                if (englishCharIndex > 0) {
                    englishElement.textContent = currentEnglishText.substring(0, englishCharIndex - 1);
                    englishCharIndex--;
                }

                if (sinhalaCharIndex === 0 && englishCharIndex === 0) {
                    // Both texts are deleted, move to next texts
                    isDeleting = false;
                    sinhalaIndex = (sinhalaIndex + 1) % sinhalaTexts.length;
                    englishIndex = (englishIndex + 1) % englishTexts.length;
                }
            }

            setTimeout(typewriterEffect, isDeleting ? 50 : 100);
        }

        // Start typewriter effect when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(typewriterEffect, 1000);
        });

        // Stats counter animation
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, 20);
        }

        // Initialize counters when they come into view
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-target'));
                        animateCounter(counter, target);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function() {
            const statsSection = document.querySelector('.stats-counter');
            if (statsSection) {
                observer.observe(statsSection);
            }
        });

        // Notification system
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `custom-notification alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} alert-dismissible fade show`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;

            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Add to cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const productPrice = parseFloat(this.getAttribute('data-price'));
                    const productImage = this.getAttribute('data-image');

                    // Get existing cart from localStorage
                    let cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];

                    // Check if item already exists in cart
                    const existingItemIndex = cart.findIndex(item => item.id === productId);

                    if (existingItemIndex !== -1) {
                        // Item exists, increase quantity
                        cart[existingItemIndex].quantity += 1;
                        showNotification(`Increased ${productName} quantity in cart!`, 'info');
                    } else {
                        // New item, add to cart
                        cart.push({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            image: productImage,
                            quantity: 1
                        });
                        showNotification(`${productName} added to cart!`, 'success');
                    }

                    // Save updated cart to localStorage
                    localStorage.setItem('cafeElixirCart', JSON.stringify(cart));

                    // Update cart display if the function exists
                    if (typeof updateCartDisplay === 'function') {
                        updateCartDisplay();
                    }

                    // Add visual feedback
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check me-1"></i>Added!';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 1500);
                });
            });
        });

        // Cart functionality is now handled by cart.js
        
        // Quick Pay functionality
        window.quickPay = function(itemId, itemName, itemPrice, itemImage) {
            // Create single item order data
            const orderData = {
                items: [{
                    id: itemId,
                    name: itemName,
                    price: parseFloat(itemPrice),
                    quantity: 1
                }],
                customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
                customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
                customer_phone: '',
                order_type: 'dine_in',
                subtotal: parseFloat(itemPrice),
                tax: parseFloat(itemPrice) * 0.1,
                total: parseFloat(itemPrice) * 1.1,
                order_id: 'ORD' + Date.now()
            };

            // Store order data globally for payment modal
            window.currentOrderData = orderData;

            // Show payment modal
            if (typeof showPaymentModal === 'function') {
                showPaymentModal(orderData);
            } else {
                console.error('Payment modal not available');
                showNotification('Payment system not available', 'error');
            }
        };
    </script>

    @stack('scripts')
@endpush
@endsection