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
            <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#newReservationModal">
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
                    <h4 class="mb-0" id="todayCount">{{ $stats['today_count'] }}</h4>
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
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="mb-0" id="totalGuests">{{ $stats['total_guests'] }}</h4>
                    <small class="text-muted">Total Guests Today</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search reservations..." id="searchInput">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="refreshReservations()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
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
                    <span class="badge bg-success" id="onlineStatus">
                        <i class="bi bi-circle-fill me-1"></i>Live Updates
                    </span>
                    <button class="btn btn-outline-secondary btn-sm" onclick="exportReservations()">
                        <i class="bi bi-download"></i> Export
                    </button>
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
                    <tbody id="reservationsTableBody">
                        @foreach($reservations as $reservation)
                        <tr data-reservation-id="{{ $reservation->id }}">
                            <td>
                                <span class="fw-bold text-coffee">#{{ $reservation->reservation_id }}</span>
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $reservation->full_name }}</h6>
                                    <small class="text-muted">{{ $reservation->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}</span><br>
                                    <small class="text-muted">{{ date('g:i A', strtotime($reservation->reservation_time)) }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $reservation->guests }} {{ $reservation->guests == 1 ? 'Guest' : 'Guests' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $reservation->table_type ?? 'Any' }}</span>
                            </td>
                            <td>
                                @if($reservation->status == 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($reservation->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($reservation->status == 'completed')
                                    <span class="badge bg-info">Completed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($reservation->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($reservation->status == 'pending')
                                        <button class="btn btn-success btn-sm" onclick="updateStatus({{ $reservation->id }}, 'confirmed')">
                                            <i class="bi bi-check"></i> Approve
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $reservation->id }}, 'cancelled')">
                                            <i class="bi bi-x"></i> Reject
                                        </button>
                                    @endif
                                    <button class="btn btn-outline-secondary btn-sm" onclick="viewReservation({{ $reservation->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="editReservation({{ $reservation->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if($reservation->status !== 'completed')
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteReservation({{ $reservation->id }})">
                                            <i class="bi bi-trash"></i>
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
                <div id="paginationContainer">
                    {{ $reservations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Reservation Modal -->
<div class="modal fade" id="newReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-coffee text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-plus me-2"></i>New Reservation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newReservationForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">First Name *</label>
                            <input type="text" class="form-control" name="firstName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last Name *</label>
                            <input type="text" class="form-control" name="lastName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone *</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date *</label>
                            <input type="date" class="form-control" name="reservationDate" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Time *</label>
                            <select class="form-select" name="reservationTime" required>
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
                            <label class="form-label fw-semibold">Guests *</label>
                            <select class="form-select" name="guests" required>
                                <option value="">Select Guests</option>
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Person' : 'People' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Table Preference</label>
                            <select class="form-select" name="tableType">
                                <option value="">No Preference</option>
                                <option value="window">Window Side</option>
                                <option value="corner">Corner Table</option>
                                <option value="center">Center Area</option>
                                <option value="outdoor">Outdoor Seating</option>
                                <option value="private">Private Section</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Occasion</label>
                            <select class="form-select" name="occasion">
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
                            <label class="form-label fw-semibold">Special Requests</label>
                            <textarea class="form-control" name="specialRequests" rows="3" placeholder="Any special requirements..."></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emailUpdates" id="emailUpdates">
                                <label class="form-check-label" for="emailUpdates">
                                    Send email updates about this reservation
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-coffee" onclick="saveReservation()">
                    <i class="bi bi-check-lg me-2"></i>Save Reservation
                </button>
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
let refreshInterval;

document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today for new reservations
    const dateInput = document.querySelector('input[name="reservationDate"]');
    if (dateInput) {
        dateInput.min = new Date().toISOString().split('T')[0];
    }

    // Start real-time updates
    startRealTimeUpdates();

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', debounce(function() {
        filterReservations();
    }, 300));

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', filterReservations);
    document.getElementById('dateFilter').addEventListener('change', filterReservations);
});

