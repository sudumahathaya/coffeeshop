// Enhanced Cart Management System for Café Elixir
class CafeElixirCart {
    constructor() {
        this.cart = this.loadCart();
        this.init();
    }

    init() {
        this.createCartModal();
        this.updateCartDisplay();
        this.bindEvents();
        console.log('Café Elixir Cart initialized successfully');
    }

    loadCart() {
        try {
            const cartData = localStorage.getItem('cafeElixirCart');
            return cartData ? JSON.parse(cartData) : [];
        } catch (error) {
            console.error('Error loading cart:', error);
            return [];
        }
    }

    saveCart() {
        try {
            localStorage.setItem('cafeElixirCart', JSON.stringify(this.cart));
            console.log('Cart saved:', this.cart);
        } catch (error) {
            console.error('Error saving cart:', error);
        }
    }

    addItem(item) {
        console.log('Adding item to cart:', item);
        
        // Validate item data
        if (!item.id || !item.name || !item.price) {
            console.error('Invalid item data:', item);
            this.showNotification('Invalid item data', 'error');
            return false;
        }

        const existingItem = this.cart.find(cartItem => cartItem.id == item.id);
        
        if (existingItem) {
            existingItem.quantity += 1;
            console.log('Updated existing item quantity:', existingItem);
        } else {
            const newItem = {
                id: item.id,
                name: item.name,
                price: parseFloat(item.price),
                quantity: 1,
                image: item.image || 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=80&h=80&fit=crop'
            };
            this.cart.push(newItem);
            console.log('Added new item to cart:', newItem);
        }

        this.saveCart();
        this.updateCartDisplay();
        this.showNotification(`${item.name} added to cart!`, 'success');
        return true;
    }

    removeItem(itemId) {
        console.log('Removing item from cart:', itemId);
        
        const itemIndex = this.cart.findIndex(item => item.id == itemId);
        if (itemIndex !== -1) {
            const itemName = this.cart[itemIndex].name;
            this.cart.splice(itemIndex, 1);
            this.saveCart();
            this.updateCartDisplay();
            this.showNotification(`${itemName} removed from cart`, 'warning');
        }
    }

