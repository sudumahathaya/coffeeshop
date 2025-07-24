@extends('layouts.admin')

@section('title', 'Orders - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Orders</h1>
            <p class="mb-0 text-muted">Manage customer orders and track sales</p>
        </div>
        <div>
            <button class="btn btn-coffee">
                <i class="bi bi-plus-circle me-2"></i>New Order
            </button>
        </div>
    </div>

    <!-- Order Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <h4 class="mb-0">47</h4>
                    <small class="text-muted">Today's Orders</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="mb-0">12</h4>
                    <small class="text-muted">Preparing</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="mb-0">35</h4>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <h4 class="mb-0">Rs. 45,200</h4>
                    <small class="text-muted">Today's Revenue</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Orders</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Preparing</option>
                        <option>Ready</option>
                        <option>Completed</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <span class="fw-bold text-coffee">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $order->customer_name }}</h6>
                                    <small class="text-muted">Walk-in Customer</small>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $order->items }}</span>
                            </td>
                            <td>
                                <span class="fw-bold">Rs. {{ number_format($order->total, 2) }}</span>
                            </td>
                            <td>
                                @if($order->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->status == 'preparing')
                                    <span class="badge bg-warning">Preparing</span>
                                @elseif($order->status == 'ready')
                                    <span class="badge bg-info">Ready</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($order->status == 'preparing')
                                        <button class="btn btn-success btn-sm" onclick="markReady('{{ $order->id }}')">
                                            <i class="bi bi-check"></i> Ready
                                        </button>
                                    @elseif($order->status == 'ready')
                                        <button class="btn btn-primary btn-sm" onclick="markCompleted('{{ $order->id }}')">
                                            <i class="bi bi-check-all"></i> Complete
                                        </button>
                                    @endif
                                    <button class="btn btn-outline-secondary btn-sm" onclick="viewOrder('{{ $order->id }}')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="printReceipt('{{ $order->id }}')">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderModalBody">
                <!-- Order details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee">Print Receipt</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markReady(orderId) {
    if (confirm('Mark this order as ready?')) {
        alert('Order marked as ready!');
        location.reload();
    }
}

function markCompleted(orderId) {
    if (confirm('Mark this order as completed?')) {
        alert('Order completed successfully!');
        location.reload();
    }
}

function viewOrder(orderId) {
    const modalBody = document.getElementById('orderModalBody');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Order Information</h6>
                <table class="table table-sm">
                    <tr><td><strong>Order ID:</strong></td><td>#${orderId}</td></tr>
                    <tr><td><strong>Customer:</strong></td><td>Alice Johnson</td></tr>
                    <tr><td><strong>Order Time:</strong></td><td>2:30 PM</td></tr>
                    <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Completed</span></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Order Items</h6>
                <table class="table table-sm">
                    <tr><td>Cappuccino</td><td>x2</td><td>Rs. 960.00</td></tr>
                    <tr><td>Croissant</td><td>x1</td><td>Rs. 280.00</td></tr>
                    <tr><td colspan="2"><strong>Total:</strong></td><td><strong>Rs. 1,240.00</strong></td></tr>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Special Instructions</h6>
                <p class="text-muted">Extra hot cappuccino, no sugar.</p>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));
    modal.show();
}

function printReceipt(orderId) {
    alert('Printing receipt for order #' + orderId);
}

// Auto-refresh orders every 30 seconds
setInterval(function() {
    // In a real app, this would fetch new orders via AJAX
    console.log('Refreshing orders...');
}, 30000);
</script>
@endpush