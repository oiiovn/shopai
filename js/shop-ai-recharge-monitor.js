/**
 * Shop-AI Recharge Monitor
 * Kiểm tra trạng thái thanh toán real-time
 */

class ShopAIRechargeMonitor {
    constructor() {
        this.checkInterval = null;
        this.qrCode = null;
        this.amount = null;
        this.userId = null;
        this.maxChecks = 900; // 15 phút * 60 giây = 900 lần check
        this.currentChecks = 0;
        this.isChecking = false;
    }

    // Bắt đầu monitoring
    startMonitoring(qrCode, amount, userId) {
        this.qrCode = qrCode;
        this.amount = amount;
        this.userId = userId;
        this.currentChecks = 0;
        this.isChecking = true;

        console.log(`🔄 Bắt đầu monitoring QR: ${qrCode}, Amount: ${amount}, User: ${userId}`);
        
        // Hiển thị trạng thái
        this.updateStatus('Đang chờ thanh toán...', 'info');
        this.showCountdown();
        
        // Bắt đầu check mỗi giây
        this.checkInterval = setInterval(() => {
            this.checkPaymentStatus();
        }, 1000);
    }

    // Dừng monitoring
    stopMonitoring() {
        if (this.checkInterval) {
            clearInterval(this.checkInterval);
            this.checkInterval = null;
        }
        this.isChecking = false;
        console.log('⏹️ Dừng monitoring');
    }

    // Kiểm tra trạng thái thanh toán
    async checkPaymentStatus() {
        if (!this.isChecking) return;

        this.currentChecks++;
        
        // Cập nhật countdown
        const remainingTime = Math.max(0, this.maxChecks - this.currentChecks);
        this.updateCountdown(remainingTime);

        // Hết thời gian
        if (this.currentChecks >= this.maxChecks) {
            this.handleTimeout();
            return;
        }

        try {
            const response = await fetch('shop-ai.php?action=check_payment_status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    qr_code: this.qrCode,
                    amount: this.amount,
                    user_id: this.userId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                if (data.status === 'completed') {
                    this.handlePaymentSuccess(data);
                } else if (data.status === 'expired') {
                    this.handleExpired();
                }
                // Nếu status là 'pending', tiếp tục check
            } else {
                console.warn('Check payment error:', data.message);
            }

        } catch (error) {
            console.error('Network error:', error);
        }
    }

    // Xử lý thanh toán thành công
    handlePaymentSuccess(data) {
        this.stopMonitoring();
        this.updateStatus('✅ Thanh toán thành công!', 'success');
        
        // Hiển thị thông báo thành công
        this.showSuccessMessage(data);
        
        // Tự động reload sau 3 giây
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }

    // Xử lý hết thời gian
    handleTimeout() {
        this.stopMonitoring();
        this.updateStatus('⏰ Hết thời gian chờ thanh toán', 'warning');
        this.showTimeoutMessage();
    }

    // Xử lý QR code hết hạn
    handleExpired() {
        this.stopMonitoring();
        this.updateStatus('⚠️ QR code đã hết hạn', 'warning');
        this.showExpiredMessage();
    }

    // Cập nhật trạng thái
    updateStatus(message, type = 'info') {
        const statusElement = document.getElementById('payment-status');
        if (statusElement) {
            statusElement.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        }
    }

    // Hiển thị countdown
    showCountdown() {
        const countdownElement = document.getElementById('payment-countdown');
        if (countdownElement) {
            countdownElement.style.display = 'block';
        }
    }

    // Cập nhật countdown
    updateCountdown(remainingSeconds) {
        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        const countdownElement = document.getElementById('countdown-timer');
        if (countdownElement) {
            countdownElement.textContent = timeString;
        }

        // Cập nhật progress bar
        const progressElement = document.getElementById('countdown-progress');
        if (progressElement) {
            const percentage = (remainingSeconds / this.maxChecks) * 100;
            progressElement.style.width = `${percentage}%`;
            
            // Đổi màu khi gần hết thời gian
            if (percentage < 20) {
                progressElement.className = 'progress-bar bg-danger';
            } else if (percentage < 50) {
                progressElement.className = 'progress-bar bg-warning';
            } else {
                progressElement.className = 'progress-bar bg-info';
            }
        }
    }

    // Hiển thị thông báo thành công
    showSuccessMessage(data) {
        const successHtml = `
            <div class="alert alert-success">
                <h5>🎉 Nạp tiền thành công!</h5>
                <p><strong>Số tiền:</strong> ${this.formatMoney(data.amount)} VNĐ</p>
                <p><strong>Số dư mới:</strong> ${this.formatMoney(data.new_balance)} VNĐ</p>
                <p><strong>Mã giao dịch:</strong> ${data.transaction_id}</p>
                <small>Trang sẽ tự động tải lại sau 3 giây...</small>
            </div>
        `;
        
        const messageElement = document.getElementById('payment-message');
        if (messageElement) {
            messageElement.innerHTML = successHtml;
        }
    }

    // Hiển thị thông báo hết thời gian
    showTimeoutMessage() {
        const timeoutHtml = `
            <div class="alert alert-warning">
                <h5>⏰ Hết thời gian chờ</h5>
                <p>QR code đã hết thời gian hiệu lực. Vui lòng tạo mã QR mới để tiếp tục nạp tiền.</p>
                <button class="btn btn-primary" onclick="location.reload()">Tạo QR mới</button>
            </div>
        `;
        
        const messageElement = document.getElementById('payment-message');
        if (messageElement) {
            messageElement.innerHTML = timeoutHtml;
        }
    }

    // Hiển thị thông báo hết hạn
    showExpiredMessage() {
        const expiredHtml = `
            <div class="alert alert-warning">
                <h5>⚠️ QR code hết hạn</h5>
                <p>QR code đã hết hạn. Vui lòng tạo mã QR mới để tiếp tục nạp tiền.</p>
                <button class="btn btn-primary" onclick="location.reload()">Tạo QR mới</button>
            </div>
        `;
        
        const messageElement = document.getElementById('payment-message');
        if (messageElement) {
            messageElement.innerHTML = expiredHtml;
        }
    }

    // Format số tiền
    formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount);
    }
}

// Global instance
let rechargeMonitor = null;

// Khởi tạo monitoring khi có QR code
function startRechargeMonitoring(qrCode, amount, userId) {
    if (rechargeMonitor) {
        rechargeMonitor.stopMonitoring();
    }
    
    rechargeMonitor = new ShopAIRechargeMonitor();
    rechargeMonitor.startMonitoring(qrCode, amount, userId);
}

// Dừng monitoring
function stopRechargeMonitoring() {
    if (rechargeMonitor) {
        rechargeMonitor.stopMonitoring();
    }
}

// Auto cleanup khi rời khỏi trang
window.addEventListener('beforeunload', function() {
    stopRechargeMonitoring();
});

// Export cho sử dụng global
window.ShopAIRechargeMonitor = ShopAIRechargeMonitor;
window.startRechargeMonitoring = startRechargeMonitoring;
window.stopRechargeMonitoring = stopRechargeMonitoring;
