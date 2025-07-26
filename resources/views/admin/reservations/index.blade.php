@extends('layouts.admin')

@section('title', 'Reservations - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Reservations Management</h1>
            <p class="mb-0 text-muted">Manage customer reservations and table bookings</p>
        </div>
        <div>
            <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#addReservationModal">
                <i class="bi bi-plus-circle me-2"></i>New Reservation
            </button>
        </div>
    </div>

    <!-- Reservation Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h4 class="mb-0" id="todayCount">{{ $stats['today_count'] }}</h4>
                    <small class="text-muted">Today's Reservations</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="mb-0" id="pendingCount">{{ $stats['pending_count'] }}</h4>
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
                    <h4 class="mb-0" id="confirmedCount">{{ $stats['confirmed_count'] }}</h4>
                    <small class="text-muted">Confirmed</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="mb-0" id="totalGuests">{{ $stats['total_guests'] }}</h4>
                    <small class="text-muted">Total Guests Today</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search reservations..." id="reservationSearch">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="guestsFilter">
                        <option value="">All Guests</option>
                        <option value="1-2">1-2 People</option>
                        <option value="3-4">3-4 People</option>
                        <option value="5-8">5-8 People</option>
                        <option value="8+">8+ People</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="refreshReservations()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-secondary w-100" onclick="exportReservations()">
                        <i class="bi bi-download"></i>
                    </button>
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
                    <span class="badge bg-info">{{ $reservations->total() }} Total</span>
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
                            <th>Table Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr data-reservation-id="{{ $reservation->id }}">
                            <td>
                                <span class="fw-bold text-coffee">#{{ $reservation->reservation_id }}</span>
                                @if($reservation->occasion)
                                    <br><small class="text-muted">{{ ucfirst($reservation->occasion) }}</small>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $reservation->full_name }}</h6>
                                    <small class="text-muted">{{ $reservation->email }}</small>
                                    @if($reservation->phone)
                                        <br><small class="text-muted">{{ $reservation->phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span>{{ $reservation->reservation_date->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $reservation->reservation_time->format('g:i A') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $reservation->guests }} {{ $reservation->guests == 1 ? 'Guest' : 'Guests' }}</span>
                            </td>
                            <td>
                                @if($reservation->table_type)
                                    <span class="badge bg-secondary">{{ ucfirst($reservation->table_type) }}</span>
                                @else
                                    <span class="text-muted">No preference</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($reservation->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($reservation->status === 'completed')
                                    <span class="badge bg-primary">Completed</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-secondary">Cancelled</span>
                                @elseif($reservation->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary" onclick="viewReservation({{ $reservation->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @if($reservation->status === 'pending')
                                        <button class="btn btn-success" onclick="approveReservation({{ $reservation->id }})">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="rejectReservation({{ $reservation->id }})">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    @endif
                                    @if(in_array($reservation->status, ['pending', 'confirmed']))
                                        <button class="btn btn-outline-primary" onclick="editReservation({{ $reservation->id }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    @endif
                                    @if($reservation->status === 'confirmed')
                                        <button class="btn btn-outline-info" onclick="markCompleted({{ $reservation->id }})">
                                            <i class="bi bi-check-all"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of {{ $reservations->total() }} reservations
                </div>
                <div>
                    {{ $reservations->links() }}
                </div>
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
            <div class="modal-footer" id="reservationModalFooter">
                <!-- Action buttons will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Approve Reservation Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Approve Reservation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this reservation?</p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> The customer will receive a confirmation email and earn 50 loyalty points.
                </div>
                <div class="mb-3">
                    <label for="approveNotes" class="form-label">Admin Notes (Optional)</label>
                    <textarea class="form-control" id="approveNotes" rows="3" 
                              placeholder="Add any notes about this approval..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="confirmApproval()">
                    <i class="bi bi-check-lg me-2"></i>Approve Reservation
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Reservation Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-x-circle me-2"></i>Reject Reservation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Please provide a reason for rejecting this reservation:</p>
                <div class="mb-3">
                    <label for="rejectionReason" class="form-label">Rejection Reason *</label>
                    <select class="form-select" id="rejectionReason" required>
                        <option value="">Select a reason</option>
                        <option value="fully_booked">Fully booked for that time</option>
                        <option value="invalid_time">Invalid time slot</option>
                        <option value="large_group">Group too large for available tables</option>
                        <option value="special_event">Special event scheduled</option>
                        <option value="maintenance">Maintenance scheduled</option>
                        <option value="incomplete_info">Incomplete information provided</option>
                        <option value="other">Other reason</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="rejectNotes" class="form-label">Additional Notes</label>
                    <textarea class="form-control" id="rejectNotes" rows="3" 
                              placeholder="Provide additional details or alternative suggestions..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmRejection()">
                    <i class="bi bi-x-lg me-2"></i>Reject Reservation
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Reservation Modal -->
<div class="modal fade" id="editReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit Reservation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editReservationForm">
                    @csrf
                    <input type="hidden" id="editReservationId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editFirstName" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="editFirstName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editLastName" class="form-label">Last Name *</label>
                            <input type="text" class="form-control" id="editLastName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Phone *</label>
                            <input type="tel" class="form-control" id="editPhone" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editDate" class="form-label">Date *</label>
                            <input type="date" class="form-control" id="editDate" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editTime" class="form-label">Time *</label>
                            <input type="time" class="form-control" id="editTime" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editGuests" class="form-label">Guests *</label>
                            <input type="number" class="form-control" id="editGuests" min="1" max="20" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editTableType" class="form-label">Table Type</label>
                            <select class="form-select" id="editTableType">
                                <option value="">No preference</option>
                                <option value="window">Window</option>
                                <option value="corner">Corner</option>
                                <option value="center">Center</option>
                                <option value="outdoor">Outdoor</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="editOccasion" class="form-label">Occasion</label>
                            <select class="form-select" id="editOccasion">
                                <option value="">Select occasion</option>
                                <option value="birthday">Birthday</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="business">Business</option>
                                <option value="date">Date</option>
                                <option value="family">Family</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="editSpecialRequests" class="form-label">Special Requests</label>
                            <textarea class="form-control" id="editSpecialRequests" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="updateReservation()">
                    <i class="bi bi-check-lg me-2"></i>Update Reservation
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentReservationId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Start real-time updates
    startRealTimeUpdates();
    
    // Search functionality
    const searchInput = document.getElementById('reservationSearch');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Filter functionality
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const guestsFilter = document.getElementById('guestsFilter');
    
    [statusFilter, dateFilter, guestsFilter].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
});

function startRealTimeUpdates() {
    // Update stats every 30 seconds
    setInterval(updateReservationStats, 30000);
}

function updateReservationStats() {
    fetch('/admin/api/reservation-stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.stats;
                
                // Update stat displays with animation
                animateStatUpdate('todayCount', stats.today_count);
                animateStatUpdate('pendingCount', stats.pending_count);
                animateStatUpdate('confirmedCount', stats.confirmed_count);
                animateStatUpdate('totalGuests', stats.total_guests);
            }
        })
        .catch(error => {
            console.error('Error updating reservation stats:', error);
        });
}

function animateStatUpdate(elementId, newValue) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const currentValue = element.textContent;
    if (currentValue !== newValue.toString()) {
        element.style.transform = 'scale(1.2)';
        element.style.color = '#28a745';
        element.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
            element.textContent = newValue;
            element.style.transform = 'scale(1)';
            element.style.color = '';
        }, 150);
    }
}

