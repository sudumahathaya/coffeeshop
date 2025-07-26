@extends('layouts.master')

@section('title', 'My Dashboard - Café Elixir')
@section('description', 'Manage your account, view orders, track loyalty points, and more at Café Elixir.')

@section('content')
<!-- Dashboard Hero Section -->
<section class="dashboard-hero">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-8">
                <div class="welcome-content" data-aos="fade-up">
                    <h1 class="display-5 fw-bold text-white mb-3">
                        Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! ☕
                    </h1>
                    <p class="lead text-white mb-4">
                        Your coffee journey continues here. Manage your orders, track rewards, and discover new favorites.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('menu') }}" class="btn btn-coffee btn-lg">
                            <i class="bi bi-cup-hot me-2"></i>Order Coffee
                        </a>
                        <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Book Table
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="user-stats-card">
                    <div class="text-center">
                        <div class="user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <h5 class="text-white mt-3 mb-2">{{ Auth::user()->name }}</h5>
                        <p class="text-white-50 mb-3">{{ Auth::user()->email }}</p>
                        
                        <div class="loyalty-badge">
                            <i class="bi bi-star-fill text-warning me-2"></i>
                            <span class="text-white">Gold Member</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">24</h3>
                        <p class="stat-label">Total Orders</p>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +3 this month
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">1,250</h3>
                        <p class="stat-label">Loyalty Points</p>
                        <small class="text-info">
                            <i class="bi bi-gift"></i> 250 points to next reward
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">8</h3>
                        <p class="stat-label">Reservations</p>
                        <small class="text-primary">
                            <i class="bi bi-clock"></i> 1 upcoming
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">12</h3>
                        <p class="stat-label">Favorite Items</p>
                        <small class="text-muted">
                            <i class="bi bi-cup-hot"></i> Cappuccino is #1
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Dashboard Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Recent Orders -->
                <div class="dashboard-card mb-4" data-aos="fade-up">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-receipt me-2 text-coffee"></i>Recent Orders
                            </h5>
                            <a href="#" class="btn btn-outline-coffee btn-sm">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="order-list">
                            <!-- Order Item 1 -->
                            <div class="order-item">
                                <div class="d-flex align-items-center">
                                    <div class="order-icon">
                                        <i class="bi bi-cup-hot text-coffee"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Order #CE2024001</h6>
                                        <p class="text-muted mb-1">Cappuccino x2, Croissant x1</p>
                                        <small class="text-muted">December 15, 2024 • 2:30 PM</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="h6 text-coffee mb-0">Rs. 1,240</span>
                                        <br>
                                        <span class="badge bg-success">Completed</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Item 2 -->
                            <div class="order-item">
                                <div class="d-flex align-items-center">
                                    <div class="order-icon">
                                        <i class="bi bi-cup text-coffee"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Order #CE2024002</h6>
                                        <p class="text-muted mb-1">Latte x1, Sandwich x1</p>
                                        <small class="text-muted">December 12, 2024 • 10:15 AM</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="h6 text-coffee mb-0">Rs. 850</span>
                                        <br>
                                        <span class="badge bg-success">Completed</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Item 3 -->
                            <div class="order-item">
                                <div class="d-flex align-items-center">
                                    <div class="order-icon">
                                        <i class="bi bi-snow text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Order #CE2024003</h6>
                                        <p class="text-muted mb-1">Iced Coffee x1, Muffin x2</p>
                                        <small class="text-muted">December 10, 2024 • 4:45 PM</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="h6 text-coffee mb-0">Rs. 920</span>
                                        <br>
                                        <span class="badge bg-success">Completed</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-coffee" onclick="loadMoreOrders()">
                                <i class="bi bi-plus-circle me-2"></i>Load More Orders
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="dashboard-card mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar-event me-2 text-coffee"></i>Upcoming Reservations
                            </h5>
                            <a href="{{ route('reservation') }}" class="btn btn-outline-coffee btn-sm">New Reservation</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="reservation-item">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="reservation-date">
                                            <span class="date-day">22</span>
                                            <span class="date-month">Dec</span>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1">Table for 4 People</h6>
                                            <p class="text-muted mb-1">
                                                <i class="bi bi-clock me-1"></i>6:30 PM
                                                <i class="bi bi-geo-alt ms-3 me-1"></i>Window Side Table
                                            </p>
                                            <small class="text-success">
                                                <i class="bi bi-check-circle me-1"></i>Confirmed
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button class="btn btn-outline-primary btn-sm me-2">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                You can cancel or modify your reservation up to 2 hours before the scheduled time.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Favorite Items -->
                <div class="dashboard-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-heart-fill me-2 text-danger"></i>Your Favorite Items
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="favorite-item">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=80&h=80&fit=crop"
                                             class="favorite-image" alt="Cappuccino">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-1">Cappuccino</h6>
                                            <p class="text-muted mb-1">Rs. 480.00</p>
                                            <small class="text-success">Ordered 8 times</small>
                                        </div>
                                        <button class="btn btn-coffee btn-sm add-to-cart"
                                                data-id="fav-1"
                                                data-name="Cappuccino"
                                                data-price="480"
                                                data-image="https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=80&h=80&fit=crop">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="favorite-item">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=80&h=80&fit=crop"
                                             class="favorite-image" alt="Latte">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-1">Café Latte</h6>
                                            <p class="text-muted mb-1">Rs. 520.00</p>
                                            <small class="text-success">Ordered 6 times</small>
                                        </div>
                                        <button class="btn btn-coffee btn-sm add-to-cart"
                                                data-id="fav-2"
                                                data-name="Café Latte"
                                                data-price="520"
                                                data-image="https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=80&h=80&fit=crop">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="favorite-item">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=80&h=80&fit=crop"
                                             class="favorite-image" alt="Caramel Macchiato">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-1">Caramel Macchiato</h6>
                                            <p class="text-muted mb-1">Rs. 650.00</p>
                                            <small class="text-success">Ordered 4 times</small>
                                        </div>
                                        <button class="btn btn-coffee btn-sm add-to-cart"
                                                data-id="fav-3"
                                                data-name="Caramel Macchiato"
                                                data-price="650"
                                                data-image="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=80&h=80&fit=crop">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="favorite-item">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=80&h=80&fit=crop"
                                             class="favorite-image" alt="Croissant">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-1">Butter Croissant</h6>
                                            <p class="text-muted mb-1">Rs. 280.00</p>
                                            <small class="text-success">Ordered 5 times</small>
                                        </div>
                                        <button class="btn btn-coffee btn-sm add-to-cart"
                                                data-id="fav-4"
                                                data-name="Butter Croissant"
                                                data-price="280"
                                                data-image="https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=80&h=80&fit=crop">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Loyalty Program Card -->
                <div class="dashboard-card mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-award me-2 text-warning"></i>Loyalty Program
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="loyalty-circle mb-3">
                            <div class="circle-progress" data-percentage="75">
                                <div class="circle-content">
                                    <span class="percentage">75%</span>
                                    <small>to Gold+</small>
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="text-coffee mb-2">Gold Member</h6>
                        <p class="text-muted mb-3">1,250 / 1,500 points</p>
                        
                        <div class="loyalty-benefits">
                            <div class="benefit-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>15% discount on all orders</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Free birthday coffee</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Priority reservations</span>
                            </div>
                        </div>

                        <button class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#loyaltyModal">
                            <i class="bi bi-info-circle me-2"></i>Learn More
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-card mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning me-2 text-warning"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <button class="btn btn-coffee" onclick="reorderLast()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reorder Last Order
                            </button>
                            <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bi bi-person-gear me-2"></i>Update Profile
                            </button>
                            <button class="btn btn-outline-coffee" onclick="downloadReceipts()">
                                <i class="bi bi-download me-2"></i>Download Receipts
                            </button>
                            <a href="{{ route('contact') }}" class="btn btn-outline-coffee">
                                <i class="bi bi-headset me-2"></i>Contact Support
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Special Offers -->
                <div class="dashboard-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-gift me-2 text-danger"></i>Special Offers
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="offer-item">
                            <div class="offer-badge">
                                <span class="badge bg-danger">20% OFF</span>
                            </div>
                            <h6 class="mb-2">Happy Hour Special</h6>
                            <p class="text-muted mb-2">Get 20% off all hot drinks from 2-5 PM</p>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>Valid until Dec 31, 2024
                            </small>
                        </div>

                        <div class="offer-item">
                            <div class="offer-badge">
                                <span class="badge bg-success">FREE</span>
                            </div>
                            <h6 class="mb-2">Birthday Treat</h6>
                            <p class="text-muted mb-2">Free coffee on your birthday month</p>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>Available all year
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
@include('user.partials.dashboard-modals')

