@extends('layouts.master')

@section('title', 'Features & Amenities - Café Elixir')
@section('description', 'Discover what makes Café Elixir special. From premium coffee and cozy atmosphere to free WiFi and exceptional service.')

@section('content')
<!-- Hero Section -->
<section class="features-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Why Choose Café Elixir?</h1>
                <p class="lead text-white mb-4">Experience the perfect blend of quality, comfort, and community. Discover what makes us the premier coffee destination in Colombo.</p>
                <div class="d-flex gap-3">
                    <a href="#features-grid" class="btn btn-coffee btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Explore Features
                    </a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Book Your Visit
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="features-showcase">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="feature-preview">
                                <i class="bi bi-wifi feature-icon"></i>
                                <h6>Free WiFi</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-preview">
                                <i class="bi bi-cup-hot feature-icon"></i>
                                <h6>Premium Coffee</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-preview">
                                <i class="bi bi-people feature-icon"></i>
                                <h6>Expert Baristas</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-preview">
                                <i class="bi bi-house-heart feature-icon"></i>
                                <h6>Cozy Atmosphere</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Overview -->
<section class="py-5 bg-light" id="features-grid">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-coffee mb-3">What Makes Us Special</h2>
                <p class="lead text-muted">Discover the unique features and amenities that create the perfect coffee experience</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Premium Coffee -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card h-100">
                    <div class="feature-icon-large">
                        <i class="bi bi-cup-hot-fill"></i>
                    </div>
                    <h4 class="feature-title">Premium Coffee Selection</h4>
                    <p class="feature-description">We source our beans directly from the finest coffee farms around the world, ensuring every cup delivers exceptional flavor and aroma.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Single-origin specialty beans</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Fresh roasted weekly</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>50+ coffee varieties</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Ethically sourced</li>
                    </ul>
                    <div class="feature-action">
                        <a href="{{ route('menu') }}" class="btn btn-outline-coffee">
                            <i class="bi bi-journal-text me-2"></i>View Menu
                        </a>
                    </div>
                </div>
            </div>

            <!-- Expert Baristas -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card h-100">
                    <div class="feature-icon-large">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 class="feature-title">Expert Barista Team</h4>
                    <p class="feature-description">Our skilled and passionate baristas undergo extensive training to craft each drink with precision, artistry, and love.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Certified coffee specialists</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Latte art expertise</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Personalized recommendations</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Brewing technique masters</li>
                    </ul>
                    <div class="feature-action">
                        <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#baristasModal">
                            <i class="bi bi-people me-2"></i>Meet Our Team
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cozy Atmosphere -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card h-100">
                    <div class="feature-icon-large">
                        <i class="bi bi-house-heart-fill"></i>
                    </div>
                    <h4 class="feature-title">Cozy & Welcoming Space</h4>
                    <p class="feature-description">Our thoughtfully designed space provides the perfect ambiance for work, study, meetings, or simply relaxing with friends.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Comfortable seating areas</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Natural lighting</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Quiet zones available</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Outdoor seating</li>
                    </ul>
                    <div class="feature-action">
                        <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#atmosphereModal">
                            <i class="bi bi-camera me-2"></i>View Gallery
                        </button>
                    </div>
                </div>
            </div>

            <!-- Technology & Connectivity -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card h-100">
                    <div class="feature-icon-large">
                        <i class="bi bi-wifi"></i>
                    </div>
                    <h4 class="feature-title">Technology & Connectivity</h4>
                    <p class="feature-description">Stay connected and productive with our high-speed internet and tech-friendly amenities designed for the modern professional.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Free high-speed WiFi</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Power outlets at every table</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>USB charging stations</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Work-friendly environment</li>
                    </ul>
                    <div class="feature-action">
                        <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#wifiModal">
                            <i class="bi bi-info-circle me-2"></i>WiFi Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Fresh Food & Snacks -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card h-100">
                    <div class="feature-icon-large">
                        <i class="bi bi-cookie"></i>
                    </div>
                    <h4 class="feature-title">Fresh Food & Snacks</h4>
                    <p class="feature-description">Complement your coffee with our selection of freshly baked pastries, healthy snacks, and light meals prepared daily.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Fresh-baked pastries</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Healthy snack options</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Gluten-free choices</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Local ingredients</li>
                    </ul>
                    <div class="feature-action">
                        <a href="{{ route('menu') }}" class="btn btn-outline-coffee">
                            <i class="bi bi-basket me-2"></i>View Food Menu
                        </a>
                    </div>
                </div>
            </div>

            <!-- Exceptional Service -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card h-100">
                    <div class="feature-icon-large">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4 class="feature-title">Exceptional Service</h4>
                    <p class="feature-description">Experience world-class hospitality with our friendly, knowledgeable staff who are passionate about creating memorable moments.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Personalized service</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Quick order processing</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Loyalty rewards program</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Special occasion support</li>
                    </ul>
                    <div class="feature-action">
                        <button class="btn btn-outline-coffee" data-bs-toggle="modal" data-bs-target="#serviceModal">
                            <i class="bi bi-award me-2"></i>Learn More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Special Amenities</h2>
                <p class="lead text-muted">Additional features that make your visit extra special</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Meeting Room -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="special-feature">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="special-icon">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-coffee">Private Meeting Room</h5>
                            <p class="mb-3">Book our private meeting room for business discussions, team meetings, or intimate gatherings.</p>
                            <ul class="list-unstyled small">
                                <li><i class="bi bi-check text-success me-2"></i>Seats up to 8 people</li>
                                <li><i class="bi bi-check text-success me-2"></i>Projector and screen</li>
                                <li><i class="bi bi-check text-success me-2"></i>Whiteboard available</li>
                                <li><i class="bi bi-check text-success me-2"></i>Complimentary coffee service</li>
                            </ul>
                            <button class="btn btn-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#meetingRoomModal">
                                Book Room
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Hosting -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="special-feature">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="special-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-coffee">Event Hosting</h5>
                            <p class="mb-3">Host your special events with us - from birthday parties to corporate gatherings.</p>
                            <ul class="list-unstyled small">
                                <li><i class="bi bi-check text-success me-2"></i>Birthday celebrations</li>
                                <li><i class="bi bi-check text-success me-2"></i>Corporate events</li>
                                <li><i class="bi bi-check text-success me-2"></i>Book club meetings</li>
                                <li><i class="bi bi-check text-success me-2"></i>Custom catering options</li>
                            </ul>
                            <button class="btn btn-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#eventsModal">
                                Plan Event
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coffee Classes -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="special-feature">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="special-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-coffee">Coffee Brewing Classes</h5>
                            <p class="mb-3">Learn from our expert baristas in hands-on coffee brewing workshops.</p>
                            <ul class="list-unstyled small">
                                <li><i class="bi bi-check text-success me-2"></i>Espresso fundamentals</li>
                                <li><i class="bi bi-check text-success me-2"></i>Latte art workshops</li>
                                <li><i class="bi bi-check text-success me-2"></i>Home brewing techniques</li>
                                <li><i class="bi bi-check text-success me-2"></i>Coffee cupping sessions</li>
                            </ul>
                            <button class="btn btn-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#classesModal">
                                Join Class
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Takeaway & Delivery -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="special-feature">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="special-icon">
                                <i class="bi bi-bicycle"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="text-coffee">Takeaway & Delivery</h5>
                            <p class="mb-3">Enjoy our premium coffee anywhere with convenient takeaway and delivery options.</p>
                            <ul class="list-unstyled small">
                                <li><i class="bi bi-check text-success me-2"></i>Quick takeaway service</li>
                                <li><i class="bi bi-check text-success me-2"></i>Local delivery available</li>
                                <li><i class="bi bi-check text-success me-2"></i>Online ordering system</li>
                                <li><i class="bi bi-check text-success me-2"></i>Eco-friendly packaging</li>
                            </ul>
                            <button class="btn btn-coffee btn-sm" data-bs-toggle="modal" data-bs-target="#deliveryModal">
                                Order Online
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-coffee text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <i class="bi bi-people-fill stat-icon mb-3"></i>
                    <h3 class="stat-number" data-target="15000">0</h3>
                    <p class="stat-label">Happy Customers</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <i class="bi bi-cup-hot-fill stat-icon mb-3"></i>
                    <h3 class="stat-number" data-target="50000">0</h3>
                    <p class="stat-label">Cups Served</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <i class="bi bi-star-fill stat-icon mb-3"></i>
                    <h3 class="stat-number" data-target="4.9">0</h3>
                    <p class="stat-label">Average Rating</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <i class="bi bi-clock-fill stat-icon mb-3"></i>
                    <h3 class="stat-number" data-target="365">0</h3>
                    <p class="stat-label">Days Open</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">What Our Customers Say</h2>
                <p class="lead text-muted">Real feedback from our valued customers</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="testimonial-text">"The WiFi here is incredibly fast and reliable. I've been working from Café Elixir for months now, and it's become my second office. The coffee is amazing too!"</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face"
                             class="author-avatar" alt="Customer">
                        <div>
                            <h6 class="mb-0">Rohan Wickremasinghe</h6>
                            <small class="text-muted">Software Developer</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="testimonial-text">"We hosted our team meeting in their private room and it was perfect! Great ambiance, excellent service, and the coffee kept everyone energized throughout."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=60&h=60&fit=crop&crop=face"
                             class="author-avatar" alt="Customer">
                        <div>
                            <h6 class="mb-0">Priya Jayawardena</h6>
                            <small class="text-muted">Marketing Manager</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="testimonial-text">"The latte art class was fantastic! I learned so much from the baristas. Now I can make beautiful coffee at home. Highly recommend these workshops!"</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face"
                             class="author-avatar" alt="Customer">
                        <div>
                            <h6 class="mb-0">Amara Silva</h6>
                            <small class="text-muted">Teacher</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h3 class="display-5 fw-bold text-coffee mb-4">Ready to Experience Café Elixir?</h3>
                <p class="lead text-muted mb-4">Join thousands of satisfied customers who have made Café Elixir their favorite coffee destination. Visit us today and discover why we're special!</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('reservation') }}" class="btn btn-coffee btn-lg">
                        <i class="bi bi-calendar-check me-2"></i>Make Reservation
                    </a>
                    <a href="{{ route('menu') }}" class="btn btn-outline-coffee btn-lg">
                        <i class="bi bi-journal-text me-2"></i>View Menu
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-coffee btn-lg">
                        <i class="bi bi-geo-alt me-2"></i>Visit Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Modals -->