function viewReservation(reservationId) {
    fetch(`/admin/reservations/${reservationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const reservation = data.reservation;
                const modalBody = document.getElementById('reservationModalBody');
                const modalFooter = document.getElementById('reservationModalFooter');
                
                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Name:</strong></td><td>${reservation.first_name} ${reservation.last_name}</td></tr>
                                <tr><td><strong>Email:</strong></td><td>${reservation.email}</td></tr>
                                <tr><td><strong>Phone:</strong></td><td>${reservation.phone || 'Not provided'}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Reservation Details</h6>
                            <table class="table table-sm">
                                <tr><td><strong>ID:</strong></td><td>#${reservation.reservation_id}</td></tr>
                                <tr><td><strong>Date:</strong></td><td>${new Date(reservation.reservation_date).toLocaleDateString()}</td></tr>
                                <tr><td><strong>Time:</strong></td><td>${reservation.reservation_time}</td></tr>
                                <tr><td><strong>Guests:</strong></td><td>${reservation.guests}</td></tr>
                                <tr><td><strong>Table:</strong></td><td>${reservation.table_type || 'No preference'}</td></tr>
                                <tr><td><strong>Occasion:</strong></td><td>${reservation.occasion || 'Not specified'}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-${getStatusColor(reservation.status)}">${reservation.status.charAt(0).toUpperCase() + reservation.status.slice(1)}</span></td></tr>
                            </table>
                        </div>
                    </div>
                    ${reservation.special_requests ? `
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Special Requests</h6>
                                <p class="text-muted">${reservation.special_requests}</p>
                            </div>
                        </div>
                    ` : ''}
                    ${reservation.admin_notes ? `
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Admin Notes</h6>
                                <p class="text-muted">${reservation.admin_notes}</p>
                            </div>
                        </div>
                    ` : ''}
                `;
                
                // Set footer buttons based on status
                let footerButtons = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                
                if (reservation.status === 'pending') {
                    footerButtons += `
                        <button type="button" class="btn btn-danger" onclick="rejectReservation(${reservation.id})" data-bs-dismiss="modal">
                            <i class="bi bi-x me-2"></i>Reject
                        </button>
                        <button type="button" class="btn btn-success" onclick="approveReservation(${reservation.id})" data-bs-dismiss="modal">
                            <i class="bi bi-check me-2"></i>Approve
                        </button>
                    `;
                } else if (reservation.status === 'confirmed') {
                    footerButtons += `
                        <button type="button" class="btn btn-outline-primary" onclick="editReservation(${reservation.id})" data-bs-dismiss="modal">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button type="button" class="btn btn-info" onclick="markCompleted(${reservation.id})" data-bs-dismiss="modal">
                            <i class="bi bi-check-all me-2"></i>Mark Completed
                        </button>
                    `;
                }
                
                modalFooter.innerHTML = footerButtons;
                
                const modal = new bootstrap.Modal(document.getElementById('reservationModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load reservation details', 'error');
        });
}

