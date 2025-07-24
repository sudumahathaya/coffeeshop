@extends('layouts.admin')

@section('title', 'Admin Dashboard - Café Elixir')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-muted">Welcome back! Here's what's happening at Café Elixir today.</p>
        </div>
        <div>
            <span class="badge bg-success fs-6">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                System Online
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Users</div>
                            <div class="h4 mb-0">{{ number_format($stats['total_users']) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +{{ $stats['new_users_today'] }} today
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Reservations</div>
                            <div class="h4 mb-0">{{ number_format($stats['total_reservations']) }}</div>
                            <div class="text-warning small">
                                <i class="bi bi-clock"></i> {{ $stats['pending_reservations'] }} pending
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Today's Revenue</div>
                            <div class="h4 mb-0">Rs. {{ number_format($stats['revenue_today'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-trending-up"></i> +12.5%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Monthly Revenue</div>
                            <div class="h4 mb-0">Rs. {{ number_format($stats['revenue_month'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +8.2%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Daily Sales Overview</h5>
                    <p class="text-muted small mb-0">Revenue trends for the past week</p>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Popular Items</h5>
                    <p class="text-muted small mb-0">Most ordered items today</p>
                </div>
                <div class="card-body">
                    @foreach($stats['popular_items'] as $item)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">{{ $item['name'] }}</h6>
                            <small class="text-muted">{{ $item['orders'] }} orders</small>
                        </div>
                        <div class="progress" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-coffee" style="width: {{ ($item['orders'] / 100) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Recent Users</h5>
                    <p class="text-muted small mb-0">Latest user registrations</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_users'] as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white small fw-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-muted">{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                    <p class="text-muted small mb-0">Common administrative tasks</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.reservations') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-calendar-plus d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">Manage Reservations</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.orders') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-receipt d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">View Orders</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-people d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">User Management</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.settings') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-gear d-block mb-2" style="font-size: 1.5rem;"></i>
                                <span class="small">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['daily_sales']['labels']) !!},
            datasets: [{
                label: 'Daily Sales (Rs.)',
                data: {!! json_encode($chartData['daily_sales']['data']) !!},
                borderColor: '#8B4513',
                backgroundColor: 'rgba(139, 69, 19, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush