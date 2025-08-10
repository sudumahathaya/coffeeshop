// Enhanced Payment System for Café Elixir
class CafeElixirPaymentSystem {
    constructor() {
        this.apiBase = '/api/payment';
        this.supportedMethods = [];
        this.currentPayment = null;
        this.isInitialized = false;
        this.init();
    }

    async init() {
        try {
            await this.loadSupportedMethods();
            this.bindEvents();
            this.isInitialized = true;
            console.log('Café Elixir Payment System initialized successfully');
        } catch (error) {
            console.error('Failed to initialize payment system:', error);
            this.isInitialized = false;
        }
    }

    async loadSupportedMethods() {
        try {
            // Use simulation data for now
            this.supportedMethods = {
                'card': 'Credit/Debit Card',
                'mobile': 'Mobile Payment',
                'bank_transfer': 'Bank Transfer',
                'digital_wallet': 'Digital Wallet',
                'cash': 'Cash Payment'
            };
            this.mobileProviders = {
                'dialog': 'Dialog',
                'mobitel': 'Mobitel',
                'hutch': 'Hutch',
                'airtel': 'Airtel'
            };
        } catch (error) {
            console.error('Failed to load payment methods:', error);
        }
    }

    bindEvents() {
        // Payment method selection
        document.addEventListener('change', (e) => {
            if (e.target.name === 'payment_method') {
                this.handlePaymentMethodChange(e.target.value);
            }
        });

        // Payment form submission
        document.addEventListener('submit', (e) => {
            if (e.target.classList.contains('payment-form')) {
                e.preventDefault();
                this.handlePaymentSubmission(e.target);
            }
        });
    }

