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

    // Store order data globally
    window.currentOrderData = orderData;

    // Show payment modal
    if (typeof showPaymentModal === 'function') {
        showPaymentModal(orderData);
    } else {
        console.error('Payment modal not available');
        showNotification('Payment system not available', 'error');
    }
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