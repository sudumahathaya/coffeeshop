@extends('layouts.master')

@section('title', 'My Orders - Café Elixir')
@section('description', 'View your order history and track current orders at Café Elixir.')

@section('content')
<!-- Orders Hero Section -->
<section class="orders-hero">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-8" data-aos="fade-up">
                <h1 class="display-5 fw-bold text-white mb-3">My Orders</h1>
                <p class="lead text-white mb-4">
                    Track your coffee journey with us. View past orders, reorder favorites, and manage your coffee preferences.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('menu') }}" class="btn btn-coffee btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>New Order
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="orders-stats">
                    <div class="stat-item">
                        <h3>24</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="stat-item">
                        <h3>Rs. 28,500</h3>
                        <p>Total Spent</p>
                    </div>
                    <div class="stat-item">
                        <h3>1,250</h3>
                        <p>Points Earned</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Orders Content -->
<section class="py-5">
    <div class="container">
        <!-- Filter and Search -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Search orders..." id="orderSearch">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="completed">Completed</option>
                                    <option value="preparing">Preparing</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="dateFilter">
                                    <option value="">All Time</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-coffee w-100">
                                    <i class="bi bi-funnel"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-lg-end">
                    <button class="btn btn-outline-coffee me-2">
                        <i class="bi bi-download me-2"></i>Export Orders
                    </button>
                    <button class="btn btn-coffee">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reorder Last
                    </button>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row g-4" id="ordersList">
            <!-- Order 1 -->
            <div class="col-12" data-aos="fade-up">
                <div class="order-card">
                    <div class="order-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Order #CE2024001</h5>
                                <small class="text-muted">December 15, 2024 • 2:30 PM</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">Completed</span>
                                <div class="mt-1">
                                    <span class="h5 text-coffee mb-0">Rs. 1,240.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="order-items">
                                    <div class="item">
                                        <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=60&h=60&fit=crop" 
                                             class="item-image" alt="Cappuccino">
                                        <div class="item-details">
                                            <h6>Cappuccino</h6>
                                            <p class="text-muted">Quantity: 2 • Rs. 480.00 each</p>
                                        </div>
                                        <div class="item-total">
                                            <span class="fw-bold">Rs. 960.00</span>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="https://images.unsplash.com/photo-1555507036-ab794f4afe5b?w=60&h=60&fit=crop" 
                                             class="item-image" alt="Croissant">
                                        <div class="item-details">
                                            <h6>Butter Croissant</h6>
                                            <p class="text-muted">Quantity: 1 • Rs. 280.00 each</p>
                                        </div>
                                        <div class="item-total">
                                            <span class="fw-bold">Rs. 280.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="order-actions">
                                    <button class="btn btn-coffee btn-sm me-2">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reorder
                                    </button>
                                    <button class="btn btn-outline-coffee btn-sm me-2">
                                        <i class="bi bi-receipt me-1"></i>Receipt
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-star me-1"></i>Review
                                    </button>
                                </div>
                                <div class="order-info mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>Pickup: Counter
                                    </small><br>
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>Order completed
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order 2 -->
            <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                <div class="order-card">
                    <div class="order-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Order #CE2024002</h5>
                                <small class="text-muted">December 12, 2024 • 10:15 AM</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">Completed</span>
                                <div class="mt-1">
                                    <span class="h5 text-coffee mb-0">Rs. 850.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="order-items">
                                    <div class="item">
                                        <img src="https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=60&h=60&fit=crop" 
                                             class="item-image" alt="Latte">
                                        <div class="item-details">
                                            <h6>Café Latte</h6>
                                            <p class="text-muted">Quantity: 1 • Rs. 520.00 each</p>
                                        </div>
                                        <div class="item-total">
                                            <span class="fw-bold">Rs. 520.00</span>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=60&h=60&fit=crop" 
                                             class="item-image" alt="Sandwich">
                                        <div class="item-details">
                                            <h6>Club Sandwich</h6>
                                            <p class="text-muted">Quantity: 1 • Rs. 330.00 each</p>
                                        </div>
                                        <div class="item-total">
                                            <span class="fw-bold">Rs. 330.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="order-actions">
                                    <button class="btn btn-coffee btn-sm me-2">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reorder
                                    </button>
                                    <button class="btn btn-outline-coffee btn-sm me-2">
                                        <i class="bi bi-receipt me-1"></i>Receipt
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-star me-1"></i>Review
                                    </button>
                                </div>
                                <div class="order-info mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>Dine-in: Table 5
                                    </small><br>
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>Order completed
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5">
            <button class="btn btn-outline-coffee btn-lg" id="loadMoreOrders">
                <i class="bi bi-plus-circle me-2"></i>Load More Orders
            </button>
        </div>
    </div>
