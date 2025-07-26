<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-coffee text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-gear me-2"></i>Edit Profile
                </h5>
                <a class="nav-link {{ request()->routeIs('admin.reservation-requests*') ? 'active' : '' }}" 
                   href="{{ route('admin.reservation-requests.index') }}">
                    <i class="bi bi-pencil-square"></i>
                    Reservation Changes
                </a>
            </li>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    @csrf
                    <div class="row g-4">
                        <!-- Personal Information -->
                        <div class="col-12">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-person-circle me-2"></i>Personal Information
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label for="editName" class="form-label fw-semibold">
                                <i class="bi bi-person me-2"></i>Full Name *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editName" 
                                   value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="editEmail" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2"></i>Email Address *
                            </label>
                            <input type="email" class="form-control form-control-lg" id="editEmail" 
                                   value="{{ Auth::user()->email }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="editPhone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-2"></i>Phone Number
                            </label>
                            <input type="tel" class="form-control form-control-lg" id="editPhone" 
                                   placeholder="+94 XX XXX XXXX">
                        </div>

                        <div class="col-md-6">
                            <label for="editBirthday" class="form-label fw-semibold">
                                <i class="bi bi-calendar-heart me-2"></i>Birthday
                            </label>
                            <input type="date" class="form-control form-control-lg" id="editBirthday">
                        </div>

                        <!-- Address Information -->
                        <div class="col-12 mt-4">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-geo-alt me-2"></i>Address Information
                            </h6>
                        </div>

                        <div class="col-12">
                            <label for="editAddress" class="form-label fw-semibold">
                                <i class="bi bi-house me-2"></i>Street Address
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editAddress" 
                                   placeholder="Enter your street address">
                        </div>

                        <div class="col-md-6">
                            <label for="editCity" class="form-label fw-semibold">
                                <i class="bi bi-building me-2"></i>City
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editCity" 
                                   placeholder="Enter your city">
                        </div>

                        <div class="col-md-6">
                            <label for="editPostalCode" class="form-label fw-semibold">
                                <i class="bi bi-mailbox me-2"></i>Postal Code
                            </label>
                            <input type="text" class="form-control form-control-lg" id="editPostalCode" 
                                   placeholder="Enter postal code">
                        </div>

                        <!-- Preferences -->
                        <div class="col-12 mt-4">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-sliders me-2"></i>Preferences
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label for="editLanguage" class="form-label fw-semibold">
                                <i class="bi bi-translate me-2"></i>Preferred Language
                            </label>
                            <select class="form-select form-select-lg" id="editLanguage">
                                <option value="en">English</option>
                                <option value="si">Sinhala</option>
                                <option value="ta">Tamil</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="editTimezone" class="form-label fw-semibold">
                                <i class="bi bi-clock me-2"></i>Timezone
                            </label>
                            <select class="form-select form-select-lg" id="editTimezone">
                                <option value="Asia/Colombo">Asia/Colombo (GMT+5:30)</option>
                                <option value="UTC">UTC (GMT+0:00)</option>
                            </select>
                        </div>

                        <!-- Notification Preferences -->
                        <div class="col-12 mt-4">
                            <h6 class="text-coffee mb-3">
                                <i class="bi bi-bell me-2"></i>Notification Preferences
                            </h6>
                        </div>

                        <div class="col-12">
                            <div class="notification-preferences">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="editEmailNotif" checked>
                                            <label class="form-check-label" for="editEmailNotif">
                                                <i class="bi bi-envelope me-2"></i>Email Notifications
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="editSmsNotif">
                                            <label class="form-check-label" for="editSmsNotif">
                                                <i class="bi bi-phone me-2"></i>SMS Notifications
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="editOrderUpdates" checked>
                                            <label class="form-check-label" for="editOrderUpdates">
                                                <i class="bi bi-receipt me-2"></i>Order Updates
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="editPromotions" checked>
                                            <label class="form-check-label" for="editPromotions">
                                                <i class="bi bi-gift me-2"></i>Promotional Offers
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-coffee" onclick="saveProfile()">
                    <i class="bi bi-check-lg me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-key me-2"></i>Change Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    @csrf
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label fw-semibold">
                            <i class="bi bi-lock me-2"></i>Current Password *
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="currentPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-2"></i>New Password *
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="newPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Password must be at least 8 characters with uppercase, lowercase, and numbers
                            </small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label fw-semibold">
                            <i class="bi bi-shield-check me-2"></i>Confirm New Password *
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-lg" id="confirmPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="password-strength">
                        <div class="strength-meter">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <small class="strength-text" id="strengthText">Enter a password to see strength</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="changePassword()">
                    <i class="bi bi-key me-2"></i>Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loyalty Details Modal -->
