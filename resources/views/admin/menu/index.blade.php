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
                    <h4 class="mb-0">{{ $menuItems->where('status', 'active')->count() }}</h4>
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
                            <input type="text" class="form-control" name="category" list="categoryList" required>
                            <datalist id="categoryList">
                                <option value="Hot Coffee">
                                <option value="Cold Coffee">
                                <option value="Specialty">
                                <option value="Tea & Others">
                                <option value="Food & Snacks">
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price (Rs.) *</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Preparation Time</label>
                            <input type="text" class="form-control" name="preparation_time" placeholder="e.g., 3-4 min">
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
                            <label class="form-label">Image</label>
                            <div class="mb-2">
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="text-muted">Or provide image URL below</small>
                            </div>
                            <input type="url" class="form-control" name="image_url" placeholder="https://...">
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
                <form id="editItemForm">
                    @csrf
                    <input type="hidden" id="editItemId" name="item_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Item Name *</label>
                            <input type="text" class="form-control" id="editItemName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <input type="text" class="form-control" id="editItemCategory" name="category" list="categoryList" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price (Rs.) *</label>
                            <input type="number" class="form-control" id="editItemPrice" name="price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Preparation Time</label>
                            <input type="text" class="form-control" id="editItemPrepTime" name="preparation_time">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Calories</label>
                            <input type="number" class="form-control" id="editItemCalories" name="calories">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editItemStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="editItemDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ingredients (comma separated)</label>
                            <input type="text" class="form-control" id="editItemIngredients" name="ingredients">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Allergens (comma separated)</label>
                            <input type="text" class="form-control" id="editItemAllergens" name="allergens">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Image</label>
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
            <div class="modal-header">
                <h5 class="modal-title">Item Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="itemDetailsBody">
                <!-- Item details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee" onclick="editItemFromDetails()">Edit Item</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentItemId = null;

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
                document.getElementById('editItemIngredients').value = item.ingredients ? item.ingredients.join(', ') : '';
                document.getElementById('editItemAllergens').value = item.allergens ? item.allergens.join(', ') : '';
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

function toggleStatus(itemId, currentStatus) {
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
            location.reload();
        } else {
            showNotification('Failed to update item status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function deleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
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
                location.reload();
            } else {
                showNotification('Failed to delete item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
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
                            <h6>${item.name}</h6>
                            <p class="text-muted">${item.description || 'No description available'}</p>
                            
                            <table class="table table-sm">
                                <tr><td><strong>Category:</strong></td><td>${item.category}</td></tr>
                                <tr><td><strong>Price:</strong></td><td>Rs. ${parseFloat(item.price).toFixed(2)}</td></tr>
                                <tr><td><strong>Preparation Time:</strong></td><td>${item.preparation_time || 'Not specified'}</td></tr>
                                <tr><td><strong>Calories:</strong></td><td>${item.calories || 'Not specified'}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge bg-${item.status === 'active' ? 'success' : 'secondary'}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span></td></tr>
                            </table>

                            ${item.ingredients && item.ingredients.length > 0 ? `
                                <h6 class="mt-3">Ingredients</h6>
                                <p class="small">${item.ingredients.join(', ')}</p>
                            ` : ''}

                            ${item.allergens && item.allergens.length > 0 ? `
                                <h6 class="mt-3">Allergens</h6>
                                <p class="small">${item.allergens.join(', ')}</p>
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

function editItemFromDetails() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('itemDetailsModal'));
    modal.hide();
    
    setTimeout(() => {
        editItem(currentItemId);
    }, 300);
}
    
function saveItem() {
    const form = document.getElementById('addItemForm');
    const formData = new FormData(form);
    const submitButton = event.target;
    
    // Convert comma-separated strings to arrays
    const ingredients = formData.get('ingredients');
    const allergens = formData.get('allergens');
    
    if (ingredients) {
        formData.delete('ingredients');
        ingredients.split(',').forEach((ingredient, index) => {
            formData.append(`ingredients[${index}]`, ingredient.trim());
        });
    }
    
    if (allergens) {
        formData.delete('allergens');
        allergens.split(',').forEach((allergen, index) => {
            formData.append(`allergens[${index}]`, allergen.trim());
        });
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
            showNotification('Menu item created successfully!', 'success');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
            modal.hide();
            form.reset();
            location.reload();
        } else {
            showNotification('Failed to create menu item', 'error');
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

function updateItem() {
    const form = document.getElementById('editItemForm');
    const formData = new FormData(form);
    const itemId = document.getElementById('editItemId').value;
    const submitButton = event.target;
    
    // Convert comma-separated strings to arrays
    const ingredients = formData.get('ingredients');
    const allergens = formData.get('allergens');
    
    if (ingredients) {
        formData.delete('ingredients');
        ingredients.split(',').forEach((ingredient, index) => {
            formData.append(`ingredients[${index}]`, ingredient.trim());
        });
    }
    
    if (allergens) {
        formData.delete('allergens');
        allergens.split(',').forEach((allergen, index) => {
            formData.append(`allergens[${index}]`, allergen.trim());
        });
    }
    
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
            location.reload();
        } else {
            showNotification('Failed to update menu item', 'error');
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
    showNotification('Exporting menu data...', 'info');
    
    fetch('/admin/menu/export')
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'menu-items.csv';
            a.click();
            window.URL.revokeObjectURL(url);
            showNotification('Menu exported successfully!', 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Export failed', 'error');
        });
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
`;
document.head.appendChild(style);
</script>
@endpush