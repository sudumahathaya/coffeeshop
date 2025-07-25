@extends('layouts.master')

@section('title', 'Contact Us - Café Elixir')
@section('description', 'Get in touch with Café Elixir. Visit us, call us, or send us a message. We\'re here to help with all your coffee needs.')

@section('content')
<!-- Contact Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Get in Touch</h1>
                <p class="lead text-white mb-4">We'd love to hear from you! Whether you have questions, feedback, or just want to say hello, we're here to help make your coffee experience exceptional.</p>
                <div class="d-flex gap-3">
                    <a href="#contact-form" class="btn btn-coffee btn-lg">
                        <i class="bi bi-envelope me-2"></i>Send Message
                    </a>
                    <a href="#contact-info" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-geo-alt me-2"></i>Visit Us
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-stats">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <h4>6AM - 10PM</h4>
                                <p>Daily Hours</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <h4>24/7</h4>
                                <p>Phone Support</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <h4>< 2 Hours</h4>
                                <p>Email Response</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <h4>Maharagama</h4>
                                <p>Prime Location</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section id="contact-form" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold text-coffee mb-3">Send Us a Message</h2>
                    <p class="lead text-muted">We're here to help! Fill out the form below and we'll get back to you as soon as possible.</p>
                </div>

                <div class="contact-card" data-aos="fade-up" data-aos-delay="200">
                    <form id="contactForm" class="needs-validation contact-form" novalidate>
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
                                    <i class="bi bi-telephone me-2"></i>Phone Number
                                </label>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone"
                                       placeholder="+94 XX XXX XXXX">
                            </div>

                            <!-- Message Details -->
                            <div class="col-12 mt-4">
                                <h5 class="text-coffee mb-3">
                                    <i class="bi bi-chat-square-text me-2"></i>Message Details
                                </h5>
                            </div>

                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">
                                    <i class="bi bi-tag me-2"></i>Subject *
                                </label>
                                <select class="form-select form-select-lg" id="subject" name="subject" required>
                                    <option value="">Select Subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="reservation">Reservation Help</option>
                                    <option value="catering">Catering Services</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="complaint">Complaint</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="employment">Employment</option>
                                    <option value="media">Media Inquiry</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a subject.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label fw-semibold">
                                    <i class="bi bi-pencil-square me-2"></i>Message *
                                </label>
                                <textarea class="form-control" id="message" name="message"
                                          rows="6" placeholder="Tell us how we can help you..." required></textarea>
                                <div class="invalid-feedback">
                                    Please provide your message.
                                </div>
                            </div>

                            <!-- Contact Preferences -->
                            <div class="col-12 mt-4">
                                <h5 class="text-coffee mb-3">
                                    <i class="bi bi-sliders me-2"></i>Contact Preferences
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <label for="contactMethod" class="form-label fw-semibold">
                                    <i class="bi bi-chat-dots me-2"></i>Preferred Contact Method *
                                </label>
                                <select class="form-select form-select-lg" id="contactMethod" name="contactMethod" required>
                                    <option value="">Select Method</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone Call</option>
                                    <option value="whatsapp">WhatsApp</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select your preferred contact method.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="bestTime" class="form-label fw-semibold">
                                    <i class="bi bi-clock me-2"></i>Best Time to Contact
                                </label>
                                <select class="form-select form-select-lg" id="bestTime" name="bestTime">
                                    <option value="">No Preference</option>
                                    <option value="morning">Morning (6AM - 12PM)</option>
                                    <option value="afternoon">Afternoon (12PM - 6PM)</option>
                                    <option value="evening">Evening (6PM - 10PM)</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="urgency" class="form-label fw-semibold">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Urgency Level *
                                </label>
                                <select class="form-select form-select-lg" id="urgency" name="urgency" required>
                                    <option value="">Select Urgency</option>
                                    <option value="normal">Normal - Response within 24 hours</option>
                                    <option value="urgent">Urgent - Response within 4 hours</option>
                                    <option value="immediate">Immediate - Response within 1 hour</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select the urgency level.
                                </div>
                            </div>

                            <!-- Newsletter Subscription -->
                            <div class="col-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        <i class="bi bi-envelope-heart me-1"></i>
                                        Subscribe to our newsletter for updates and special offers
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-4">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-coffee btn-lg">
                                        <i class="bi bi-send me-2"></i>
                                        <span class="btn-text">Send Message</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Sending...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section id="contact-info" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Visit Our Café</h2>
                <p class="lead text-muted">Come experience the warmth and aroma of Café Elixir in person</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Location Info -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5>Our Location</h5>
                    <p class="mb-3">No.1, Mahamegawaththa Road<br>Maharagama, Sri Lanka</p>
                    <a href="https://maps.google.com" target="_blank" class="btn btn-outline-coffee btn-sm">
                        <i class="bi bi-map me-2"></i>Get Directions
                    </a>
                </div>
            </div>

            <!-- Phone Info -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5>Phone & WhatsApp</h5>
                    <p class="mb-3">
                        <strong>Phone:</strong> +94 77 186 9132<br>
                        <strong>WhatsApp:</strong> +94 77 186 9132
                    </p>
                    <div class="d-flex gap-2">
                        <a href="tel:+94771869132" class="btn btn-outline-coffee btn-sm">
                            <i class="bi bi-telephone me-1"></i>Call
                        </a>
                        <a href="https://wa.me/94771869132" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Email Info -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5>Email Addresses</h5>
                    <p class="mb-3">
                        <strong>General:</strong> info@cafeelixir.lk<br>
                        <strong>Reservations:</strong> reservations@cafeelixir.lk<br>
                        <strong>Events:</strong> events@cafeelixir.lk
                    </p>
                    <a href="mailto:info@cafeelixir.lk" class="btn btn-outline-coffee btn-sm">
                        <i class="bi bi-envelope me-2"></i>Send Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Business Hours Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h3 class="text-coffee mb-4">Business Hours</h3>
                <div class="hours-table">
                    <div class="hour-row">
                        <span class="day">Monday - Friday</span>
                        <span class="time">6:00 AM - 10:00 PM</span>
                    </div>
                    <div class="hour-row">
                        <span class="day">Saturday</span>
                        <span class="time">6:00 AM - 11:00 PM</span>
                    </div>
                    <div class="hour-row">
                        <span class="day">Sunday</span>
                        <span class="time">7:00 AM - 10:00 PM</span>
                    </div>
                </div>

                <div class="business-status mt-4">
                    <div class="status-indicator">
                        <span class="status-dot bg-success"></span>
                        <span class="status-text">Currently Open</span>
                    </div>
                    <small class="text-muted">We're here to serve you!</small>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="map-container">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467128486!2d79.8448244!3d6.927079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae253d10f7a7003%3A0x320b2e4d32d3838d!2sMaharagama!5e0!3m2!1sen!2slk!4v1699999999999!5m2!1sen!2slk"
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