<div class="modal fade" id="loyaltyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-award me-2"></i>Loyalty Program Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                    <h6 class="text-coffee mb-3">Available Rewards</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="reward-item">
                                <div class="reward-icon">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                                <div class="reward-content">
                                    <h6>Free Coffee</h6>
                                    <p class="small text-muted">Any regular coffee drink</p>
                                    <span class="badge bg-coffee">500 points</span>
                                </div>
                                <button class="btn btn-outline-coffee btn-sm">Redeem</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="reward-item">
                                <div class="reward-icon">
                                    <i class="bi bi-cookie"></i>
                                </div>
                                <div class="reward-content">
                                    <h6>Free Pastry</h6>
                                    <p class="small text-muted">Any pastry or snack</p>
                                    <span class="badge bg-coffee">300 points</span>
                                </div>
                                <button class="btn btn-outline-coffee btn-sm">Redeem</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee">
                    <i class="bi bi-gift me-2"></i>View All Rewards
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Account Deactivation Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Deactivate Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Warning:</strong> This action will temporarily deactivate your account. You can reactivate it anytime by logging in.
                </div>

                <h6 class="mb-3">What happens when you deactivate your account?</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Your profile will be hidden</li>
                    <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Order history will be preserved</li>
                    <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Loyalty points will remain</li>
                    <li class="mb-2"><i class="bi bi-x text-danger me-2"></i>You won't receive notifications</li>
                    <li class="mb-2"><i class="bi bi-x text-danger me-2"></i>Active reservations will be cancelled</li>
                </ul>

                <div class="mt-4">
                    <label for="deactivateReason" class="form-label fw-semibold">
                        Reason for deactivation (optional)
                    </label>
                    <select class="form-select" id="deactivateReason">
                        <option value="">Select a reason</option>
                        <option value="temporary_break">Taking a temporary break</option>
                        <option value="privacy_concerns">Privacy concerns</option>
                        <option value="too_many_emails">Too many emails</option>
                        <option value="not_using">Not using the service</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label for="deactivateComments" class="form-label fw-semibold">
                        Additional comments (optional)
                    </label>
                    <textarea class="form-control" id="deactivateComments" rows="3" 
                              placeholder="Help us improve by sharing your feedback..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deactivateAccount()">
                    <i class="bi bi-pause-circle me-2"></i>Deactivate Account
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

.reward-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    border-radius: 10px;
    border: 1px solid rgba(139, 69, 19, 0.1);
}

.reward-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.reward-content {
    flex-grow: 1;
}

.reward-content h6 {
    margin-bottom: 0.25rem;
    color: var(--coffee-primary);
}

.password-strength {
    margin-top: 1rem;
}

.strength-meter {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-bar {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 4px;
}

.strength-weak { background: #dc3545; width: 25%; }
.strength-fair { background: #fd7e14; width: 50%; }
.strength-good { background: #ffc107; width: 75%; }
.strength-strong { background: #28a745; width: 100%; }

.bg-coffee {
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary)) !important;
}
</style>

<script>
function saveProfile() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    button.disabled = true;

    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Saved!';
        button.classList.remove('btn-coffee');
        button.classList.add('btn-success');

        showNotification('Profile updated successfully!', 'success');

        setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
            modal.hide();
            
            // Reset button and reload page to show changes
            setTimeout(() => {
                location.reload();
            }, 500);
        }, 1500);
    }, 1000);
}

function changePassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        showNotification('Please fill in all password fields', 'warning');
        return;
    }

    if (newPassword !== confirmPassword) {
        showNotification('New passwords do not match', 'warning');
        return;
    }

    if (newPassword.length < 8) {
        showNotification('Password must be at least 8 characters long', 'warning');
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Changing...';
    button.disabled = true;

    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Changed!';
        button.classList.remove('btn-warning');
        button.classList.add('btn-success');

        showNotification('Password changed successfully!', 'success');

        setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
            modal.hide();
            
            // Reset form and button
            document.getElementById('changePasswordForm').reset();
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('btn-success');
            button.classList.add('btn-warning');
        }, 1500);
    }, 1500);
}

function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

function deactivateAccount() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    if (!confirm('Are you sure you want to deactivate your account? You can reactivate it anytime by logging in.')) {
        return;
    }

    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deactivating...';
    button.disabled = true;

    setTimeout(() => {
        showNotification('Account deactivated successfully. You will be logged out shortly.', 'info');
        
        setTimeout(() => {
            window.location.href = '/logout';
        }, 2000);
    }, 1500);
}

// Password strength checker
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('newPassword');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
    }
});

function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (!password) {
        strengthBar.className = 'strength-bar';
        strengthText.textContent = 'Enter a password to see strength';
        return;
    }

    let score = 0;
    
    // Length check
    if (password.length >= 8) score++;
    if (password.length >= 12) score++;
    
    // Character variety checks
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    // Update strength indicator
    strengthBar.className = 'strength-bar';
    
    if (score < 3) {
        strengthBar.classList.add('strength-weak');
        strengthText.textContent = 'Weak password';
        strengthText.className = 'strength-text text-danger';
    } else if (score < 4) {
        strengthBar.classList.add('strength-fair');
        strengthText.textContent = 'Fair password';
        strengthText.className = 'strength-text text-warning';
    } else if (score < 5) {
        strengthBar.classList.add('strength-good');
        strengthText.textContent = 'Good password';
        strengthText.className = 'strength-text text-info';
    } else {
        strengthBar.classList.add('strength-strong');
        strengthText.textContent = 'Strong password';
        strengthText.className = 'strength-text text-success';
    }
}
</script>