function startRealTimeUpdates() {
    // Update every 30 seconds
    refreshInterval = setInterval(function() {
        refreshReservations();
        updateStats();
    }, 30000);

    // Visual indicator that updates are running
    const statusIndicator = document.getElementById('onlineStatus');
    statusIndicator.classList.add('pulse');
}

function stopRealTimeUpdates() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
        const statusIndicator = document.getElementById('onlineStatus');
        statusIndicator.classList.remove('pulse');
        statusIndicator.innerHTML = '<i class="bi bi-circle me-1"></i>Offline';
        statusIndicator.classList.remove('bg-success');
        statusIndicator.classList.add('bg-secondary');
    }
}

function refreshReservations() {
    const searchTerm = document.getElementById('searchInput').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;

    const params = new URLSearchParams();
    if (searchTerm) params.append('search', searchTerm);
    if (statusFilter) params.append('status', statusFilter);
    if (dateFilter) params.append('date', dateFilter);

    fetch(`/admin/api/reservations?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateReservationsTable(data.reservations.data);
                updatePagination(data.reservations);
            }
        })
        .catch(error => {
            console.error('Error fetching reservations:', error);
            showNotification('Failed to refresh reservations', 'error');
        });
}

function updateStats() {
    fetch('/admin/api/reservation-stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('todayCount').textContent = data.stats.today_count;
                document.getElementById('pendingCount').textContent = data.stats.pending_count;
                document.getElementById('confirmedCount').textContent = data.stats.confirmed_count;
                document.getElementById('totalGuests').textContent = data.stats.total_guests;
            }
        })
        .catch(error => {
            console.error('Error fetching stats:', error);
        });
}

function updateReservationsTable(reservations) {
    const tbody = document.getElementById('reservationsTableBody');
    
    if (reservations.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="text-muted">
                        <i class="bi bi-calendar-x fs-1 mb-3"></i>
                        <p>No reservations found</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = reservations.map(reservation => {
        const date = new Date(reservation.reservation_date);
        const time = new Date(`2000-01-01 ${reservation.reservation_time}`);
        
        let statusBadge = '';
        let actionButtons = '';

        switch(reservation.status) {
            case 'confirmed':
                statusBadge = '<span class="badge bg-success">Confirmed</span>';
                break;
            case 'pending':
                statusBadge = '<span class="badge bg-warning">Pending</span>';
                actionButtons = `
                    <button class="btn btn-success btn-sm" onclick="updateStatus(${reservation.id}, 'confirmed')">
                        <i class="bi bi-check"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="updateStatus(${reservation.id}, 'cancelled')">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                break;
            case 'completed':
                statusBadge = '<span class="badge bg-info">Completed</span>';
                break;
            case 'cancelled':
                statusBadge = '<span class="badge bg-secondary">Cancelled</span>';
                break;
        }

        return `
            <tr data-reservation-id="${reservation.id}" class="reservation-row">
                <td>
                    <span class="fw-bold text-coffee">#${reservation.reservation_id}</span>
                </td>
                <td>
                    <div>
                        <h6 class="mb-0">${reservation.first_name} ${reservation.last_name}</h6>
                        <small class="text-muted">${reservation.email}</small>
                    </div>
                </td>
                <td>
                    <div>
                        <span class="fw-medium">${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span><br>
                        <small class="text-muted">${time.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })}</small>
                    </div>
                </td>
                <td>
                    <span class="badge bg-light text-dark">${reservation.guests} ${reservation.guests == 1 ? 'Guest' : 'Guests'}</span>
                </td>
                <td>
                    <span class="text-muted">${reservation.table_type || 'Any'}</span>
                </td>
                <td>${statusBadge}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        ${actionButtons}
                        <button class="btn btn-outline-secondary btn-sm" onclick="viewReservation(${reservation.id})">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="editReservation(${reservation.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteReservation(${reservation.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

    // Add animation to new rows
    const rows = tbody.querySelectorAll('.reservation-row');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
}

function filterReservations() {
    refreshReservations();
}

function saveReservation() {
    const form = document.getElementById('newReservationForm');
    const formData = new FormData(form);
    const submitButton = event.target;
    
    // Show loading state
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    submitButton.disabled = true;

    // Convert FormData to JSON
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    fetch('/admin/reservations', {
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
            showNotification('Reservation created successfully!', 'success');
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('newReservationModal'));
            modal.hide();
            form.reset();
            
            // Refresh the reservations list
            refreshReservations();
            updateStats();
        } else {
            showNotification('Failed to create reservation', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while saving the reservation', 'error');
    })
    .finally(() => {
        // Reset button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function updateStatus(reservationId, status) {
    const confirmMessage = status === 'confirmed' ? 'approve and confirm' : 'reject and cancel';
    
    if (!confirm(`Are you sure you want to ${confirmMessage} this reservation? ${status === 'confirmed' ? 'The customer will be notified and earn 50 loyalty points.' : 'The customer will be notified of the cancellation.'}`)) {
        return;
    }

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
            const message = status === 'confirmed' ? 
                'Reservation approved and confirmed! Customer has been notified and earned 50 loyalty points.' : 
                'Reservation rejected and cancelled. Customer has been notified.';
            showNotification(message, status === 'confirmed' ? 'success' : 'warning');
            refreshReservations();
            updateStats();
        } else {
            showNotification('Failed to update reservation status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating the reservation', 'error');
    });
}

function deleteReservation(reservationId) {
    if (!confirm('Are you sure you want to delete this reservation? This action cannot be undone.')) {
        return;
    }

    fetch(`/admin/reservations/${reservationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Reservation deleted successfully!', 'success');
            refreshReservations();
            updateStats();
        } else {
            showNotification('Failed to delete reservation', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while deleting the reservation', 'error');
    });
}

