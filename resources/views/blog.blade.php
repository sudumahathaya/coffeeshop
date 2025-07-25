@extends('layouts.master')

@section('title', 'Blog - Café Elixir')
@section('description', 'Discover coffee stories, brewing guides, and café updates at Café Elixir blog. Stay updated with the latest coffee trends and tips.')

@section('content')
<!-- Hero Section -->
<section class="blog-hero">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6" data-aos="fade-up">
                <h1 class="display-3 fw-bold text-white mb-4">Coffee Stories & More</h1>
                <p class="lead text-white mb-4">Dive into the world of coffee with our expert insights, brewing guides, and stories from the heart of Café Elixir. Discover what makes every cup special.</p>
                <div class="d-flex gap-3">
                    <a href="#blog-posts" class="btn btn-coffee btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Read Articles
                    </a>
                    <a href="#newsletter" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-envelope me-2"></i>Subscribe
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image-container">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=700&fit=crop"
                         alt="Coffee Writing"
                         class="img-fluid rounded-3 shadow-lg floating">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Article -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="featured-article" data-aos="fade-up">
                    <div class="badge bg-coffee mb-3">
                        <i class="bi bi-star-fill me-1"></i>Featured Article
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&h=400&fit=crop"
                                 alt="Perfect Espresso"
                                 class="img-fluid rounded-3 shadow">
                        </div>
                        <div class="col-lg-6">
                            <div class="ps-lg-4 mt-4 mt-lg-0">
                                <span class="badge bg-secondary mb-2">Brewing Guide</span>
                                <h2 class="h1 fw-bold text-coffee mb-3">The Art of Perfect Espresso</h2>
                                <p class="lead text-muted mb-4">Master the fundamentals of espresso making with our comprehensive guide. From bean selection to extraction timing, discover the secrets behind every perfect shot.</p>
                                <div class="d-flex align-items-center mb-4">
                                    <img src="img/avindu.jpg"
                                         class="rounded-circle me-3" width="50" height="50" alt="Author">
                                    <div>
                                        <h6 class="mb-0">Avindu Oshan</h6>
                                        <small class="text-muted">Head Barista • Dec 15, 2024</small>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#articleModal1">
                                    <i class="bi bi-book-open me-2"></i>Read Full Article
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Categories -->
<section class="py-5 bg-light" id="blog-posts">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-coffee mb-3">Explore Our Blog Categories</h2>
                <p class="lead text-muted">Choose from our diverse collection of coffee-related content</p>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-10">
                <div class="category-filters d-flex flex-wrap justify-content-center gap-2">
                    <button class="btn btn-coffee active" data-category="all">
                        <i class="bi bi-grid me-2"></i>All Posts
                    </button>
                    <button class="btn btn-outline-coffee" data-category="brewing">
                        <i class="bi bi-cup-hot me-2"></i>Brewing Guides
                    </button>
                    <button class="btn btn-outline-coffee" data-category="culture">
                        <i class="bi bi-globe me-2"></i>Coffee Culture
                    </button>
                    <button class="btn btn-outline-coffee" data-category="recipes">
                        <i class="bi bi-journal-bookmark me-2"></i>Recipes
                    </button>
                    <button class="btn btn-outline-coffee" data-category="news">
                        <i class="bi bi-newspaper me-2"></i>Café News
                    </button>
                    <button class="btn btn-outline-coffee" data-category="health">
                        <i class="bi bi-heart-pulse me-2"></i>Health & Wellness
                    </button>
                </div>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="row g-4" id="blog-grid">
            <!-- Brewing Guide Post -->
            <div class="col-lg-4 col-md-6 blog-item" data-category="brewing" data-aos="fade-up" data-aos-delay="100">
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=400&h=250&fit=crop"
                             alt="French Press Guide" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-info">Brewing Guide</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Dec 10</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">Mastering the French Press</h5>
                        <p class="blog-excerpt">Learn the step-by-step process to brew the perfect French press coffee at home. From grind size to steeping time, we cover it all.</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By Nimal Perera</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>1.2k
                                        <i class="bi bi-heart ms-2 me-1"></i>89
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#articleModal2">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Coffee Culture Post -->
            <div class="col-lg-4 col-md-6 blog-item" data-category="culture" data-aos="fade-up" data-aos-delay="200">
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400&h=250&fit=crop"
                             alt="Ceylon Coffee History" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-success">Coffee Culture</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Dec 08</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">Ceylon Coffee: A Rich Heritage</h5>
                        <p class="blog-excerpt">Explore the fascinating history of Ceylon coffee and how Sri Lanka became renowned for its exceptional tea after the coffee leaf disease.</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By Sasha Fernando</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>890
                                        <i class="bi bi-heart ms-2 me-1"></i>67
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#articleModal3">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Recipe Post -->
            <div class="col-lg-4 col-md-6 blog-item" data-category="recipes" data-aos="fade-up" data-aos-delay="300">
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=250&fit=crop"
                             alt="Iced Coffee Recipe" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-warning">Recipe</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Dec 05</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">Ultimate Cold Brew Recipe</h5>
                        <p class="blog-excerpt">Beat the Sri Lankan heat with our signature cold brew recipe. Perfect for those hot Colombo afternoons when you need a refreshing coffee fix.</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By Kavya Rajapaksha</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>1.5k
                                        <i class="bi bi-heart ms-2 me-1"></i>124
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#articleModal4">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Café News Post -->
            <div class="col-lg-4 col-md-6 blog-item" data-category="news" data-aos="fade-up" data-aos-delay="100">
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=400&h=250&fit=crop"
                             alt="New Coffee Blend" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-primary">Café News</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Dec 12</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">Introducing Our New Signature Blend</h5>
                        <p class="blog-excerpt">We're excited to launch our latest creation - the "Elixir Harmony" blend, featuring beans from three different regions for a unique flavor profile.</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By Café Elixir Team</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>2.1k
                                        <i class="bi bi-heart ms-2 me-1"></i>156
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#articleModal5">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Health Post -->
            <div class="col-lg-4 col-md-6 blog-item" data-category="health" data-aos="fade-up" data-aos-delay="200">
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=400&h=250&fit=crop"
                             alt="Coffee Health Benefits" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-danger">Health & Wellness</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Dec 01</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">Health Benefits of Quality Coffee</h5>
                        <p class="blog-excerpt">Discover the surprising health benefits of drinking quality coffee, from antioxidants to improved mental focus and physical performance.</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By Dr. Amara Wijesekara</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>980
                                        <i class="bi bi-heart ms-2 me-1"></i>78
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#articleModal6">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Another Recipe Post -->
            <div class="col-lg-4 col-md-6 blog-item" data-category="recipes" data-aos="fade-up" data-aos-delay="300">
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=250&fit=crop"
                             alt="Latte Art" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-warning">Recipe</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Nov 28</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">Latte Art for Beginners</h5>
                        <p class="blog-excerpt">Learn the basics of latte art with our easy-to-follow guide. Start with simple patterns and work your way up to impressive designs that will wow your guests.</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By Ravi Kumara</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>1.8k
                                        <i class="bi bi-heart ms-2 me-1"></i>145
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#articleModal7">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <button class="btn btn-outline-coffee btn-lg" id="loadMoreBtn">
                <i class="bi bi-plus-circle me-2"></i>Load More Articles
            </button>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section id="newsletter" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <div class="newsletter-card">
                    <div class="newsletter-icon mb-4">
                        <i class="bi bi-envelope-heart"></i>
                    </div>
                    <h3 class="fw-bold text-coffee mb-3">Stay Updated with Our Blog</h3>
                    <p class="lead text-muted mb-4">Get the latest coffee tips, brewing guides, and café updates delivered straight to your inbox. Join our community of coffee enthusiasts!</p>

                    <form class="newsletter-form" id="newsletterForm">
                    <form class="newsletter-form" id="newsletterForm" novalidate>
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-6">
                                <input type="email" class="form-control form-control-lg"
                                       name="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-coffee btn-lg w-100">
                                    <i class="bi bi-send me-2"></i>Subscribe
                                </button>
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-shield-check me-1"></i>
                            We respect your privacy. Unsubscribe anytime.
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Posts Sidebar (for larger screens) -->
<section class="py-5 bg-light d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="text-coffee mb-4">Popular Articles This Month</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mini-article">
                            <div class="row g-3">
                                <div class="col-4">
                                    <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=100&h=80&fit=crop"
                                         class="img-fluid rounded" alt="Popular Article">
                                </div>
                                <div class="col-8">
                                    <h6 class="mb-1">Best Coffee Beans of 2024</h6>
                                    <small class="text-muted">Our annual review of the finest...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mini-article">
                            <div class="row g-3">
                                <div class="col-4">
                                    <img src="https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=100&h=80&fit=crop"
                                         class="img-fluid rounded" alt="Popular Article">
                                </div>
                                <div class="col-8">
                                    <h6 class="mb-1">Café Etiquette Guide</h6>
                                    <small class="text-muted">How to be the perfect café customer...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <h4 class="text-coffee mb-4">Follow Us</h4>
                <div class="social-links d-flex gap-3">
                    <a href="#" class="social-link">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Modals -->
