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
                                <label class="form-label fw-semibold">Current Image:</label>
                                <div>
                                    <img id="currentImage" src="" alt="Current Image" class="img-thumbnail" 
                                         style="max-width: 200px; display: none;">
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