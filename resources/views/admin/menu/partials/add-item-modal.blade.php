<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
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
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-12">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-info-circle me-2"></i>Basic Information
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-cup-hot me-2"></i>Item Name *
                            </label>
                            <input type="text" class="form-control form-control-lg" name="name" required
                                   placeholder="e.g., Cappuccino, Latte, Croissant">
                            <div class="invalid-feedback">Please provide an item name.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-grid-3x3-gap me-2"></i>Category *
                            </label>
                            <select class="form-select form-select-lg" name="category" required>
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
                            <label class="form-label fw-semibold">
                                <i class="bi bi-currency-dollar me-2"></i>Price (Rs.) *
                            </label>
                            <input type="number" class="form-control form-control-lg" name="price" 
                                   step="0.01" min="0" required placeholder="0.00">
                            <div class="invalid-feedback">Please provide a valid price.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-clock me-2"></i>Preparation Time
                            </label>
                            <input type="text" class="form-control form-control-lg" name="preparation_time" 
                                   placeholder="e.g., 3-4 min, Ready now">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-speedometer me-2"></i>Calories
                            </label>
                            <input type="number" class="form-control form-control-lg" name="calories" 
                                   min="0" placeholder="e.g., 120">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-toggle-on me-2"></i>Status
                            </label>
                            <select class="form-select form-select-lg" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12 mt-4">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-card-text me-2"></i>Description & Details
                            </h6>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-text me-2"></i>Description *
                            </label>
                            <textarea class="form-control" name="description" rows="4" required 
                                      placeholder="Enter a detailed description of the menu item..."></textarea>
                            <div class="invalid-feedback">Please provide a description.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-list-ul me-2"></i>Ingredients (comma separated)
                            </label>
                            <input type="text" class="form-control form-control-lg" name="ingredients" 
                                   placeholder="e.g., Espresso, Steamed milk, Foam">
                            <small class="text-muted">Separate ingredients with commas</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-exclamation-triangle me-2"></i>Allergens (comma separated)
                            </label>
                            <input type="text" class="form-control form-control-lg" name="allergens" 
                                   placeholder="e.g., Dairy, Nuts, Gluten">
                            <small class="text-muted">List any allergens separated by commas</small>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-12 mt-4">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-image me-2"></i>Item Image
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-upload me-2"></i>Upload Image
                            </label>
                            <input type="file" class="form-control form-control-lg" name="image" accept="image/*">
                            <small class="text-muted">Supported formats: JPG, PNG, GIF (Max: 2MB)</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-link-45deg me-2"></i>Or Image URL
                            </label>
                            <input type="url" class="form-control form-control-lg" name="image_url" 
                                   placeholder="https://example.com/image.jpg">
                            <small class="text-muted">Provide a direct link to an image</small>
                        </div>

                        <!-- Preview Section -->
                        <div class="col-12 mt-4">
                            <div class="preview-section" style="display: none;">
                                <h6 class="text-coffee mb-3">
                                    <i class="bi bi-eye me-2"></i>Image Preview
                                </h6>
                                <img id="imagePreview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-coffee" onclick="saveItem()">
                    <i class="bi bi-check-lg me-2"></i>Save Item
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-lg, .form-select-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus, .form-select-lg:focus {
    border-color: var(--coffee-primary);
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
    transform: translateY(-1px);
}

.preview-section {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid rgba(139, 69, 19, 0.1);
}

.bg-coffee {
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary)) !important;
}
</style>

<script>
// Image preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.querySelector('input[name="image"]');
    const imageUrlInput = document.querySelector('input[name="image_url"]');
    const previewSection = document.querySelector('.preview-section');
    const imagePreview = document.getElementById('imagePreview');

    // File input preview
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewSection.style.display = 'block';
                };
                reader.readAsDataURL(file);
                imageUrlInput.value = ''; // Clear URL input
            }
        });
    }

    // URL input preview
    if (imageUrlInput) {
        imageUrlInput.addEventListener('input', function(e) {
            const url = e.target.value;
            if (url && isValidUrl(url)) {
                imagePreview.src = url;
                previewSection.style.display = 'block';
                imageInput.value = ''; // Clear file input
            } else if (!url) {
                previewSection.style.display = 'none';
            }
        });
    }

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