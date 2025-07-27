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
                    <h4 class="mb-0" id="totalItemsCount">{{ $stats['total_items'] }}</h4>
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
                    <h4 class="mb-0" id="activeItemsCount">{{ $stats['active_items'] }}</h4>
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
                    <h4 class="mb-0" id="categoriesCount">{{ $stats['total_categories'] }}</h4>
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
                    <h4 class="mb-0" id="avgPriceDisplay">Rs. {{ number_format($stats['average_price'], 0) }}</h4>
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
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="menuItemsGrid">
        @foreach($menuItems as $item)
        <div class="col menu-item-card" data-category="{{ $item->category }}" data-status="{{ $item->status }}" data-item-id="{{ $item->id }}">
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
                    <p class="card-text text-muted">{{ Str::limit($item->description, 100) }}</p>
                    
                    <div class="item-details mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-muted">Price:</small>
                                <div class="fw-bold text-coffee">Rs. {{ number_format($item->price, 2) }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Prep Time:</small>
                                <div class="fw-bold">{{ $item->preparation_time ?? 'Not specified' }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Calories:</small>
                                <div class="fw-bold">{{ $item->calories ?? 'Not specified' }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Allergens:</small>
                                <div class="fw-bold">{{ empty($item->allergens) ? 'None' : (is_array($item->allergens) ? implode(', ', $item->allergens) : $item->allergens) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewDetails({{ $item->id }})" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary" onclick="editItem({{ $item->id }})" title="Edit Item">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-{{ $item->status === 'active' ? 'warning' : 'success' }}" 
                                    onclick="toggleStatus({{ $item->id }}, '{{ $item->status }}')" 
                                    title="{{ $item->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                <i class="bi bi-{{ $item->status === 'active' ? 'pause' : 'play' }}"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteItem({{ $item->id }})" title="Delete Item">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($menuItems->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-cup text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">No menu items found</h4>
        <p class="text-muted">Start by adding your first menu item!</p>
        <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#addItemModal">
            <i class="bi bi-plus-circle me-2"></i>Add First Item
        </button>
    </div>
    @endif
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-coffee text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Add New Menu Item
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addItemForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Item Name *</label>
                            <input type="text" class="form-control" name="name" required>
                            <div class="invalid-feedback">Please provide an item name.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Hot Coffee">Hot Coffee</option>
                                <option value="Cold Coffee">Cold Coffee</option>
                                <option value="Specialty">Specialty</option>
                                <option value="Tea & Others">Tea & Others</option>
                                <option value="Food & Snacks">Food & Snacks</option>
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (Rs.) *</label>
                            <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                            <div class="invalid-feedback">Please provide a valid price.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preparation Time</label>
                            <input type="text" class="form-control" name="preparation_time" placeholder="e.g., 3-4 min">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Calories</label>
                            <input type="number" class="form-control" name="calories" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description *</label>
                            <textarea class="form-control" name="description" rows="3" required placeholder="Enter a detailed description of the menu item..."></textarea>
                            <div class="invalid-feedback">Please provide a description.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ingredients (comma separated)</label>
                            <input type="text" class="form-control" name="ingredients" placeholder="e.g., Espresso, Steamed milk, Foam">
                            <small class="text-muted">Separate ingredients with commas</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Allergens (comma separated)</label>
                            <input type="text" class="form-control" name="allergens" placeholder="e.g., Dairy, Nuts">
                            <small class="text-muted">List any allergens separated by commas</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Image</label>
                            <div class="mb-2">
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="text-muted">Or provide image URL below</small>
                            </div>
                            <input type="url" class="form-control" name="image_url" placeholder="https://...">
                            <small class="text-muted">Upload an image file or provide a URL</small>
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

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit Menu Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editItemForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editItemId" name="item_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Item Name *</label>
                            <input type="text" class="form-control" id="editItemName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select class="form-select" id="editItemCategory" name="category" required>
                                <option value="Hot Coffee">Hot Coffee</option>
                                <option value="Cold Coffee">Cold Coffee</option>
                                <option value="Specialty">Specialty</option>
                                <option value="Tea & Others">Tea & Others</option>
                                <option value="Food & Snacks">Food & Snacks</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (Rs.) *</label>
                            <input type="number" class="form-control" id="editItemPrice" name="price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preparation Time</label>
                            <input type="text" class="form-control" id="editItemPrepTime" name="preparation_time">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Calories</label>
                            <input type="number" class="form-control" id="editItemCalories" name="calories">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="editItemStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description *</label>
                            <textarea class="form-control" id="editItemDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ingredients (comma separated)</label>
                            <input type="text" class="form-control" id="editItemIngredients" name="ingredients">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Allergens (comma separated)</label>
                            <input type="text" class="form-control" id="editItemAllergens" name="allergens">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Image</label>
                            <div class="mb-2">
                                <img id="currentImage" src="" alt="Current Image" class="img-thumbnail" style="max-width: 200px; display: none;">
                            </div>
                            <div class="mb-2">
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="text-muted">Or provide image URL below</small>
                            </div>
                            <input type="url" class="form-control" id="editItemImageUrl" name="image_url">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="updateItem()">
                    <i class="bi bi-check-lg me-2"></i>Update Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Item Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="itemDetailsBody">
                <!-- Item details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee" onclick="editItemFromDetails()">
                    <i class="bi bi-pencil me-2"></i>Edit Item
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentItemId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Start real-time stats updates
    startRealTimeStatsUpdates();
    
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

function startRealTimeStatsUpdates() {
    // Update stats every 30 seconds
    setInterval(updateMenuStats, 30000);
    
    // Also update stats immediately after any menu operation
    window.updateStatsAfterOperation = function() {
        setTimeout(updateMenuStats, 500);
    };
}

function updateMenuStats() {
    fetch('/admin/api/menu-stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.stats;
                
                // Update the stat displays with animation
                animateStatUpdate('totalItemsCount', stats.total_items);
                animateStatUpdate('activeItemsCount', stats.active_items);
                animateStatUpdate('categoriesCount', stats.total_categories);
                animateStatUpdate('avgPriceDisplay', 'Rs. ' + Math.round(stats.average_price).toLocaleString());
                
                // Add visual feedback
                document.querySelectorAll('.stat-icon').forEach(icon => {
                    icon.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        icon.style.transform = 'scale(1)';
                    }, 200);
                });
            }
        })
        .catch(error => {
            console.error('Error updating menu stats:', error);
        });
}

function animateStatUpdate(elementId, newValue) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const currentValue = element.textContent;
    if (currentValue !== newValue.toString()) {
        // Add update animation
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

function viewDetails(itemId) {
    currentItemId = itemId;
    
    fetch(`/admin/menu/${itemId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = data.menu_item;
                
                const modalBody = document.getElementById('itemDetailsBody');
                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <img src="${item.image || 'https://via.placeholder.com/300x200'}" 
                                 class="img-fluid rounded" alt="${item.name}">
                        </div>
                        <div class="col-md-8">
                            <h4 class="text-coffee">${item.name}</h4>
                            <p class="text-muted">${item.description || 'No description available'}</p>
                            
                            <table class="table table-sm">
                                <tr><td><strong>Category:</strong></td><td>${item.category}</td></tr>
                                <tr><td><strong>Price:</strong></td><td>Rs. ${parseFloat(item.price).toFixed(2)}</td></tr>
                                <tr><td><strong>Preparation Time:</strong></td><td>${item.preparation_time || 'Not specified'}</td></tr>
                                <tr><td><strong>Calories:</strong></td><td>${item.calories || 'Not specified'}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-${item.status === 'active' ? 'success' : 'secondary'}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span></td></tr>
                                <tr><td><strong>Created:</strong></td><td>${new Date(item.created_at).toLocaleDateString()}</td></tr>
                                <tr><td><strong>Updated:</strong></td><td>${new Date(item.updated_at).toLocaleDateString()}</td></tr>
                            </table>

                            ${item.ingredients && item.ingredients.length > 0 ? `
                                <h6 class="mt-3">Ingredients</h6>
                                <p class="small">${Array.isArray(item.ingredients) ? item.ingredients.join(', ') : item.ingredients}</p>
                            ` : ''}

                            ${item.allergens && item.allergens.length > 0 ? `
                                <h6 class="mt-3">Allergens</h6>
                                <p class="small">${Array.isArray(item.allergens) ? item.allergens.join(', ') : item.allergens}</p>
                            ` : ''}
                        </div>
                    </div>
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load item details', 'error');
        });
}

function editItem(itemId) {
    fetch(`/admin/menu/${itemId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = data.menu_item;
                
                document.getElementById('editItemId').value = item.id;
                document.getElementById('editItemName').value = item.name;
                document.getElementById('editItemCategory').value = item.category;
                document.getElementById('editItemPrice').value = item.price;
                document.getElementById('editItemPrepTime').value = item.preparation_time || '';
                document.getElementById('editItemCalories').value = item.calories || '';
                document.getElementById('editItemStatus').value = item.status;
                document.getElementById('editItemDescription').value = item.description || '';
                document.getElementById('editItemIngredients').value = Array.isArray(item.ingredients) ? item.ingredients.join(', ') : (item.ingredients || '');
                document.getElementById('editItemAllergens').value = Array.isArray(item.allergens) ? item.allergens.join(', ') : (item.allergens || '');
                document.getElementById('editItemImageUrl').value = item.image || '';
                
                // Show current image
                const currentImage = document.getElementById('currentImage');
                if (item.image) {
                    currentImage.src = item.image;
                    currentImage.style.display = 'block';
                } else {
                    currentImage.style.display = 'none';
                }
                
                const modal = new bootstrap.Modal(document.getElementById('editItemModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to load item data', 'error');
        });
}

function editItemFromDetails() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('itemDetailsModal'));
    modal.hide();
    
    setTimeout(() => {
        editItem(currentItemId);
    }, 300);
}

function toggleStatus(itemId, currentStatus) {
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    button.disabled = true;

    fetch(`/admin/menu/${itemId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Item status updated successfully!', 'success');
            
            // Update the button and badge in the UI
            const card = button.closest('.menu-item-card');
            const statusBadge = card.querySelector('.badge');
            const newStatus = data.menu_item.status;
            
            // Update status badge
            statusBadge.className = `badge bg-${newStatus === 'active' ? 'success' : 'secondary'}`;
            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            
            // Update button
            button.className = `btn btn-outline-${newStatus === 'active' ? 'warning' : 'success'} btn-sm`;
            button.innerHTML = `<i class="bi bi-${newStatus === 'active' ? 'pause' : 'play'}"></i>`;
            button.title = newStatus === 'active' ? 'Deactivate' : 'Activate';
            
            // Update data attribute
            card.setAttribute('data-status', newStatus);
            
            // Update stats after operation
            if (typeof updateStatsAfterOperation === 'function') {
                updateStatsAfterOperation();
            }
        } else {
            showNotification('Failed to update item status', 'error');
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
        button.innerHTML = originalText;
    })
    .finally(() => {
        button.disabled = false;
    });
}

function deleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        button.disabled = true;

        fetch(`/admin/menu/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Item deleted successfully!', 'success');
                
                // Remove the item card from the UI
                const card = button.closest('.menu-item-card');
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Check if no items left
                    const remainingItems = document.querySelectorAll('.menu-item-card');
                    if (remainingItems.length === 0) {
                        location.reload(); // Reload to show empty state
                    }
                }, 300);
                
                // Update stats after operation
                if (typeof updateStatsAfterOperation === 'function') {
                    updateStatsAfterOperation();
                }
            } else {
                showNotification('Failed to delete item', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}

function saveItem() {
    const form = document.getElementById('addItemForm');
    const formData = new FormData(form);
    const submitButton = event.target;
    
    // Validate required fields
    const name = form.querySelector('[name="name"]').value;
    const description = form.querySelector('[name="description"]').value;
    const category = form.querySelector('[name="category"]').value;
    const price = form.querySelector('[name="price"]').value;
    
    if (!name || !description || !category || !price) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    if (parseFloat(price) <= 0) {
        showNotification('Price must be greater than 0', 'warning');
        return;
    }
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    submitButton.disabled = true;

    fetch('/admin/menu', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`${data.menu_item.name} has been added to the menu successfully!`, 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
            modal.hide();
            form.reset();
            
            // Add new item to the grid instead of reloading
            addItemToGrid(data.menu_item);
            
            // Update stats after operation
            if (typeof updateStatsAfterOperation === 'function') {
                updateStatsAfterOperation();
            }
        } else {
            showNotification(data.message || 'Failed to create menu item', 'error');
            if (data.errors) {
                console.error('Validation errors:', data.errors);
                // Show specific validation errors
                Object.keys(data.errors).forEach(field => {
                    const fieldElement = form.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        fieldElement.classList.add('is-invalid');
                        // Remove invalid class after 3 seconds
                        setTimeout(() => {
                            fieldElement.classList.remove('is-invalid');
                        }, 3000);
                    }
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while creating the menu item', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function updateItem() {
    const form = document.getElementById('editItemForm');
    const formData = new FormData(form);
    const itemId = document.getElementById('editItemId').value;
    const submitButton = event.target;
    
    // Add method override for PUT request
    formData.append('_method', 'PUT');
    
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    submitButton.disabled = true;

    fetch(`/admin/menu/${itemId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Menu item updated successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editItemModal'));
            modal.hide();
            
            // Update the item in the grid instead of reloading
            updateItemInGrid(data.menu_item);
            
            // Update stats after operation
            if (typeof updateStatsAfterOperation === 'function') {
                updateStatsAfterOperation();
            }
        } else {
            showNotification(data.message || 'Failed to update menu item', 'error');
            if (data.errors) {
                console.error('Validation errors:', data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating the menu item', 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function addItemToGrid(item) {
    const menuGrid = document.getElementById('menuItemsGrid');
    if (!menuGrid) return;
    
    const itemCard = createItemCard(item);
    menuGrid.insertAdjacentHTML('beforeend', itemCard);
    
    // Animate the new item
    const newCard = menuGrid.lastElementChild;
    newCard.style.opacity = '0';
    newCard.style.transform = 'scale(0.8)';
    
    setTimeout(() => {
        newCard.style.transition = 'all 0.3s ease';
        newCard.style.opacity = '1';
        newCard.style.transform = 'scale(1)';
    }, 100);
}

function updateItemInGrid(item) {
    const existingCard = document.querySelector(`[data-item-id="${item.id}"]`);
    if (!existingCard) return;
    
    const newCard = createItemCard(item);
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = newCard;
    
    existingCard.outerHTML = tempDiv.firstElementChild.outerHTML;
}

function createItemCard(item) {
    const allergens = Array.isArray(item.allergens) ? item.allergens.join(', ') : (item.allergens || 'None');
    const ingredients = Array.isArray(item.ingredients) ? item.ingredients.join(', ') : (item.ingredients || '');
    
    return `
        <div class="col menu-item-card" data-category="${item.category}" data-status="${item.status}" data-item-id="${item.id}">
            <div class="card menu-item border-0 shadow-sm h-100">
                <div class="position-relative">
                    <img src="${item.image}" class="card-img-top" alt="${item.name}" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-${item.status === 'active' ? 'success' : 'secondary'}">
                            ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                        </span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-primary">${item.category}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-coffee">${item.name}</h5>
                    <p class="card-text text-muted">${item.description.length > 100 ? item.description.substring(0, 100) + '...' : item.description}</p>
                    
                    <div class="item-details mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-muted">Price:</small>
                                <div class="fw-bold text-coffee">Rs. ${parseFloat(item.price).toFixed(2)}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Prep Time:</small>
                                <div class="fw-bold">${item.preparation_time || 'Not specified'}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Calories:</small>
                                <div class="fw-bold">${item.calories || 'Not specified'}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Allergens:</small>
                                <div class="fw-bold">${allergens}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewDetails(${item.id})" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary" onclick="editItem(${item.id})" title="Edit Item">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-${item.status === 'active' ? 'warning' : 'success'}" 
                                    onclick="toggleStatus(${item.id}, '${item.status}')" 
                                    title="${item.status === 'active' ? 'Deactivate' : 'Activate'}">
                                <i class="bi bi-${item.status === 'active' ? 'pause' : 'play'}"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteItem(${item.id})" title="Delete Item">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
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

function exportMenu() {
    showNotification('Export functionality coming soon!', 'info');
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
    
    .menu-item:hover .stat-icon {
        transform: scale(1.1);
    }
    
    .stats-updated {
        animation: statsGlow 0.5s ease;
    }
    
    @keyframes statsGlow {
        0% { box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
        50% { box-shadow: 0 0 20px rgba(40, 167, 69, 0.8); }
        100% { box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
    }
    
    .menu-item-card {
        transition: all 0.3s ease;
    }
    
    .menu-item-card:hover {
        transform: translateY(-5px);
    }
    
    .item-details {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid rgba(139, 69, 19, 0.05);
    }
`;
document.head.appendChild(style);
</script>
@endpush