<!-- Enhanced Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-coffee text-white">
                <h5 class="modal-title">
                    <i class="bi bi-credit-card me-2"></i>Complete Your Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="order-summary-section">
                            <h6 class="mb-3">
                                <i class="bi bi-receipt me-2"></i>Order Summary
                            </h6>
                            <div class="order-summary" id="paymentOrderSummary">
                                <!-- Order items will be populated here -->
                            </div>
                            
                            <div class="payment-breakdown mt-4">
                                <div class="breakdown-row">
                                    <span>Subtotal:</span>
                                    <span id="paymentSubtotal">Rs. 0.00</span>
                                </div>
                                <div class="breakdown-row">
                                    <span>Tax (10%):</span>
                                    <span id="paymentTax">Rs. 0.00</span>
                                </div>
                                <div class="breakdown-row processing-fee" style="display: none;">
                                    <span>Processing Fee:</span>
                                    <span id="paymentProcessingFee">Rs. 0.00</span>
                                </div>
                                <div class="breakdown-row total">
                                    <span><strong>Total:</strong></span>
                                    <span><strong id="paymentTotal">Rs. 0.00</strong></span>
                                </div>
                            </div>

                            <div class="security-info mt-4">
                                <div class="alert alert-success">
                                    <i class="bi bi-shield-check me-2"></i>
                                    <strong>Secure Payment</strong><br>
                                    Your payment information is encrypted and secure.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="col-lg-7">
                        <div class="payment-form-section">
                            <h6 class="mb-3">
                                <i class="bi bi-credit-card me-2"></i>Payment Method
                            </h6>

                            <form class="payment-form" id="paymentForm">
                                @csrf
                                <input type="hidden" name="order_id" id="paymentOrderId">
                                <input type="hidden" name="amount" id="paymentAmount">
                                <input type="hidden" name="currency" value="LKR">
                                <input type="hidden" name="customer_name" id="paymentCustomerName">
                                <input type="hidden" name="customer_email" id="paymentCustomerEmail">
                                <input type="hidden" name="customer_phone" id="paymentCustomerPhone">

                                <!-- Payment Method Selection -->
                                <div class="payment-methods mb-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" class="btn-check" name="payment_method" 
                                                       id="method_card" value="card" checked>
                                                <label class="btn btn-outline-primary w-100 p-3" for="method_card">
                                                    <i class="bi bi-credit-card d-block mb-2" style="font-size: 2rem;"></i>
                                                    <strong>Credit/Debit Card</strong><br>
                                                    <small>Visa, Mastercard, Amex</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" class="btn-check" name="payment_method" 
                                                       id="method_mobile" value="mobile">
                                                <label class="btn btn-outline-success w-100 p-3" for="method_mobile">
                                                    <i class="bi bi-phone d-block mb-2" style="font-size: 2rem;"></i>
                                                    <strong>Mobile Payment</strong><br>
                                                    <small>Dialog, Mobitel, Hutch</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" class="btn-check" name="payment_method" 
                                                       id="method_bank" value="bank_transfer">
                                                <label class="btn btn-outline-info w-100 p-3" for="method_bank">
                                                    <i class="bi bi-bank d-block mb-2" style="font-size: 2rem;"></i>
                                                    <strong>Bank Transfer</strong><br>
                                                    <small>All major banks</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" class="btn-check" name="payment_method" 
                                                       id="method_cash" value="cash">
                                                <label class="btn btn-outline-warning w-100 p-3" for="method_cash">
                                                    <i class="bi bi-cash-stack d-block mb-2" style="font-size: 2rem;"></i>
                                                    <strong>Cash Payment</strong><br>
                                                    <small>Pay at café</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Details (Dynamic) -->
                                <div id="paymentDetails">
                                    <!-- Payment method specific forms will be rendered here -->
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-coffee btn-lg">
                                        <i class="bi bi-lock me-2"></i>
                                        <span class="btn-text">Complete Payment</span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Processing...
                                        </span>
                                    </button>
                                </div>

                                <!-- Test Information -->
                                <div class="alert alert-info mt-3">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Test Mode:</strong> This is a simulation payment gateway for demonstration purposes.
                                    <details class="mt-2">
                                        <summary class="text-primary" style="cursor: pointer;">View Test Scenarios</summary>
                                        <div class="mt-2 small">
                                            <strong>Test Amounts:</strong><br>
                                            • Rs. 9999.99 - Insufficient funds<br>
                                            • Rs. 8888.88 - Card declined<br>
                                            • Rs. 7777.77 - Network error<br>
                                            • Any other amount - 95% success rate<br><br>
                                            <strong>Test Card:</strong> 4242424242424242<br>
                                            <strong>Test OTP:</strong> Will be shown in mobile payment
                                        </div>
                                    </details>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-summary-section {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(139, 69, 19, 0.1);
    height: fit-content;
    position: sticky;
    top: 20px;
}

.order-summary {
    max-height: 300px;
    overflow-y: auto;
}

