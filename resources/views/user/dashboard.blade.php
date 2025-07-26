@extends('layouts.master')

@section('title', 'Dashboard - Café Elixir')
@section('description', 'Your personal dashboard at Café Elixir. Track orders, manage reservations, and view loyalty points.')

@section('content')
<!-- Dashboard Hero Section -->
<section class="dashboard-hero">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-8" data-aos="fade-up">
                <h1 class="display-5 fw-bold text-white mb-3">Welcome back, {{ $user->name }}!</h1>
                <p class="lead text-white mb-4">
                    Your coffee journey continues. Track your orders, manage reservations, and enjoy exclusive member benefits.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('menu') }}" class="btn btn-coffee btn-lg">
                        <i class="bi bi-cup-hot me-2"></i>Order Coffee
                    </a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-plus me-2"></i>New Reservation
                    </a>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="welcome-card">
                    <div class="text-center">
                        <div class="user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <div class="loyalty-badge">
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                        </div>
                        <h4 class="text-white mt-3 mb-2">{{ $dashboardData['stats']['current_tier'] }} Member</h4>
                        <p class="text-white-50 mb-3">{{ $dashboardData['stats']['loyalty_points'] }} loyalty points</p>
                        <div class="member-since">
                            <small class="text-white-50">Member since {{ $user->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Stats -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $dashboardData['stats']['total_orders'] }}</h3>
                        <p>Total Orders</p>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> +2 this week
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ number_format($dashboardData['stats']['loyalty_points']) }}</h3>
                        <p>Loyalty Points</p>
                        <small class="text-info">
                            <i class="bi bi-info-circle"></i> {{ $dashboardData['stats']['points_to_next_tier'] }} to next tier
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
                        <h3>{{ $dashboardData['stats']['total_reservations'] }}</h3>
                        <p>Reservations</p>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> Next: Dec 22
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Rs. {{ number_format($dashboardData['stats']['total_spent']) }}</h3>
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
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Recent Orders -->
                <div class="dashboard-section mb-4" data-aos="fade-up">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-receipt me-2 text-coffee"></i>Recent Orders</h5>
                            <a href="{{ route('user.orders') }}" class="btn btn-outline-coffee btn-sm">
                                <i class="bi bi-eye me-2"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="section-body">
                        @forelse($dashboardData['recent_orders'] as $order)
                        <div class="order-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="order-icon">
                                        <i class="bi bi-cup-hot"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">Order #{{ $order->order_id ?? 'CE' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-coffee">Rs. {{ number_format($order->total, 2) }}</span>
                                    <div>
                                        <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No orders yet</p>
                            <a href="{{ route('menu') }}" class="btn btn-coffee">
                                <i class="bi bi-cup-hot me-2"></i>Order Now
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="dashboard-section" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-calendar-check me-2 text-coffee"></i>Upcoming Reservations</h5>
                            <a href="{{ route('reservation') }}" class="btn btn-outline-coffee btn-sm">
                                <i class="bi bi-calendar-plus me-2"></i>New Reservation
                            </a>
                        </div>
                    </div>
                    <div class="section-body">
                        @forelse($dashboardData['upcoming_reservations'] as $reservation)
                        <div class="reservation-item">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="reservation-date">
                                            <div class="date-number">{{ $reservation->reservation_date->format('d') }}</div>
                                            <div class="date-month">{{ $reservation->reservation_date->format('M') }}</div>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1">Table for {{ $reservation->guests }} {{ $reservation->guests == 1 ? 'Person' : 'People' }}</h6>
                                            <p class="text-muted mb-1">
                                                <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                                                @if($reservation->table_type)
                                                    • <i class="bi bi-geo-alt me-1"></i>{{ ucfirst($reservation->table_type) }} Table
                                                @endif
                                            </p>
                                            <small class="text-muted">Reservation #{{ $reservation->reservation_id }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-md-end">
                                        <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                        <div class="mt-2">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" onclick="editReservation({{ $reservation->id }})">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button class="btn btn-outline-danger" onclick="cancelReservation({{ $reservation->id }})">
                                                    <i class="bi bi-x"></i> Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No upcoming reservations</p>
                            <a href="{{ route('reservation') }}" class="btn btn-coffee">
                                <i class="bi bi-calendar-plus me-2"></i>Make Reservation
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Loyalty Status -->
                <div class="dashboard-section mb-4" data-aos="fade-up">
                    <div class="section-header">
                        <h5><i class="bi bi-award me-2 text-warning"></i>Loyalty Status</h5>
                    </div>
                    <div class="section-body text-center">
                        <div class="loyalty-circle mb-3">
                            <div class="circle-progress" data-percentage="83">
                                <div class="circle-content">
                                    <span class="percentage">83%</span>
                                    <small>to Platinum</small>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-coffee mb-2">{{ $dashboardData['stats']['current_tier'] }} Member</h6>
                        <p class="text-muted mb-3">{{ number_format($dashboardData['stats']['loyalty_points']) }} / 1,500 points</p>
                        <button class="btn btn-outline-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#loyaltyModal">
                            <i class="bi bi-info-circle me-2"></i>View Details
                        </button>
                    </div>
                </div>

                <!-- Favorite Items -->
                <div class="dashboard-section mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-header">
                        <h5><i class="bi bi-heart me-2 text-danger"></i>Favorite Items</h5>
                    </div>
                    <div class="section-body">
                        @foreach($dashboardData['favorite_items'] as $item)
                        <div class="favorite-item">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->image }}" class="favorite-image" alt="{{ $item->name }}">
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-1">{{ $item->name }}</h6>
                                    <small class="text-muted">Ordered {{ $item->order_count }} times</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-coffee">Rs. {{ number_format($item->price, 2) }}</span>
                                    <div>
                                        <button class="btn btn-coffee btn-sm add-to-cart" 
                                                data-id="{{ $item->id ?? rand(1, 100) }}"
                                                data-name="{{ $item->name }}" 
                                                data-price="{{ $item->price }}"
                                                data-image="{{ $item->image }}">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-section" data-aos="fade-up" data-aos-delay="200">
                    <div class="section-header">
                        <h5><i class="bi bi-lightning me-2 text-primary"></i>Quick Actions</h5>
                    </div>
                    <div class="section-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-person-gear me-2"></i>Edit Profile
                            </button>
                            <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key me-2"></i>Change Password
                            </button>
                            <button class="btn btn-outline-coffee" onclick="reorderLast()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reorder Last
                            </button>
                            <a href="{{ route('contact') }}" class="btn btn-outline-coffee">
                                <i class="bi bi-headset me-2"></i>Contact Support
                            </a>
                        </div>
                    </div>
                </div>
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
        width: 100px;
        height: 100px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid rgba(255, 255, 255, 0.3);
        position: relative;
    }

    .avatar-text {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
    }

    .loyalty-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 30px;
        height: 30px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
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
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .stat-content h3 {
        color: var(--coffee-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .stat-content p {
        color: #6c757d;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .dashboard-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dashboard-section:hover {
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.12);
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

    .order-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .reservation-item {
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.5s ease;
    }

    .reservation-item:last-child {
        border-bottom: none;
    }

    .reservation-item.cancelling {
        opacity: 0.5;
        pointer-events: none;
    }

    .reservation-date {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }

    .date-number {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .date-month {
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
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
        background: conic-gradient(var(--coffee-primary) 0deg, var(--coffee-primary) 299deg, #e9ecef 299deg);
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

        .welcome-card {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
        }

        .avatar-text {
            font-size: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
            flex-direction: column;
            text-align: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .section-header,
        .section-body {
            padding: 1rem;
        }

        .reservation-item {
            padding: 1rem 0;
        }

        .btn-group-sm .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
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

    // Check for pending reservation change requests
    checkReservationStatus();
});

function editReservation(reservationId) {
    // Set minimum date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    document.getElementById('editReservationDate').min = tomorrow.toISOString().split('T')[0];
    
    // Set reservation ID
    document.getElementById('editReservationId').value = reservationId;
    
    // Load current reservation data
    fetch(`/admin/reservations/${reservationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const reservation = data.reservation;
                document.getElementById('editReservationDate').value = reservation.reservation_date;
                document.getElementById('editReservationTime').value = reservation.reservation_time;
                document.getElementById('editGuests').value = reservation.guests;
                document.getElementById('editTableType').value = reservation.table_type || '';
                document.getElementById('editOccasion').value = reservation.occasion || '';
                document.getElementById('editSpecialRequests').value = reservation.special_requests || '';
            }
        })
        .catch(error => {
            console.error('Error loading reservation:', error);
            // Set default values if loading fails
            document.getElementById('editReservationDate').value = '';
            document.getElementById('editReservationTime').value = '';
            document.getElementById('editGuests').value = '';
            document.getElementById('editTableType').value = '';
            document.getElementById('editOccasion').value = '';
            document.getElementById('editSpecialRequests').value = '';
        });
    
    const modal = new bootstrap.Modal(document.getElementById('editReservationModal'));
    modal.show();
}

function cancelReservation(reservationId) {
    if (!confirm('Are you sure you want to cancel this reservation? This action cannot be undone.')) {
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Cancelling...';
    button.disabled = true;

    fetch(`/admin/reservations/${reservationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation cancelled successfully!', 'success');
            
            // Remove the reservation item from the UI
            const reservationItem = button.closest('.reservation-item');
            if (reservationItem) {
                reservationItem.style.transition = 'all 0.3s ease';
                reservationItem.style.opacity = '0';
                reservationItem.style.transform = 'translateX(-100%)';
                
                setTimeout(() => {
                    reservationItem.remove();
                    
                    // Check if no reservations left
                    const remainingReservations = document.querySelectorAll('.reservation-item');
                    if (remainingReservations.length === 0) {
                        const sectionBody = document.querySelector('.dashboard-section .section-body');
                        sectionBody.innerHTML = `
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">No upcoming reservations</p>
                                <a href="{{ route('reservation') }}" class="btn btn-coffee">
                                    <i class="bi bi-calendar-plus me-2"></i>Make Reservation
                                </a>
                            </div>
                        `;
                    }
                }, 300);
            }
        } else {
            showNotification(data.message || 'Failed to cancel reservation', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while cancelling the reservation', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function submitReservationEdit() {
    const form = document.getElementById('editReservationForm');
    const formData = new FormData(form);
    const reservationId = document.getElementById('editReservationId').value;
    const submitButton = event.target;
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
    submitButton.disabled = true;

    // Convert FormData to JSON
    const data = {};
    formData.forEach((value, key) => {
        if (key !== 'reservation_id') {
            data[key] = value;
        }
    });

    fetch(`/reservation-change-requests/${reservationId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation change request submitted successfully!', 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editReservationModal'));
            modal.hide();
            
            // Show status message
            showReservationStatus('pending', 'Your reservation change request is pending admin approval.');
            
            // Reset form
            form.reset();
        } else {
            showNotification(data.message || 'Failed to submit request', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while submitting the request', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function checkReservationStatus() {
    // Check if there's a pending reservation change request
    const reservations = document.querySelectorAll('.reservation-item');
    if (reservations.length > 0) {
        const firstReservationId = 1; // You might need to get this dynamically
        
        fetch(`/reservation-change-requests/${firstReservationId}/status`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.has_pending_request) {
                    showReservationStatus('pending', 'You have a pending reservation change request awaiting admin approval.');
                }
            })
            .catch(error => {
                console.error('Error checking reservation status:', error);
            });
    }
}

function showReservationStatus(status, message) {
    const statusDiv = document.getElementById('reservationStatus');
    const statusMessage = document.getElementById('statusMessage');
    
    if (statusDiv && statusMessage) {
        statusDiv.className = `alert alert-${status === 'pending' ? 'warning' : status === 'approved' ? 'success' : 'danger'}`;
        statusMessage.textContent = message;
        statusDiv.style.display = 'block';
    }
}

function reorderLast() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding to Cart...';
    button.disabled = true;

    fetch('/user/reorder-last', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
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
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'warning' ? 'exclamation-triangle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
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

<!-- Edit Reservation Modal -->
<div class="modal fade" id="editReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>Request Reservation Changes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> Changes to your reservation require admin approval. You will be notified once your request is reviewed.
                </div>
                
                <div id="reservationStatus" class="alert alert-info" style="display: none;">
                    <i class="bi bi-info-circle me-2"></i>
                    <span id="statusMessage"></span>
                </div>
                
                <form id="editReservationForm">
                    @csrf
                    <input type="hidden" id="editReservationId" name="reservation_id">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editReservationDate" class="form-label fw-semibold">
                                <i class="bi bi-calendar3 me-2"></i>Date *
                            </label>
                            <input type="date" class="form-control form-control-lg" id="editReservationDate" name="reservation_date" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editReservationTime" class="form-label fw-semibold">
                                <i class="bi bi-clock me-2"></i>Time *
                            </label>
                            <select class="form-select form-select-lg" id="editReservationTime" name="reservation_time" required>
                                <option value="">Select Time</option>
                                @for($hour = 6; $hour <= 22; $hour++)
                                    @for($minute = 0; $minute < 60; $minute += 30)
                                        @php
                                            $time = sprintf('%02d:%02d', $hour, $minute);
                                            $displayTime = date('g:i A', strtotime($time));
                                        @endphp
                                        <option value="{{ $time }}">{{ $displayTime }}</option>
                                    @endfor
                                @endfor
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editGuests" class="form-label fw-semibold">
                                <i class="bi bi-people me-2"></i>Number of Guests *
                            </label>
                            <select class="form-select form-select-lg" id="editGuests" name="guests" required>
                                <option value="">Select Guests</option>
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Person' : 'People' }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editTableType" class="form-label fw-semibold">
                                <i class="bi bi-grid-3x3-gap me-2"></i>Table Preference
                            </label>
                            <select class="form-select form-select-lg" id="editTableType" name="table_type">
                                <option value="">No Preference</option>
                                <option value="window">Window Side</option>
                                <option value="corner">Corner Table</option>
                                <option value="center">Center Area</option>
                                <option value="outdoor">Outdoor Seating</option>
                                <option value="private">Private Section</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="editOccasion" class="form-label fw-semibold">
                                <i class="bi bi-balloon-heart me-2"></i>Occasion
                            </label>
                            <select class="form-select form-select-lg" id="editOccasion" name="occasion">
                                <option value="">Select Occasion</option>
                                <option value="birthday">Birthday</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="business">Business Meeting</option>
                                <option value="date">Date</option>
                                <option value="family">Family Gathering</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="editSpecialRequests" class="form-label fw-semibold">
                                <i class="bi bi-pencil-square me-2"></i>Special Requests
                            </label>
                            <textarea class="form-control" id="editSpecialRequests" name="special_requests" rows="3" 
                                      placeholder="Any special requirements..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="submitReservationEdit()">
                    <i class="bi bi-send me-2"></i>Submit Request
                </button>
            </div>
        </div>
    </div>
</div>