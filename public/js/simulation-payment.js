// Simulation Payment Gateway Integration
class SimulationPaymentGateway {
    constructor() {
        this.apiBase = '/api/payment';
        this.supportedMethods = [];
        this.currentPayment = null;
        this.init();
    }

    async init() {
        try {
            await this.loadSupportedMethods();
            this.bindEvents();
            console.log('Simulation Payment Gateway initialized');
        } catch (error) {
            console.error('Failed to initialize payment gateway:', error);
        }
    }

    async loadSupportedMethods() {
        try {
            const response = await fetch(`${this.apiBase}/methods`);
            const data = await response.json();
            
            if (data.success) {
                this.supportedMethods = data.methods;
                this.mobileProviders = data.mobile_providers;
            }
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
        
        // Add animations
        paymentDetails.style.opacity = '0';
        paymentDetails.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            paymentDetails.style.transition = 'all 0.3s ease';
            paymentDetails.style.opacity = '1';
            paymentDetails.style.transform = 'translateY(0)';
        }, 100);
    }

    renderCardForm() {
        return `
            <div class="card-payment-form">
                <h6 class="mb-3"><i class="bi bi-credit-card me-2"></i>Card Details</h6>
                
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Card Number *</label>
                        <input type="text" class="form-control" name="card_number" 
                               placeholder="1234 5678 9012 3456" maxlength="19" required>
                        <div class="card-types mt-2">
                            <img src="https://img.icons8.com/color/24/visa.png" alt="Visa" title="Visa">
                            <img src="https://img.icons8.com/color/24/mastercard.png" alt="Mastercard" title="Mastercard">
                            <img src="https://img.icons8.com/color/24/amex.png" alt="Amex" title="American Express">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Expiry Date *</label>
                        <input type="text" class="form-control" name="card_expiry" 
                               placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CVC *</label>
                        <input type="text" class="form-control" name="card_cvc" 
                               placeholder="123" maxlength="4" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Cardholder Name *</label>
                        <input type="text" class="form-control" name="card_holder" 
                               placeholder="John Doe" required>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Test Cards:</strong> Use 4242424242424242 for successful payments, 
                    4000000000000002 for declined cards.
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
                        <label class="form-label">Mobile Provider *</label>
                        <select class="form-select" name="mobile_provider" required>
                            <option value="">Select Provider</option>
                            <option value="dialog">Dialog</option>
                            <option value="mobitel">Mobitel</option>
                            <option value="hutch">Hutch</option>
                            <option value="airtel">Airtel</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile Number *</label>
                        <input type="tel" class="form-control" name="mobile_number" 
                               placeholder="077 123 4567" required>
                    </div>
                </div>
                
                <div class="alert alert-success mt-3">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Secure Payment:</strong> You'll receive an OTP to confirm the payment.
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
                        <label class="form-label">Bank *</label>
                        <select class="form-select" name="bank_code" required>
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
                        <label class="form-label">Account Number *</label>
                        <input type="text" class="form-control" name="account_number" 
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
                        <label class="form-label">Wallet Type *</label>
                        <select class="form-select" name="wallet_type" required>
                            <option value="">Select Wallet</option>
                            <option value="paypal">PayPal</option>
                            <option value="google_pay">Google Pay</option>
                            <option value="apple_pay">Apple Pay</option>
                            <option value="samsung_pay">Samsung Pay</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Wallet ID/Email *</label>
                        <input type="text" class="form-control" name="wallet_id" 
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
            if (paymentMethod === 'cash') {
                // Handle cash payment (no gateway processing needed)
                await this.processCashPayment();
            } else {
                // Handle electronic payments
                await this.processElectronicPayment(formData, paymentMethod);
            }
        } catch (error) {
            console.error('Payment processing error:', error);
            this.showNotification('Payment processing failed. Please try again.', 'error');
        } finally {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }

    async processCashPayment() {
        // Simulate cash payment processing
        await this.delay(1000);
        
        // Submit order directly for cash payment
        const orderData = window.currentOrderData;
        if (orderData) {
            orderData.payment_method = 'cash';
            orderData.payment_status = 'pending';
            await window.submitOrder(orderData);
        } else {
            throw new Error('Order data not found');
        }
    }

    async processElectronicPayment(formData, method) {
        const paymentData = this.preparePaymentData(formData, method);

        if (method === 'mobile') {
            await this.processMobilePayment(paymentData);
        } else {
            await this.processDirectPayment(paymentData);
        }
    }

    async processMobilePayment(paymentData) {
        try {
            // Step 1: Send OTP
            const otpResponse = await fetch(`${this.apiBase}/mobile/send-otp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    phone_number: paymentData.mobile.number,
                    provider: paymentData.mobile.provider
                })
            });

            const otpData = await otpResponse.json();

            if (otpData.success) {
                // Step 2: Show OTP modal
                const otpCode = await this.showOTPModal(otpData);
                
                // Step 3: Verify OTP
                const verifyResponse = await fetch(`${this.apiBase}/mobile/verify-otp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        otp_id: otpData.otp_id,
                        otp_code: otpCode,
                        test_otp: otpData.test_otp
                    })
                });

                const verifyData = await verifyResponse.json();

                if (verifyData.success) {
                    // Step 4: Process payment
                    const response = await fetch(`${this.apiBase}/process`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(paymentData)
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Payment successful, now submit order
                        const orderData = window.currentOrderData;
                        if (orderData) {
                            orderData.payment_method = paymentData.method;
                            orderData.transaction_id = result.transaction_id;
                            orderData.payment_status = 'completed';
                            await window.submitOrder(orderData);
                        } else {
                            throw new Error('Order data not found');
                        }
                    } else {
                        throw new Error(result.message || 'Payment processing failed');
                    }
                } else {
                    throw new Error(verifyData.message || 'OTP verification failed');
                }
            } else {
                throw new Error(otpData.message || 'Failed to send OTP');
            }
        } catch (error) {
            throw error;
        }
    }

    async processDirectPayment(paymentData) {
        try {
            const response = await fetch(`${this.apiBase}/process`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(paymentData)
            });

            const result = await response.json();

            if (result.success) {
                // Payment successful, now submit order
                const orderData = window.currentOrderData;
                if (orderData) {
                    orderData.payment_method = paymentData.method;
                    orderData.transaction_id = result.transaction_id;
                    orderData.payment_status = 'completed';
                    await window.submitOrder(orderData);
                } else {
                    throw new Error('Order data not found');
                }
            } else {
                throw new Error(result.message || 'Payment processing failed');
            }
        } catch (error) {
            throw error;
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
                            
                            <div class="otp-input-group my-4">
                                <input type="text" class="form-control form-control-lg text-center" 
                                       id="otpInput" maxlength="6" placeholder="000000"
                                       style="font-size: 1.5rem; letter-spacing: 0.5rem;">
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Test Mode:</strong> Use OTP: <code>${otpData.test_otp}</code>
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
                document.getElementById('otpTimer').textContent = 
                    `${minutes}:${seconds.toString().padStart(2, '0')}`;

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
                                    <strong>Transaction ID:</strong><br>
                                    <code class="text-primary">${result.transaction_id || 'CASH_PAYMENT'}</code>
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
                            
                            ${result.processing_fee ? `
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <small class="text-muted">
                                            Processing fee: Rs. ${result.processing_fee.toFixed(2)}
                                        </small>
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
                            ${result.method === 'cash' ? '• Pay when you arrive at the café' : '• Payment has been processed'}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="printReceipt()">
                            <i class="bi bi-printer me-2"></i>Print Receipt
                        </button>
                        <a href="/dashboard" class="btn btn-coffee">
                            <i class="bi bi-speedometer2 me-2"></i>View Dashboard
                        </a>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        // Clean up when modal is hidden
        modal.addEventListener('hidden.bs.modal', () => {
            document.body.removeChild(modal);
        });

        // Print receipt function
        window.printReceipt = () => {
            this.printPaymentReceipt(result);
        };
    }

    printPaymentReceipt(paymentData) {
        const receiptWindow = window.open('', '_blank');
        receiptWindow.document.write(`
            <html>
                <head>
                    <title>Payment Receipt - Café Elixir</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                        .header { text-align: center; border-bottom: 2px solid #8B4513; padding-bottom: 20px; margin-bottom: 30px; }
                        .logo { color: #8B4513; font-size: 24px; font-weight: bold; }
                        .receipt-details { margin: 20px 0; }
                        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
                        .total { font-weight: bold; font-size: 18px; border-top: 2px solid #8B4513; padding-top: 10px; }
                        .footer { text-align: center; margin-top: 30px; color: #666; }
                        @media print { .no-print { display: none; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div class="logo">☕ Café Elixir</div>
                        <p>Payment Receipt</p>
                    </div>
                    
                    <div class="receipt-details">
                        <div class="detail-row">
                            <span>Transaction ID:</span>
                            <span>${paymentData.transaction_id || 'CASH_PAYMENT'}</span>
                        </div>
                        <div class="detail-row">
                            <span>Date & Time:</span>
                            <span>${new Date().toLocaleString()}</span>
                        </div>
                        <div class="detail-row">
                            <span>Payment Method:</span>
                            <span>${this.getMethodDisplayName(paymentData.method)}</span>
                        </div>
                        <div class="detail-row">
                            <span>Customer:</span>
                            <span>${paymentData.customer?.name || 'Guest'}</span>
                        </div>
                        <div class="detail-row total">
                            <span>Total Amount:</span>
                            <span>Rs. ${parseFloat(paymentData.amount || 0).toFixed(2)}</span>
                        </div>
                        ${paymentData.processing_fee ? `
                            <div class="detail-row">
                                <span>Processing Fee:</span>
                                <span>Rs. ${paymentData.processing_fee.toFixed(2)}</span>
                            </div>
                        ` : ''}
                    </div>
                    
                    <div class="footer">
                        <p>Thank you for choosing Café Elixir!</p>
                        <p>Visit us at: No.1, Mahamegawaththa Road, Maharagama</p>
                        <p>Phone: +94 77 186 9132</p>
                    </div>
                </body>
            </html>
        `);
        receiptWindow.document.close();
        receiptWindow.print();
    }

    async processDirectPayment(paymentData) {
        const response = await fetch(`${this.apiBase}/process`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(paymentData)
        });

        const result = await response.json();

        if (result.success) {
            this.showPaymentSuccess(result);
            this.currentPayment = result;
        } else {
            throw new Error(result.message || 'Payment processing failed');
        }
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
        }, 5000);
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

    // Phone number formatting for mobile payments
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

// Initialize payment gateway when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.simulationPaymentGateway = new SimulationPaymentGateway();
    
    // Add input formatting event listeners
    document.addEventListener('input', function(e) {
        if (e.target.name === 'card_number') {
            window.simulationPaymentGateway.formatCardNumber(e.target);
        } else if (e.target.name === 'card_expiry') {
            window.simulationPaymentGateway.formatExpiryDate(e.target);
        } else if (e.target.name === 'mobile_number') {
            window.simulationPaymentGateway.formatPhoneNumber(e.target);
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