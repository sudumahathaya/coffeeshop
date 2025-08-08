// Coming Soon Functionality Handler
class ComingSoonFeatures {
    constructor() {
        this.init();
    }

    init() {
        this.bindComingSoonButtons();
        this.createComingSoonModal();
    }

    bindComingSoonButtons() {
        // Handle all buttons/links that should show "coming soon"
        document.addEventListener('click', (e) => {
            const element = e.target.closest('[data-coming-soon]');
            if (element) {
                e.preventDefault();
                const feature = element.getAttribute('data-coming-soon') || 'This feature';
                this.showComingSoonModal(feature);
            }
        });

        // Handle specific coming soon features
        this.handleSpecificFeatures();
    }

    handleSpecificFeatures() {
        // Social media links
        document.querySelectorAll('a[href="#"]').forEach(link => {
            const text = link.textContent.toLowerCase();
            if (text.includes('facebook') || text.includes('instagram') || 
                text.includes('twitter') || text.includes('youtube') || 
                text.includes('tiktok') || text.includes('linkedin')) {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.showComingSoonModal('Social media integration');
                });
            }
        });

        // Newsletter subscription (enhanced)
        document.querySelectorAll('.newsletter-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleNewsletterSubscription(form);
            });
        });

        // Export functionality
        document.querySelectorAll('[onclick*="export"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.showComingSoonModal('Export functionality');
            });
        });

        // Print functionality
        document.querySelectorAll('[onclick*="print"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.showComingSoonModal('Print functionality');
            });
        });
    }

    showComingSoonModal(featureName) {
        const modal = document.getElementById('comingSoonModal');
        const featureNameElement = document.getElementById('featureName');
        
        if (featureNameElement) {
            featureNameElement.textContent = featureName;
        }

        if (modal) {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else {
            // Fallback notification
            this.showNotification(`${featureName} is coming soon! Stay tuned for updates.`, 'info');
        }
    }

    createComingSoonModal() {
        if (document.getElementById('comingSoonModal')) return;

        const modalHTML = `
            <div class="modal fade" id="comingSoonModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-coffee text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-clock-history me-2"></i>Coming Soon
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="coming-soon-icon mb-4">
                                <i class="bi bi-tools text-coffee" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-coffee mb-3">We're Working on It!</h4>
                            <p class="lead mb-4">
                                <span id="featureName">This feature</span> is currently under development and will be available soon.
                            </p>
                            <div class="features-list">
                                <h6 class="text-coffee mb-3">What's Coming:</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="feature-item">
                                            <i class="bi bi-credit-card text-primary me-2"></i>
                                            <span>Online Payments</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="feature-item">
                                            <i class="bi bi-phone text-success me-2"></i>
                                            <span>Mobile Payments</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="feature-item">
                                            <i class="bi bi-truck text-info me-2"></i>
                                            <span>Delivery Service</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="feature-item">
                                            <i class="bi bi-share text-warning me-2"></i>
                                            <span>Social Integration</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-4">
                                <i class="bi bi-bell me-2"></i>
                                <strong>Stay Updated!</strong> Subscribe to our newsletter to be notified when new features are released.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-coffee" onclick="subscribeForUpdates()">
                                <i class="bi bi-envelope me-2"></i>Notify Me
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    handleNewsletterSubscription(form) {
        const email = form.querySelector('input[type="email"]').value;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        if (!email) {
            this.showNotification('Please enter your email address', 'warning');
            return;
        }

        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Subscribing...';
        submitBtn.disabled = true;

        // Simulate subscription
        setTimeout(() => {
            submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Subscribed!';
            submitBtn.classList.add('btn-success');
            form.reset();
            this.showNotification('Thank you for subscribing! You\'ll be notified about new features.', 'success');
            
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-success');
            }, 3000);
        }, 1500);
    }

    showNotification(message, type = 'info') {
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
            backdrop-filter: blur(10px);
        `;

        const iconMap = {
            'success': 'check-circle-fill',
            'error': 'exclamation-triangle-fill',
            'warning': 'exclamation-triangle-fill',
            'info': 'info-circle-fill'
        };

        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${iconMap[type]} me-2"></i>
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
        }, 5000);
    }
}

// Global function for subscribe button in modal
function subscribeForUpdates() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('comingSoonModal'));
    modal.hide();
    
    setTimeout(() => {
        window.comingSoonFeatures.showNotification('Thank you for your interest! We\'ll notify you when new features are available.', 'success');
    }, 500);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.comingSoonFeatures = new ComingSoonFeatures();
});