@push('styles')
<style>
    .dashboard-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=1920&h=600&fit=crop') center/cover;
        position: relative;
        min-height: 400px;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .dashboard-hero .container {
        position: relative;
        z-index: 2;
    }

    .user-stats-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .avatar-text {
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }

    .loyalty-badge {
        background: rgba(255, 193, 7, 0.2);
        border: 1px solid rgba(255, 193, 7, 0.5);
        border-radius: 25px;
        padding: 0.5rem 1rem;
        display: inline-block;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-content {
        flex-grow: 1;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--coffee-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .dashboard-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.12);
    }

    .dashboard-card .card-header {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-bottom: 1px solid rgba(139, 69, 19, 0.1);
        padding: 1.5rem;
    }

    .dashboard-card .card-body {
        padding: 1.5rem;
    }

    .order-item {
        padding: 1.5rem;
        border-radius: 15px;
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border: 1px solid rgba(139, 69, 19, 0.05);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
    }

    .order-item:last-child {
        margin-bottom: 0;
    }

    .order-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.1), rgba(210, 105, 30, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 1rem;
    }

    .reservation-item {
        padding: 1.5rem;
        border-radius: 15px;
        background: linear-gradient(45deg, rgba(40, 167, 69, 0.05), rgba(25, 135, 84, 0.05));
        border: 1px solid rgba(40, 167, 69, 0.1);
    }

    .reservation-date {
        background: var(--coffee-primary);
        color: white;
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        min-width: 70px;
    }

    .date-day {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .date-month {
        display: block;
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .favorite-item {
        padding: 1rem;
        border-radius: 15px;
        background: linear-gradient(45deg, rgba(220, 53, 69, 0.05), rgba(214, 51, 132, 0.05));
        border: 1px solid rgba(220, 53, 69, 0.1);
        transition: all 0.3s ease;
    }

    .favorite-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.1);
    }

    .favorite-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
    }

    .loyalty-circle {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .circle-progress {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(var(--coffee-primary) 0deg, var(--coffee-primary) 270deg, #e9ecef 270deg);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .circle-progress::before {
        content: '';
        position: absolute;
        width: 90px;
        height: 90px;
        background: white;
        border-radius: 50%;
    }

    .circle-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .percentage {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--coffee-primary);
    }

    .benefit-item {
        text-align: left;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .offer-item {
        position: relative;
        padding: 1.5rem;
        border-radius: 15px;
        background: linear-gradient(45deg, rgba(220, 53, 69, 0.05), rgba(255, 193, 7, 0.05));
        border: 1px solid rgba(220, 53, 69, 0.1);
        margin-bottom: 1rem;
    }

    .offer-item:last-child {
        margin-bottom: 0;
    }

    .offer-badge {
        position: absolute;
        top: -10px;
        right: 15px;
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
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
        color: white;
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

    .text-coffee {
        color: var(--coffee-primary) !important;
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            min-height: 300px;
        }

        .user-stats-card {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .stat-card {
            padding: 1.5rem;
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .stat-icon {
            margin: 0 auto;
        }

        .dashboard-card .card-header,
        .dashboard-card .card-body {
            padding: 1rem;
        }

        .order-item,
        .reservation-item {
            padding: 1rem;
        }

        .loyalty-circle {
            width: 100px;
            height: 100px;
        }

        .circle-progress {
            width: 100px;
            height: 100px;
        }

        .circle-progress::before {
            width: 75px;
            height: 75px;
        }
    }

    /* Loading animations */
    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Start real-time updates for user dashboard
    startUserDashboardUpdates();
    
    // Initialize loyalty circle progress
    const circleProgress = document.querySelector('.circle-progress');
    if (circleProgress) {
        const percentage = circleProgress.getAttribute('data-percentage');
        const degrees = (percentage / 100) * 360;
        circleProgress.style.background = `conic-gradient(var(--coffee-primary) 0deg, var(--coffee-primary) ${degrees}deg, #e9ecef ${degrees}deg)`;
    }

    // Animate stats on scroll
    const statNumbers = document.querySelectorAll('.stat-number');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });

    statNumbers.forEach(stat => observer.observe(stat));

    function animateNumber(element) {
        const target = parseInt(element.textContent.replace(/,/g, ''));
        const increment = target / 50;
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 30);
    }

    // Add to cart functionality is now handled by cart.js

    // Order item hover effects
    document.querySelectorAll('.order-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Stat card hover effects
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Real-time updates for user dashboard
function startUserDashboardUpdates() {
    updateUserDashboard();
    
    // Update every 60 seconds
    setInterval(updateUserDashboard, 60000);
}

function updateUserDashboard() {
    // Check for reservation status updates
    fetch('/api/user/reservations/status')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.updates.length > 0) {
                data.updates.forEach(update => {
                    if (update.status === 'confirmed') {
                        showNotification(`Your reservation #${update.reservation_id} has been confirmed!`, 'success');
                        updateReservationStatus(update.reservation_id, 'confirmed');
                    } else if (update.status === 'cancelled') {
                        showNotification(`Your reservation #${update.reservation_id} has been cancelled.`, 'warning');
                        updateReservationStatus(update.reservation_id, 'cancelled');
                    }
                });
            }
        })
        .catch(error => {
            console.error('Failed to check reservation updates:', error);
        });
}

function updateReservationStatus(reservationId, status) {
    const reservationElement = document.querySelector(`[data-reservation-id="${reservationId}"]`);
    if (reservationElement) {
        const statusBadge = reservationElement.querySelector('.badge');
        if (statusBadge) {
            statusBadge.className = `badge bg-${status === 'confirmed' ? 'success' : status === 'cancelled' ? 'danger' : 'warning'}`;
            statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }
    }
}

// Quick action functions
function reorderLast() {
    showNotification('Reordering your last order...', 'info');
    
    setTimeout(() => {
        showNotification('Order #CE2024001 has been added to your cart!', 'success');
    }, 1500);
}

function downloadReceipts() {
    showNotification('Preparing your receipt download...', 'info');
    
    setTimeout(() => {
        // Create a mock download
        const link = document.createElement('a');
        link.href = 'data:text/plain;charset=utf-8,Café Elixir - Receipt History\n\nOrder #CE2024001 - Rs. 1,240\nOrder #CE2024002 - Rs. 850\nOrder #CE2024003 - Rs. 920\n\nTotal: Rs. 3,010';
        link.download = 'cafe-elixir-receipts.txt';
        link.click();
        
        showNotification('Receipt history downloaded successfully!', 'success');
    }, 1000);
}

function loadMoreOrders() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
    button.disabled = true;

    setTimeout(() => {
        // Add more orders to the list
        const orderList = document.querySelector('.order-list');
        const newOrders = `
            <div class="order-item" style="opacity: 0; transform: translateY(20px);">
                <div class="d-flex align-items-center">
                    <div class="order-icon">
                        <i class="bi bi-cup-straw text-info"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Order #CE2024004</h6>
                        <p class="text-muted mb-1">Frappuccino x1, Cookie x2</p>
                        <small class="text-muted">December 8, 2024 • 3:20 PM</small>
                    </div>
                    <div class="text-end">
                        <span class="h6 text-coffee mb-0">Rs. 1,080</span>
                        <br>
                        <span class="badge bg-success">Completed</span>
                    </div>
                </div>
            </div>
        `;

        orderList.insertAdjacentHTML('beforeend', newOrders);

        // Animate new orders
        const newOrderElements = orderList.querySelectorAll('.order-item[style*="opacity: 0"]');
        newOrderElements.forEach((order, index) => {
            setTimeout(() => {
                order.style.transition = 'all 0.5s ease';
                order.style.opacity = '1';
                order.style.transform = 'translateY(0)';
            }, index * 100);
        });

        button.innerHTML = originalText;
        button.disabled = false;
        
        showNotification('More orders loaded!', 'success');
    }, 1000);
}

// Notification function
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
    `;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'warning' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
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
    }, 4000);
}

// CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .notification-toast {
        backdrop-filter: blur(10px);
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection