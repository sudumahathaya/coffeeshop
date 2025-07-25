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
                    <button class="btn btn-outline-coffee" data-category="hot-coffee">
                        <i class="bi bi-cup-hot me-2"></i>Hot Coffee
                    </button>
                    <button class="btn btn-outline-coffee" data-category="cold-coffee">
                        <i class="bi bi-snow me-2"></i>Cold Coffee
                    </button>
                    <button class="btn btn-outline-coffee" data-category="specialty">
                        <i class="bi bi-star me-2"></i>Specialty
                    </button>
                    <button class="btn btn-outline-coffee" data-category="tea">
                        <i class="bi bi-cup me-2"></i>Tea & Others
                    </button>
                    <button class="btn btn-outline-coffee" data-category="food">
                        <i class="bi bi-cookie me-2"></i>Food & Snacks
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="menu-items">
            <!-- Hot Coffee Section -->
            <div class="row g-4" id="menu-grid">
                <!-- Espresso -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="hot-coffee" data-aos="fade-up" data-aos-delay="100">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Espresso">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.9
                                </span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-success">Popular</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Classic Espresso</h5>
                            <p class="card-text text-muted">Rich, bold espresso shot with perfect crema. The foundation of all great coffee drinks.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 320.00</span>
                                <span class="text-muted ms-2">(Single Shot)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="1"
                                        data-name="Classic Espresso" 
                                        data-price="320"
                                        data-image="https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>2-3 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cappuccino -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="hot-coffee" data-aos="fade-up" data-aos-delay="200">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Cappuccino">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.8
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Cappuccino</h5>
                            <p class="card-text text-muted">Perfect balance of espresso, steamed milk, and foam. Traditional Italian favorite.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 480.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="2"
                                        data-name="Cappuccino" 
                                        data-price="480"
                                        data-image="https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>3-4 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latte -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="hot-coffee" data-aos="fade-up" data-aos-delay="300">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Latte">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.7
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Café Latte</h5>
                            <p class="card-text text-muted">Smooth espresso with steamed milk and delicate foam art. Creamy and comforting.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 520.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="3"
                                        data-name="Café Latte" 
                                        data-price="520"
                                        data-image="https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>4-5 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Caramel Macchiato -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="specialty" data-aos="fade-up" data-aos-delay="100">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Caramel Macchiato">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.9
                                </span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-info">Signature</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Caramel Macchiato</h5>
                            <p class="card-text text-muted">Rich espresso with vanilla syrup, steamed milk, and caramel drizzle. Sweet perfection.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 650.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="4"
                                        data-name="Caramel Macchiato" 
                                        data-price="650"
                                        data-image="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>5-6 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Iced Coffee -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="cold-coffee" data-aos="fade-up" data-aos-delay="200">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Iced Coffee">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.6
                                </span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-primary">Refreshing</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Iced Coffee</h5>
                            <p class="card-text text-muted">Cold brew coffee served over ice with your choice of milk. Perfect for hot days.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 580.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="5"
                                        data-name="Iced Coffee" 
                                        data-price="580"
                                        data-image="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>3-4 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Frappuccino -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="cold-coffee" data-aos="fade-up" data-aos-delay="300">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Frappuccino">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.8
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Vanilla Frappuccino</h5>
                            <p class="card-text text-muted">Blended ice coffee with vanilla flavor and whipped cream. A delightful treat.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 720.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="6"
                                        data-name="Vanilla Frappuccino" 
                                        data-price="720"
                                        data-image="https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>4-5 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ceylon Tea -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="tea" data-aos="fade-up" data-aos-delay="100">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1597318374671-96ee162414ca?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Ceylon Tea">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.7
                                </span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-success">
                                    <i class="bi bi-geo-alt"></i> Ceylon
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Premium Ceylon Tea</h5>
                            <p class="card-text text-muted">Authentic Sri Lankan black tea with rich flavor and golden color. A local favorite.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 380.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="7"
                                        data-name="Premium Ceylon Tea" 
                                        data-price="380"
                                        data-image="https://images.unsplash.com/photo-1597318374671-96ee162414ca?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>3-4 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hot Chocolate -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="tea" data-aos="fade-up" data-aos-delay="200">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1542990253-a781e04c0082?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Hot Chocolate">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.5
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Premium Hot Chocolate</h5>
                            <p class="card-text text-muted">Rich, creamy hot chocolate made with premium cocoa and topped with marshmallows.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 550.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="8"
                                        data-name="Premium Hot Chocolate" 
                                        data-price="550"
                                        data-image="https://images.unsplash.com/photo-1542990253-a781e04c0082?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>4-5 min
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Croissant -->
                <div class="col-lg-4 col-md-6 menu-item" data-category="food" data-aos="fade-up" data-aos-delay="300">
                    <div class="card menu-card h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=400&h=300&fit=crop"
                                 class="card-img-top" alt="Croissant">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> 4.6
                                </span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-warning">Fresh Baked</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-coffee">Butter Croissant</h5>
                            <p class="card-text text-muted">Flaky, buttery croissant baked fresh daily. Perfect with your morning coffee.</p>
                            <div class="price-section mb-3">
                                <span class="h5 text-coffee mb-0">Rs. 280.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-coffee btn-sm add-to-cart" 
                                        data-id="9"
                                        data-name="Butter Croissant" 
                                        data-price="280"
                                        data-image="https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=400&h=300&fit=crop">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>Ready now
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
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
