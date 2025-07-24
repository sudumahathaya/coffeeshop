@extends('layouts.admin')

@section('title', 'Settings - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Settings</h1>
            <p class="mb-0 text-muted">Manage café settings and configurations</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- General Settings -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">General Settings</h5>
                </div>
                <div class="card-body">
                    <form id="generalSettings">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Café Name</label>
                                <input type="text" class="form-control" value="{{ $settings['cafe_name'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Email</label>
                                <input type="email" class="form-control" value="{{ $settings['contact_email'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Phone</label>
                                <input type="tel" class="form-control" value="{{ $settings['contact_phone'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Max Reservation Guests</label>
                                <input type="number" class="form-control" value="{{ $settings['max_reservation_guests'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Opening Time</label>
                                <input type="time" class="form-control" value="{{ $settings['opening_time'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Closing Time</label>
                                <input type="time" class="form-control" value="{{ $settings['closing_time'] }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-coffee">
                                    <i class="bi bi-check-lg me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Notification Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">
                                    Email Notifications for New Reservations
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="smsNotifications">
                                <label class="form-check-label" for="smsNotifications">
                                    SMS Notifications for Order Updates
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="pushNotifications" checked>
                                <label class="form-check-label" for="pushNotifications">
                                    Push Notifications for Admin Panel
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-download me-2"></i>Export Data
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="bi bi-upload me-2"></i>Import Menu Items
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="bi bi-arrow-clockwise me-2"></i>Clear Cache
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="bi bi-shield-check me-2"></i>Run Security Scan
                        </button>
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-database me-2"></i>Backup Database
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Version:</strong></td>
                            <td>1.0.0</td>
                        </tr>
                        <tr>
                            <td><strong>Laravel:</strong></td>
                            <td>11.x</td>
                        </tr>
                        <tr>
                            <td><strong>PHP:</strong></td>
                            <td>8.2</td>
                        </tr>
                        <tr>
                            <td><strong>Database:</strong></td>
                            <td>SQLite</td>
                        </tr>
                        <tr>
                            <td><strong>Last Backup:</strong></td>
                            <td>2 hours ago</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('generalSettings').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Settings saved successfully!');
});
</script>
@endpush