<!-- Social Media Section -->
<section class="py-5 bg-coffee text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12" data-aos="fade-up">
                <h3 class="mb-4">Follow Us on Social Media</h3>
                <p class="lead mb-4">Stay connected and get the latest updates, behind-the-scenes content, and special offers!</p>
                
                <div class="social-links d-flex justify-content-center gap-4 mb-4">
                    <a href="#" class="social-link facebook">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="#" class="social-link instagram">
                        <i class="bi bi-instagram"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="#" class="social-link twitter">
                        <i class="bi bi-twitter"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="#" class="social-link youtube">
                        <i class="bi bi-youtube"></i>
                        <span>YouTube</span>
                    </a>
                    <a href="#" class="social-link tiktok">
                        <i class="bi bi-tiktok"></i>
                        <span>TikTok</span>
                    </a>
                </div>

                <p class="mb-0">
                    <i class="bi bi-hash me-1"></i>
                    <strong>#CafeElixir #CoffeeLovers #SriLankaCoffee</strong>
                </p>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=1920&h=1080&fit=crop') center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .contact-hero .container {
        position: relative;
        z-index: 2;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .contact-stats {
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
        height: 100%;
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

    .stat-card h4 {
        color: var(--coffee-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-card p {
        color: #666;
        margin-bottom: 0;
        font-weight: 500;
    }

    .contact-card {
        background: white;
        border-radius: 25px;
        padding: 3rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .contact-info-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.1);
        height: 100%;
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
    }

    .contact-icon {
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

    .contact-info-card h5 {
        color: var(--coffee-primary);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .hours-table {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .hour-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(139, 69, 19, 0.1);
    }

    .hour-row:last-child {
        border-bottom: none;
    }

    .day {
        font-weight: 600;
        color: var(--coffee-primary);
    }

    .time {
        font-weight: 500;
        color: #666;
    }

    .business-status {
        background: linear-gradient(45deg, rgba(40, 167, 69, 0.1), rgba(25, 135, 84, 0.1));
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .status-text {
        font-weight: 600;
        color: #28a745;
        font-size: 1.1rem;
    }

    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .social-links {
        flex-wrap: wrap;
    }

    .social-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        min-width: 100px;
    }

    .social-link:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-5px);
        color: white;
    }

    .social-link i {
        font-size: 2rem;
    }

    .social-link span {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .bg-coffee {
        background: linear-gradient(135deg, var(--coffee-primary), var(--coffee-secondary)) !important;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    @media (max-width: 768px) {
        .contact-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .contact-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .contact-stats {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .contact-info-card {
            padding: 1.5rem;
        }

        .social-links {
            gap: 1rem !important;
        }

        .social-link {
            min-width: 80px;
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill for logged in users
    @auth
        document.getElementById('firstName').value = '{{ explode(" ", Auth::user()->name)[0] ?? "" }}';
        document.getElementById('lastName').value = '{{ explode(" ", Auth::user()->name)[1] ?? "" }}';
        document.getElementById('email').value = '{{ Auth::user()->email }}';
    @endauth

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

    // Form validation
    const contactForm = document.getElementById('contactForm');
    contactForm.addEventListener('submit', function(event) {
        if (!contactForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            contactForm.classList.add('was-validated');
            
            // Scroll to first error
            const firstError = contactForm.querySelector('.is-invalid, :invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Social media links
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('span').textContent;
            showNotification(`${platform} page coming soon!`, 'info');
        });
    });

    // Business status check
    checkBusinessStatus();
});

function checkBusinessStatus() {
    const now = new Date();
    const currentHour = now.getHours();
    const currentDay = now.getDay(); // 0 = Sunday, 1 = Monday, etc.
    
    let isOpen = false;
    
    if (currentDay === 0) { // Sunday
        isOpen = currentHour >= 7 && currentHour < 22;
    } else if (currentDay === 6) { // Saturday
        isOpen = currentHour >= 6 && currentHour < 23;
    } else { // Monday to Friday
        isOpen = currentHour >= 6 && currentHour < 22;
    }
    
    const statusDot = document.querySelector('.status-dot');
    const statusText = document.querySelector('.status-text');
    
    if (isOpen) {
        statusDot.className = 'status-dot bg-success';
        statusText.textContent = 'Currently Open';
        statusText.style.color = '#28a745';
    } else {
        statusDot.className = 'status-dot bg-danger';
        statusText.textContent = 'Currently Closed';
        statusText.style.color = '#dc3545';
    }
}
</script>
@endpush
@endsection