    updateQuantity(itemId, change) {
        console.log('Updating quantity for item:', itemId, 'change:', change);
        
        const item = this.cart.find(cartItem => cartItem.id == itemId);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                this.removeItem(itemId);
            } else {
                this.saveCart();
                this.updateCartDisplay();
            }
        }
    }

    clearCart() {
        console.log('Clearing cart');
        this.cart = [];
        this.saveCart();
        this.updateCartDisplay();
        // Don't show notification when clearing cart after successful payment
        if (!window.paymentInProgress) {
            this.showNotification('Cart cleared successfully', 'info');
        }
    }

    getTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getTotalItems() {
        return this.cart.reduce((total, item) => total + item.quantity, 0);
    }

    updateCartDisplay() {
        this.updateCartCounter();
        this.updateCartModal();
    }

    updateCartCounter() {
        const cartCounters = document.querySelectorAll('.cart-counter');
        const totalItems = this.getTotalItems();

        cartCounters.forEach(counter => {
            if (totalItems > 0) {
                counter.textContent = totalItems;
                counter.style.display = 'inline-block';
                counter.classList.add('animate-bounce');
                setTimeout(() => counter.classList.remove('animate-bounce'), 500);
            } else {
                counter.style.display = 'none';
            }
        });

        console.log('Cart counter updated:', totalItems);
    }

    updateCartModal() {
        const cartItemsContainer = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartFooter = document.getElementById('cartFooter');

        if (!cartItemsContainer) {
            console.log('Cart modal not found, will be created when needed');
            return;
        }

        console.log('Updating cart modal with items:', this.cart);

        if (this.cart.length === 0) {
            cartItemsContainer.innerHTML = '';
            if (emptyCartMessage) emptyCartMessage.style.display = 'block';
            if (cartFooter) cartFooter.style.display = 'none';
        } else {
            if (emptyCartMessage) emptyCartMessage.style.display = 'none';
            if (cartFooter) cartFooter.style.display = 'block';

            cartItemsContainer.innerHTML = this.cart.map(item => `
                <div class="cart-item d-flex align-items-center py-3 border-bottom">
                    <img src="${item.image}" class="cart-item-image me-3" alt="${item.name}">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <small class="text-muted">Rs. ${parseFloat(item.price).toFixed(2)} each</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="window.cart.updateQuantity('${item.id}', -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="mx-2 fw-bold">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="window.cart.updateQuantity('${item.id}', 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger ms-2" onclick="window.cart.removeItem('${item.id}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="text-end ms-3">
                        <strong>Rs. ${(parseFloat(item.price) * parseInt(item.quantity)).toFixed(2)}</strong>
                    </div>
                </div>
            `).join('');

            if (cartTotal) {
                cartTotal.textContent = `Rs. ${this.getTotal().toFixed(2)}`;
            }
        }
    }

    createCartModal() {
        if (document.getElementById('cartModal')) {
            console.log('Cart modal already exists');
            return;
        }

        console.log('Creating cart modal');

        const modalHTML = `
            <div class="modal fade" id="cartModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-coffee text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-cart me-2"></i>Your Cart
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="emptyCartMessage" class="text-center py-5" style="display: none;">
                                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">Your cart is empty</h5>
                                <p class="text-muted">Add some delicious items from our menu!</p>
                                <a href="/menu" class="btn btn-coffee" data-bs-dismiss="modal">
                                    <i class="bi bi-cup-hot me-2"></i>Browse Menu
                                </a>
                            </div>
                            <div id="cartItems"></div>
                        </div>
                        <div class="modal-footer" id="cartFooter" style="display: none;">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Total: <span id="cartTotal">Rs. 0.00</span></h5>
                                    <button class="btn btn-outline-danger" onclick="window.cart.clearCart()">
                                        <i class="bi bi-trash me-2"></i>Clear Cart
                                    </button>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-coffee btn-lg" onclick="window.cart.proceedToCheckout()">
                                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Add event listeners for proper focus management
        const cartModal = document.getElementById('cartModal');
        cartModal.addEventListener('hide.bs.modal', function() {
            const focusedElement = this.querySelector(':focus');
            if (focusedElement) {
                focusedElement.blur();
            }
        });

        cartModal.addEventListener('hidden.bs.modal', function() {
            if (document.activeElement && this.contains(document.activeElement)) {
                document.activeElement.blur();
            }
        });

        console.log('Cart modal created successfully');
    }

    bindEvents() {
        console.log('Binding cart events');

        // Add to cart buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-cart')) {
                e.preventDefault();
                const button = e.target.closest('.add-to-cart');
                this.handleAddToCart(button);
            }
        });

        // Cart modal trigger
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-bs-target="#cartModal"]')) {
                this.updateCartDisplay();
            }
        });

        console.log('Cart events bound successfully');
    }

    handleAddToCart(button) {
        console.log('Handling add to cart button click');
        
        const item = {
            id: button.getAttribute('data-id'),
            name: button.getAttribute('data-name'),
            price: button.getAttribute('data-price'),
            image: button.getAttribute('data-image')
        };

        console.log('Item data from button:', item);

        if (!item.name || !item.price) {
            console.error('Invalid item data from button:', item);
            this.showNotification('Invalid item data', 'error');
            return;
        }

        // Show loading state
        const originalHTML = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Adding...';
        button.disabled = true;

        setTimeout(() => {
            const success = this.addItem(item);

            if (success) {
                // Success state
                button.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
                button.classList.add('btn-success');
                button.classList.remove('btn-coffee');

                // Reset button after delay
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.disabled = false;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-coffee');
                }, 2000);
            } else {
                // Error state
                button.innerHTML = originalHTML;
                button.disabled = false;
            }
        }, 500);
    }

    proceedToCheckout() {
        console.log('Proceeding to checkout');
        
        if (this.cart.length === 0) {
            this.showNotification('Your cart is empty!', 'warning');
            return;
        }

        // Calculate totals
        const subtotal = this.getTotal();
        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        // Prepare order data
        const orderData = {
            items: this.cart.map(item => ({
                id: item.id,
                name: item.name,
                price: parseFloat(item.price),
                quantity: parseInt(item.quantity),
                image: item.image
            })),
            customer_name: document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Guest Customer',
            customer_email: document.querySelector('meta[name="user-email"]')?.getAttribute('content') || '',
            customer_phone: '',
            order_type: 'dine_in',
            subtotal: subtotal,
            tax: tax,
            total: total,
            order_id: 'ORD' + Date.now()
        };

        // Store order data globally for payment modal
        window.currentOrderData = orderData;

        console.log('Checkout order data prepared:', orderData);

        // Close cart modal
        const cartModal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
        if (cartModal) {
            cartModal.hide();
        }

        // Show payment modal
        setTimeout(() => {
            if (typeof showPaymentModal === 'function') {
                showPaymentModal(orderData);
            } else {
                console.error('Payment modal function not available');
                this.showNotification('Payment system is loading. Please try again in a moment.', 'warning');
            }
        }, 300);
    }

    showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.cart-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed cart-notification`;
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
        }, 4000);
    }

    // Method to get cart data for external use
    getCartData() {
        return {
            items: this.cart,
            total: this.getTotal(),
            totalItems: this.getTotalItems()
        };
    }

    // Method to set cart data from external source
    setCartData(cartData) {
        if (Array.isArray(cartData)) {
            this.cart = cartData;
            this.saveCart();
            this.updateCartDisplay();
        }
    }
}

// Initialize cart when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing cart...');
    window.cart = new CafeElixirCart();
    
    // Make cart globally accessible
    window.cafeElixirCart = window.cart;
    
    console.log('Cart initialized and made globally available');
});

// CSS for cart animations and styling
const cartStyle = document.createElement('style');
cartStyle.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    .cart-notification {
        backdrop-filter: blur(10px);
    }
    
    .animate-bounce {
        animation: cartBounce 0.5s ease;
    }
    
    @keyframes cartBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    .cart-item-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    .cart-counter {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        min-width: 20px;
    }
    
    .bg-coffee {
        background: linear-gradient(45deg, #8B4513, #D2691E) !important;
    }
    
    .btn-coffee {
        background: linear-gradient(45deg, #8B4513, #D2691E);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-coffee:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
        color: white;
    }
    
    .cart-item {
        transition: all 0.3s ease;
    }
    
    .cart-item:hover {
        background-color: rgba(139, 69, 19, 0.02);
    }
`;
document.head.appendChild(cartStyle);