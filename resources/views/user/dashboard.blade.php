@extends('layouts.master')

@section('title', 'Dashboard - Café Elixir')
@section('description', 'Your personal coffee dashboard at Café Elixir. Track orders, reservations, and loyalty points.')

@section('content')
<!-- Dashboard Hero Section -->
<section class="dashboard-hero">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-8" data-aos="fade-up">
                <h1 class="display-5 fw-bold text-white mb-3">Welcome back, {{ $dashboardData['user']->name }}!</h1>
                <p class="lead text-white mb-4">
                    Your coffee journey continues. Track your orders, manage reservations, and enjoy exclusive member benefits.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('menu') }}" class="btn btn-coffee btn-lg">
                        <i class="bi bi-cup-hot me-2"></i>Order Coffee
                    </a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Book Table
                    </a>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="welcome-card">
                    <div class="text-center">
                        <div class="user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr($dashboardData['user']->name, 0, 1)) }}</span>
                            <div class="tier-badge">
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                        </div>
                        <h4 class="text-white mt-3 mb-2">{{ $dashboardData['stats']['current_tier'] }} Member</h4>
                        <p class="text-white-50 mb-3">{{ $dashboardData['stats']['loyalty_points'] }} loyalty points</p>
                        <div class="progress-container">
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: {{ isset($dashboardData['stats']['loyalty_points']) ? min(($dashboardData['stats']['loyalty_points'] / 1500) * 100, 100) : 0 }}%"></div>
                            </div>
                            <small class="text-white-50 mt-2 d-block">{{ $dashboardData['stats']['points_to_next_tier'] ?? 0 }} points to next tier</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $dashboardData['stats']['total_orders'] ?? 0 }}</h3>
                        <p>Total Orders</p>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> Active member
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($dashboardData['stats']['loyalty_points'] ?? 0) }}</h3>
                        <p>Loyalty Points</p>
                        <small class="text-info">
                            <i class="bi bi-gift"></i> {{ $dashboardData['stats']['current_tier'] ?? 'Bronze' }} tier
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $dashboardData['stats']['total_reservations'] ?? 0 }}</h3>
                        <p>Reservations</p>
                        <small class="text-primary">
                            <i class="bi bi-clock"></i> Upcoming: {{ count($dashboardData['upcoming_reservations'] ?? []) }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Rs. {{ number_format($dashboardData['stats']['total_spent'] ?? 0) }}</h3>
                        <p>Total Spent</p>
                        <small class="text-success">
                            <i class="bi bi-trending-up"></i> Great savings!
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Dashboard Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Recent Orders -->
            <div class="col-lg-8">
                <div class="dashboard-section">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-receipt me-2 text-coffee"></i>Recent Orders</h5>
                            <a href="{{ route('user.orders') }}" class="btn btn-outline-coffee btn-sm">
                                <i class="bi bi-eye me-2"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="section-body">
                        @if(isset($dashboardData['recent_orders']) && count($dashboardData['recent_orders']) > 0)
                            @foreach($dashboardData['recent_orders'] as $order)
                            <div class="order-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="order-info">
                                        <h6 class="mb-1">Order #{{ $order->order_id ?? 'ORD' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                        <p class="text-muted mb-1">{{ $order->created_at->format('M d, Y g:i A') }}</p>
                                        <small class="text-muted">{{ count($order->items ?? []) }} items</small>
                                    </div>
                                    <div class="order-status">
                                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'preparing' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <div class="text-end mt-1">
                                            <strong class="text-coffee">Rs. {{ number_format($order->total, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-actions mt-2">
                                    <button class="btn btn-outline-coffee btn-sm me-2" onclick="reorderItems({{ $order->id }})">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reorder
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye me-1"></i>Details
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-3">No orders yet</h6>
                                <p class="text-muted">Start your coffee journey with us!</p>
                                <a href="{{ route('menu') }}" class="btn btn-coffee">
                                    <i class="bi bi-cup-hot me-2"></i>Order Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="dashboard-section mt-4">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-calendar-check me-2 text-coffee"></i>Upcoming Reservations</h5>
                            <a href="{{ route('reservation') }}" class="btn btn-outline-coffee btn-sm">
                                <i class="bi bi-plus-circle me-2"></i>New Reservation
                            </a>
                        </div>
                    </div>
                    <div class="section-body">
                        @if(isset($dashboardData['upcoming_reservations']) && count($dashboardData['upcoming_reservations']) > 0)
                            @foreach($dashboardData['upcoming_reservations'] as $reservation)
                            <div class="reservation-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="reservation-info">
                                        <h6 class="mb-1">Reservation #{{ $reservation->reservation_id }}</h6>
                                        <p class="text-muted mb-1">
                                            {{ $reservation->reservation_date->format('M d, Y') }} at 
                                            {{ $reservation->reservation_time instanceof \Carbon\Carbon ? $reservation->reservation_time->format('g:i A') : $reservation->reservation_time }}
                                        </p>
                                        <small class="text-muted">{{ $reservation->guests }} {{ $reservation->guests == 1 ? 'guest' : 'guests' }}</small>
                                    </div>
                                    <div class="reservation-status">
                                        <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="reservation-actions mt-2">
                                    @if($reservation->status === 'confirmed')
                                        <button class="btn btn-outline-warning btn-sm me-2" onclick="requestReservationChange({{ $reservation->id }})">
                                            <i class="bi bi-pencil me-1"></i>Modify
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" onclick="cancelReservation({{ $reservation->id }})">
                                            <i class="bi bi-x-circle me-1"></i>Cancel
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-3">No upcoming reservations</h6>
                                <p class="text-muted">Book a table for your next visit!</p>
                                <a href="{{ route('reservation') }}" class="btn btn-coffee">
                                    <i class="bi bi-calendar-check me-2"></i>Make Reservation
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Loyalty Program -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h5><i class="bi bi-award me-2 text-warning"></i>Loyalty Program</h5>
                    </div>
                    <div class="section-body text-center">
                        <div class="loyalty-circle mb-3">
                            <div class="circle-progress" data-percentage="{{ isset($dashboardData['stats']['loyalty_points']) ? min(($dashboardData['stats']['loyalty_points'] / 1500) * 100, 100) : 0 }}">
                                <div class="circle-content">
                                    <span class="points">{{ $dashboardData['stats']['loyalty_points'] ?? 0 }}</span>
                                    <small>points</small>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-coffee mb-2">{{ $dashboardData['stats']['current_tier'] ?? 'Bronze' }} Member</h6>
                        <p class="text-muted mb-3">{{ $dashboardData['stats']['points_to_next_tier'] ?? 0 }} points to Platinum</p>
                        <button class="btn btn-outline-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#loyaltyModal">
                            <i class="bi bi-info-circle me-2"></i>View Details
                        </button>
                    </div>
                </div>

                <!-- Favorite Items -->
                <div class="dashboard-section mt-4">
                    <div class="section-header">
                        <h5><i class="bi bi-heart me-2 text-danger"></i>Your Favorites</h5>
                    </div>
                    <div class="section-body">
                        @if(isset($dashboardData['favorite_items']))
                            @foreach($dashboardData['favorite_items'] as $item)
                        <div class="favorite-item">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->image }}" class="favorite-image me-3" alt="{{ $item->name }}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->name }}</h6>
                                    <small class="text-muted">Ordered {{ $item->order_count }} times</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-coffee">Rs. {{ number_format($item->price, 2) }}</div>
                                    <button class="btn btn-coffee btn-sm mt-1 add-to-cart" 
                                            data-id="{{ $item->id ?? rand(1000, 9999) }}"
                                            data-name="{{ $item->name }}" 
                                            data-price="{{ $item->price }}"
                                            data-image="{{ $item->image }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-heart text-muted" style="font-size: 2rem;"></i>
                                <h6 class="text-muted mt-2">No favorites yet</h6>
                                <p class="text-muted small">Start ordering to build your favorites!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-section mt-4">
                    <div class="section-header">
                        <h5><i class="bi bi-lightning me-2 text-primary"></i>Quick Actions</h5>
                    </div>
                    <div class="section-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-coffee" onclick="reorderLast()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reorder Last Order
                            </button>
                            <a href="{{ route('menu') }}" class="btn btn-outline-coffee">
                                <i class="bi bi-journal-text me-2"></i>Browse Menu
                            </a>
                            <a href="{{ route('reservation') }}" class="btn btn-outline-coffee">
                                <i class="bi bi-calendar-plus me-2"></i>Book Table
                            </a>
                            <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bi bi-person-gear me-2"></i>Update Profile
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                @if(isset($dashboardData['pending_change_requests']) && ($dashboardData['pending_change_requests']['profile_changes'] > 0 || $dashboardData['pending_change_requests']['reservation_changes'] > 0))
                <div class="dashboard-section mt-4">
                    <div class="section-header">
                        <h5><i class="bi bi-clock-history me-2 text-warning"></i>Pending Requests</h5>
                    </div>
                    <div class="section-body">
                        @if(isset($dashboardData['pending_change_requests']['profile_changes']) && $dashboardData['pending_change_requests']['profile_changes'] > 0)
                        <div class="alert alert-warning">
                            <i class="bi bi-person-gear me-2"></i>
                            <strong>Profile Change Request</strong><br>
                            Your profile update is being reviewed by our team.
                        </div>
                        @endif
                        
                        @if(isset($dashboardData['pending_change_requests']['reservation_changes']) && $dashboardData['pending_change_requests']['reservation_changes'] > 0)
                        <div class="alert alert-info">
                            <i class="bi bi-calendar-event me-2"></i>
                            <strong>Reservation Change Request</strong><br>
                            Your reservation modification is being processed.
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Include Modals -->
@include('user.partials.dashboard-modals')

