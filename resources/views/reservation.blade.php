@extends('layouts.master')

@section('title', 'Menu - Café Elixir')
@section('description', 'Explore our carefully crafted coffee menu at Café Elixir. Premium coffee blends, artisanal drinks, and delicious treats.')

@section('content')
<!-- Hero Section -->
<section class="reservation-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Reserve Your Table</h1>
                <p class="lead text-white mb-4">Secure your spot at Café Elixir for an unforgettable coffee experience. Whether it's a casual meetup, business meeting, or romantic date, we've got the perfect table for you.</p>
                <div class="d-flex gap-3">
                    <a href="#reservation-form" class="btn btn-coffee btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Book Now
                    </a>
                    <a href="{{ route('menu') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-journal-text me-2"></i>View Menu
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-stats">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <h3>500+</h3>
                                <p>Happy Customers</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <h3>4.9</h3>
                                <p>Average Rating</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <h3>6AM</h3>
                                <p>Opening Time</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-cup-hot-fill"></i>
                                </div>
                                <h3>50+</h3>
                                <p>Coffee Varieties</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reservation Form Section -->
<section id="reservation-form" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold text-coffee mb-3">Book Your Table</h2>
                    <p class="lead text-muted">Fill in the details below to reserve your perfect spot at Café Elixir</p>
                </div>

                <div class="reservation-card" data-aos="fade-up" data-aos-delay="200">
                    <form id="reservationForm" class="needs-validation reservation-form" novalidate>
                        @csrf
                        <div class="row g-4">
                            <!-- Personal Information -->
                            <div class="col-12">
                                <h5 class="text-coffee mb-3">
                                    <i class="bi bi-person-circle me-2"></i>Personal Information
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="firstName" class="form-label fw-semibold">
                                    <i class="bi bi-person me-2"></i>First Name *
                                </label>
                                <input type="text" class="form-control form-control-lg" id="firstName" name="firstName" required>
                                <div class="invalid-feedback">
                                    Please provide your first name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="lastName" class="form-label fw-semibold">
                                    <i class="bi bi-person-fill me-2"></i>Last Name *
                                </label>
                                <input type="text" class="form-control form-control-lg" id="lastName" name="lastName" required>
                                <div class="invalid-feedback">
                                    Please provide your last name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>Email Address *
                                </label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    <i class="bi bi-telephone me-2"></i>Phone Number *
                                </label>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                       placeholder="+94 XX XXX XXXX" required>
                                <div class="invalid-feedback">
                                    Please provide your phone number.
                                </div>
                            </div>

                            <!-- Reservation Details -->
                            <div class="col-12 mt-4">
                                <h5 class="text-coffee mb-3">
                                    <i class="bi bi-calendar-event me-2"></i>Reservation Details
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="reservationDate" class="form-label fw-semibold">
                                    <i class="bi bi-calendar3 me-2"></i>Date *
                                </label>
                                <input type="date" class="form-control form-control-lg" id="reservationDate"
                                       name="reservationDate" required>
                                <div class="invalid-feedback">
                                    Please select a reservation date.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="reservationTime" class="form-label fw-semibold">
                                    <i class="bi bi-clock me-2"></i>Time *
                                </label>
                                <select class="form-select form-select-lg" id="reservationTime" name="reservationTime" required>
                                    <option value="">Select Time</option>
                                    <option value="06:00">6:00 AM</option>
                                    <option value="06:30">6:30 AM</option>
                                    <option value="07:00">7:00 AM</option>
                                    <option value="07:30">7:30 AM</option>
                                    <option value="08:00">8:00 AM</option>
                                    <option value="08:30">8:30 AM</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="09:30">9:30 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="10:30">10:30 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="12:30">12:30 PM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="13:30">1:30 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="14:30">2:30 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="15:30">3:30 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="16:30">4:30 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                    <option value="17:30">5:30 PM</option>
                                    <option value="18:00">6:00 PM</option>
                                    <option value="18:30">6:30 PM</option>
                                    <option value="19:00">7:00 PM</option>
                                    <option value="19:30">7:30 PM</option>
                                    <option value="20:00">8:00 PM</option>
                                    <option value="20:30">8:30 PM</option>
                                    <option value="21:00">9:00 PM</option>
                                    <option value="21:30">9:30 PM</option>
                                    <option value="22:00">10:00 PM</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a reservation time.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="guests" class="form-label fw-semibold">
                                    <i class="bi bi-people me-2"></i>Number of Guests *
                                </label>
                                <select class="form-select form-select-lg" id="guests" name="guests" required>
                                    <option value="">Select Guests</option>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 People</option>
                                    <option value="3">3 People</option>
                                    <option value="4">4 People</option>
                                    <option value="5">5 People</option>
                                    <option value="6">6 People</option>
                                    <option value="7">7 People</option>
                                    <option value="8">8 People</option>
                                    <option value="8+">8+ People (Contact Us)</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select the number of guests.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tableType" class="form-label fw-semibold">
                                    <i class="bi bi-grid-3x3-gap me-2"></i>Table Preference
                                </label>
                                <select class="form-select form-select-lg" id="tableType" name="tableType">
                                    <option value="">No Preference</option>
                                    <option value="window">Window Side</option>
                                    <option value="corner">Corner Table</option>
                                    <option value="center">Center Area</option>
                                    <option value="outdoor">Outdoor Seating</option>
                                    <option value="private">Private Section</option>
                                </select>
                            </div>

                            <!-- Special Requests -->
                            <div class="col-12 mt-4">
                                <h5 class="text-coffee mb-3">
                                    <i class="bi bi-chat-square-text me-2"></i>Special Requests
                                </h5>
                            </div>

                            <div class="col-12">
                                <label for="occasion" class="form-label fw-semibold">
                                    <i class="bi bi-balloon-heart me-2"></i>Occasion (Optional)
                                </label>
                                <select class="form-select form-select-lg" id="occasion" name="occasion">
                                    <option value="">Select Occasion</option>
                                    <option value="birthday">Birthday Celebration</option>
                                    <option value="anniversary">Anniversary</option>
                                    <option value="business">Business Meeting</option>
                                    <option value="date">Romantic Date</option>
                                    <option value="family">Family Gathering</option>
                                    <option value="friends">Friends Meetup</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="specialRequests" class="form-label fw-semibold">
                                    <i class="bi bi-pencil-square me-2"></i>Additional Requests
                                </label>
                                <textarea class="form-control" id="specialRequests" name="specialRequests"
                                          rows="4" placeholder="Any special dietary requirements, accessibility needs, decoration requests, or other preferences..."></textarea>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="col-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label" for="agreeTerms">
                                        I agree to the <a href="#" class="text-coffee">Terms & Conditions</a> and
                                        <a href="#" class="text-coffee">Cancellation Policy</a> *
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree to the terms and conditions.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="emailUpdates">
                                    <label class="form-check-label" for="emailUpdates">
                                        <i class="bi bi-envelope-heart me-1"></i>
                                        Send me updates about special offers and events
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-4">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-coffee btn-lg">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        <span class="btn-text">Confirm Reservation</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Processing...
                                        </span>
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Your reservation will be reviewed and confirmed by our team within 2 hours.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Information Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Important Information</h2>
                <p class="lead text-muted">Please read the following before making your reservation</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h5>Reservation Policy</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>Tables held for 15 minutes</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Free cancellation up to 2 hours</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Confirmation via email & SMS</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Maximum 2 hours per reservation</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h5>Payment & Pricing</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>No reservation fee</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Pay when you visit</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>All major cards accepted</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Cash payments welcome</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5>Health & Safety</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>Sanitized tables & chairs</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Regular cleaning schedule</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Contactless menu options</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Health guidelines followed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h3 class="text-coffee mb-4">Need Help with Your Reservation?</h3>
                <p class="lead mb-4">Our friendly staff is here to assist you with any questions or special arrangements.</p>

                <div class="contact-info">
                    <div class="contact-item mb-3">
                        <i class="bi bi-telephone-fill text-coffee me-3"></i>
                        <strong>Phone:</strong> <a href="tel:+94112345678" class="text-decoration-none">+94 11 234 5678</a>
                    </div>
                    <div class="contact-item mb-3">
                        <i class="bi bi-envelope-fill text-coffee me-3"></i>
                        <strong>Email:</strong> <a href="mailto:reservations@cafeelixir.lk" class="text-decoration-none">reservations@cafeelixir.lk</a>
                    </div>
                    <div class="contact-item mb-3">
                        <i class="bi bi-geo-alt-fill text-coffee me-3"></i>
                        <strong>Address:</strong> 123 Galle Road, Colombo 03, Sri Lanka
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-clock-fill text-coffee me-3"></i>
                        <strong>Hours:</strong> Daily 6:00 AM - 10:00 PM
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="map-container">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467128486!2d79.8448244!3d6.927079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae253d10f7a7003%3A0x320b2e4d32d3838d!2sGalle%20Rd%2C%20Colombo!5e0!3m2!1sen!2slk!4v1699999999999!5m2!1sen!2slk"
                                style="border:0; border-radius: 15px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .reservation-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=1920&h=1080&fit=crop') center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .reservation-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .reservation-hero .container {
        position: relative;
        z-index: 2;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .hero-stats {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(139, 69, 19, 0.2);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .stat-card h3 {
        color: var(--coffee-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .stat-card p {
        color: #666;
        margin-bottom: 0;
        font-weight: 500;
    }

    .reservation-card {
        background: white;
        border-radius: 25px;
        padding: 3rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .form-control, .form-select {
        border-radius: 15px;
        border: 2px solid #e9ecef;
        padding: 0.875rem 1.25rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--coffee-primary);
        box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        transform: translateY(-2px);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
    }

    .btn-coffee {
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 15px;
        padding: 1rem 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-coffee::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s;
    }

    .btn-coffee:hover::before {
        left: 100%;
    }

    .btn-coffee:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(139, 69, 19, 0.3);
        color: white;
    }

    .btn-loading {
        display: none;
    }

    .btn-coffee.loading .btn-text {
        display: none;
    }

    .btn-coffee.loading .btn-loading {
        display: inline-block;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.1);
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
    }

    .info-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }

    .info-card h5 {
        color: var(--coffee-primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .info-card ul li {
        margin-bottom: 0.5rem;
        text-align: left;
    }

    .contact-info {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .contact-item {
        display: flex;
        align-items: center;
        font-size: 1.1rem;
    }

    .contact-item a {
        color: var(--coffee-primary);
        font-weight: 500;
    }

    .contact-item a:hover {
        color: var(--coffee-secondary);
    }

    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .text-coffee {
        color: var(--coffee-primary) !important;
    }

    .form-check-input:checked {
        background-color: var(--coffee-primary);
        border-color: var(--coffee-primary);
    }

    .form-check-input:focus {
        border-color: var(--coffee-primary);
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
    }

    @media (max-width: 768px) {
        .reservation-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .reservation-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .hero-stats {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .info-card {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const dateInput = document.getElementById('reservationDate');
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;

    // Set maximum date to 30 days from today
    const maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 30);
    dateInput.max = maxDate.toISOString().split('T')[0];

    // Form validation
    const reservationForm = document.getElementById('reservationForm');
    reservationForm.addEventListener('submit', function(event) {
        if (!reservationForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            reservationForm.classList.add('was-validated');
            
            // Scroll to first error
            const firstError = reservationForm.querySelector('.is-invalid, :invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Show success modal/message
    function showReservationSuccess(reservationId, data) {
        const successModal = document.createElement('div');
        successModal.className = 'modal fade';
        successModal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle-fill me-2"></i>Reservation Confirmed!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="success-icon mb-3">
                                <i class="bi bi-calendar-check-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-success">Thank you, ${data.firstName}!</h4>
                            <p class="lead">Your table reservation has been confirmed.</p>
                        </div>

                        <div class="reservation-details bg-light p-4 rounded">
                            <h6 class="fw-bold mb-3">Reservation Details:</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <strong>Reservation ID:</strong><br>
                                    <span class="text-primary">${reservationId}</span>
                                </div>
                                <div class="col-6">
                                    <strong>Guest Name:</strong><br>
                                    ${data.firstName} ${data.lastName}
                                </div>
                                <div class="col-6">
                                    <strong>Date & Time:</strong><br>
                                    ${formatDate(data.date)} at ${formatTime(data.time)}
                                </div>
                                <div class="col-6">
                                    <strong>Number of Guests:</strong><br>
                                    ${data.guests} ${data.guests === '1' ? 'Person' : 'People'}
                                </div>
                                ${data.tableType ? `
                                <div class="col-6">
                                    <strong>Table Preference:</strong><br>
                                    ${data.tableType.charAt(0).toUpperCase() + data.tableType.slice(1)}
                                </div>
                                ` : ''}
                                ${data.occasion ? `
                                <div class="col-6">
                                    <strong>Occasion:</strong><br>
                                    ${data.occasion.charAt(0).toUpperCase() + data.occasion.slice(1)}
                                </div>
                                ` : ''}
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>What's Next?</strong><br>
                            • You'll receive a confirmation email shortly<br>
                            • Please arrive 10 minutes before your reservation time<br>
                            • Contact us at +94 11 234 5678 if you need to make changes
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('menu') }}" class="btn btn-coffee">
                            <i class="bi bi-journal-text me-2"></i>View Menu
                        </a>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(successModal);
        const modal = new bootstrap.Modal(successModal);
        modal.show();

        // Remove modal from DOM when closed
        successModal.addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(successModal);
        });

        // Send notification email (simulation)
        setTimeout(() => {
            showNotification(`Confirmation email sent to ${data.email}`, 'success');
        }, 1000);
    }

    // Utility functions
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function formatTime(timeString) {
        const [hours, minutes] = timeString.split(':');
        const date = new Date();
        date.setHours(hours, minutes);
        return date.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');

        // Sri Lankan phone number formatting
        if (value.startsWith('94')) {
            value = '+' + value.substring(0, 2) + ' ' + value.substring(2, 4) + ' ' +
                    value.substring(4, 7) + ' ' + value.substring(7, 11);
        } else if (value.startsWith('0')) {
            value = '+94 ' + value.substring(1, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 10);
        }

        this.value = value;
    });

    // Real-time availability check (simulation)
    const dateInput = document.getElementById('reservationDate');
    const timeInput = document.getElementById('reservationTime');
    const guestsInput = document.getElementById('guests');

    function checkAvailability() {
        const date = dateInput.value;
        const time = timeInput.value;
        const guests = guestsInput.value;

        if (date && time && guests) {
            // Simulate availability check
            const availabilityIndicator = document.getElementById('availabilityIndicator');
            if (!availabilityIndicator) {
                const indicator = document.createElement('div');
                indicator.id = 'availabilityIndicator';
                indicator.className = 'alert mt-3';
                timeInput.parentNode.appendChild(indicator);
            }

            // Simulate random availability
            const isAvailable = Math.random() > 0.2; // 80% availability
            const indicator = document.getElementById('availabilityIndicator');

            if (isAvailable) {
                indicator.className = 'alert alert-success mt-3';
                indicator.innerHTML = `
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Great!</strong> Tables are available for ${guests} ${guests === '1' ? 'person' : 'people'} on ${formatDate(date)} at ${formatTime(time)}.
                `;
            } else {
                indicator.className = 'alert alert-warning mt-3';
                indicator.innerHTML = `
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Limited availability</strong> for this time slot. We recommend choosing an alternative time or contacting us directly.
                `;
            }
        }
    }

    // Check availability when inputs change
    [dateInput, timeInput, guestsInput].forEach(input => {
        input.addEventListener('change', checkAvailability);
    });

    // Prevent booking in the past
    timeInput.addEventListener('change', function() {
        const selectedDate = new Date(dateInput.value);
        const today = new Date();
        const selectedTime = this.value.split(':');

        selectedDate.setHours(selectedTime[0], selectedTime[1]);

        if (selectedDate < today) {
            this.setCustomValidity('Cannot book a time in the past');
            this.reportValidity();
        } else {
            this.setCustomValidity('');
        }
    });

    // Dynamic pricing information (if applicable)
    const occasionSelect = document.getElementById('occasion');
    occasionSelect.addEventListener('change', function() {
        const occasion = this.value;
        const pricingInfo = document.getElementById('pricingInfo');

        if (!pricingInfo) {
            const info = document.createElement('div');
            info.id = 'pricingInfo';
            info.className = 'alert mt-3';
            this.parentNode.appendChild(info);
        }

        const info = document.getElementById('pricingInfo');

        if (occasion === 'birthday' || occasion === 'anniversary') {
            info.className = 'alert alert-info mt-3';
            info.innerHTML = `
                <i class="bi bi-gift-fill me-2"></i>
                <strong>Special Celebration Package Available!</strong><br>
                Ask our staff about decoration options and complimentary dessert for your ${occasion}.
            `;
        } else if (occasion === 'business') {
            info.className = 'alert alert-info mt-3';
            info.innerHTML = `
                <i class="bi bi-briefcase-fill me-2"></i>
                <strong>Business Meeting Setup Available!</strong><br>
                We can provide a quiet corner table with power outlets and complimentary WiFi.
            `;
        } else {
            info.style.display = 'none';
        }
    });

    // Auto-fill for returning customers (if logged in)
    @auth
        document.getElementById('firstName').value = '{{ explode(" ", Auth::user()->name)[0] ?? "" }}';
        document.getElementById('lastName').value = '{{ explode(" ", Auth::user()->name)[1] ?? "" }}';
        document.getElementById('email').value = '{{ Auth::user()->email }}';
    @endauth
});

// Reservation form submission is now handled by master layout
</script>
@endpush
@endsection
