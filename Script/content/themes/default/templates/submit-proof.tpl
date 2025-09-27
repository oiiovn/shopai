{include file='_head.tpl'}

<style>
/* Ẩn các thông báo liên tục */
.toast-container,
.notification-container,
.notification-wrapper,
[class*="notification"],
[class*="toast"],
[class*="alert-notification"] {
    display: none !important;
}

/* Ẩn các popup thông báo */
.modal-backdrop,
.popup-notification,
.system-notification {
    display: none !important;
}

/* Ẩn chat widget nếu có */
#chatgpt-widget,
.chatgpt-widget {
    display: none !important;
}
</style>

<div class="container mt30">
    <div class="row">
        <div class="col-md-8 mx-md-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Gửi bằng chứng đánh giá</h4>
                </div>
                <div class="card-body">
                    {if $task}
                        <div class="alert alert-info">
                            <h5>Thông tin nhiệm vụ:</h5>
                            <p><strong>Địa điểm:</strong> {$task.place_name}</p>
                            <p><strong>Địa chỉ:</strong> {$task.place_address}</p>
                            <p><strong>Phần thưởng:</strong> {$task.reward_amount|number_format} VNĐ</p>
                        </div>
                        
                        <form id="submit-proof-form" enctype="multipart/form-data">
                            <input type="hidden" name="sub_request_id" value="{$task.sub_request_id}">
                            <input type="hidden" name="place_name" value="{$task.place_name}">
                            
                            <div class="form-group mb20">
                                <label for="screenshot">Hình ảnh chụp màn hình đánh giá:</label>
                                <input type="file" class="form-control" id="screenshot" name="screenshot" accept="image/*" required>
                                <small class="form-text text-muted">Chọn 1 hình ảnh chụp màn hình đánh giá (JPEG, PNG, GIF - tối đa 5MB)</small>
                            </div>
                            
                            <div class="form-group mb20">
                                <label for="shared_link">Link chia sẻ đánh giá:</label>
                                <input type="url" class="form-control" id="shared_link" name="shared_link" placeholder="https://maps.google.com/..." required>
                                <small class="form-text text-muted">Copy link chia sẻ đánh giá từ Google Maps</small>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane mr5"></i>Gửi bằng chứng
                                </button>
                            </div>
                        </form>
                    {else}
                        <div class="alert alert-danger">
                            <h5>Lỗi!</h5>
                            <p>Không tìm thấy nhiệm vụ hoặc bạn không có quyền truy cập nhiệm vụ này.</p>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tắt tất cả các thông báo liên tục
document.addEventListener('DOMContentLoaded', function() {
    // TẮT ÂM THANH THÔNG BÁO
    // Tắt tất cả âm thanh
    const audioElements = document.querySelectorAll('audio, video');
    audioElements.forEach(audio => {
        audio.muted = true;
        audio.volume = 0;
        audio.pause();
    });
    
    // Tắt âm thanh hệ thống
    if (window.AudioContext || window.webkitAudioContext) {
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            audioContext.suspend();
        } catch(e) {}
    }
    
    // Override các hàm tạo âm thanh
    const originalPlay = HTMLAudioElement.prototype.play;
    HTMLAudioElement.prototype.play = function() {
        this.muted = true;
        this.volume = 0;
        return Promise.resolve();
    };
    
    // Tắt Notification API
    if (window.Notification) {
        window.Notification.requestPermission = function() {
            return Promise.resolve('denied');
        };
    }
    
    // Ẩn các thông báo
    const hideNotifications = () => {
        const notifications = document.querySelectorAll('.toast-container, .notification-container, .notification-wrapper, [class*="notification"], [class*="toast"], [class*="alert-notification"], .modal-backdrop, .popup-notification, .system-notification, #chatgpt-widget, .chatgpt-widget');
        notifications.forEach(notification => {
            if (notification) {
                notification.style.display = 'none';
                notification.remove();
            }
        });
        
        // Tắt âm thanh của các element mới
        const newAudioElements = document.querySelectorAll('audio, video');
        newAudioElements.forEach(audio => {
            audio.muted = true;
            audio.volume = 0;
            audio.pause();
        });
    };
    
    // Chạy ngay lập tức
    hideNotifications();
    
    // Chạy định kỳ để ẩn các thông báo mới
    setInterval(hideNotifications, 500);
    
    // Tắt các event listener có thể tạo thông báo
    if (window.toastr) {
        window.toastr.clear();
        window.toastr.remove();
    }
    
    // Tắt OneSignal nếu có
    if (window.OneSignal) {
        window.OneSignal.on('notificationDisplay', function(event) {
            event.preventDefault();
        });
    }
    
    // Tắt WebSocket notifications
    if (window.WebSocket) {
        const originalWebSocket = window.WebSocket;
        window.WebSocket = function(url, protocols) {
            const ws = new originalWebSocket(url, protocols);
            ws.onmessage = function() {
                // Không làm gì cả để tắt thông báo
            };
            return ws;
        };
    }
    
    // Tắt Service Worker notifications
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister();
            }
        });
    }
});

// Xử lý form submit
const submitForm = document.getElementById('submit-proof-form');
if (submitForm) {
    submitForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Debug user info
        console.log('Window.user:', window.user);
        console.log('User logged in:', window.user ? window.user.logged_in : 'undefined');
        console.log('User ID:', window.user ? window.user.user_id : 'undefined');
        
        const screenshot = document.getElementById('screenshot').files[0];
        if (!screenshot) {
            alert('Vui lòng chọn ảnh chụp màn hình!');
            return;
        }
        
        // Kiểm tra kích thước file
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (screenshot.size > maxSize) {
            alert('Ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 5MB.');
            return;
        }
        
        const formData = new FormData(this);
        
        fetch('{$system.system_url}/gpt-verify-proof', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Gửi bằng chứng thành công! Đang xác minh...');
                window.location.href = '{$system.system_url}/google-maps-reviews/my-reviews';
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi gửi bằng chứng');
        });
    });
}
</script>

{include file='_footer.tpl'}