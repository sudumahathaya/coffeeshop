@extends('layouts.master')

@section('title', 'My Profile - Café Elixir')
@section('description', 'Manage your profile, preferences, and account settings at Café Elixir.')

@section('content')
<!-- Profile Hero Section -->
<section class="profile-hero">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-lg-8" data-aos="fade-up">
                <h1 class="display-5 fw-bold text-white mb-3">My Profile</h1>
                <p class="lead text-white mb-4">
                    Manage your account settings, preferences, and coffee journey with Café Elixir.
                </p>
                <div class="d-flex gap-3">
                    <button class="btn btn-coffee btn-lg" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="profile-card">
                    <div class="text-center">
                        <div class="profile-avatar">
                            <span class="avatar-text">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <div class="avatar-badge">
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                        </div>
                        <h4 class="text-white mt-3 mb-2">{{ Auth::user()->name }}</h4>
                        <p class="text-white-50 mb-3">{{ Auth::user()->email }}</p>
                        <div class="member-since">
                            <small class="text-white-50">Member since {{ Auth::user()->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left Column - Profile Info -->
            <div class="col-lg-4">
                <!-- Account Overview -->
                <div class="profile-section mb-4" data-aos="fade-up">
                    <div class="section-header">
                        <h5><i class="bi bi-person-circle me-2 text-coffee"></i>Account Overview</h5>
                    </div>
                    <div class="section-body">
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">
                                {{ Auth::user()->email }}
                                @if(Auth::user()->email_verified_at)
                                    <i class="bi bi-patch-check-fill text-success ms-2" title="Verified"></i>
                                @else
                                    <i class="bi bi-exclamation-triangle-fill text-warning ms-2" title="Unverified"></i>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value text-muted">Not provided</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Birthday</div>
                            <div class="info-value text-muted">Not provided</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Account Status</div>
                            <div class="info-value">
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loyalty Status -->
                <div class="profile-section mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-header">
                        <h5><i class="bi bi-award me-2 text-warning"></i>Loyalty Status</h5>
                    </div>
                    <div class="section-body text-center">
                        <div class="loyalty-circle mb-3">
                            <div class="circle-progress" data-percentage="75">
                                <div class="circle-content">
                                    <span class="percentage">75%</span>
                                    <small>to Platinum</small>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-coffee mb-2">Gold Member</h6>
                        <p class="text-muted mb-3">1,250 / 1,500 points</p>
                        <div class="loyalty-benefits">
                            <div class="benefit-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>15% discount on all orders</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Free birthday coffee</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Priority reservations</span>
                            </div>
                        </div>
                        <button class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#loyaltyModal">
                            <i class="bi bi-info-circle me-2"></i>View Details
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="profile-section" data-aos="fade-up" data-aos-delay="200">
                    <div class="section-header">
                        <h5><i class="bi bi-graph-up me-2 text-info"></i>Quick Stats</h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-mini">
                                    <div class="stat-number">24</div>
                                    <div class="stat-label">Total Orders</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <div class="stat-number">8</div>
                                    <div class="stat-label">Reservations</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <div class="stat-number">Rs. 28,500</div>
                                    <div class="stat-label">Total Spent</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini">
                                    <div class="stat-number">12</div>
                                    <div class="stat-label">Favorites</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Settings & Preferences -->
            <div class="col-lg-8">
                <!-- Account Settings -->
                <div class="profile-section mb-4" data-aos="fade-up">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-gear me-2 text-coffee"></i>Account Settings</h5>
                            <button class="btn btn-outline-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </button>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div class="setting-content">
                                        <h6>Email Notifications</h6>
                                        <p class="text-muted mb-2">Receive updates about orders and offers</p>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                            <label class="form-check-label" for="emailNotifications">Enabled</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="setting-content">
                                        <h6>SMS Notifications</h6>
                                        <p class="text-muted mb-2">Get order updates via SMS</p>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="smsNotifications">
                                            <label class="form-check-label" for="smsNotifications">Disabled</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div class="setting-content">
                                        <h6>Two-Factor Authentication</h6>
                                        <p class="text-muted mb-2">Add extra security to your account</p>
                                        <button class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>Enable 2FA
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="setting-item">
                                    <div class="setting-icon">
                                        <i class="bi bi-key"></i>
                                    </div>
                                    <div class="setting-content">
                                        <h6>Password</h6>
                                        <p class="text-muted mb-2">Last changed 3 months ago</p>
                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                            <i class="bi bi-pencil me-1"></i>Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coffee Preferences -->
                <div class="profile-section mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-header">
                        <h5><i class="bi bi-cup-hot me-2 text-coffee"></i>Coffee Preferences</h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="preference-group">
                                    <h6 class="mb-3">Favorite Coffee Types</h6>
                                    <div class="preference-options">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefEspresso" checked>
                                            <label class="form-check-label" for="prefEspresso">Espresso-based drinks</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefCold" checked>
                                            <label class="form-check-label" for="prefCold">Cold brew & iced coffee</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefSpecialty">
                                            <label class="form-check-label" for="prefSpecialty">Specialty drinks</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefTea">
                                            <label class="form-check-label" for="prefTea">Tea & alternatives</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="preference-group">
                                    <h6 class="mb-3">Dietary Preferences</h6>
                                    <div class="preference-options">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefDairy">
                                            <label class="form-check-label" for="prefDairy">Dairy-free options</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefSugar">
                                            <label class="form-check-label" for="prefSugar">Sugar-free alternatives</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefDecaf">
                                            <label class="form-check-label" for="prefDecaf">Decaffeinated options</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="prefOrganic">
                                            <label class="form-check-label" for="prefOrganic">Organic products</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-coffee" onclick="savePreferences()">
                                <i class="bi bi-check-lg me-2"></i>Save Preferences
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="profile-section mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="section-header">
                        <h5><i class="bi bi-clock-history me-2 text-info"></i>Recent Activity</h5>
                    </div>
                    <div class="section-body">
                        <div class="activity-timeline">
                            <div class="activity-item">
                                <div class="activity-icon bg-success">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Order Completed</h6>
                                    <p class="text-muted mb-1">Order #CE2024001 - Cappuccino x2, Croissant x1</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="activity-amount">
                                    <span class="text-success">Rs. 1,240</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon bg-warning">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Points Earned</h6>
                                    <p class="text-muted mb-1">Earned 124 loyalty points from recent order</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="activity-amount">
                                    <span class="text-warning">+124 pts</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon bg-info">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Reservation Confirmed</h6>
                                    <p class="text-muted mb-1">Table for 4 on Dec 22, 2024 at 6:30 PM</p>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon bg-primary">
                                    <i class="bi bi-person-check"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Profile Updated</h6>
                                    <p class="text-muted mb-1">Updated coffee preferences and notifications</p>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-outline-coffee">
                                <i class="bi bi-clock-history me-2"></i>View Full Activity
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account Actions -->
                <div class="profile-section" data-aos="fade-up" data-aos-delay="300">
                    <div class="section-header">
                        <h5><i class="bi bi-tools me-2 text-secondary"></i>Account Actions</h5>
                    </div>
                    <div class="section-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <button class="btn btn-outline-primary w-100" onclick="downloadData()">
                                    <i class="bi bi-download d-block mb-2" style="font-size: 1.5rem;"></i>
                                    <span class="small">Download Data</span>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-outline-info w-100" onclick="exportOrders()">
                                    <i class="bi bi-file-earmark-text d-block mb-2" style="font-size: 1.5rem;"></i>
                                    <span class="small">Export Orders</span>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                    <i class="bi bi-pause-circle d-block mb-2" style="font-size: 1.5rem;"></i>
                                    <span class="small">Deactivate Account</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Modals -->
@include('profile.partials.profile-modals')

@push('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1920&h=600&fit=crop') center/cover;
        position: relative;
        min-height: 400px;
    }

    .profile-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .profile-hero .container {
        position: relative;
        z-index: 2;
    }

    .profile-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 4px solid rgba(255, 255, 255, 0.3);
        position: relative;
    }

    .avatar-text {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
    }

    .avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 30px;
        height: 30px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .profile-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-section:hover {
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.12);
    }

    .section-header {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-bottom: 1px solid rgba(139, 69, 19, 0.1);
        padding: 1.5rem;
    }

    .section-header h5 {
        margin: 0;
        color: var(--coffee-primary);
        font-weight: 600;
    }

    .section-body {
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
    }

    .info-value {
        font-weight: 600;
        color: var(--coffee-primary);
    }

    .loyalty-circle {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .circle-progress {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(var(--coffee-primary) 0deg, var(--coffee-primary) 270deg, #e9ecef 270deg);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .circle-progress::before {
        content: '';
        position: absolute;
        width: 90px;
        height: 90px;
        background: white;
        border-radius: 50%;
    }

    .circle-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .percentage {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--coffee-primary);
    }

    .benefit-item {
        text-align: left;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .stat-mini {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        border: 1px solid rgba(139, 69, 19, 0.1);
        transition: all 0.3s ease;
    }

    .stat-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
    }

    .stat-number {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--coffee-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    .setting-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem;
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border-radius: 15px;
        border: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .setting-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
    }

    .setting-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .setting-content {
        flex-grow: 1;
    }

    .setting-content h6 {
        color: var(--coffee-primary);
        margin-bottom: 0.5rem;
    }

    .preference-group {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(139, 69, 19, 0.05);
        height: 100%;
    }

    .preference-group h6 {
        color: var(--coffee-primary);
    }

    .preference-options .form-check {
        margin-bottom: 0.75rem;
    }

    .form-check-input:checked {
        background-color: var(--coffee-primary);
        border-color: var(--coffee-primary);
    }

    .form-check-input:focus {
        border-color: var(--coffee-primary);
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
    }

    .activity-timeline {
        position: relative;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.05);
        position: relative;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 60px;
        bottom: -15px;
        width: 2px;
        background: linear-gradient(to bottom, var(--coffee-primary), transparent);
    }

    .activity-item:last-child::before {
        display: none;
    }

    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .activity-content {
        flex-grow: 1;
    }

    .activity-content h6 {
        color: var(--coffee-primary);
        margin-bottom: 0.5rem;
    }

    .activity-amount {
        text-align: right;
        font-weight: 600;
    }

    .btn-coffee {
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .btn-coffee:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
        color: white;
    }

    .btn-outline-coffee {
        border: 2px solid var(--coffee-primary);
        color: var(--coffee-primary);
        background: transparent;
        font-weight: 600;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .btn-outline-coffee:hover {
        background: var(--coffee-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    .text-coffee {
        color: var(--coffee-primary) !important;
    }

    @media (max-width: 768px) {
        .profile-hero {
            min-height: 300px;
        }

        .profile-card {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .avatar-text {
            font-size: 2rem;
        }

        .section-header,
        .section-body {
            padding: 1rem;
        }

        .setting-item {
            padding: 1rem;
            flex-direction: column;
            text-align: center;
        }

        .activity-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .activity-item::before {
            display: none;
        }

        .activity-amount {
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize loyalty circle progress
    const circleProgress = document.querySelector('.circle-progress');
    if (circleProgress) {
        const percentage = circleProgress.getAttribute('data-percentage');
        const degrees = (percentage / 100) * 360;
        circleProgress.style.background = `conic-gradient(var(--coffee-primary) 0deg, var(--coffee-primary) ${degrees}deg, #e9ecef ${degrees}deg)`;
    }

    // Notification settings
    document.getElementById('emailNotifications').addEventListener('change', function() {
        const label = this.nextElementSibling;
        label.textContent = this.checked ? 'Enabled' : 'Disabled';
        showNotification(`Email notifications ${this.checked ? 'enabled' : 'disabled'}`, 'info');
    });

    document.getElementById('smsNotifications').addEventListener('change', function() {
        const label = this.nextElementSibling;
        label.textContent = this.checked ? 'Enabled' : 'Disabled';
        showNotification(`SMS notifications ${this.checked ? 'enabled' : 'disabled'}`, 'info');
    });

    // Setting item hover effects
    document.querySelectorAll('.setting-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Stat mini hover effects
    document.querySelectorAll('.stat-mini').forEach(stat => {
        stat.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.05)';
        });

        stat.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

function savePreferences() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    button.disabled = true;

    setTimeout(() => {
        button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Saved!';
        button.classList.remove('btn-coffee');
        button.classList.add('btn-success');

        showNotification('Coffee preferences saved successfully!', 'success');

        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('btn-success');
            button.classList.add('btn-coffee');
        }, 2000);
    }, 1000);
}

function downloadData() {
    showNotification('Preparing your data download...', 'info');
    
    setTimeout(() => {
        const data = {
            profile: {
                name: '{{ Auth::user()->name }}',
                email: '{{ Auth::user()->email }}',
                member_since: '{{ Auth::user()->created_at->format("M Y") }}'
            },
            stats: {
                total_orders: 24,
                total_spent: 28500,
                loyalty_points: 1250
            }
        };

        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'cafe-elixir-profile-data.json';
        a.click();
        URL.revokeObjectURL(url);

        showNotification('Profile data downloaded successfully!', 'success');
    }, 1500);
}

function exportOrders() {
    showNotification('Exporting your order history...', 'info');
    
    setTimeout(() => {
        const csvContent = `Order ID,Date,Items,Total,Status
CE2024001,2024-12-15,"Cappuccino x2, Croissant x1",1240.00,Completed
CE2024002,2024-12-12,"Latte x1, Sandwich x1",850.00,Completed
CE2024003,2024-12-10,"Iced Coffee x1, Muffin x2",920.00,Completed`;

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'cafe-elixir-orders.csv';
        a.click();
        URL.revokeObjectURL(url);

        showNotification('Order history exported successfully!', 'success');
    }, 1500);
}

// Notification function
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
            <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'warning' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
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
    }, 4000);
}

// CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .notification-toast {
        backdrop-filter: blur(10px);
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection