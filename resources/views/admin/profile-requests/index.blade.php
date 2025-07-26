@extends('layouts.admin')

@section('title', 'Profile Change Requests - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Profile Change Requests</h1>
            <p class="mb-0 text-muted">Review and approve customer profile change requests</p>
        </div>
        <div>
            <span class="badge bg-warning fs-6" id="pendingCount">
                <i class="bi bi-clock me-1"></i>
                {{ $requests->where('status', 'pending')->count() }} Pending
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="mb-0">{{ $requests->where('status', 'pending')->count() }}</h4>
                    <small class="text-muted">Pending Requests</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="mb-0">{{ $requests->where('status', 'approved')->count() }}</h4>
                    <small class="text-muted">Approved</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-danger mx-auto mb-3">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h4 class="mb-0">{{ $requests->where('status', 'rejected')->count() }}</h4>
                    <small class="text-muted">Rejected</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <h4 class="mb-0">{{ $requests->total() }}</h4>
                    <small class="text-muted">Total Requests</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by customer name or email..." id="searchInput">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="refreshRequests()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Profile Change Requests</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Requested Changes</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr data-request-id="{{ $request->id }}">
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $request->user->name }}</h6>
                                    <small class="text-muted">{{ $request->user->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="changes-summary">
                                    @php
                                        $changes = [];
                                        foreach($request->requested_changes as $field => $newValue) {
                                            $oldValue = $request->current_data[$field] ?? 'Not set';
                                            if ($oldValue !== $newValue) {
                                                $changes[] = ucfirst(str_replace('_', ' ', $field));
                                            }
                                        }
                                    @endphp
                                    <small class="text-muted">
                                        {{ implode(', ', array_slice($changes, 0, 3)) }}
                                        @if(count($changes) > 3)
                                            <span class="badge bg-light text-dark">+{{ count($changes) - 3 }} more</span>
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td>
                                <span>{{ $request->created_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $request->created_at->format('g:i A') }}</small>
                            </td>
                            <td>
                                @if($request->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($request->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary" onclick="viewRequest({{ $request->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @if($request->status === 'pending')
                                        <button class="btn btn-success" onclick="approveRequest({{ $request->id }})">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="rejectRequest({{ $request->id }})">
                                            <i class="bi bi-x"></i>
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
                    Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} requests
                </div>
                <div>
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Request Details Modal -->
<div class="modal fade" id="requestModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Change Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="requestModalBody">
                <!-- Request details will be loaded here -->
            </div>
            <div class="modal-footer" id="requestModalFooter">
                <!-- Action buttons will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Approve Profile Changes
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this profile change request?</p>
                <div class="mb-3">
                    <label for="approvalNotes" class="form-label">Admin Notes (Optional)</label>
                    <textarea class="form-control" id="approvalNotes" rows="3" 
                              placeholder="Add any notes about this approval..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="confirmApproval()">
                    <i class="bi bi-check-lg me-2"></i>Approve Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-x-circle me-2"></i>Reject Profile Changes
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Please provide a reason for rejecting this profile change request:</p>
                <div class="mb-3">
                    <label for="rejectionNotes" class="form-label">Rejection Reason *</label>
                    <textarea class="form-control" id="rejectionNotes" rows="3" required
                              placeholder="Explain why this request is being rejected..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmRejection()">
                    <i class="bi bi-x-lg me-2"></i>Reject Request
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentRequestId = null;

function viewRequest(requestId) {
    fetch(`/admin/profile-requests/${requestId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const request = data.request;
                const modalBody = document.getElementById('requestModalBody');
                const modalFooter = document.getElementById('requestModalFooter');
                
                // Build changes comparison
                let changesHtml = '';
                for (const [field, newValue] of Object.entries(request.requested_changes)) {
                    const oldValue = request.current_data[field] || 'Not set';
                    const fieldName = field.charAt(0).toUpperCase() + field.slice(1).replace('_', ' ');
                    
                    if (oldValue !== newValue) {
                        changesHtml += `
                            <div class="change-item mb-3">
                                <strong>${fieldName}:</strong>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="old-value">
                                            <small class="text-muted">Current:</small><br>
                                            <span class="text-danger">${oldValue || 'Not set'}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="new-value">
                                            <small class="text-muted">Requested:</small><br>
                                            <span class="text-success">${newValue || 'Not set'}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }

                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Name:</strong></td><td>${request.user.name}</td></tr>
                                <tr><td><strong>Email:</strong></td><td>${request.user.email}</td></tr>
                                <tr><td><strong>Request Date:</strong></td><td>${new Date(request.created_at).toLocaleDateString()}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-${request.status === 'pending' ? 'warning' : request.status === 'approved' ? 'success' : 'danger'}">${request.status.charAt(0).toUpperCase() + request.status.slice(1)}</span></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            ${request.approved_by ? `
                                <h6>Processing Information</h6>
                                <table class="table table-sm">
                                    <tr><td><strong>Processed By:</strong></td><td>${request.approved_by.name}</td></tr>
                                    <tr><td><strong>Processed At:</strong></td><td>${new Date(request.approved_at).toLocaleDateString()}</td></tr>
                                    ${request.admin_notes ? `<tr><td><strong>Notes:</strong></td><td>${request.admin_notes}</td></tr>` : ''}
                                </table>
                            ` : ''}
                        </div>
                    </div>
                    <hr>
                    <h6>Requested Changes</h6>
                    <div class="changes-list">
                        ${changesHtml}
                    </div>
                `;

                // Set footer buttons based on status
                if (request.status === 'pending') {
                    modalFooter.innerHTML = `
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="rejectRequest(${request.id})" data-bs-dismiss="modal">
                            <i class="bi bi-x me-2"></i>Reject
                        </button>
                        <button type="button" class="btn btn-success" onclick="approveRequest(${request.id})" data-bs-dismiss="modal">
                            <i class="bi bi-check me-2"></i>Approve
                        </button>
                    `;
                } else {
                    modalFooter.innerHTML = `
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    `;
                }
                
                const modal = new bootstrap.Modal(document.getElementById('requestModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load request details', 'error');
        });
}

function approveRequest(requestId) {
    currentRequestId = requestId;
    const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    modal.show();
}

function rejectRequest(requestId) {
    currentRequestId = requestId;
    const modal = new bootstrap.Modal(document.getElementById('rejectionModal'));
    modal.show();
}

function confirmApproval() {
    const notes = document.getElementById('approvalNotes').value;
    
    fetch(`/admin/profile-requests/${currentRequestId}/approve`, {
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
            showNotification('Profile change request approved successfully!', 'success');
            updateRequestRow(currentRequestId, 'approved');
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('approvalModal'));
            modal.hide();
            
            // Clear the notes
            document.getElementById('approvalNotes').value = '';
        } else {
            showNotification('Failed to approve request: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while approving the request', 'error');
    });
}

function confirmRejection() {
    const notes = document.getElementById('rejectionNotes').value;
    
    if (!notes.trim()) {
        showNotification('Please provide a reason for rejection', 'warning');
        return;
    }
    
    fetch(`/admin/profile-requests/${currentRequestId}/reject`, {
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
            showNotification('Profile change request rejected.', 'warning');
            updateRequestRow(currentRequestId, 'rejected');
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('rejectionModal'));
            modal.hide();
            
            // Clear the notes
            document.getElementById('rejectionNotes').value = '';
        } else {
            showNotification('Failed to reject request: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while rejecting the request', 'error');
    });
}

function updateRequestRow(requestId, newStatus) {
    const row = document.querySelector(`tr[data-request-id="${requestId}"]`);
    if (row) {
        const statusCell = row.querySelector('td:nth-child(4)');
        const actionsCell = row.querySelector('td:nth-child(5)');
        
        // Update status badge
        let badgeClass = 'bg-warning';
        if (newStatus === 'approved') badgeClass = 'bg-success';
        if (newStatus === 'rejected') badgeClass = 'bg-danger';
        
        statusCell.innerHTML = `<span class="badge ${badgeClass}">${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`;
        
        // Update action buttons
        actionsCell.innerHTML = `
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-secondary" onclick="viewRequest(${requestId})">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        `;
    }
    
    // Update pending count
    updatePendingCount();
}

function updatePendingCount() {
    fetch('/admin/profile-requests/pending-count')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('pendingCount').innerHTML = `
                    <i class="bi bi-clock me-1"></i>
                    ${data.pending_count} Pending
                `;
            }
        })
        .catch(error => {
            console.error('Error updating pending count:', error);
        });
}

function refreshRequests() {
    location.reload();
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
    
    .change-item {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }
    
    .old-value {
        background: rgba(220, 53, 69, 0.1);
        padding: 0.5rem;
        border-radius: 5px;
        border-left: 3px solid #dc3545;
    }
    
    .new-value {
        background: rgba(25, 135, 84, 0.1);
        padding: 0.5rem;
        border-radius: 5px;
        border-left: 3px solid #198754;
    }
`;
document.head.appendChild(style);
</script>
@endpush