.order-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(139, 69, 19, 0.1);
}

.order-item:last-child {
    border-bottom: none;
}

.breakdown-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(139, 69, 19, 0.05);
}

.breakdown-row.total {
    border-top: 2px solid var(--coffee-primary);
    border-bottom: none;
    margin-top: 0.5rem;
    padding-top: 1rem;
    font-size: 1.1rem;
}

.payment-method-card {
    transition: all 0.3s ease;
}

.payment-method-card:hover {
    transform: translateY(-3px);
}

.payment-method-card .btn-check:checked + .btn {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
    transform: scale(1.02);
}

.payment-form-section {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
}

.bg-coffee {
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary)) !important;
}

.btn-coffee {
    background: linear-gradient(45deg, var(--coffee-primary), var(--coffee-secondary));
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

.btn-loading {
    display: none;
}

.btn-coffee.loading .btn-text {
    display: none;
}

.btn-coffee.loading .btn-loading {
    display: inline-block;
}

#paymentDetails {
    min-height: 200px;
    transition: all 0.3s ease;
}

.card-payment-form,
.mobile-payment-form,
.bank-transfer-form,
.digital-wallet-form,
.cash-payment-form {
    background: linear-gradient(45deg, rgba(139, 69, 19, 0.02), rgba(210, 105, 30, 0.02));
    border-radius: 10px;
    padding: 1.5rem;
    border: 1px solid rgba(139, 69, 19, 0.1);
}

.security-info {
    background: linear-gradient(45deg, rgba(40, 167, 69, 0.05), rgba(25, 135, 84, 0.05));
    border-radius: 10px;
    border: 1px solid rgba(40, 167, 69, 0.1);
}
</style>

<script>
// Initialize payment modal functionality
document.addEventListener('DOMContentLoaded', function() {
    // Show payment modal function
    window.showPaymentModal = function(orderData) {
        // Populate order summary
        populateOrderSummary(orderData);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();
        
        // Initialize default payment method
        setTimeout(() => {
            document.getElementById('method_card').checked = true;
            window.simulationPaymentGateway.handlePaymentMethodChange('card');
        }, 100);
    };
    
    function populateOrderSummary(orderData) {
        // Populate hidden fields
        document.getElementById('paymentOrderId').value = orderData.order_id || '';
        document.getElementById('paymentAmount').value = orderData.total || 0;
        document.getElementById('paymentCustomerName').value = orderData.customer_name || '';
        document.getElementById('paymentCustomerEmail').value = orderData.customer_email || '';
        document.getElementById('paymentCustomerPhone').value = orderData.customer_phone || '';
        
        // Populate order summary
        const summaryContainer = document.getElementById('paymentOrderSummary');
        if (orderData.items && orderData.items.length > 0) {
            summaryContainer.innerHTML = orderData.items.map(item => `
                <div class="order-item">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <small class="text-muted">Rs. ${parseFloat(item.price).toFixed(2)} × ${item.quantity}</small>
                    </div>
                    <div class="text-end">
                        <strong>Rs. ${(parseFloat(item.price) * parseInt(item.quantity)).toFixed(2)}</strong>
                    </div>
                </div>
            `).join('');
        }
        
        // Populate totals
        document.getElementById('paymentSubtotal').textContent = `Rs. ${parseFloat(orderData.subtotal || 0).toFixed(2)}`;
        document.getElementById('paymentTax').textContent = `Rs. ${parseFloat(orderData.tax || 0).toFixed(2)}`;
        document.getElementById('paymentTotal').textContent = `Rs. ${parseFloat(orderData.total || 0).toFixed(2)}`;
    }
    
    // Update processing fee based on payment method
    document.addEventListener('change', function(e) {
        if (e.target.name === 'payment_method') {
            updateProcessingFee(e.target.value);
        }
    });
    
    function updateProcessingFee(method) {
        const amount = parseFloat(document.getElementById('paymentAmount').value) || 0;
        const feeRow = document.querySelector('.processing-fee');
        const feeElement = document.getElementById('paymentProcessingFee');
        const totalElement = document.getElementById('paymentTotal');
        
        let fee = 0;
        
        if (method !== 'cash') {
            const fees = {
                'card': { percentage: 2.9, fixed: 30 },
                'mobile': { percentage: 1.5, fixed: 10 },
                'bank_transfer': { percentage: 0.5, fixed: 25 },
                'digital_wallet': { percentage: 2.0, fixed: 15 }
            };
            
            const feeStructure = fees[method] || fees['card'];
            fee = (amount * feeStructure.percentage / 100) + feeStructure.fixed;
            
            feeRow.style.display = 'flex';
            feeElement.textContent = `Rs. ${fee.toFixed(2)}`;
        } else {
            feeRow.style.display = 'none';
        }
        
        const total = amount + fee;
        totalElement.textContent = `Rs. ${total.toFixed(2)}`;
        
        // Update hidden amount field to include fee
        document.getElementById('paymentAmount').value = total;
    }
});
</script>
</div>