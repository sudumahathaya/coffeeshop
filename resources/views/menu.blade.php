@extends('layouts.master')

@section('title', 'Menu - Café Elixir')
@section('description', 'Explore our carefully crafted coffee menu at Café Elixir. Premium coffee blends, artisanal drinks, and delicious treats.')

@section('content')
<!-- Hero Section -->
<section class="menu-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Our Coffee Menu</h1>
                <p class="lead text-white mb-4">Discover the perfect blend of tradition and innovation in every cup. From classic espressos to signature creations, each drink is crafted with passion and precision.</p>
                <div class="d-flex gap-3">
                    <a href="#menu-categories" class="btn btn-coffee btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Explore Menu
                    </a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Reserve Table
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image-container">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&h=700&fit=crop"
                         alt="Café Elixir Coffee"
                         class="img-fluid rounded-3 shadow-lg floating">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Categories -->
<section id="menu-categories" class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">Menu Categories</h2>
                <p class="lead text-muted">Choose from our carefully curated selection of beverages and treats</p>
            </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-8">
                <div class="category-filters d-flex flex-wrap justify-content-center gap-2">
                    <button class="btn btn-coffee active" data-category="all">
                        <i class="bi bi-grid me-2"></i>All Items
                    </button>
                    @foreach($categories as $category)
                        @php
                            $categoryMap = [
                                'Hot Coffee' => ['hot-coffee', 'bi-cup-hot'],
                                'Cold Coffee' => ['cold-coffee', 'bi-snow'],
                                'Specialty' => ['specialty', 'bi-star'],
                                'Tea & Others' => ['tea', 'bi-cup'],
                                'Food & Snacks' => ['food', 'bi-cookie']
                            ];
                            $categoryData = $categoryMap[$category] ?? ['other', 'bi-circle'];
                            $categoryClass = $categoryData[0];
                            $categoryIcon = $categoryData[1];
                        @endphp
                        <button class="btn btn-outline-coffee" data-category="{{ $categoryClass }}">
                            <i class="bi {{ $categoryIcon }} me-2"></i>{{ $category }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="menu-items">
            <!-- Hot Coffee Section -->
            <div class="row g-4" id="menu-grid">
                @foreach($menuItems as $index => $item)
                    @php
                        $categoryMap = [
                            'Hot Coffee' => 'hot-coffee',
                            'Cold Coffee' => 'cold-coffee',
                            'Specialty' => 'specialty',
                            'Tea & Others' => 'tea',
                            'Food & Snacks' => 'food'
                        ];
                        $categoryClass = $categoryMap[$item->category] ?? 'other';
                        
                        // Generate random rating between 4.5 and 5.0
                        $rating = number_format(4.5 + (rand(0, 50) / 100), 1);
                        
                        // Determine badge based on category or special properties
                        $badge = '';
                        $badgeClass = '';
                        if ($item->category === 'Specialty') {
                            $badge = 'Signature';
                            $badgeClass = 'bg-info';
                        } elseif ($item->category === 'Cold Coffee') {
                            $badge = 'Refreshing';
                            $badgeClass = 'bg-primary';
                        } elseif ($item->category === 'Tea & Others' && str_contains($item->name, 'Ceylon')) {
                            $badge = 'Ceylon';
                            $badgeClass = 'bg-success';
                        } elseif ($item->category === 'Food & Snacks') {
                            $badge = 'Fresh Baked';
                            $badgeClass = 'bg-warning';
                        } elseif ($index < 3) {
                            $badge = 'Popular';
                            $badgeClass = 'bg-success';
                        }
                    @endphp
                    
                    <div class="col-lg-4 col-md-6 menu-item" data-category="{{ $categoryClass }}" data-aos="fade-up" data-aos-delay="{{ (($index % 3) + 1) * 100 }}">
                        <div class="card menu-card h-100">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-star-fill"></i> {{ $rating }}
                                    </span>
                                </div>
                                @if($badge)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge {{ $badgeClass }}">
                                            @if($badge === 'Ceylon')
                                                <i class="bi bi-geo-alt"></i> 
                                            @endif
                                            {{ $badge }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-coffee">{{ $item->name }}</h5>
                                <p class="card-text text-muted">{{ $item->description }}</p>
                                <div class="price-section mb-3">
                                    <span class="h5 text-coffee mb-0">Rs. {{ number_format($item->price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    @auth
                                        <button class="btn btn-coffee btn-sm add-to-cart" 
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}" 
                                                data-price="{{ $item->price }}"
                                                data-image="{{ $item->image }}">
                                            <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-coffee btn-sm">
                                            <i class="bi bi-box-arrow-in-right me-1"></i>Login to Order
                                        </a>
                                    @endauth
                                    <button class="btn btn-outline-coffee btn-sm ms-2" data-payment-trigger>
                                        <i class="bi bi-credit-card me-1"></i>Quick Pay
                                    </button>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $item->preparation_time ?? 'Ready soon' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Today's Special Offers</h2>
                <p class="lead text-muted">Don't miss these amazing deals at Café Elixir</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card offer-card border-0 shadow">
                    <div class="card-body text-center">
                        <div class="offer-icon mb-3">
                            <i class="bi bi-clock-history text-coffee" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title">Happy Hour</h4>
                        <p class="card-text">Get 20% off all hot coffee drinks from 2 PM to 5 PM</p>
                        <div class="offer-time">
                            <span class="badge bg-coffee">2:00 PM - 5:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card offer-card border-0 shadow">
                    <div class="card-body text-center">
                        <div class="offer-icon mb-3">
                            <i class="bi bi-gift text-coffee" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title">Combo Deal</h4>
                        <p class="card-text">Any coffee + croissant for just Rs. 650 (Save Rs. 150)</p>
                        <div class="offer-time">
                            <span class="badge bg-success">All Day</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card offer-card border-0 shadow">
                    <div class="card-body text-center">
                        <div class="offer-icon mb-3">
                            <i class="bi bi-heart text-coffee" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title">Loyalty Card</h4>
                        <p class="card-text">Buy 10 drinks, get the 11th absolutely free!</p>
                        <div class="offer-time">
                            <span class="badge bg-info">Sign Up Today</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .menu-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1920&h=1080&fit=crop') center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .menu-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .menu-hero .container {
        position: relative;
        z-index: 2;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .hero-image-container {
        position: relative;
    }

    .floating {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .category-filters .btn {
        margin: 0.25rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .category-filters .btn:not(.active):hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.2);
    }

    .menu-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
    }

    .menu-card .card-img-top {
        height: 250px;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .menu-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .price-section {
        border-top: 1px solid rgba(139, 69, 19, 0.1);
        border-bottom: 1px solid rgba(139, 69, 19, 0.1);
        padding: 0.75rem 0;
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border-radius: 8px;
        margin: 0.5rem -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .add-to-cart {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .add-to-cart::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s;
    }

    .add-to-cart:hover::before {
        left: 100%;
    }

    .add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    .offer-card {
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .offer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .offer-icon {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.1), rgba(210, 105, 30, 0.1));
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .menu-item {
        transition: all 0.3s ease;
    }

    .menu-item.hidden {
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
    }

    .text-coffee {
        color: var(--coffee-primary) !important;
    }

    .btn-coffee {
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .btn-coffee:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    .btn-outline-coffee {
        border: 2px solid var(--coffee-primary);
        color: var(--coffee-primary);
        background: transparent;
        font-weight: 600;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .btn-outline-coffee:hover {
        background: var(--coffee-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    .btn-outline-coffee.active {
        background: var(--coffee-primary);
        color: white;
        border-color: var(--coffee-primary);
    }

    @media (max-width: 768px) {
        .menu-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .category-filters {
            flex-direction: column;
        }

        .category-filters .btn {
            width: 100%;
            margin: 0.25rem 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize menu functionality
    initializeMenuFilters();
    initializeMenuSearch();

    // Smooth scrolling for menu categories
    document.querySelector('[href="#menu-categories"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('menu-categories').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

// Menu filtering functionality
function initializeMenuFilters() {
    const categoryButtons = document.querySelectorAll('[data-category]');
    const menuItems = document.querySelectorAll('.menu-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update active button
            categoryButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('btn-outline-coffee');
                btn.classList.remove('btn-coffee');
            });

            this.classList.add('active');
            this.classList.remove('btn-outline-coffee');
            this.classList.add('btn-coffee');

            // Filter items
            menuItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');

                if (category === 'all' || itemCategory === category) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        if (item.classList.contains('hidden')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });

            // Re-trigger AOS animation for visible items
            setTimeout(() => {
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            }, 400);
        });
    });
}

// Menu search functionality
function initializeMenuSearch() {
    const searchInput = document.getElementById('menuSearch');
    const menuItems = document.querySelectorAll('.menu-item');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            menuItems.forEach(item => {
                const itemName = item.querySelector('.card-title').textContent.toLowerCase();
                const itemDescription = item.querySelector('.card-text').textContent.toLowerCase();

                if (itemName.includes(searchTerm) || itemDescription.includes(searchTerm)) {
                    item.style.display = 'block';
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        if (item.classList.contains('hidden')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });
        });
    }
}
</script>
@endpush
@endsection
