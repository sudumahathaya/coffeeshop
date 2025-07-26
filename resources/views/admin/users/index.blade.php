@extends('layouts.admin')

@section('title', 'User Management - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">User Management</h1>
            <p class="mb-0 text-muted">Manage registered users and their accounts</p>
        </div>
        <div>
            <button class="btn btn-coffee">
                <i class="bi bi-person-plus me-2"></i>Add New User
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search users..." id="userSearch">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
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
                    <button class="btn btn-outline-secondary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users ({{ $users->total() }})</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Joined Date</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <span class="text-white small fw-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <i class="bi bi-patch-check-fill text-success ms-1" title="Verified"></i>
                                @else
                                    <i class="bi bi-exclamation-triangle-fill text-warning ms-1" title="Unverified"></i>
                                @endif
                            </td>
                            <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-muted">
                                {{ $user->updated_at->diffForHumans() }}
                            </td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="viewUser({{ $user->id }})">
                                            <i class="bi bi-eye me-2"></i>View Details
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" onclick="editUser({{ $user->id }})">
                                            <i class="bi bi-pencil me-2"></i>Edit User
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" onclick="viewUserStats({{ $user->id }})">
                                            <i class="bi bi-graph-up me-2"></i>View Stats
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-warning" href="#" onclick="suspendUser({{ $user->id }})">
                                            <i class="bi bi-pause-circle me-2"></i>Suspend
                                        </a></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser({{ $user->id }})">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </a></li>
                                    </ul>
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
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userModalBody">
                <!-- User details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-coffee text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password *</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role *</label>
                            <select class="form-select" name="role" required>
                                <option value="">Select Role</option>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Birthday</label>
                            <input type="date" class="form-control" name="birthday">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-coffee" onclick="saveUser()">
                    <i class="bi bi-check-lg me-2"></i>Create User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    @csrf
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role *</label>
                            <select class="form-select" id="editUserRole" name="role" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editUserPhone" name="phone">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="editUserBirthday" name="birthday">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="updateUser()">
                    <i class="bi bi-check-lg me-2"></i>Update User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- User Stats Modal -->
<div class="modal fade" id="userStatsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-graph-up me-2"></i>User Statistics
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userStatsBody">
                <!-- User stats will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAll = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');

    selectAll.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('userSearch');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const userRows = document.querySelectorAll('tbody tr');
        
        userRows.forEach(row => {
            const userName = row.querySelector('h6').textContent.toLowerCase();
            const userEmail = row.querySelector('.text-muted').textContent.toLowerCase();
            
            if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Add user button
    document.querySelector('.btn-coffee').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
        modal.show();
    });
});

function saveUser() {
    const form = document.getElementById('addUserForm');
    const formData = new FormData(form);
    const submitButton = event.target;
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    submitButton.disabled = true;

    fetch('/admin/users', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User created successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            form.reset();
            location.reload();
        } else {
            showNotification('Failed to create user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function viewUser(userId) {
    fetch(`/admin/users/${userId}/stats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const stats = data.stats;
                
                const modalBody = document.getElementById('userModalBody');
                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                                <span class="text-white h3 mb-0">${user.name.charAt(0).toUpperCase()}</span>
                            </div>
                            <h5>${user.name}</h5>
                            <p class="text-muted">${user.email}</p>
                            <span class="badge bg-${user.role === 'admin' ? 'danger' : 'primary'}">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span>
                        </div>
                        <div class="col-md-8">
                            <h6>Account Information</h6>
                            <table class="table table-sm">
                                <tr><td><strong>User ID:</strong></td><td>${user.id}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Active</span></td></tr>
                                <tr><td><strong>Joined:</strong></td><td>${new Date(user.created_at).toLocaleDateString()}</td></tr>
                                <tr><td><strong>Email Verified:</strong></td><td>${user.email_verified_at ? 'Yes' : 'No'}</td></tr>
                                <tr><td><strong>Total Orders:</strong></td><td>${stats.total_orders}</td></tr>
                                <tr><td><strong>Total Spent:</strong></td><td>Rs. ${stats.total_spent.toLocaleString()}</td></tr>
                                <tr><td><strong>Loyalty Points:</strong></td><td>${stats.loyalty_points}</td></tr>
                                <tr><td><strong>Loyalty Tier:</strong></td><td>${stats.loyalty_tier}</td></tr>
                            </table>
                        </div>
                    </div>
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('userModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user details', 'error');
        });
}

function editUser(userId) {
    fetch(`/admin/users/${userId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.name;
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserRole').value = user.role;
                document.getElementById('editUserPhone').value = user.phone || '';
                document.getElementById('editUserBirthday').value = user.birthday || '';
                
                const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user data', 'error');
        });
}

function updateUser() {
    const form = document.getElementById('editUserForm');
    const formData = new FormData(form);
    const userId = document.getElementById('editUserId').value;
    const submitButton = event.target;
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    submitButton.disabled = true;

    fetch(`/admin/users/${userId}`, {
        method: 'PUT',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User updated successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
            location.reload();
        } else {
            showNotification('Failed to update user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function viewUserStats(userId) {
    fetch(`/admin/users/${userId}/stats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const stats = data.stats;
                
                const modalBody = document.getElementById('userStatsBody');
                modalBody.innerHTML = `
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="stat-card text-center">
                                <h3 class="text-primary">${stats.total_orders}</h3>
                                <p>Total Orders</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card text-center">
                                <h3 class="text-success">Rs. ${stats.total_spent.toLocaleString()}</h3>
                                <p>Total Spent</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card text-center">
                                <h3 class="text-warning">${stats.loyalty_points}</h3>
                                <p>Loyalty Points</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card text-center">
                                <h3 class="text-info">${stats.total_reservations}</h3>
                                <p>Reservations</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6>Recent Orders</h6>
                            <div class="list-group">
                                ${stats.recent_orders.map(order => `
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span>#${order.order_id}</span>
                                            <span>Rs. ${order.total}</span>
                                        </div>
                                        <small class="text-muted">${new Date(order.created_at).toLocaleDateString()}</small>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Recent Reservations</h6>
                            <div class="list-group">
                                ${stats.recent_reservations.map(reservation => `
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span>#${reservation.reservation_id}</span>
                                            <span class="badge bg-${reservation.status === 'confirmed' ? 'success' : reservation.status === 'pending' ? 'warning' : 'secondary'}">${reservation.status}</span>
                                        </div>
                                        <small class="text-muted">${new Date(reservation.reservation_date).toLocaleDateString()}</small>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('userStatsModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load user statistics', 'error');
        });
}

function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        return;
    }

    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User deleted successfully!', 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Failed to delete user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
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
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
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

function suspendUser(userId) {
    if (confirm('Are you sure you want to suspend this user?')) {
        showNotification('User suspended successfully', 'warning');
    }
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
    
    .stat-card {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }
`;
document.head.appendChild(style);
</script>
@endpush