@push('styles')
<style>
    .dashboard-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1920&h=600&fit=crop') center/cover;
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

    .welcome-card {
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
        border: 3px solid rgba(255, 255, 255, 0.3);
        position: relative;
    }

    .avatar-text {
        font-size: 2rem;
        font-weight: 700;
        color: white;
    }

    .tier-badge {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 25px;
        height: 25px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .progress-container .progress {
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-content h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--coffee-primary);
        margin-bottom: 0.25rem;
    }

    .stat-content p {
        margin-bottom: 0.25rem;
        color: #6c757d;
        font-weight: 500;
    }

    .dashboard-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        overflow: hidden;
    }

    .section-header {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-bottom: 1px solid rgba(139, 69, 19, 0.1);
        padding: 1.5rem;
    }

    .section-header h5 {
        margin: 0;
        color: var(--coffee-primary);
        font-weight: 600;
    }

    .section-body {
        padding: 1.5rem;
    }

    .order-item, .reservation-item {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.3s ease;
    }

    .order-item:last-child, .reservation-item:last-child {
        border-bottom: none;
    }

    .order-item:hover, .reservation-item:hover {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    }

    .loyalty-circle {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }

    .circle-progress {
        width: 100px;
        height: 100px;
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
        width: 75px;
        height: 75px;
        background: white;
        border-radius: 50%;
    }

    .circle-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .points {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--coffee-primary);
    }

    .favorite-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
    }

    .favorite-item:last-child {
        border-bottom: none;
    }

    .favorite-image {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
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

    @media (max-width: 768px) {
        .dashboard-hero {
            min-height: 300px;
        }

        .welcome-card {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .section-header,
        .section-body {
            padding: 1rem;
        }

        .order-item,
        .reservation-item {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize loyalty circle progress
    const circleProgress = document.querySelector('.circle-progress');
    if (circleProgress) {
        const percentage = circleProgress.getAttribute('data-percentage');
        const degrees = (percentage / 100) * 360;
        circleProgress.style.background = `conic-gradient(var(--coffee-primary) 0deg, var(--coffee-primary) ${degrees}deg, #e9ecef ${degrees}deg)`;
    }

    // Real-time updates for reservations
    setInterval(checkReservationUpdates, 30000); // Check every 30 seconds
});

function reorderItems(orderId) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Adding...';
    button.disabled = true;

    // Simulate API call
    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
        button.classList.remove('btn-outline-coffee');
        button.classList.add('btn-success');

        showNotification('Order items added to cart!', 'success');

        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-coffee');
        }, 2000);
    }, 800);
}

function reorderLast() {
    fetch('/user/reorder-last', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Last order added to cart!', 'success');
        } else {
            showNotification(data.message || 'No previous orders found', 'warning');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to reorder. Please try again.', 'error');
    });
}

function requestReservationChange(reservationId) {
    // This would open a modal or redirect to reservation change form
    showNotification('Reservation change request feature coming soon!', 'info');
}

function cancelReservation(reservationId) {
    if (!confirm('Are you sure you want to cancel this reservation?')) {
        return;
    }

    fetch(`/user/reservations/${reservationId}/cancel`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation cancelled successfully', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to cancel reservation', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to cancel reservation. Please try again.', 'error');
    });
}

function checkReservationUpdates() {
    fetch('/user/reservation-updates')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.updates.length > 0) {
                data.updates.forEach(update => {
                    showNotification(`Reservation ${update.reservation_id} status updated to ${update.status}`, 'info');
                });
            }
        })
        .catch(error => {
            console.error('Error checking updates:', error);
        });
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