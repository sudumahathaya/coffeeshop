@extends('layouts.admin')

@section('title', 'Reservations - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Reservations</h1>
            <p class="mb-0 text-muted">Manage table reservations and bookings</p>
        </div>
        <div>
            <button class="btn btn-coffee">
                <i class="bi bi-calendar-plus me-2"></i>New Reservation
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h4 class="mb-0">24</h4>
                    <small class="text-muted">Today's Reservations</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h4 class="mb-0">8</h4>
                    <small class="text-muted">Pending Approval</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="mb-0">16</h4>
                    <small class="text-muted">Confirmed</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="mb-0">68</h4>
                    <small class="text-muted">Total Guests</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Reservations</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Confirmed</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>
                    <input type="date" class="form-control form-control-sm" style="width: auto;">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Reservation ID</th>
                            <th>Customer</th>
                            <th>Date & Time</th>
                            <th>Guests</th>
                            <th>Table</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>
                                <span class="fw-bold text-coffee">#{{ $reservation->id }}</span>
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $reservation->customer_name }}</h6>
                                    <small class="text-muted">{{ $reservation->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</span><br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->time)->format('g:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $reservation->guests }} {{ $reservation->guests == 1 ? 'Guest' : 'Guests' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">Table 5</span>
                            </td>
                            <td>
                                @if($reservation->status == 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($reservation->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($reservation->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($reservation->status == 'pending')
                                        <button class="btn btn-success btn-sm" onclick="confirmReservation('{{ $reservation->id }}')">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="cancelReservation('{{ $reservation->id }}')">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-outline-secondary btn-sm" onclick="viewReservation('{{ $reservation->id }}')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="editReservation('{{ $reservation->id }}')">
                                        <i class="bi bi-pencil"></i>
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

<!-- Reservation Details Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reservationModalBody">
                <!-- Reservation details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee">Send Confirmation</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmReservation(id) {
    if (confirm('Confirm this reservation?')) {
        alert('Reservation confirmed successfully!');
        location.reload();
    }
}

function cancelReservation(id) {
    if (confirm('Cancel this reservation?')) {
        alert('Reservation cancelled successfully!');
        location.reload();
    }
}

function viewReservation(id) {
    const modalBody = document.getElementById('reservationModalBody');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Customer Information</h6>
                <table class="table table-sm">
                    <tr><td><strong>Name:</strong></td><td>John Doe</td></tr>
                    <tr><td><strong>Email:</strong></td><td>john@example.com</td></tr>
                    <tr><td><strong>Phone:</strong></td><td>+94 77 123 4567</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Reservation Details</h6>
                <table class="table table-sm">
                    <tr><td><strong>Date:</strong></td><td>December 20, 2024</td></tr>
                    <tr><td><strong>Time:</strong></td><td>2:00 PM</td></tr>
                    <tr><td><strong>Guests:</strong></td><td>4 People</td></tr>
                    <tr><td><strong>Table:</strong></td><td>Window Side</td></tr>
                    <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Confirmed</span></td></tr>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Special Requests</h6>
                <p class="text-muted">Birthday celebration - please arrange a corner table with decorations.</p>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('reservationModal'));
    modal.show();
}

function editReservation(id) {
    alert('Edit reservation functionality would be implemented here');
}
</script>
@endpush