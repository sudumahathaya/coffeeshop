<!-- Item Details Modal -->
<div class="modal fade" id="itemDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Menu Item Details
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
                <button type="button" class="btn btn-outline-warning" onclick="toggleStatusFromDetails()">
                    <i class="bi bi-eye-slash me-2"></i>Toggle Status
                </button>
                <button type="button" class="btn btn-outline-danger" onclick="deleteItemFromDetails()">
                    <i class="bi bi-trash me-2"></i>Delete Item
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.detail-section {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(139, 69, 19, 0.1);
}

.detail-section h6 {
    color: var(--coffee-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    border-bottom: 2px solid var(--coffee-primary);
    padding-bottom: 0.5rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(139, 69, 19, 0.05);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #6c757d;
    min-width: 120px;
}

.detail-value {
    font-weight: 500;
    color: var(--coffee-primary);
    text-align: right;
    flex-grow: 1;
}

.ingredient-tag, .allergen-tag {
    display: inline-block;
    background: var(--coffee-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    margin: 0.25rem;
    font-weight: 500;
}

.allergen-tag {
    background: #dc3545;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.status-inactive {
    background: linear-gradient(45deg, #6c757d, #adb5bd);
    color: white;
}

.item-image-large {
    width: 100%;
    max-width: 400px;
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.nutrition-info {
    background: linear-gradient(45deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.price-display {
    font-size: 2rem;
    font-weight: 700;
    color: var(--coffee-primary);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}
</style>