function viewReservation(reservationId) {
    // Fetch reservation details and show in modal
    fetch(`/admin/reservations/${reservationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const reservation = data.reservation;
                const modalBody = document.getElementById('reservationModalBody');
                
                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Name:</strong></td><td>${reservation.first_name} ${reservation.last_name}</td></tr>
                                <tr><td><strong>Email:</strong></td><td>${reservation.email}</td></tr>
                                <tr><td><strong>Phone:</strong></td><td>${reservation.phone}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Reservation Details</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Date:</strong></td><td>${new Date(reservation.reservation_date).toLocaleDateString()}</td></tr>
                                <tr><td><strong>Time:</strong></td><td>${reservation.reservation_time}</td></tr>
                                <tr><td><strong>Guests:</strong></td><td>${reservation.guests} People</td></tr>
                                <tr><td><strong>Table:</strong></td><td>${reservation.table_type || 'Any'}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">${reservation.status}</span></td></tr>
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
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('reservationModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load reservation details', 'error');
        });
}

function editReservation(reservationId) {
    showNotification('Edit functionality will be implemented soon', 'info');
}

function exportReservations() {
    showNotification('Exporting reservations...', 'info');
    
    // Create CSV export
    const csvContent = generateCSV();
    downloadCSV(csvContent, 'reservations.csv');
}

function generateCSV() {
    const rows = document.querySelectorAll('#reservationsTableBody tr');
    let csv = 'Reservation ID,Customer Name,Email,Date,Time,Guests,Status\n';
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length > 1) {
            const reservationId = cells[0].textContent.trim();
            const customerName = cells[1].querySelector('h6').textContent.trim();
            const email = cells[1].querySelector('small').textContent.trim();
            const date = cells[2].querySelector('span').textContent.trim();
            const time = cells[2].querySelector('small').textContent.trim();
            const guests = cells[3].textContent.trim();
            const status = cells[5].textContent.trim();
            
            csv += `"${reservationId}","${customerName}","${email}","${date}","${time}","${guests}","${status}"\n`;
        }
    });
    
    return csv;
}

function downloadCSV(content, filename) {
    const blob = new Blob([content], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
    
    showNotification('Reservations exported successfully!', 'success');
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

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    stopRealTimeUpdates();
});

// Add CSS for animations
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
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .notification-toast {
        backdrop-filter: blur(10px);
    }
    
    .reservation-row {
        transition: all 0.3s ease;
    }
    
    .reservation-row:hover {
        background-color: rgba(139, 69, 19, 0.05);
    }
`;
document.head.appendChild(style);
</script>
@endpush