@include('partials.blog-modals')

@push('styles')
<style>
    .blog-hero {
        background: linear-gradient(135deg,
                    rgba(139, 69, 19, 0.9),
                    rgba(210, 105, 30, 0.8)),
                    url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&h=1080&fit=crop') center/cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
    }

    .blog-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
    }

    .blog-hero .container {
        position: relative;
        z-index: 2;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .floating {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .featured-article {
        background: white;
        border-radius: 25px;
        padding: 3rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .category-filters .btn {
        margin: 0.25rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .category-filters .btn:not(.active):hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.2);
    }

    .blog-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid rgba(139, 69, 19, 0.05);
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
    }

    .blog-image {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.05);
    }

    .blog-category {
        position: absolute;
        top: 15px;
        left: 15px;
    }

    .blog-date {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .blog-content {
        padding: 2rem;
    }

    .blog-title {
        color: var(--coffee-primary);
        font-weight: 600;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .blog-excerpt {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .blog-meta {
        border-top: 1px solid #e9ecef;
        padding-top: 1rem;
    }

    .newsletter-card {
        background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        border-radius: 25px;
        padding: 3rem;
        border: 1px solid rgba(139, 69, 19, 0.1);
    }

    .newsletter-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
        color: white;
    }

    .newsletter-form .form-control {
        border-radius: 15px;
        border: 2px solid #e9ecef;
        padding: 0.875rem 1.25rem;
    }

    .newsletter-form .form-control:focus {
        border-color: var(--coffee-primary);
        box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
    }

    .mini-article {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 69, 19, 0.05);
    }

    .mini-article:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .social-link {
        width: 50px;
        height: 50px;
        background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
        border-radius: 50%;
        display: flex;
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

    .btn-outline-coffee.active {
        background: var(--coffee-primary);
        color: white;
        border-color: var(--coffee-primary);
    }

    .text-coffee {
        color: var(--coffee-primary) !important;
    }

    .blog-item {
        transition: all 0.3s ease;
    }

    .blog-item.hidden {
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .blog-hero {
            min-height: 80vh;
        }

        .display-3 {
            font-size: 2.5rem;
        }

        .featured-article {
            padding: 2rem 1.5rem;
        }

        .blog-content {
            padding: 1.5rem;
        }

        .newsletter-card {
            padding: 2rem 1.5rem;
        }

        .category-filters {
            flex-direction: column;
        }

        .category-filters .btn {
            width: 100%;
            margin: 0.25rem 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Blog category filtering
    const categoryButtons = document.querySelectorAll('[data-category]');
    const blogItems = document.querySelectorAll('.blog-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update active button
            categoryButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('btn-outline-coffee');
                btn.classList.remove('btn-coffee');
            });

            this.classList.add('active');
            this.classList.remove('btn-outline-coffee');
            this.classList.add('btn-coffee');

            // Filter blog items
            blogItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');

                if (category === 'all' || itemCategory === category) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        if (item.classList.contains('hidden')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });

            // Re-trigger AOS animation for visible items
            setTimeout(() => {
                AOS.refresh();
            }, 400);
        });
    });

    // Newsletter form submission
    // Newsletter form submission is now handled by master layout

    // Load more functionality
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    let loadCount = 0;

    loadMoreBtn.addEventListener('click', function() {
        loadCount++;

        // Show loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        this.disabled = true;

        // Simulate loading more articles
        setTimeout(() => {
            // Create new blog items (simulation)
            const blogGrid = document.getElementById('blog-grid');
            const newArticles = generateMoreArticles(loadCount);

            newArticles.forEach(article => {
                blogGrid.appendChild(article);
            });

            // Reset button
            this.innerHTML = originalText;
            this.disabled = false;

            // Hide button after 3 loads
            if (loadCount >= 3) {
                this.style.display = 'none';
                showNotification('You\'ve reached the end of our blog posts!', 'info');
            }

            // Trigger AOS for new items
            AOS.refresh();

            showNotification(`Loaded ${newArticles.length} more articles`, 'success');

        }, 1000);
    });

    // Generate more articles function
    function generateMoreArticles(loadNumber) {
        const moreArticles = [
            {
                category: 'brewing',
                categoryColor: 'info',
                title: 'V60 Pour Over Techniques',
                excerpt: 'Master the art of V60 brewing with these professional techniques and tips from our head barista.',
                author: 'Kasun Silva',
                image: 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=250&fit=crop',
                views: '756',
                likes: '62'
            },
            {
                category: 'culture',
                categoryColor: 'success',
                title: 'Coffee Traditions Around the World',
                excerpt: 'Explore how different cultures celebrate and enjoy coffee, from Ethiopian ceremonies to Italian espresso culture.',
                author: 'Priya Mendis',
                image: 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400&h=250&fit=crop',
                views: '923',
                likes: '87'
            },
            {
                category: 'health',
                categoryColor: 'danger',
                title: 'Coffee and Sleep: Finding the Balance',
                excerpt: 'Learn how to enjoy your coffee without disrupting your sleep patterns. Expert advice on timing and quantity.',
                author: 'Dr. Nuwan Perera',
                image: 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=400&h=250&fit=crop',
                views: '643',
                likes: '54'
            }
        ];

        return moreArticles.map((article, index) => {
            const articleEl = document.createElement('div');
            articleEl.className = 'col-lg-4 col-md-6 blog-item';
            articleEl.setAttribute('data-category', article.category);
            articleEl.setAttribute('data-aos', 'fade-up');
            articleEl.setAttribute('data-aos-delay', (index + 1) * 100);

            articleEl.innerHTML = `
                <article class="blog-card h-100">
                    <div class="blog-image">
                        <img src="${article.image}" alt="${article.title}" class="img-fluid">
                        <div class="blog-category">
                            <span class="badge bg-${article.categoryColor}">${article.category.charAt(0).toUpperCase() + article.category.slice(1)}</span>
                        </div>
                        <div class="blog-date">
                            <span class="badge bg-dark">Nov ${25 - loadNumber * 3 - index}</span>
                        </div>
                    </div>
                    <div class="blog-content">
                        <h5 class="blog-title">${article.title}</h5>
                        <p class="blog-excerpt">${article.excerpt}</p>
                        <div class="blog-meta">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="author-info">
                                    <small class="text-muted">By ${article.author}</small>
                                </div>
                                <div class="blog-stats">
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>${article.views}
                                        <i class="bi bi-heart ms-2 me-1"></i>${article.likes}
                                    </small>
                                </div>
                            </div>
                            <a href="#" class="btn btn-outline-coffee btn-sm mt-3">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            `;

            return articleEl;
        });
    }

    // Social media link interactions
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('i').className.split('-')[1];
            showNotification(`${platform.charAt(0).toUpperCase() + platform.slice(1)} page coming soon!`, 'info');
        });
    });

    // Article card interactions
    document.querySelectorAll('.blog-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Search functionality (if search input exists)
    const searchInput = document.getElementById('blogSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            blogItems.forEach(item => {
                const title = item.querySelector('.blog-title').textContent.toLowerCase();
                const excerpt = item.querySelector('.blog-excerpt').textContent.toLowerCase();

                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                    item.style.display = 'block';
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        if (item.classList.contains('hidden')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });
        });
    }

    // Smooth scrolling for blog posts anchor
    document.querySelector('[href="#blog-posts"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('blog-posts').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    // Newsletter section smooth scroll
    document.querySelector('[href="#newsletter"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('newsletter').scrollIntoView({
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
