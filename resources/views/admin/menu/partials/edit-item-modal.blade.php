<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
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
                    
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="text-warning mb-3">
                                <i class="bi bi-info-circle me-2"></i>Basic Information
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-cup-hot me-2"></i>Item Name *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editItemName" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-grid-3x3-gap me-2"></i>Category *
                            </label>
                            <select class="form-select form-select-lg" id="editItemCategory" name="category" required>
                                <option value="Hot Coffee">Hot Coffee</option>
                                <option value="Cold Coffee">Cold Coffee</option>
                                <option value="Specialty">Specialty</option>
                                <option value="Tea & Others">Tea & Others</option>
                                <option value="Food & Snacks">Food & Snacks</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-currency-dollar me-2"></i>Price (Rs.) *
                            </label>
                            <input type="number" class="form-control form-control-lg" id="editItemPrice" 
                                   name="price" step="0.01" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-clock me-2"></i>Preparation Time
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editItemPrepTime" 
                                   name="preparation_time">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-speedometer me-2"></i>Calories
                            </label>
                            <input type="number" class="form-control form-control-lg" id="editItemCalories" 
                                   name="calories">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-toggle-on me-2"></i>Status
                            </label>
                            <select class="form-select form-select-lg" id="editItemStatus" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12 mt-4">
                            <h6 class="text-warning mb-3">
                                <i class="bi bi-card-text me-2"></i>Description & Details
                            </h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-text me-2"></i>Description *
                            </label>
                            <textarea class="form-control" id="editItemDescription" name="description" 
                                      rows="4" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-list-ul me-2"></i>Ingredients (comma separated)
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editItemIngredients" 
                                   name="ingredients">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-exclamation-triangle me-2"></i>Allergens (comma separated)
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editItemAllergens" 
                                   name="allergens">
                        </div>

                        <!-- Image Upload -->
                        <div class="col-12 mt-4">
                            <h6 class="text-warning mb-3">
                                <i class="bi bi-image me-2"></i>Item Image
                            </h6>
                        </div>

                        <div class="col-12">
                            <div class="current-image mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image me-2"></i>Current Image:
                                </label>
                                <div class="current-image-container">
                                    <img id="currentImage" src="" alt="Current Image" class="current-image-display" 
                                         style="display: none;">
                                    <div class="image-overlay">
                                        <button type="button" class="btn btn-sm btn-outline-light" onclick="previewCurrentImage()">
                                            <i class="bi bi-eye"></i> Preview
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-upload me-2"></i>Upload New Image
                            </label>
                            <input type="file" class="form-control form-control-lg" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-link-45deg me-2"></i>Or Image URL
                            </label>
                            <input type="url" class="form-control form-control-lg" id="editItemImageUrl" 
                                   name="image_url">
                        </div>
                        
                        <!-- New Image Preview -->
                        <div class="col-12">
                            <div class="new-preview-section" id="editImagePreviewSection" style="display: none;">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-eye me-2"></i>New Image Preview:
                                </label>
                                <div class="preview-container">
                                    <img id="editImagePreview" src="" alt="New Preview" class="preview-image">
                                    <button type="button" class="btn btn-sm btn-outline-danger preview-remove" onclick="removeEditImagePreview()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-warning" onclick="updateItem()">
                    <i class="bi bi-check-lg me-2"></i>Update Item
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.current-image-container {
    position: relative;
    display: inline-block;
}

.current-image-display {
    max-width: 200px;
    max-height: 150px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    border-radius: 10px;
}

.current-image-container:hover .image-overlay {
    opacity: 1;
}

.new-preview-section {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid rgba(139, 69, 19, 0.1);
}
</style>

<script>
// Enhanced edit modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const editImageInput = document.querySelector('#editItemModal input[name="image"]');
    const editImageUrlInput = document.getElementById('editItemImageUrl');
    const editImagePreview = document.getElementById('editImagePreview');
    const editPreviewSection = document.getElementById('editImagePreviewSection');

    // File input preview for edit modal
    if (editImageInput) {
        editImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    this.value = '';
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    alert('Image size must be less than 2MB.');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    editImagePreview.src = e.target.result;
                    showEditImagePreview();
                };
                reader.readAsDataURL(file);
                editImageUrlInput.value = ''; // Clear URL input
            }
        });
    }

    // URL input preview for edit modal
    if (editImageUrlInput) {
        editImageUrlInput.addEventListener('input', function(e) {
            const url = e.target.value;
            if (url && isValidUrl(url)) {
                const testImg = new Image();
                testImg.onload = function() {
                    editImagePreview.src = url;
                    showEditImagePreview();
                    editImageInput.value = ''; // Clear file input
                };
                testImg.onerror = function() {
                    alert('Invalid image URL. Please check the URL and try again.');
                };
                testImg.src = url;
            } else if (!url) {
                hideEditImagePreview();
            }
        });
    }
    
    function showEditImagePreview() {
        editPreviewSection.style.display = 'block';
        editPreviewSection.style.opacity = '0';
        editPreviewSection.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            editPreviewSection.style.transition = 'all 0.3s ease';
            editPreviewSection.style.opacity = '1';
            editPreviewSection.style.transform = 'translateY(0)';
        }, 100);
    }
    
    function hideEditImagePreview() {
        editPreviewSection.style.transition = 'all 0.3s ease';
        editPreviewSection.style.opacity = '0';
        editPreviewSection.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            editPreviewSection.style.display = 'none';
        }, 300);
    }
    
    window.removeEditImagePreview = function() {
        editImageInput.value = '';
        editImageUrlInput.value = '';
        hideEditImagePreview();
    };
    
    window.previewCurrentImage = function() {
        const currentImage = document.getElementById('currentImage');
        if (currentImage.src) {
            // Create full-screen preview modal
            const previewModal = document.createElement('div');
            previewModal.className = 'modal fade';
            previewModal.innerHTML = `
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Image Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${currentImage.src}" class="img-fluid" alt="Full Preview">
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(previewModal);
            const modal = new bootstrap.Modal(previewModal);
            modal.show();
            
            previewModal.addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(previewModal);
            });
        }
    };
    
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
});
</script>