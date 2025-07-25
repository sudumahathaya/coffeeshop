@extends('layouts.admin')

@section('title', 'Menu Management - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Menu Management</h1>
            <p class="mb-0 text-muted">Manage menu items, categories, and pricing</p>
        </div>
        <div>
            <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#addItemModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Item
            </button>
        </div>
    </div>

    <!-- Menu Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-primary mx-auto mb-3">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                    <h4 class="mb-0">{{ count($menuItems) }}</h4>
                    <small class="text-muted">Total Items</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-success mx-auto mb-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="mb-0">{{ count(array_filter($menuItems, fn($item) => $item->status === 'active')) }}</h4>
                    <small class="text-muted">Active Items</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-info mx-auto mb-3">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <h4 class="mb-0">{{ count($categories) }}</h4>
                    <small class="text-muted">Categories</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon bg-warning mx-auto mb-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <h4 class="mb-0">Rs. {{ number_format(collect($menuItems)->avg('price'), 0) }}</h4>
                    <small class="text-muted">Avg. Price</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search menu items..." id="menuSearch">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="exportMenu()">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Items Grid -->
    <div class="row g-4" id="menuItemsGrid">
        @foreach($menuItems as $item)
        <div class="col-lg-4 col-md-6 menu-item-card" data-category="{{ $item->category }}" data-status="{{ $item->status }}">
            <div class="card menu-item border-0 shadow-sm h-100">
                <div class="position-relative">
                    <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-{{ $item->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-primary">{{ $item->category }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-coffee">{{ $item->name }}</h5>
                    <p class="card-text text-muted">{{ $item->description }}</p>
                    
                    <div class="item-details mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-muted">Price:</small>
                                <div class="fw-bold text-coffee">Rs. {{ number_format($item->price, 2) }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Prep Time:</small>
                                <div class="fw-bold">{{ $item->preparation_time }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Calories:</small>
                                <div class="fw-bold">{{ $item->calories }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Allergens:</small>
                                <div class="fw-bold">{{ empty($item->allergens) ? 'None' : implode(', ', $item->allergens) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="editItem({{ $item->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-{{ $item->status === 'active' ? 'warning' : 'success' }}" 
                                    onclick="toggleStatus({{ $item->id }}, '{{ $item->status }}')">
                                <i class="bi bi-{{ $item->status === 'active' ? 'pause' : 'play' }}"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteItem({{ $item->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <button class="btn btn-coffee btn-sm" onclick="viewDetails({{ $item->id }})">
                            <i class="bi bi-eye me-1"></i>Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addItemForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Item Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price (Rs.) *</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Preparation Time</label>
                            <input type="text" class="form-control" name="prep_time" placeholder="e.g., 3-4 min">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Calories</label>
                            <input type="number" class="form-control" name="calories">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ingredients (comma separated)</label>
                            <input type="text" class="form-control" name="ingredients" placeholder="e.g., Espresso, Steamed milk, Foam">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Allergens (comma separated)</label>
                            <input type="text" class="form-control" name="allergens" placeholder="e.g., Dairy, Nuts">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Image URL</label>
                            <input type="url" class="form-control" name="image" placeholder="https://...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-coffee" onclick="saveItem()">
                    <i class="bi bi-check-lg me-2"></i>Save Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="itemDetailsBody">
                <!-- Item details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee">Edit Item</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('menuSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    function filterItems() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const selectedStatus = statusFilter.value;
        const items = document.querySelectorAll('.menu-item-card');

        items.forEach(item => {
            const itemName = item.querySelector('.card-title').textContent.toLowerCase();
            const itemCategory = item.getAttribute('data-category');
            const itemStatus = item.getAttribute('data-status');

            const matchesSearch = itemName.includes(searchTerm);
            const matchesCategory = !selectedCategory || itemCategory === selectedCategory;
            const matchesStatus = !selectedStatus || itemStatus === selectedStatus;

            if (matchesSearch && matchesCategory && matchesStatus) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterItems);
    categoryFilter.addEventListener('change', filterItems);
    statusFilter.addEventListener('change', filterItems);
});

function editItem(itemId) {
    alert('Edit item functionality would be implemented here for item ID: ' + itemId);
}

function toggleStatus(itemId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    if (confirm(`Are you sure you want to ${newStatus === 'active' ? 'activate' : 'deactivate'} this item?`)) {
        alert(`Item ${newStatus === 'active' ? 'activated' : 'deactivated'} successfully!`);
        location.reload();
    }
}

function deleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        alert('Item deleted successfully!');
        location.reload();
    }
}

function viewDetails(itemId) {
    const modalBody = document.getElementById('itemDetailsBody');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=300&h=200&fit=crop" 
                     class="img-fluid rounded" alt="Item">
            </div>
            <div class="col-md-8">
                <h6>Cappuccino</h6>
                <p class="text-muted">Perfect balance of espresso, steamed milk, and foam. Traditional Italian favorite.</p>
                
                <table class="table table-sm">
                    <tr><td><strong>Category:</strong></td><td>Hot Coffee</td></tr>
                    <tr><td><strong>Price:</strong></td><td>Rs. 480.00</td></tr>
                    <tr><td><strong>Preparation Time:</strong></td><td>3-4 minutes</td></tr>
                    <tr><td><strong>Calories:</strong></td><td>120</td></tr>
                    <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Active</span></td></tr>
                </table>

                <h6 class="mt-3">Ingredients</h6>
                <p class="small">Espresso, Steamed milk, Milk foam</p>

                <h6 class="mt-3">Allergens</h6>
                <p class="small">Dairy</p>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
    modal.show();
}

function saveItem() {
    const form = document.getElementById('addItemForm');
    const formData = new FormData(form);
    
    // Simulate saving
    alert('Menu item added successfully!');
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
    modal.hide();
    form.reset();
}

function exportMenu() {
    alert('Exporting menu data...');
    // In a real application, this would generate and download a CSV/Excel file
}
</script>
@endpush