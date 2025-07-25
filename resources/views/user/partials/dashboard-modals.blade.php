<!-- Loyalty Program Modal -->
<div class="modal fade" id="loyaltyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-coffee text-white">
                <h5 class="modal-title">
                    <i class="bi bi-award me-2"></i>Loyalty Program Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="loyalty-tiers">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="tier-card bronze">
                                    <div class="tier-icon">
                                        <i class="bi bi-award"></i>
                                    </div>
                                    <h6>Bronze</h6>
                                    <p class="small">0 - 499 points</p>
                                    <ul class="tier-benefits">
                                        <li>5% discount</li>
                                        <li>Birthday treat</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="tier-card gold active">
                                    <div class="tier-icon">
                                        <i class="bi bi-award-fill"></i>
                                    </div>
                                    <h6>Gold</h6>
                                    <p class="small">500 - 1,499 points</p>
                                    <ul class="tier-benefits">
                                        <li>15% discount</li>
                                        <li>Free birthday coffee</li>
                                        <li>Priority reservations</li>
                                    </ul>
                                    <div class="current-tier">Your Current Tier</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="tier-card platinum">
                                    <div class="tier-icon">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <h6>Platinum</h6>
                                    <p class="small">1,500+ points</p>
                                    <ul class="tier-benefits">
                                        <li>25% discount</li>
                                        <li>Free monthly coffee</li>
                                        <li>Exclusive events</li>
                                        <li>Personal barista</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="points-earning">
                    <h6 class="text-coffee mb-3">How to Earn Points</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="earning-method">
                                <i class="bi bi-cup-hot text-coffee me-2"></i>
                                <span>1 point per Rs. 10 spent</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="earning-method">
                                <i class="bi bi-calendar-check text-coffee me-2"></i>
                                <span>50 bonus points per reservation</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="earning-method">
                                <i class="bi bi-share text-coffee me-2"></i>
                                <span>25 points for social media shares</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="earning-method">
                                <i class="bi bi-star text-coffee me-2"></i>
                                <span>100 points for reviews</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="text-coffee mb-3">Your Progress</h6>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar bg-coffee" style="width: 83%"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">1,250 points</small>
                        <small class="text-muted">250 points to Platinum</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee">
                    <i class="bi bi-gift me-2"></i>Redeem Points
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Update Modal -->
<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-gear me-2"></i>Update Profile
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="profileUpdateForm">
                    @csrf
                    <div class="mb-3">
                        <label for="profileName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="profileName" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="profileEmail" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="profileEmail" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="profilePhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="profilePhone" placeholder="+94 XX XXX XXXX">
                    </div>
                    <div class="mb-3">
                        <label for="profileBirthday" class="form-label">Birthday (for special offers)</label>
                        <input type="date" class="form-control" id="profileBirthday">
                    </div>
                    <div class="mb-3">
                        <label for="profilePreferences" class="form-label">Coffee Preferences</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="prefStrong">
                            <label class="form-check-label" for="prefStrong">Strong coffee</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="prefDecaf">
                            <label class="form-check-label" for="prefDecaf">Decaf options</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="prefSoy">
                            <label class="form-check-label" for="prefSoy">Soy milk alternatives</label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                        <label class="form-check-label" for="emailNotifications">
                            Receive email notifications about offers and updates
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-coffee" onclick="updateProfile()">
                    <i class="bi bi-check-lg me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.tier-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
}

.tier-card.active {
    border-color: var(--coffee-primary);
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    transform: scale(1.05);
}

.tier-card.bronze .tier-icon { color: #cd7f32; }
.tier-card.gold .tier-icon { color: #ffd700; }
.tier-card.platinum .tier-icon { color: #e5e4e2; }

.tier-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.tier-benefits {
    list-style: none;
    padding: 0;
    margin: 1rem 0;
}

.tier-benefits li {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    color: #6c757d;
}

.tier-benefits li::before {
    content: '✓';
    color: #28a745;
    font-weight: bold;
    margin-right: 0.5rem;
}

.current-tier {
    background: var(--coffee-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-top: 1rem;
}

.earning-method {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid rgba(139, 69, 19, 0.1);
}

.bg-coffee {
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary)) !important;
}
</style>

<script>
function updateProfile() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
    button.disabled = true;

    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Updated!';
        button.classList.remove('btn-coffee');
        button.classList.add('btn-success');

        showNotification('Profile updated successfully!', 'success');

        setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
            modal.hide();
            
            // Reset button
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                button.classList.remove('btn-success');
                button.classList.add('btn-coffee');
            }, 500);
        }, 1500);
    }, 1000);
}
</script>