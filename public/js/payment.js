// Enhanced Payment Gateway Integration
class PaymentGateway {
    constructor() {
        this.stripe = null;
        this.elements = null;
        this.card = null;
        this.init();
    }

    async init() {
        // Initialize Stripe (replace with your publishable key)
        if (typeof Stripe !== 'undefined') {
            this.stripe = Stripe('pk_test_your_stripe_publishable_key_here');
            this.elements = this.stripe.elements();
            
            // Create card element
            this.card = this.elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#424770',
                        '::placeholder': {
                            color: '#aab7c4',
                        },
                    },
                    invalid: {
                        color: '#9e2146',
                    },
                },
            });
        }
    }

    mountCard(elementId) {
        if (this.card) {
            this.card.mount(elementId);
            
            this.card.on('change', (event) => {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                    displayError.style.display = 'block';
                } else {
                    displayError.textContent = '';
                    displayError.style.display = 'none';
                }
            });
        }
    }

    async createPaymentIntent(amount) {
        try {
            const response = await fetch('/api/payment/create-intent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ amount: amount })
            });

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error creating payment intent:', error);
            return { success: false, message: 'Payment service unavailable' };
        }
    }

    async processPayment(clientSecret, orderData) {
        if (!this.stripe || !this.card) {
            return {
                success: false,
                message: 'Payment system not initialized'
            };
        }

        try {
            const { error, paymentIntent } = await this.stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: this.card,
                    billing_details: {
                        name: orderData.customer_name,
                        email: orderData.customer_email,
                    },
                }
            });

            if (error) {
                return {
                    success: false,
                    message: error.message
                };
            } else {
                return {
                    success: true,
                    payment_intent: paymentIntent
                };
            }
        } catch (error) {
            console.error('Payment processing error:', error);
            return {
                success: false,
                message: 'Payment processing failed'
            };
        }
    }

    // Mobile payment methods (for Sri Lankan market)
    async processMobilePayment(method, amount, phone) {
        try {
            const response = await fetch('/api/payment/mobile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    method: method, // 'dialog', 'mobitel', 'hutch'
                    amount: amount,
                    phone: phone
                })
            });

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Mobile payment error:', error);
            return { success: false, message: 'Mobile payment service unavailable' };
        }
    }

    showPaymentModal(orderData) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'paymentModal';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-coffee text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-credit-card me-2"></i>Complete Payment
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Order Summary</h6>
                                <div class="order-summary">
                                    ${orderData.items.map(item => `
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>${item.name} x${item.quantity}</span>
                                            <span>Rs. ${(item.price * item.quantity).toFixed(2)}</span>
                                        </div>
                                    `).join('')}
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Subtotal:</strong>
                                        <strong>Rs. ${orderData.subtotal.toFixed(2)}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Tax (10%):</span>
                                        <span>Rs. ${orderData.tax.toFixed(2)}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <strong class="text-coffee">Rs. ${orderData.total.toFixed(2)}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Payment Method</h6>
                                
                                <!-- Payment Method Tabs -->
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#card-payment">
                                            <i class="bi bi-credit-card me-1"></i>Card
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mobile-payment">
                                            <i class="bi bi-phone me-1"></i>Mobile
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cash-payment">
                                            <i class="bi bi-cash me-1"></i>Cash
                                        </button>
                                    </li>
                                </ul>

                                <!-- Payment Method Content -->
                                <div class="tab-content">
                                    <!-- Card Payment -->
                                    <div class="tab-pane fade show active" id="card-payment">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Coming Soon!</strong> Credit card payments will be available soon.
                                        </div>
                                        <div id="card-element" class="form-control mb-3" style="padding: 12px; display: none;"></div>
                                        <div id="card-errors" class="alert alert-danger" style="display: none;"></div>
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="bi bi-lock me-2"></i>Card Payment Coming Soon
                                        </button>
                                    </div>

                                    <!-- Mobile Payment -->
                                    <div class="tab-pane fade" id="mobile-payment">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Coming Soon!</strong> Mobile payments (Dialog, Mobitel, Hutch) will be available soon.
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mobile Provider</label>
                                            <select class="form-select" id="mobileProvider" disabled>
                                                <option value="dialog">Dialog</option>
                                                <option value="mobitel">Mobitel</option>
                                                <option value="hutch">Hutch</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="tel" class="form-control" id="mobileNumber" placeholder="07X XXX XXXX" disabled>
                                        </div>
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="bi bi-phone me-2"></i>Mobile Payment Coming Soon
                                        </button>
                                    </div>

                                    <!-- Cash Payment -->
                                    <div class="tab-pane fade" id="cash-payment">
                                        <div class="alert alert-success">
                                            <i class="bi bi-info-circle me-2"></i>
                                            You can pay with cash when you collect your order or at your table.
                                        </div>
                                        <div class="payment-instructions mb-3">
                                            <h6>Payment Instructions:</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="bi bi-check text-success me-2"></i>Order will be confirmed immediately</li>
                                                <li><i class="bi bi-check text-success me-2"></i>Pay when you arrive at the café</li>
                                                <li><i class="bi bi-check text-success me-2"></i>Show your order ID to our staff</li>
                                                <li><i class="bi bi-check text-success me-2"></i>Exact change appreciated</li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-coffee w-100" onclick="processCashPayment()">
                                            <i class="bi bi-cash me-2"></i>Confirm Order (Pay at Café)
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        // Mount card element after modal is shown (when available)
        modal.addEventListener('shown.bs.modal', () => {
            if (this.card) {
                this.mountCard('#card-element');
            }
        });

        // Clean up when modal is hidden
        modal.addEventListener('hidden.bs.modal', () => {
            document.body.removeChild(modal);
        });

        // Store order data for payment processing
        window.currentOrderData = orderData;
    }
}

