@extends('layouts.master')

@section('title', 'Contact Us - Café Elixir')
@section('description', 'Get in touch with Café Elixir. Visit us, call us, or send us a message. We\'d love to hear from you!')

@section('content')
<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Get In Touch</h1>
                <p class="lead text-white mb-4">We'd love to hear from you! Whether you have questions about our coffee, want to make a reservation, or just want to chat about your favorite brew, we're here to help.</p>
                <div class="d-flex gap-3">
                    <a href="#contact-form" class="btn btn-coffee btn-lg">
                        <i class="bi bi-envelope me-2"></i>Send Message
                    </a>
                    <a href="tel:+94771869132" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-telephone me-2"></i>Call Now
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="contact-info-cards">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="info-card-hero">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle me-3">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-white">Visit Our Café</h6>
                                        <p class="mb-0 text-white-50">123 Galle Road, Colombo 03, Sri Lanka</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card-hero">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle me-3">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-white">Call Us</h6>
                                        <p class="mb-0 text-white-50">+94 11 234 5678</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card-hero">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle me-3">
                                        <i class="bi bi-clock-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-white">Open Daily</h6>
                                        <p class="mb-0 text-white-50">6:00 AM - 10:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Multiple Ways to Connect</h2>
                <p class="lead text-muted">Choose the most convenient way to reach out to us</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Location Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-card h-100">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="card-title">Visit Our Café</h5>
                    <div class="contact-details">
                        <p class="mb-2"><strong>Address:</strong></p>
                        <p class="mb-3">No1,<br>Mahamegawaththa Road,<br>Maharagama</p>
                        <p class="mb-2"><strong>Landmarks:</strong></p>
                        <p class="text-muted small">Near Sathara builsing<br>Near Mirror Salloon</p>
                    </div>
                    <div class="contact-actions">
                        <a href="https://maps.google.com/?q=123+Galle+Road+Colombo"
                           target="_blank" class="btn btn-outline-coffee btn-sm">
                            <i class="bi bi-map me-1"></i>Get Directions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Phone Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-card h-100">
                    <div class="contact-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="card-title">Call or Text</h5>
                    <div class="contact-details">
                        <p class="mb-2"><strong>Main Line:</strong></p>
                        <p class="mb-3"><a href="tel:+94771869132" class="text-coffee">+94 77 186 9132</a></p>
                        <p class="mb-2"><strong>WhatsApp:</strong></p>
                        <p class="mb-3"><a href="https://wa.me/94771869132" class="text-coffee">+94 77 186 9132</a></p>
                        <p class="mb-2"><strong>Reservations:</strong></p>
                        <p class="text-muted">Direct line for table bookings</p>
                    </div>
                    <div class="contact-actions">
                        <a href="tel:+94771869132" class="btn btn-coffee btn-sm me-2">
                            <i class="bi bi-telephone me-1"></i>Call Now
                        </a>
                        <a href="https://wa.me/94771869132" class="btn btn-outline-coffee btn-sm">
                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Email Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-card h-100">
                    <div class="contact-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5 class="card-title">Email Us</h5>
                    <div class="contact-details">
                        <p class="mb-2"><strong>General Inquiries:</strong></p>
                        <p class="mb-3"><a href="mailto:info@cafeelixir.lk" class="text-coffee">info@cafeelixir.lk</a></p>
                        <p class="mb-2"><strong>Reservations:</strong></p>
                        <p class="mb-3"><a href="mailto:reservations@cafeelixir.lk" class="text-coffee">reservations@cafeelixir.lk</a></p>
                        <p class="mb-2"><strong>Events & Catering:</strong></p>
                        <p class="text-muted"><a href="mailto:events@cafeelixir.lk" class="text-coffee">events@cafeelixir.lk</a></p>
                    </div>
                    <div class="contact-actions">
                        <a href="mailto:info@cafeelixir.lk" class="btn btn-outline-coffee btn-sm">
                            <i class="bi bi-envelope me-1"></i>Send Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section id="contact-form" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold text-coffee mb-3">Send Us a Message</h2>
                    <p class="lead text-muted">Have a question, feedback, or special request? We'd love to hear from you!</p>
                </div>

                <div class="contact-form-card" data-aos="fade-up" data-aos-delay="200">
                    <form id="contactForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-4">
                            <!-- Personal Information -->
                            <div class="col-12">
                                <h5 class="text-coffee mb-3">
                                    <i class="bi bi-person-circle me-2"></i>Your Information
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
                                    <i class="bi bi-chat-square-text me-2"></i>Your Message
                                </h5>
                            </div>

                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">
                                    <i class="bi bi-tag me-2"></i>Subject *
                                </label>
                                <select class="form-select form-select-lg" id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="reservation">Table Reservation</option>
                                    <option value="catering">Catering & Events</option>
                                    <option value="feedback">Feedback & Suggestions</option>
                                    <option value="complaint">Complaint or Issue</option>
                                    <option value="partnership">Business Partnership</option>
                                    <option value="employment">Employment Inquiry</option>
                                    <option value="media">Media & Press</option>
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
                                <textarea class="form-control" id="message" name="message" rows="6"
                                          placeholder="Tell us how we can help you..." required></textarea>
                                <div class="invalid-feedback">
                                    Please enter your message.
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Please be as detailed as possible to help us assist you better.
                                    </small>
                                </div>
                            </div>

                            <!-- Preferred Contact Method -->
                            <div class="col-12 mt-4">
                                <h6 class="text-coffee mb-3">Preferred Response Method</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contactMethod"
                                                   id="contactEmail" value="email" checked>
                                            <label class="form-check-label" for="contactEmail">
                                                <i class="bi bi-envelope me-1"></i>Email
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contactMethod"
                                                   id="contactPhone" value="phone">
                                            <label class="form-check-label" for="contactPhone">
                                                <i class="bi bi-telephone me-1"></i>Phone Call
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contactMethod"
                                                   id="contactWhatsapp" value="whatsapp">
                                            <label class="form-check-label" for="contactWhatsapp">
                                                <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Best Time to Contact -->
                            <div class="col-md-6">
                                <label for="bestTime" class="form-label fw-semibold">
                                    <i class="bi bi-clock me-2"></i>Best Time to Contact
                                </label>
                                <select class="form-select form-select-lg" id="bestTime" name="bestTime">
                                    <option value="">Any time</option>
                                    <option value="morning">Morning (8 AM - 12 PM)</option>
                                    <option value="afternoon">Afternoon (12 PM - 5 PM)</option>
                                    <option value="evening">Evening (5 PM - 8 PM)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="urgency" class="form-label fw-semibold">
                                    <i class="bi bi-exclamation-circle me-2"></i>Urgency Level
                                </label>
                                <select class="form-select form-select-lg" id="urgency" name="urgency">
                                    <option value="normal">Normal (2-3 business days)</option>
                                    <option value="urgent">Urgent (Within 24 hours)</option>
                                    <option value="immediate">Immediate (ASAP)</option>
                                </select>
                            </div>

                            <!-- Newsletter Subscription -->
                            <div class="col-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        <i class="bi bi-envelope-heart me-1"></i>
                                        Subscribe to our newsletter for coffee tips and special offers
                                    </label>
                                </div>
                            </div>

                            <!-- Privacy Policy -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        I agree to the <a href="#" class="text-coffee">Privacy Policy</a> and
                                        consent to Café Elixir contacting me regarding my inquiry *
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree to our privacy policy.
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-4">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-coffee btn-lg" id="submitContact">
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

