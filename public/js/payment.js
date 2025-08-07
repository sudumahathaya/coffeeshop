// Enhanced Payment Gateway Integration
class PaymentGateway {
    constructor() {
        this.simulationMode = true;
        this.supportedMethods = ['card', 'mobile', 'bank_transfer', 'digital_wallet', 'cash'];
        this.init();
    }

    async init() {
        console.log('Payment Gateway initialized in simulation mode');
        this.bindEvents();
    }

    bindEvents() {
        // Payment modal trigger
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-payment-trigger]')) {
                e.preventDefault();
                this.handlePaymentTrigger(e.target.closest('[data-payment-trigger]'));
            }
        });
    }

    handlePaymentTrigger(trigger) {
        const orderData = this.extractOrderData(trigger);
        this.showPaymentModal(orderData);
    }

    extractOrderData(trigger) {
        // Extract order data from trigger element or cart
        const cart = JSON.parse(localStorage.getItem('cafeElixirCart')) || [];
        
        if (cart.length === 0) {
            this.showNotification('Your cart is empty!', 'warning');
            return null;
        }

        const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        return {
            items: cart.map(item => ({
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: item.quantity
            })),
            subtotal: subtotal,
            tax: tax,
            total: total,
            customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
            customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
            customer_phone: '',
            order_id: 'ORD' + Date.now()
        };
    }

    async createPaymentIntent(amount, method = 'card') {
        try {
            const response = await fetch('/api/payment/create-intent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ 
                    amount: amount,
                    method: method,
                    currency: 'LKR'
                })
            });

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error creating payment intent:', error);
            return { success: false, message: 'Payment service unavailable' };
        }
    }

    async processPayment(paymentData) {
        try {
            const response = await fetch('/api/payment/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(paymentData)
            });

            const result = await response.json();
            return result;
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
        if (!orderData) return;
        
        // Use the global function from payment modal partial
        if (typeof showPaymentModal === 'function') {
            showPaymentModal(orderData);
        } else {
            console.error('Payment modal not available');
            this.showNotification('Payment system not available', 'error');
        }
    }

    async verifyPayment(transactionId) {
        try {
            const response = await fetch(`/api/payment/verify/${transactionId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Payment verification error:', error);
            return {
                success: false,
                message: 'Verification failed'
            };
        }
    }

    async processRefund(transactionId, amount = null, reason = 'Customer request') {
        try {
            const response = await fetch('/api/payment/refund', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    transaction_id: transactionId,
                    amount: amount,
                    reason: reason
                })
            });

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Refund processing error:', error);
            return {
                success: false,
                message: 'Refund processing failed'
            };
        }
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

// Update cart checkout function to use simulation payment gateway
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
            name: item.name,
            price: item.price,
            quantity: item.quantity
        })),
        customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
        customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
        order_type: 'dine_in',
        subtotal: subtotal,
        tax: tax,
        total: total,
        order_id: 'ORD' + Date.now()
    };

    // Show payment modal
    if (typeof showPaymentModal === 'function') {
        showPaymentModal(orderData);
    } else {
        console.error('Payment modal not available');
        showNotification('Payment system not available', 'error');
    }
}

// Process cash payment function
async function processCashPayment() {
    const orderData = window.currentOrderData;
    if (!orderData) {
        showNotification('Order data not found', 'error');
        return;
    }
    
    orderData.payment_method = 'cash';
    await submitOrder(orderData);
}

// Submit order function
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

// Legacy functions for backward compatibility
async function processCardPayment() {
    showNotification('Please use the payment form above to complete your card payment.', 'info');
}

async function processMobilePayment() {
    showNotification('Please use the payment form above to complete your mobile payment.', 'info');
}

// Initialize payment gateway when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.paymentGateway = new PaymentGateway();
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