// Payment processing functions
async function processCardPayment() {
    showNotification('Card payments coming soon! Please use cash payment for now.', 'info');
}

async function processMobilePayment() {
    showNotification('Mobile payments coming soon! Please use cash payment for now.', 'info');
}

async function processCashPayment() {
    const orderData = window.currentOrderData;
    orderData.payment_method = 'cash';
    
    await submitOrder(orderData);
}

async function submitOrder(orderData) {
    try {
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(orderData)
        });

        const result = await response.json();
        
        if (result.success) {
            // Close payment modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            if (modal) {
                modal.hide();
            }
            
            // Clear cart
            localStorage.removeItem('cafeElixirCart');
            if (typeof updateCartDisplay === 'function') {
                updateCartDisplay();
            }
            
            // Show success message
            showOrderSuccess(result.order_id, result.order);
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Order submission error:', error);
        showNotification('Failed to place order: ' + error.message, 'error');
    }
}

function showOrderSuccess(orderId, orderData) {
    const successModal = document.createElement('div');
    successModal.className = 'modal fade';
    successModal.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle-fill me-2"></i>Order Placed Successfully!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="success-icon mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-success mb-3">Thank you for your order!</h4>
                    <p class="lead">Your order has been confirmed and is being prepared.</p>
                    
                    <div class="order-details bg-light p-4 rounded mt-4">
                        <h6 class="fw-bold mb-3">Order Details:</h6>
                        <div class="row">
                            <div class="col-6">
                                <strong>Order ID:</strong><br>
                                <span class="text-primary">${orderId}</span>
                            </div>
                            <div class="col-6">
                                <strong>Total Amount:</strong><br>
                                Rs. ${parseFloat(orderData.total).toFixed(2)}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <strong>Payment Method:</strong><br>
                                ${orderData.payment_method.charAt(0).toUpperCase() + orderData.payment_method.slice(1)}
                            </div>
                            <div class="col-6">
                                <strong>Order Type:</strong><br>
                                ${orderData.order_type.replace('_', ' ').charAt(0).toUpperCase() + orderData.order_type.replace('_', ' ').slice(1)}
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>What's Next?</strong><br>
                        • You'll receive updates about your order status<br>
                        • Estimated preparation time: 10-15 minutes<br>
                        • ${orderData.payment_method === 'cash' ? 'Pay when you arrive at the café' : 'Payment processed successfully'}<br>
                        • Show this order ID to our staff: <strong>${orderId}</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="/dashboard" class="btn btn-coffee">
                        <i class="bi bi-speedometer2 me-2"></i>View Dashboard
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
}

// Initialize payment gateway when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.paymentGateway = new PaymentGateway();
});

// Update cart checkout function to use payment gateway
function proceedToCheckout() {
    const cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];

    if (cart.length === 0) {
        showNotification('Your cart is empty!', 'warning');
        return;
    }

    // Calculate totals
    const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    const tax = subtotal * 0.1;
    const total = subtotal + tax;

    // Prepare order data
    const orderData = {
        items: cart.map(item => ({
            id: item.id,
            quantity: item.quantity,
            name: item.name,
            price: item.price
        })),
        customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
        customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
        order_type: 'dine_in',
        subtotal: subtotal,
        tax: tax,
        total: total
    };

    // Show payment modal
    window.paymentGateway.showPaymentModal(orderData);
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

// CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    .notification-toast {
        backdrop-filter: blur(10px);
    }
    
    .bg-coffee {
        background: linear-gradient(45deg, #8B4513, #D2691E) !important;
    }
`;
document.head.appendChild(style);