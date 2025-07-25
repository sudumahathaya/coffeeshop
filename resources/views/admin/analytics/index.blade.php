@extends('layouts.admin')

@section('title', 'Analytics - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Analytics Dashboard</h1>
            <p class="mb-0 text-muted">Comprehensive insights into your café's performance</p>
        </div>
        <div>
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar3 me-2"></i>Last 30 Days
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                    <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                </ul>
            </div>
            <button class="btn btn-coffee ms-2">
                <i class="bi bi-download me-2"></i>Export Report
            </button>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Revenue</div>
                            <div class="h4 mb-0">Rs. {{ number_format($analyticsData['overview']['total_revenue'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +{{ $analyticsData['overview']['revenue_growth'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Orders</div>
                            <div class="h4 mb-0">{{ number_format($analyticsData['overview']['total_orders']) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +{{ $analyticsData['overview']['order_growth'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Total Customers</div>
                            <div class="h4 mb-0">{{ number_format($analyticsData['overview']['total_customers']) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +{{ $analyticsData['overview']['customer_growth'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted small">Avg. Order Value</div>
                            <div class="h4 mb-0">Rs. {{ number_format($analyticsData['overview']['avg_order_value'], 2) }}</div>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i> +5.2%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Sales Chart -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Revenue Trends</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active" onclick="showDailySales()">Daily</button>
                            <button class="btn btn-outline-secondary" onclick="showMonthlySales()">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    @foreach($analyticsData['top_products'] as $index => $product)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rank-badge">{{ $index + 1 }}</div>
                            <div class="ms-3">
                                <h6 class="mb-0">{{ $product['name'] }}</h6>
                                <small class="text-muted">{{ $product['sales'] }} orders</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">Rs. {{ number_format($product['revenue']) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Analytics Row -->
    <div class="row g-4 mb-4">
        <!-- Customer Analytics -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Customer Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="text-coffee">{{ $analyticsData['customer_analytics']['customer_retention'] }}%</h4>
                                <small class="text-muted">Customer Retention</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h4 class="text-coffee">{{ $analyticsData['customer_analytics']['avg_visits_per_customer'] }}</h4>
                                <small class="text-muted">Avg. Visits/Customer</small>
                            </div>
                        </div>
                    </div>
                    <canvas id="customerChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- Peak Hours -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Peak Hours Analysis</h5>
                </div>
                <div class="card-body">
                    <canvas id="peakHoursChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods and Additional Insights -->
    <div class="row g-4">
        <!-- Payment Methods -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Payment Methods</h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Key Insights -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Key Insights & Recommendations</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="insight-card">
                                <div class="insight-icon bg-success">
                                    <i class="bi bi-trending-up"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>Revenue Growth</h6>
                                    <p class="small text-muted mb-2">Your revenue has increased by 12.5% compared to last month. Cappuccino and specialty drinks are driving this growth.</p>
                                    <span class="badge bg-success">Positive Trend</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="insight-card">
                                <div class="insight-icon bg-info">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>Peak Hours</h6>
                                    <p class="small text-muted mb-2">8-9 AM and 2-3 PM are your busiest hours. Consider staffing adjustments during these times.</p>
                                    <span class="badge bg-info">Optimization Opportunity</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="insight-card">
                                <div class="insight-icon bg-warning">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>Customer Retention</h6>
                                    <p class="small text-muted mb-2">78.5% retention rate is good, but there's room for improvement through loyalty programs.</p>
                                    <span class="badge bg-warning">Action Needed</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="insight-card">
                                <div class="insight-icon bg-primary">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                                <div class="insight-content">
                                    <h6>Product Performance</h6>
                                    <p class="small text-muted mb-2">Cold drinks are gaining popularity. Consider expanding the iced coffee menu for summer.</p>
                                    <span class="badge bg-primary">Growth Opportunity</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.rank-badge {
    width: 30px;
    height: 30px;
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}

.insight-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    border-radius: 15px;
    border: 1px solid rgba(139, 69, 19, 0.1);
    height: 100%;
}

.insight-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.insight-content {
    flex-grow: 1;
}

.insight-content h6 {
    color: var(--coffee-primary);
    margin-bottom: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    let salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($analyticsData['sales_by_period']['daily']['labels']) !!},
            datasets: [{
                label: 'Daily Revenue (Rs.)',
                data: {!! json_encode($analyticsData['sales_by_period']['daily']['data']) !!},
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

    // Customer Chart
    const customerCtx = document.getElementById('customerChart').getContext('2d');
    new Chart(customerCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($analyticsData['customer_analytics']['new_customers_monthly']['labels']) !!},
            datasets: [{
                label: 'New Customers',
                data: {!! json_encode($analyticsData['customer_analytics']['new_customers_monthly']['data']) !!},
                backgroundColor: 'rgba(139, 69, 19, 0.8)',
                borderColor: '#8B4513',
                borderWidth: 1
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
                    beginAtZero: true
                }
            }
        }
    });

    // Peak Hours Chart
    const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
    new Chart(peakHoursCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($analyticsData['peak_hours']['labels']) !!},
            datasets: [{
                label: 'Orders per Hour',
                data: {!! json_encode($analyticsData['peak_hours']['data']) !!},
                borderColor: '#D2691E',
                backgroundColor: 'rgba(210, 105, 30, 0.1)',
                borderWidth: 2,
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
                    beginAtZero: true
                }
            }
        }
    });

    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($analyticsData['payment_methods']['labels']) !!},
            datasets: [{
                data: {!! json_encode($analyticsData['payment_methods']['data']) !!},
                backgroundColor: [
                    '#8B4513',
                    '#D2691E',
                    '#CD853F',
                    '#DEB887'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Chart switching functions
    window.showDailySales = function() {
        salesChart.data.labels = {!! json_encode($analyticsData['sales_by_period']['daily']['labels']) !!};
        salesChart.data.datasets[0].data = {!! json_encode($analyticsData['sales_by_period']['daily']['data']) !!};
        salesChart.data.datasets[0].label = 'Daily Revenue (Rs.)';
        salesChart.update();
        
        // Update button states
        document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    };

    window.showMonthlySales = function() {
        salesChart.data.labels = {!! json_encode($analyticsData['sales_by_period']['monthly']['labels']) !!};
        salesChart.data.datasets[0].data = {!! json_encode($analyticsData['sales_by_period']['monthly']['data']) !!};
        salesChart.data.datasets[0].label = 'Monthly Revenue (Rs.)';
        salesChart.update();
        
        // Update button states
        document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    };
});
</script>
@endpush