</section>

@push('styles')
<style>
    .orders-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1920&h=600&fit=crop') center/cover;
        position: relative;
        min-height: 400px;
    }

    .orders-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .orders-hero .container {
        position: relative;
        z-index: 2;
    }

    .orders-stats {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .stat-item {
        text-align: center;
        color: white;
    }

    .stat-item h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .order-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
    }

    .order-header {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-bottom: 1px solid rgba(139, 69, 19, 0.1);
        padding: 1.5rem;
    }

    .order-body {
        padding: 1.5rem;
    }

    .order-items {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border-radius: 10px;
        border: 1px solid rgba(139, 69, 19, 0.05);
    }

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-details h6 {
        margin-bottom: 0.25rem;
        color: var(--coffee-primary);
    }

    .item-details p {
        margin-bottom: 0;
        font-size: 0.875rem;
    }

    .item-total {
        text-align: right;
    }

    .order-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .order-info {
        text-align: right;
    }

    @media (max-width: 768px) {
        .orders-hero {
            min-height: 300px;
        }

        .orders-stats {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .order-header,
        .order-body {
            padding: 1rem;
        }

        .order-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .order-info {
            text-align: left;
            margin-top: 1rem;
        }

        .item {
            flex-direction: column;
            text-align: center;
        }

        .item-details,
        .item-total {
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Order search functionality
    const searchInput = document.getElementById('orderSearch');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const orderCards = document.querySelectorAll('.order-card');

        orderCards.forEach(card => {
            const orderText = card.textContent.toLowerCase();
            if (orderText.includes(searchTerm)) {
                card.closest('.col-12').style.display = 'block';
            } else {
                card.closest('.col-12').style.display = 'none';
            }
        });
    });

    // Reorder functionality
    document.querySelectorAll('.order-actions .btn-coffee').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.closest('.order-card').querySelector('h5').textContent;
            const originalText = this.innerHTML;
            
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Adding...';
            this.disabled = true;

            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
                this.classList.remove('btn-coffee');
                this.classList.add('btn-success');

                showNotification(`${orderId} items added to cart!`, 'success');

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-coffee');
                }, 2000);
            }, 800);
        });
    });

    // Load more orders
    document.getElementById('loadMoreOrders').addEventListener('click', function() {
        const button = this;
        const originalText = button.innerHTML;
        
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        button.disabled = true;

        setTimeout(() => {
            // Add more orders (simulation)
            const ordersList = document.getElementById('ordersList');
            const newOrder = `
                <div class="col-12" style="opacity: 0; transform: translateY(20px);">
                    <div class="order-card">
                        <div class="order-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">Order #CE2024004</h5>
                                    <small class="text-muted">December 8, 2024 • 3:20 PM</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">Completed</span>
                                    <div class="mt-1">
                                        <span class="h5 text-coffee mb-0">Rs. 1,080.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-body">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="order-items">
                                        <div class="item">
                                            <img src="https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=60&h=60&fit=crop" 
                                                 class="item-image" alt="Frappuccino">
                                            <div class="item-details">
                                                <h6>Vanilla Frappuccino</h6>
                                                <p class="text-muted">Quantity: 1 • Rs. 720.00 each</p>
                                            </div>
                                            <div class="item-total">
                                                <span class="fw-bold">Rs. 720.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="order-actions">
                                        <button class="btn btn-coffee btn-sm me-2">
                                            <i class="bi bi-arrow-clockwise me-1"></i>Reorder
                                        </button>
                                        <button class="btn btn-outline-coffee btn-sm me-2">
                                            <i class="bi bi-receipt me-1"></i>Receipt
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            ordersList.insertAdjacentHTML('beforeend', newOrder);

            // Animate new order
            const newOrderElement = ordersList.lastElementChild;
            setTimeout(() => {
                newOrderElement.style.transition = 'all 0.5s ease';
                newOrderElement.style.opacity = '1';
                newOrderElement.style.transform = 'translateY(0)';
            }, 100);

            button.innerHTML = originalText;
            button.disabled = false;
            
            showNotification('More orders loaded!', 'success');
        }, 1000);
    });
});
</script>
@endpush
@endsection