    handlePaymentMethodChange(method) {
        const paymentDetails = document.getElementById('paymentDetails');
        if (!paymentDetails) return;

        let detailsHTML = '';

        switch (method) {
            case 'card':
                detailsHTML = this.renderCardForm();
                break;
            case 'mobile':
                detailsHTML = this.renderMobileForm();
                break;
            case 'bank_transfer':
                detailsHTML = this.renderBankTransferForm();
                break;
            case 'digital_wallet':
                detailsHTML = this.renderDigitalWalletForm();
                break;
            case 'cash':
                detailsHTML = this.renderCashForm();
                break;
        }

        paymentDetails.innerHTML = detailsHTML;
        
        // Update processing fee based on selected method
        this.updateProcessingFee(method);
        
        // Add animations
        paymentDetails.style.opacity = '0';
        paymentDetails.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            paymentDetails.style.transition = 'all 0.3s ease';
            paymentDetails.style.opacity = '1';
            paymentDetails.style.transform = 'translateY(0)';
        }, 100);
    }

    updateProcessingFee(method) {
        const orderData = window.currentOrderData;
        if (!orderData) return;

        const subtotal = orderData.subtotal || 0;
        const tax = orderData.tax || (subtotal * 0.1);
        const processingFee = this.calculateProcessingFee(subtotal, method);
        const total = subtotal + tax + processingFee;
        
        // Update UI
        const processingFeeElement = document.getElementById('summaryProcessingFee');
        const totalElement = document.getElementById('summaryTotal');
        const amountInput = document.getElementById('paymentAmount');
        
        if (processingFeeElement) {
            processingFeeElement.textContent = `Rs. ${processingFee.toFixed(2)}`;
        }
        if (totalElement) {
            totalElement.textContent = `Rs. ${total.toFixed(2)}`;
        }
        if (amountInput) {
            amountInput.value = total;
        }
    }

    calculateProcessingFee(amount, method) {
        const fees = {
            'card': { percentage: 2.9, fixed: 30 },
            'mobile': { percentage: 1.5, fixed: 10 },
            'bank_transfer': { percentage: 0.5, fixed: 25 },
            'digital_wallet': { percentage: 2.0, fixed: 15 },
            'cash': { percentage: 0, fixed: 0 }
        };
        
        const fee = fees[method] || fees['card'];
        return Math.round(((amount * fee.percentage / 100) + fee.fixed) * 100) / 100;
    }

    renderCardForm() {
        return `
            <div class="card-payment-form">
                <h6 class="mb-3"><i class="bi bi-credit-card me-2"></i>Card Details</h6>
                
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Card Number *</label>
                        <input type="text" class="form-control form-control-lg" name="card_number" 
                               placeholder="1234 5678 9012 3456" maxlength="19" required>
                        <div class="card-types mt-2">
                            <img src="https://img.icons8.com/color/24/visa.png" alt="Visa" title="Visa">
                            <img src="https://img.icons8.com/color/24/mastercard.png" alt="Mastercard" title="Mastercard">
                            <img src="https://img.icons8.com/color/24/amex.png" alt="Amex" title="American Express">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Expiry Date *</label>
                        <input type="text" class="form-control form-control-lg" name="card_expiry" 
                               placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">CVC *</label>
                        <input type="text" class="form-control form-control-lg" name="card_cvc" 
                               placeholder="123" maxlength="4" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Cardholder Name *</label>
                        <input type="text" class="form-control form-control-lg" name="card_holder" 
                               placeholder="John Doe" required>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Test Payment:</strong> Enter any valid card details for successful payment. 
                    Use <code>4000000000000002</code> to test declined payments.
                </div>
            </div>
        `;
    }

    renderMobileForm() {
        return `
            <div class="mobile-payment-form">
                <h6 class="mb-3"><i class="bi bi-phone me-2"></i>Mobile Payment</h6>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mobile Provider *</label>
                        <select class="form-select form-select-lg" name="mobile_provider" required>
                            <option value="">Select Provider</option>
                            <option value="dialog">Dialog</option>
                            <option value="mobitel">Mobitel</option>
                            <option value="hutch">Hutch</option>
                            <option value="airtel">Airtel</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mobile Number *</label>
                        <input type="tel" class="form-control form-control-lg" name="mobile_number" 
                               placeholder="077 123 4567" required>
                    </div>
                </div>
                
                <div class="alert alert-success mt-3">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Secure Payment:</strong> You'll receive an OTP to confirm the payment.<br>
                    <small class="text-muted">📱 Test OTP: <code>123456</code></small>
                </div>
                
                <div class="provider-logos mt-3">
                    <img src="https://img.icons8.com/color/32/dialog.png" alt="Dialog" title="Dialog">
                    <img src="https://img.icons8.com/color/32/mobitel.png" alt="Mobitel" title="Mobitel">
                    <img src="https://img.icons8.com/color/32/hutch.png" alt="Hutch" title="Hutch">
                </div>
            </div>
        `;
    }

    renderBankTransferForm() {
        return `
            <div class="bank-transfer-form">
                <h6 class="mb-3"><i class="bi bi-bank me-2"></i>Bank Transfer</h6>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Bank *</label>
                        <select class="form-select form-select-lg" name="bank_code" required>
                            <option value="">Select Bank</option>
                            <option value="BOC">Bank of Ceylon</option>
                            <option value="PB">People's Bank</option>
                            <option value="CB">Commercial Bank</option>
                            <option value="HNB">Hatton National Bank</option>
                            <option value="DFCC">DFCC Bank</option>
                            <option value="NSB">National Savings Bank</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Account Number *</label>
                        <input type="text" class="form-control form-control-lg" name="account_number" 
                               placeholder="1234567890" required>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-clock me-2"></i>
                    <strong>Processing Time:</strong> Bank transfers may take 1-3 business days to process.
                </div>
            </div>
        `;
    }

    renderDigitalWalletForm() {
        return `
            <div class="digital-wallet-form">
                <h6 class="mb-3"><i class="bi bi-wallet2 me-2"></i>Digital Wallet</h6>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Wallet Type *</label>
                        <select class="form-select form-select-lg" name="wallet_type" required>
                            <option value="">Select Wallet</option>
                            <option value="paypal">PayPal</option>
                            <option value="google_pay">Google Pay</option>
                            <option value="apple_pay">Apple Pay</option>
                            <option value="samsung_pay">Samsung Pay</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Wallet ID/Email *</label>
                        <input type="text" class="form-control form-control-lg" name="wallet_id" 
                               placeholder="user@example.com" required>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-shield-check me-2"></i>
                    <strong>Secure:</strong> You'll be redirected to your wallet provider for authentication.
                </div>
            </div>
        `;
    }

    renderCashForm() {
        return `
            <div class="cash-payment-form">
                <div class="alert alert-success">
                    <i class="bi bi-cash-stack me-2"></i>
                    <strong>Cash Payment Selected</strong><br>
                    You can pay with cash when you collect your order or at your table.
                </div>
                
                <div class="payment-instructions">
                    <h6>Payment Instructions:</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check text-success me-2"></i>Order will be confirmed immediately</li>
                        <li><i class="bi bi-check text-success me-2"></i>Pay when you arrive at the café</li>
                        <li><i class="bi bi-check text-success me-2"></i>Show your order ID to our staff</li>
                        <li><i class="bi bi-check text-success me-2"></i>Exact change appreciated</li>
                    </ul>
                </div>
            </div>
        `;
    }

    async handlePaymentSubmission(form) {
        const formData = new FormData(form);
        const paymentMethod = formData.get('payment_method');
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        // Show loading state
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        submitButton.disabled = true;

        try {
            // Validate payment method selection
            if (!paymentMethod) {
                throw new Error('Please select a payment method');
            }

            if (paymentMethod === 'cash') {
                // Handle cash payment (no gateway processing needed)
                await this.processCashPayment();
            } else {
                // Handle electronic payments
                await this.processElectronicPayment(formData, paymentMethod);
            }
        } catch (error) {
            console.error('Payment processing error:', error);
            this.showNotification(error.message || 'Payment processing failed. Please try again.', 'error');
        } finally {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }

    async processCashPayment() {
        const orderData = window.currentOrderData;
        if (!orderData) {
            throw new Error('Order data not found');
        }

        // Simulate cash payment processing
        await this.delay(1000);
        
        orderData.payment_method = 'cash';
        orderData.payment_status = 'pending';
        
        // Submit the order
        await this.submitOrder(orderData);
    }

    async processElectronicPayment(formData, method) {
        const orderData = window.currentOrderData;
        if (!orderData) {
            throw new Error('Order data not found');
        }
        
        const paymentData = this.preparePaymentData(formData, method);

        // Validate payment data based on method
        this.validatePaymentData(paymentData, method);
        
        // Check for test card scenarios
        if (method === 'card' && paymentData.card_number) {
            const cardNumber = paymentData.card_number.replace(/\D/g, '');
            
            if (cardNumber === '4242424242424242') {
                this.showNotification('Test card detected! Processing successful payment...', 'success');
                await this.delay(1000);
            } else if (cardNumber === '4000000000000002') {
                this.showNotification('Test card detected! Simulating declined payment...', 'warning');
                await this.delay(1000);
                throw new Error('Your card was declined. Please try a different payment method.');
            }
        }

        if (method === 'mobile') {
            await this.processMobilePayment(paymentData);
        } else {
            await this.processDirectPayment(paymentData);
        }
    }

    async processMobilePayment(paymentData) {
        try {
            this.showNotification('Sending OTP to your mobile number...', 'info');
            
            // Simulate OTP process
            const otpData = {
                success: true,
                otp_id: 'otp_sim_' + Date.now(),
                test_otp: '123456',
                expires_in: 300
            };

            if (otpData.success) {
                this.showNotification('OTP sent successfully! Check your mobile phone.', 'success');
                
                // Show OTP modal
                const otpCode = await this.showOTPModal(otpData);
                
                // Verify OTP
                if (otpCode === '123456' || otpCode === otpData.test_otp) {
                    this.showNotification('OTP verified successfully! Processing payment...', 'success');
                    
                    // Process successful payment
                    const result = {
                        success: true,
                        transaction_id: 'MP_sim_' + Date.now(),
                        amount: paymentData.amount,
                        method: paymentData.method
                    };

                    // Submit order
                    const orderData = window.currentOrderData;
                    if (orderData) {
                        orderData.payment_method = paymentData.method;
                        orderData.transaction_id = result.transaction_id;
                        orderData.payment_status = 'completed';
                        
                        await this.submitOrder(orderData);
                    }
                } else {
                    throw new Error('Invalid OTP code');
                }
            } else {
                throw new Error('Failed to send OTP');
            }
        } catch (error) {
            throw error;
        }
    }

    async processDirectPayment(paymentData) {
        try {
            // Show processing notification
            if (paymentData.method === 'card') {
                const cardNumber = paymentData.card_number?.replace(/\D/g, '');
                if (cardNumber === '4242424242424242') {
                    this.showNotification('Processing payment with test card...', 'info');
                } else if (cardNumber === '4000000000000002') {
                    this.showNotification('Testing declined card scenario...', 'warning');
                } else {
                    this.showNotification('Processing your payment securely...', 'info');
                }
            }
            
            // Simulate payment processing
            await this.delay(1500);
            
            // Check for declined card
            if (paymentData.method === 'card' && paymentData.card_number) {
                const cardNumber = paymentData.card_number.replace(/\D/g, '');
                
                if (cardNumber === '4000000000000002') {
                    throw new Error('Your card was declined. Please try a different payment method.');
                }
            }

            // Simulate successful payment
            const result = {
                success: true,
                transaction_id: this.generateTransactionId(paymentData.method),
                amount: paymentData.amount,
                method: paymentData.method,
                processing_fee: this.calculateProcessingFee(paymentData.amount, paymentData.method)
            };
            
            this.showNotification('Payment processed successfully!', 'success');

            // Submit order
            const orderData = window.currentOrderData;
            if (orderData) {
                orderData.payment_method = paymentData.method;
                orderData.transaction_id = result.transaction_id;
                orderData.payment_status = 'completed';
                
                await this.submitOrder(orderData);
            }
        } catch (error) {
            throw error;
        }
    }

    async submitOrder(orderData) {
        try {
            // Set flags to prevent unnecessary notifications
            window.paymentInProgress = true;
            window.orderSuccessful = false;
            
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
                console.log('Order placed successfully:', result);
                
                // Set success flag
                window.orderSuccessful = true;
                
                // Clear cart
                if (typeof window.cart !== 'undefined') {
                    window.cart.clearCart();
                    console.log('Cart cleared via cart object');
                } else if (localStorage.getItem('cafeElixirCart')) {
                    localStorage.removeItem('cafeElixirCart');
                    console.log('Cart cleared via localStorage');
                    
                    // Update cart counters directly
                    const cartCounters = document.querySelectorAll('.cart-counter');
                    cartCounters.forEach(counter => {
                        counter.style.display = 'none';
                        counter.textContent = '0';
                    });
                }
                
                // Close payment modal
                const paymentModal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
                if (paymentModal) {
                    paymentModal.hide();
                }
                
                // Show success modal
                this.showPaymentSuccess({
                    transaction_id: orderData.transaction_id || 'CASH_PAYMENT',
                    amount: orderData.total,
                    method: orderData.payment_method,
                    order_id: result.order_id,
                    points_earned: result.points_earned || 0
                });
                
            } else {
                throw new Error(result.message || 'Failed to place order');
            }
        } catch (error) {
            console.error('Order submission error:', error);
            throw new Error('Failed to place order. Please try again.');
        } finally {
            // Reset payment flag
            window.paymentInProgress = false;
        }
    }

    showPaymentSuccess(result) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle-fill me-2"></i>Payment Successful!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="success-animation mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        
                        <h4 class="text-success mb-3">Payment Completed Successfully!</h4>
                        <p class="lead">Your order has been confirmed and payment processed.</p>
                        
                        <div class="payment-details bg-light p-4 rounded mt-4">
                            <h6 class="fw-bold mb-3">Payment Details:</h6>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Order ID:</strong><br>
                                    <code class="text-primary">${result.order_id || 'ORD' + Date.now()}</code>
                                </div>
                                <div class="col-6">
                                    <strong>Amount:</strong><br>
                                    Rs. ${parseFloat(result.amount || 0).toFixed(2)}
                                </div>
                                <div class="col-6 mt-3">
                                    <strong>Payment Method:</strong><br>
                                    ${this.getMethodDisplayName(result.method)}
                                </div>
                                <div class="col-6 mt-3">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-success">Completed</span>
                                </div>
                            </div>
                            
                            ${result.transaction_id && result.transaction_id !== 'CASH_PAYMENT' ? `
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <strong>Transaction ID:</strong><br>
                                        <code class="text-primary">${result.transaction_id}</code>
                                    </div>
                                </div>
                            ` : ''}
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>What's Next?</strong><br>
                            • You'll receive a confirmation email<br>
                            • Your order is being prepared<br>
                            • Estimated time: 10-15 minutes<br>
                            ${result.points_earned ? `• You earned ${result.points_earned} loyalty points!<br>` : ''}
                            ${result.method === 'cash' ? '• Pay when you arrive at the café' : '• Payment has been processed successfully'}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="/user/dashboard" class="btn btn-coffee">
                            <i class="bi bi-speedometer2 me-2"></i>View Dashboard
                        </a>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        // Add celebration animation if points were earned
        if (result.points_earned > 0) {
            this.showCelebrationAnimation(result.points_earned);
        }

        // Handle modal hide event to properly manage focus
        modal.addEventListener('hide.bs.modal', function() {
            const focusedElement = this.querySelector(':focus');
            if (focusedElement) {
                focusedElement.blur();
            }
        });

        // Clean up when modal is hidden
        modal.addEventListener('hidden.bs.modal', () => {
            // Ensure no elements retain focus after modal is completely hidden
            if (document.activeElement && modal.contains(document.activeElement)) {
                document.activeElement.blur();
            }
            document.body.removeChild(modal);
            
            // Trigger dashboard refresh if on dashboard page
            if (window.location.pathname.includes('dashboard')) {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Redirect to dashboard to show updated stats
                setTimeout(() => {
                    window.location.href = '/user/dashboard?order_success=true';
                }, 1000);
            }
        });
    }
    
    showCelebrationAnimation(pointsEarned) {
        const celebration = document.createElement('div');
        celebration.className = 'points-celebration';
        celebration.innerHTML = `
            <div class="celebration-content">
                <div class="points-icon">
                    <i class="bi bi-star-fill text-warning"></i>
                </div>
                <h4 class="text-warning">+${pointsEarned} Points!</h4>
                <p>Added to your loyalty account</p>
            </div>
        `;
        
        celebration.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10001;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: celebrationBounce 0.6s ease;
        `;
        
        document.body.appendChild(celebration);
        
        // Auto remove after 2 seconds
        setTimeout(() => {
            celebration.style.animation = 'celebrationFadeOut 0.5s ease';
            setTimeout(() => {
                if (celebration.parentElement) {
                    celebration.remove();
                }
            }, 500);
        }, 2000);
    }

    showOTPModal(otpData) {
        return new Promise((resolve, reject) => {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-shield-check me-2"></i>Verify Mobile Payment
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <div class="otp-icon mb-3">
                                <i class="bi bi-phone text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5>Enter OTP Code</h5>
                            <p class="text-muted">We've sent a 6-digit code to your mobile number</p>
                            
                            <div class="alert alert-success mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>OTP Sent Successfully!</strong><br>
                                For testing, use OTP: <code>${otpData.test_otp}</code>
                            </div>
                            
                            <div class="otp-input-group my-4">
                                <input type="text" class="form-control form-control-lg text-center" 
                                       id="otpInput" maxlength="6" placeholder="000000"
                                       style="font-size: 1.5rem; letter-spacing: 0.5rem;">
                            </div>
                            
                            <div class="otp-timer">
                                <small class="text-muted">Code expires in: <span id="otpTimer">5:00</span></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="rejectOTP()">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="verifyOTP()">
                                <i class="bi bi-check-lg me-2"></i>Verify
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();

            // Start countdown timer
            let timeLeft = 300; // 5 minutes
            const timer = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                const timerElement = document.getElementById('otpTimer');
                if (timerElement) {
                    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    reject(new Error('OTP expired'));
                    bootstrapModal.hide();
                }
            }, 1000);

            // Global functions for modal
            window.verifyOTP = () => {
                const otpCode = document.getElementById('otpInput').value;
                if (otpCode.length === 6) {
                    clearInterval(timer);
                    bootstrapModal.hide();
                    resolve(otpCode);
                } else {
                    this.showNotification('Please enter a valid 6-digit OTP', 'warning');
                }
            };

            window.rejectOTP = () => {
                clearInterval(timer);
                bootstrapModal.hide();
                reject(new Error('OTP verification cancelled'));
            };

            // Auto-focus OTP input
            modal.addEventListener('shown.bs.modal', () => {
                document.getElementById('otpInput').focus();
            });

            // Clean up when modal is hidden
            modal.addEventListener('hidden.bs.modal', () => {
                clearInterval(timer);
                document.body.removeChild(modal);
                delete window.verifyOTP;
                delete window.rejectOTP;
            });
        });
    }

    validatePaymentData(paymentData, method) {
        switch (method) {
            case 'card':
                if (!paymentData.card_number || !paymentData.card_expiry || !paymentData.card_cvc || !paymentData.card_holder) {
                    throw new Error('Please fill in all card details');
                }
                break;
            case 'mobile':
                if (!paymentData.mobile_provider || !paymentData.mobile_number) {
                    throw new Error('Please select mobile provider and enter phone number');
                }
                break;
            case 'bank_transfer':
                if (!paymentData.bank_code || !paymentData.account_number) {
                    throw new Error('Please select bank and enter account number');
                }
                break;
            case 'digital_wallet':
                if (!paymentData.wallet_type || !paymentData.wallet_id) {
                    throw new Error('Please select wallet type and enter wallet ID');
                }
                break;
        }
    }

    preparePaymentData(formData, method) {
        const data = {
            amount: parseFloat(formData.get('amount')),
            method: method,
            currency: formData.get('currency') || 'LKR',
            order_id: formData.get('order_id'),
            customer_name: formData.get('customer_name'),
            customer_email: formData.get('customer_email'),
            customer_phone: formData.get('customer_phone')
        };

        // Add method-specific data
        switch (method) {
            case 'card':
                data.card_number = formData.get('card_number');
                data.card_expiry = formData.get('card_expiry');
                data.card_cvc = formData.get('card_cvc');
                data.card_holder = formData.get('card_holder');
                break;

            case 'mobile':
                data.mobile_provider = formData.get('mobile_provider');
                data.mobile_number = formData.get('mobile_number');
                break;

            case 'bank_transfer':
                data.bank_code = formData.get('bank_code');
                data.account_number = formData.get('account_number');
                break;

            case 'digital_wallet':
                data.wallet_type = formData.get('wallet_type');
                data.wallet_id = formData.get('wallet_id');
                break;
        }

        return data;
    }

    generateTransactionId(method) {
        const prefix = {
            'card': 'CC',
            'mobile': 'MP',
            'bank_transfer': 'BT',
            'digital_wallet': 'DW'
        }[method] || 'TX';
        
        return `${prefix}_sim_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    }

    getMethodDisplayName(method) {
        const names = {
            'card': 'Credit/Debit Card',
            'mobile': 'Mobile Payment',
            'bank_transfer': 'Bank Transfer',
            'digital_wallet': 'Digital Wallet',
            'cash': 'Cash Payment'
        };
        return names[method] || method;
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
        }, 4000);
    }

    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // Card number formatting
    formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        input.value = value;
    }

    // Expiry date formatting
    formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        input.value = value;
    }

    // Phone number formatting
    formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.startsWith('94')) {
            value = '+' + value.substring(0, 2) + ' ' + value.substring(2, 4) + ' ' +
                    value.substring(4, 7) + ' ' + value.substring(7, 11);
        } else if (value.startsWith('0')) {
            value = value.substring(1, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 10);
        }
        
        input.value = value;
    }
}

// Initialize payment system when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.cafeElixirPaymentSystem = new CafeElixirPaymentSystem();
    
    // Add input formatting event listeners
    document.addEventListener('input', function(e) {
        if (e.target.name === 'card_number') {
            window.cafeElixirPaymentSystem.formatCardNumber(e.target);
        } else if (e.target.name === 'card_expiry') {
            window.cafeElixirPaymentSystem.formatExpiryDate(e.target);
        } else if (e.target.name === 'mobile_number') {
            window.cafeElixirPaymentSystem.formatPhoneNumber(e.target);
        }
    });
});

// CSS for animations and styling
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
    
    .card-types img, .provider-logos img {
        margin-right: 0.5rem;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }
    
    .card-types img:hover, .provider-logos img:hover {
        opacity: 1;
    }
    
    .otp-input-group input {
        border: 2px solid #007bff;
        border-radius: 10px;
    }
    
    .otp-input-group input:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .success-animation {
        animation: bounce 0.6s ease;
    }
    
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .payment-form .form-control:focus,
    .payment-form .form-select:focus {
        border-color: var(--coffee-primary);
        box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
    }
`;
document.head.appendChild(style);