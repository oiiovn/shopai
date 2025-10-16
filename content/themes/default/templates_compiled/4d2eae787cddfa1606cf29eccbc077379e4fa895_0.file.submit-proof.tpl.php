<?php
/* Smarty version 4.3.4, created on 2025-09-29 13:05:06
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/submit-proof.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68da840224e918_64322560',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d2eae787cddfa1606cf29eccbc077379e4fa895' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/submit-proof.tpl',
      1 => 1759064125,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68da840224e918_64322560 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

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
                    <?php if ($_smarty_tpl->tpl_vars['task']->value) {?>
                        <div class="alert alert-info">
                            <h5>Thông tin nhiệm vụ:</h5>
                            <p><strong>Địa điểm:</strong> <?php echo $_smarty_tpl->tpl_vars['task']->value['place_name'];?>
</p>
                            <p><strong>Địa chỉ:</strong> <?php echo $_smarty_tpl->tpl_vars['task']->value['place_address'];?>
</p>
                            <p><strong>Phần thưởng:</strong> <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['task']->value['reward_amount']);?>
 VNĐ</p>
                        </div>
                        
                        <form id="submit-proof-form" enctype="multipart/form-data">
                            <input type="hidden" name="sub_request_id" value="<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
">
                            <input type="hidden" name="place_name" value="<?php echo $_smarty_tpl->tpl_vars['task']->value['place_name'];?>
">
                            
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
                                <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                                    <i class="fas fa-paper-plane mr5"></i>Gửi bằng chứng
                                </button>
                            </div>
                            
                            <!-- Loading State -->
                            <div class="text-center mt-3" id="loading-state" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Đang xử lý...</span>
                                </div>
                                <p class="mt-2">Đang gửi bằng chứng và xác minh...</p>
                            </div>
                            
                            <!-- Success/Error Messages -->
                            <div class="alert alert-success mt-3" id="success-message" style="display: none;">
                                <i class="fas fa-check-circle me-2"></i>
                                <span id="success-text"></span>
                            </div>
                            
                            <div class="alert alert-danger mt-3" id="error-message" style="display: none;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <span id="error-text"></span>
                            </div>
                        </form>
                    <?php } else { ?>
                        <div class="alert alert-danger">
                            <h5>Lỗi!</h5>
                            <p>Không tìm thấy nhiệm vụ hoặc bạn không có quyền truy cập nhiệm vụ này.</p>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
>
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

// Helper functions
function showMessage(type, message) {
    // Hide all messages first
    document.getElementById('success-message').style.display = 'none';
    document.getElementById('error-message').style.display = 'none';
    
    if (type === 'success') {
        document.getElementById('success-text').textContent = message;
        document.getElementById('success-message').style.display = 'block';
        
        // Auto redirect after 3 seconds
        setTimeout(() => {
            window.location.href = '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews';
        }, 3000);
    } else {
        document.getElementById('error-text').textContent = message;
        document.getElementById('error-message').style.display = 'block';
    }
}

function resetForm() {
    const submitBtn = document.getElementById('submit-btn');
    const loadingState = document.getElementById('loading-state');
    
    // Reset button state
    submitBtn.disabled = false;
    submitBtn.innerHTML = '<i class="fas fa-paper-plane mr5"></i>Gửi bằng chứng';
    submitBtn.style.display = 'block';
    loadingState.style.display = 'none';
}

// Xử lý form submit
const submitForm = document.getElementById('submit-proof-form');
if (submitForm) {
    submitForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submit-btn');
        const loadingState = document.getElementById('loading-state');
        
        // Chặn nhấn nút hai lần - vô hiệu hóa ngay lập tức
        if (submitBtn.disabled) {
            return; // Đã được xử lý, không làm gì thêm
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr5"></i>Đang xử lý...';
        
        // Show loading state
        submitBtn.style.display = 'none';
        loadingState.style.display = 'block';
        
        // Hide any previous messages
        document.getElementById('success-message').style.display = 'none';
        document.getElementById('error-message').style.display = 'none';
        
        const screenshot = document.getElementById('screenshot').files[0];
        if (!screenshot) {
            showMessage('error', 'Vui lòng chọn ảnh chụp màn hình!');
            resetForm();
            return;
        }
        
        // Kiểm tra kích thước file
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (screenshot.size > maxSize) {
            showMessage('error', 'Ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 5MB.');
            resetForm();
            return;
        }
        
        const formData = new FormData(this);
        
        fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/gpt-verify-proof', {
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
                showMessage('success', 'Gửi bằng chứng thành công! Đang xác minh... Sẽ chuyển hướng trong 3 giây.');
            } else {
                // Xử lý các loại lỗi cụ thể
                let errorMessage = 'Có lỗi xảy ra';
                
                if (data.message) {
                    if (data.message.includes('duplicate') || data.message.includes('trùng')) {
                        errorMessage = 'URL đánh giá này đã được sử dụng trước đó. Vui lòng sử dụng URL khác.';
                    } else if (data.message.includes('time') || data.message.includes('thời gian')) {
                        errorMessage = 'Thời gian đánh giá không hợp lệ. Vui lòng kiểm tra lại.';
                    } else if (data.message.includes('image') || data.message.includes('ảnh')) {
                        errorMessage = 'Hình ảnh không hợp lệ. Vui lòng chọn ảnh khác.';
                    } else if (data.message.includes('link') || data.message.includes('URL')) {
                        errorMessage = 'Link đánh giá không hợp lệ. Vui lòng kiểm tra lại URL.';
                    } else {
                        errorMessage = 'Lỗi: ' + data.message;
                    }
                }
                
                showMessage('error', errorMessage);
                resetForm();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'Có lỗi xảy ra khi gửi bằng chứng. Vui lòng thử lại.');
            resetForm();
        });
    });
}
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