function approveReservation(reservationId) {
    currentReservationId = reservationId;
    const modal = new bootstrap.Modal(document.getElementById('approveModal'));
    modal.show();
}

function rejectReservation(reservationId) {
    currentReservationId = reservationId;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

function confirmApproval() {
    const notes = document.getElementById('approveNotes').value;
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Approving...';
    button.disabled = true;
    
    fetch(`/admin/reservations/${currentReservationId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            admin_notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation approved successfully!', 'success');
            updateReservationRow(currentReservationId, 'confirmed');
            updateReservationStats();
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
            modal.hide();
            
            // Clear the notes
            document.getElementById('approveNotes').value = '';
        } else {
            showNotification('Failed to approve reservation: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while approving the reservation', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function confirmRejection() {
    const reason = document.getElementById('rejectionReason').value;
    const notes = document.getElementById('rejectNotes').value;
    
    if (!reason) {
        showNotification('Please select a rejection reason', 'warning');
        return;
    }
    
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Rejecting...';
    button.disabled = true;
    
    fetch(`/admin/reservations/${currentReservationId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            rejection_reason: reason,
            admin_notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation rejected successfully.', 'warning');
            updateReservationRow(currentReservationId, 'rejected');
            updateReservationStats();
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
            modal.hide();
            
            // Clear the form
            document.getElementById('rejectionReason').value = '';
            document.getElementById('rejectNotes').value = '';
        } else {
            showNotification('Failed to reject reservation: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while rejecting the reservation', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function editReservation(reservationId) {
    fetch(`/admin/reservations/${reservationId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const reservation = data.reservation;
                
                document.getElementById('editReservationId').value = reservation.id;
                document.getElementById('editFirstName').value = reservation.first_name;
                document.getElementById('editLastName').value = reservation.last_name;
                document.getElementById('editEmail').value = reservation.email;
                document.getElementById('editPhone').value = reservation.phone;
                document.getElementById('editDate').value = reservation.reservation_date;
                document.getElementById('editTime').value = reservation.reservation_time;
                document.getElementById('editGuests').value = reservation.guests;
                document.getElementById('editTableType').value = reservation.table_type || '';
                document.getElementById('editOccasion').value = reservation.occasion || '';
                document.getElementById('editSpecialRequests').value = reservation.special_requests || '';
                
                const modal = new bootstrap.Modal(document.getElementById('editReservationModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load reservation data', 'error');
        });
}

function updateReservation() {
    const form = document.getElementById('editReservationForm');
    const formData = new FormData(form);
    const reservationId = document.getElementById('editReservationId').value;
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Convert FormData to JSON
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    button.disabled = true;

    fetch(`/admin/reservations/${reservationId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            first_name: document.getElementById('editFirstName').value,
            last_name: document.getElementById('editLastName').value,
            email: document.getElementById('editEmail').value,
            phone: document.getElementById('editPhone').value,
            reservation_date: document.getElementById('editDate').value,
            reservation_time: document.getElementById('editTime').value,
            guests: document.getElementById('editGuests').value,
            table_type: document.getElementById('editTableType').value,
            occasion: document.getElementById('editOccasion').value,
            special_requests: document.getElementById('editSpecialRequests').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation updated successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editReservationModal'));
            modal.hide();
            
            // Update the row in the table
            updateReservationRowData(data.reservation);
        } else {
            showNotification('Failed to update reservation', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function markCompleted(reservationId) {
    if (confirm('Mark this reservation as completed?')) {
        updateReservationStatus(reservationId, 'completed');
    }
}

function updateReservationStatus(reservationId, status) {
    fetch(`/admin/reservations/${reservationId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Reservation marked as ${status}!`, 'success');
            updateReservationRow(reservationId, status);
            updateReservationStats();
        } else {
            showNotification('Failed to update reservation status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function updateReservationRow(reservationId, newStatus) {
    const row = document.querySelector(`tr[data-reservation-id="${reservationId}"]`);
    if (row) {
        const statusCell = row.querySelector('td:nth-child(6)');
        const actionsCell = row.querySelector('td:nth-child(7)');
        
        // Update status badge
        let badgeClass = 'bg-secondary';
        let statusText = newStatus;
        
        switch(newStatus) {
            case 'pending': badgeClass = 'bg-warning'; break;
            case 'confirmed': badgeClass = 'bg-success'; break;
            case 'completed': badgeClass = 'bg-primary'; break;
            case 'cancelled': badgeClass = 'bg-secondary'; break;
            case 'rejected': badgeClass = 'bg-danger'; break;
        }
        
        statusCell.innerHTML = `<span class="badge ${badgeClass}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
        
        // Update action buttons
        updateActionButtons(actionsCell, newStatus, reservationId);
        
        // Add visual feedback
        row.style.backgroundColor = '#d1ecf1';
        setTimeout(() => {
            row.style.backgroundColor = '';
        }, 2000);
    }
}

function updateReservationRowData(reservation) {
    const row = document.querySelector(`tr[data-reservation-id="${reservation.id}"]`);
    if (row) {
        // Update customer info
        const customerCell = row.querySelector('td:nth-child(2)');
        customerCell.innerHTML = `
            <div>
                <h6 class="mb-0">${reservation.first_name} ${reservation.last_name}</h6>
                <small class="text-muted">${reservation.email}</small>
                ${reservation.phone ? `<br><small class="text-muted">${reservation.phone}</small>` : ''}
            </div>
        `;
        
        // Update date & time
        const dateTimeCell = row.querySelector('td:nth-child(3)');
        const date = new Date(reservation.reservation_date);
        const time = reservation.reservation_time;
        dateTimeCell.innerHTML = `
            <span>${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span><br>
            <small class="text-muted">${time}</small>
        `;
        
        // Update guests
        const guestsCell = row.querySelector('td:nth-child(4)');
        guestsCell.innerHTML = `<span class="badge bg-light text-dark">${reservation.guests} ${reservation.guests == 1 ? 'Guest' : 'Guests'}</span>`;
        
        // Update table type
        const tableCell = row.querySelector('td:nth-child(5)');
        if (reservation.table_type) {
            tableCell.innerHTML = `<span class="badge bg-secondary">${reservation.table_type.charAt(0).toUpperCase() + reservation.table_type.slice(1)}</span>`;
        } else {
            tableCell.innerHTML = '<span class="text-muted">No preference</span>';
        }
    }
}

function updateActionButtons(actionsCell, status, reservationId) {
    let buttonsHtml = `
        <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary" onclick="viewReservation(${reservationId})">
                <i class="bi bi-eye"></i>
            </button>
    `;
    
    if (status === 'pending') {
        buttonsHtml += `
            <button class="btn btn-success" onclick="approveReservation(${reservationId})">
                <i class="bi bi-check"></i>
            </button>
            <button class="btn btn-danger" onclick="rejectReservation(${reservationId})">
                <i class="bi bi-x"></i>
            </button>
        `;
    }
    
    if (status === 'pending' || status === 'confirmed') {
        buttonsHtml += `
            <button class="btn btn-outline-primary" onclick="editReservation(${reservationId})">
                <i class="bi bi-pencil"></i>
            </button>
        `;
    }
    
    if (status === 'confirmed') {
        buttonsHtml += `
            <button class="btn btn-outline-info" onclick="markCompleted(${reservationId})">
                <i class="bi bi-check-all"></i>
            </button>
        `;
    }
    
    buttonsHtml += '</div>';
    actionsCell.innerHTML = buttonsHtml;
}

function getStatusColor(status) {
    const colors = {
        'pending': 'warning',
        'confirmed': 'success',
        'completed': 'primary',
        'cancelled': 'secondary',
        'rejected': 'danger'
    };
    return colors[status] || 'secondary';
}

function applyFilters() {
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    const guestsFilter = document.getElementById('guestsFilter').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let show = true;
        
        // Status filter
        if (statusFilter) {
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge.textContent.toLowerCase();
            if (rowStatus !== statusFilter) {
                show = false;
            }
        }
        
        // Date filter
        if (dateFilter) {
            const dateCell = row.querySelector('td:nth-child(3)');
            const rowDate = dateCell.textContent;
            const filterDate = new Date(dateFilter).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            if (!rowDate.includes(filterDate)) {
                show = false;
            }
        }
        
        // Guests filter
        if (guestsFilter) {
            const guestsCell = row.querySelector('td:nth-child(4)');
            const guestsText = guestsCell.textContent;
            const guestsCount = parseInt(guestsText.match(/\d+/)[0]);
            
            switch(guestsFilter) {
                case '1-2':
                    if (guestsCount < 1 || guestsCount > 2) show = false;
                    break;
                case '3-4':
                    if (guestsCount < 3 || guestsCount > 4) show = false;
                    break;
                case '5-8':
                    if (guestsCount < 5 || guestsCount > 8) show = false;
                    break;
                case '8+':
                    if (guestsCount <= 8) show = false;
                    break;
            }
        }
        
        row.style.display = show ? '' : 'none';
    });
}

function refreshReservations() {
    location.reload();
}

function exportReservations() {
    showNotification('Export functionality coming soon!', 'info');
}

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
    
    const iconMap = {
        'success': 'check-circle-fill',
        'error': 'exclamation-triangle-fill',
        'warning': 'exclamation-triangle-fill',
        'info': 'info-circle-fill'
    };
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${iconMap[type]} me-2"></i>
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
    }, 5000);
}

// CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    .notification-toast {
        backdrop-filter: blur(10px);
    }
    
    .stat-icon {
        transition: all 0.3s ease;
    }
    
    .card:hover .stat-icon {
        transform: scale(1.1);
    }
`;
document.head.appendChild(style);
</script>
@endpush