<!-- Map Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <h3 class="text-coffee mb-4">Find Us on the Map</h3>
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

                <div class="map-info mt-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="bi bi-car-front text-coffee me-2"></i>
                                <strong>Parking:</strong> Street parking available, paid parking nearby
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="bi bi-bus-front text-coffee me-2"></i>
                                <strong>Public Transport:</strong> Bus stops within 100m
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="bi bi-bicycle text-coffee me-2"></i>
                                <strong>Bicycle Friendly:</strong> Bike parking available
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="bi bi-universal-access text-coffee me-2"></i>
                                <strong>Accessibility:</strong> Wheelchair accessible entrance
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-left">
                <h4 class="text-coffee mb-4">Business Hours</h4>
                <div class="hours-card">
                    <div class="hours-item">
                        <div class="d-flex justify-content-between">
                            <span class="day">Monday</span>
                            <span class="time">6:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                    <div class="hours-item">
                        <div class="d-flex justify-content-between">
                            <span class="day">Tuesday</span>
                            <span class="time">6:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                    <div class="hours-item">
                        <div class="d-flex justify-content-between">
                            <span class="day">Wednesday</span>
                            <span class="time">6:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                    <div class="hours-item">
                        <div class="d-flex justify-content-between">
                            <span class="day">Thursday</span>
                            <span class="time">6:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                    <div class="hours-item">
                        <div class="d-flex justify-content-between">
                            <span class="day">Friday</span>
                            <span class="time">6:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                    <div class="hours-item weekend">
                        <div class="d-flex justify-content-between">
                            <span class="day">Saturday</span>
                            <span class="time">6:00 AM - 11:00 PM</span>
                        </div>
                    </div>
                    <div class="hours-item weekend">
                        <div class="d-flex justify-content-between">
                            <span class="day">Sunday</span>
                            <span class="time">7:00 AM - 10:00 PM</span>
                        </div>
                    </div>
                </div>

                <div class="status-card mt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Current Status</h6>
                            <span class="status-text" id="currentStatus">Checking...</span>
                        </div>
                        <div class="status-indicator" id="statusIndicator">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>

                <h5 class="text-coffee mt-4 mb-3">Follow Us</h5>
                <div class="social-links">
                    <a href="#" class="social-link me-3">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-link me-3">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-link me-3">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="social-link me-3">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Frequently Asked Questions</h2>
                <p class="lead text-muted">Quick answers to common questions</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle me-2 text-coffee"></i>
                                Do I need a reservation to visit?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                While reservations are not required, we highly recommend making one during peak hours (7-9 AM, 12-2 PM, 7-9 PM) and weekends to ensure you get your preferred seating. Walk-ins are always welcome when space is available!
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-wifi me-2 text-coffee"></i>
                                Do you have free WiFi?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! We offer complimentary high-speed WiFi to all our customers. The network name is "CafeElixir_Free" and the password is available at the counter. Perfect for remote work or staying connected while enjoying your coffee.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-credit-card me-2 text-coffee"></i>
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept cash (LKR), all major credit cards (Visa, Mastercard, Amex), debit cards, and popular mobile payments including Dialog eZ Cash, Mobitel mCash, and international options like Apple Pay and Google Pay.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="bi bi-cup-hot me-2 text-coffee"></i>
                                Do you have vegan and dietary options?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely! We offer plant-based milk alternatives (oat, almond, soy, coconut milk), vegan pastries, gluten-free options, and can accommodate most dietary restrictions. Please inform our staff about any allergies or dietary requirements.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                <i class="bi bi-people me-2 text-coffee"></i>
                                Can you accommodate large groups or events?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! We can accommodate groups of 8-20 people with advance notice. For larger events, birthday parties, or corporate gatherings, please contact our events team at events@cafeelixir.lk or call us directly to discuss arrangements and catering options.
                            </div>
                        </div>
                    </div>
                </div>
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

    .info-card-hero {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .info-card-hero:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
    }

    .contact-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .contact-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
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
        transition: all 0.3s ease;
    }

    .contact-card:hover .contact-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .contact-details {
        text-align: left;
        margin: 1.5rem 0;
    }

    .contact-details a {
        text-decoration: none;
        font-weight: 500;
    }

    .contact-details a:hover {
        text-decoration: underline;
    }

    .contact-actions {
        margin-top: 1.5rem;
    }

    .contact-form-card {
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

    .btn-loading {
        display: none;
    }

    .btn-coffee.loading .btn-text {
        display: none;
    }

    .btn-coffee.loading .btn-loading {
        display: inline-block;
    }

    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: rgba(139, 69, 19, 0.05);
        border-radius: 10px;
        margin-bottom: 0.5rem;
    }

    .hours-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .hours-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .hours-item:last-child {
        border-bottom: none;
    }

    .hours-item:hover {
        background: rgba(139, 69, 19, 0.05);
        border-radius: 8px;
        margin: 0 -0.5rem;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .hours-item.weekend {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.1), rgba(210, 105, 30, 0.1));
        border-radius: 8px;
        margin: 0.25rem 0;
        padding: 1rem;
    }

    .day {
        font-weight: 600;
        color: var(--coffee-primary);
    }

    .time {
        color: #666;
        font-weight: 500;
    }

    .status-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .status-indicator {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .status-indicator.open {
        background: #28a745;
        color: white;
    }

    .status-indicator.closed {
        background: #dc3545;
        color: white;
    }

    .status-indicator.closing-soon {
        background: #ffc107;
        color: white;
    }

    .social-link {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .social-link:hover {
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
        color: white;
    }

    .accordion-item {
        border: 1px solid rgba(139, 69, 19, 0.1);
        border-radius: 15px !important;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .accordion-button {
        background: white;
        border: none;
        font-weight: 600;
        color: #333;
        padding: 1.5rem;
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(45deg, rgba(139, 69, 19, 0.1), rgba(210, 105, 30, 0.1));
        color: var(--coffee-primary);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
    }

    .accordion-body {
        padding: 1.5rem;
        background: rgba(139, 69, 19, 0.02);
        line-height: 1.6;
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
        .contact-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .contact-form-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .contact-card {
            padding: 2rem 1.5rem;
        }

        .hours-card {
            padding: 1.5rem;
        }

        .info-card-hero {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form validation and submission
    const contactForm = document.getElementById('contactForm');
    const submitButton = document.getElementById('submitContact');

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (contactForm.checkValidity()) {
            handleContactSubmission();
        } else {
            // Show validation errors
            contactForm.classList.add('was-validated');

            // Scroll to first error
            const firstError = contactForm.querySelector('.is-invalid, :invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Handle form submission
    function handleContactSubmission() {
        // Show loading state
        submitButton.classList.add('loading');
        submitButton.disabled = true;

        // Collect form data
        const formData = new FormData(contactForm);
        const contactData = {
            firstName: formData.get('firstName'),
            lastName: formData.get('lastName'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            subject: formData.get('subject'),
            message: formData.get('message'),
            contactMethod: formData.get('contactMethod'),
            bestTime: formData.get('bestTime'),
            urgency: formData.get('urgency'),
            newsletter: formData.get('newsletter') === 'on'
        };

        // Simulate API call
        setTimeout(() => {
            // Generate message ID
            const messageId = 'CM' + Date.now().toString().slice(-6);

            // Store message in localStorage (for demo purposes)
            const messages = JSON.parse(localStorage.getItem('cafeElixirMessages')) || [];
            messages.push({
                id: messageId,
                ...contactData,
                status: 'received',
                createdAt: new Date().toISOString()
            });
            localStorage.setItem('cafeElixirMessages', JSON.stringify(messages));

            // Show success message
            showContactSuccess(messageId, contactData);

            // Reset form
            contactForm.reset();
            contactForm.classList.remove('was-validated');

            // Reset button
            submitButton.classList.remove('loading');
            submitButton.disabled = false;

        }, 2000);
    }

    // Show success modal/message
    function showContactSuccess(messageId, data) {
        const successModal = document.createElement('div');
        successModal.className = 'modal fade';
        successModal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle-fill me-2"></i>Message Sent Successfully!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="success-icon mb-3">
                                <i class="bi bi-envelope-check-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-success">Thank you, ${data.firstName}!</h4>
                            <p class="lead">Your message has been received and we'll get back to you soon.</p>
                        </div>

                        <div class="message-details bg-light p-4 rounded">
                            <h6 class="fw-bold mb-3">Message Details:</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <strong>Message ID:</strong><br>
                                    <span class="text-primary">${messageId}</span>
                                </div>
                                <div class="col-6">
                                    <strong>Subject:</strong><br>
                                    ${data.subject.charAt(0).toUpperCase() + data.subject.slice(1)}
                                </div>
                                <div class="col-6">
                                    <strong>Contact Method:</strong><br>
                                    ${data.contactMethod.charAt(0).toUpperCase() + data.contactMethod.slice(1)}
                                </div>
                                <div class="col-6">
                                    <strong>Response Time:</strong><br>
                                    ${getResponseTime(data.urgency)}
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>What's Next?</strong><br>
                            • We'll review your message within the next few hours<br>
                            • You'll receive a response via your preferred contact method<br>
                            • For urgent matters, feel free to call us at +94 77 186 9132
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('menu') }}" class="btn btn-coffee">
                            <i class="bi bi-cup-hot me-2"></i>View Our Menu
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

    // Get response time based on urgency
    function getResponseTime(urgency) {
        switch(urgency) {
            case 'immediate': return 'Within 1 hour';
            case 'urgent': return 'Within 24 hours';
            default: return '2-3 business days';
        }
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

    // Check current business status
    function updateBusinessStatus() {
        const now = new Date();
        const currentDay = now.getDay(); // 0 = Sunday, 1 = Monday, etc.
        const currentHour = now.getHours();
        const currentMinute = now.getMinutes();
        const currentTime = currentHour * 60 + currentMinute;

        let openTime, closeTime;

        // Set opening hours based on day
        if (currentDay === 0) { // Sunday
            openTime = 7 * 60; // 7:00 AM
            closeTime = 22 * 60; // 10:00 PM
        } else if (currentDay === 6) { // Saturday
            openTime = 6 * 60; // 6:00 AM
            closeTime = 23 * 60; // 11:00 PM
        } else { // Monday to Friday
            openTime = 6 * 60; // 6:00 AM
            closeTime = 22 * 60; // 10:00 PM
        }

        const statusText = document.getElementById('currentStatus');
        const statusIndicator = document.getElementById('statusIndicator');

        if (currentTime >= openTime && currentTime < closeTime) {
            if (currentTime >= closeTime - 60) { // Last hour
                statusText.textContent = 'Closing Soon';
                statusIndicator.className = 'status-indicator closing-soon';
                statusIndicator.innerHTML = '<i class="bi bi-exclamation-triangle"></i>';
            } else {
                statusText.textContent = 'Open Now';
                statusIndicator.className = 'status-indicator open';
                statusIndicator.innerHTML = '<i class="bi bi-check-circle"></i>';
            }
        } else {
            statusText.textContent = 'Closed';
            statusIndicator.className = 'status-indicator closed';
            statusIndicator.innerHTML = '<i class="bi bi-x-circle"></i>';
        }
    }

    // Update status immediately and then every minute
    updateBusinessStatus();
    setInterval(updateBusinessStatus, 60000);

    // Auto-fill for returning customers (if logged in)
    @auth
        document.getElementById('firstName').value = '{{ explode(" ", Auth::user()->name)[0] ?? "" }}';
        document.getElementById('lastName').value = '{{ explode(" ", Auth::user()->name)[1] ?? "" }}';
        document.getElementById('email').value = '{{ Auth::user()->email }}';
    @endauth

    // Social media link interactions
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('i').className.split('-')[1];
            showNotification(`${platform.charAt(0).toUpperCase() + platform.slice(1)} page coming soon!`, 'info');
        });
    });

    // Smooth scrolling for contact form anchor
    document.querySelector('[href="#contact-form"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('contact-form').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

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

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => notification.remove(), 500);
        }
    }, 5000);
}

// CSS animations for notifications
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