@include('partials.features-modals')

@push('styles')
<style>
    .features-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=1920&h=1080&fit=crop') center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .features-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .features-hero .container {
        position: relative;
        z-index: 2;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .features-showcase {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .feature-preview {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .feature-preview .feature-icon {
        font-size: 2rem;
        color: var(--coffee-primary);
        margin-bottom: 0.5rem;
    }

    .feature-preview h6 {
        color: var(--coffee-primary);
        font-weight: 600;
        margin: 0;
    }

    .feature-card {
        background: white;
        border-radius: 25px;
        padding: 2.5rem;
        text-align: center;
        transition: all 0.4s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
    }

    .feature-icon-large {
        width: 100px;
        height: 100px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 3rem;
        color: white;
    }

    .feature-title {
        color: var(--coffee-primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .feature-description {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .feature-list {
        text-align: left;
        margin-bottom: 2rem;
        padding-left: 0;
    }

    .feature-list li {
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .feature-action {
        margin-top: auto;
    }

    .special-feature {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .special-feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.12);
    }

    .special-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2.5rem;
        color: white;
    }

    .bg-coffee {
        background: linear-gradient(135deg, var(--coffee-primary), var(--coffee-secondary)) !important;
    }

    .stat-item {
        text-align: center;
    }

    .stat-icon {
        font-size: 3rem;
        opacity: 0.9;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 700;
        display: block;
        margin: 1rem 0;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .testimonial-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 69, 19, 0.12);
    }

    .testimonial-content {
        flex-grow: 1;
    }

    .testimonial-text {
        font-style: italic;
        line-height: 1.6;
        color: #555;
        margin-bottom: 0;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .author-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-right: 1rem;
        border: 3px solid var(--coffee-primary);
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
        .features-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .feature-card {
            padding: 2rem 1.5rem;
        }

        .special-feature {
            padding: 1.5rem;
        }

        .features-showcase {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2.5rem;
        }

        .testimonial-card {
            padding: 1.5rem;
        }
    }

    /* Animation for stats counter */
    .stat-item {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .stat-item.animated {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stats counter animation
    function animateStats() {
        const statNumbers = document.querySelectorAll('.stat-number');

        statNumbers.forEach(stat => {
            const target = parseFloat(stat.getAttribute('data-target'));
            const increment = target / 100;
            let current = 0;
            const isDecimal = target % 1 !== 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    stat.textContent = isDecimal ? target.toFixed(1) : target.toLocaleString();
                    clearInterval(timer);
                } else {
                    stat.textContent = isDecimal ? current.toFixed(1) : Math.floor(current).toLocaleString();
                }
            }, 20);

            // Add animated class for fade-in effect
            stat.closest('.stat-item').classList.add('animated');
        });
    }

    // Intersection Observer for stats
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateStats();
                statsObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    });

    const statsSection = document.querySelector('.bg-coffee');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }

    // Feature card interactions
    document.querySelectorAll('.feature-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Special feature interactions
    document.querySelectorAll('.special-feature').forEach(feature => {
        feature.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        feature.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Testimonial card interactions
    document.querySelectorAll('.testimonial-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Smooth scrolling for features grid
    document.querySelector('[href="#features-grid"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('features-grid').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    // Modal button interactions
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-bs-target');
            console.log(`Opening modal: ${modalId}`);

            // Add some visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Feature preview hover effects
    document.querySelectorAll('.feature-preview').forEach(preview => {
        preview.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.feature-icon');
            icon.style.transform = 'scale(1.2) rotate(5deg)';
            icon.style.transition = 'all 0.3s ease';
        });

        preview.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.feature-icon');
            icon.style.transform = 'scale(1) rotate(0deg)';
        });
    });

    // Add parallax effect to hero section (optional)
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.features-hero');
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.3;

        if (heroSection && scrolled < heroSection.offsetHeight) {
            heroSection.style.transform = `translateY(${parallax}px)`;
        }
    });

    // Notification function for modal interactions
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed notification-toast`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 15px;
            animation: slideInRight 0.5s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        `;
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'info-circle-fill'} me-2"></i>
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

    // Example modal action handlers (you can customize these)
    window.openBookingModal = function() {
        showNotification('Booking system coming soon!', 'info');
    };

    window.joinClass = function() {
        showNotification('Coffee classes enrollment opening soon!', 'info');
    };

    window.orderOnline = function() {
        showNotification('Online ordering system in development!', 'info');
    };
});

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
