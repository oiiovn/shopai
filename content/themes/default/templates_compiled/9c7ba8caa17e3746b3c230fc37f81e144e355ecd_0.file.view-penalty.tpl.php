<?php
/* Smarty version 4.3.4, created on 2025-10-31 06:24:45
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/view-penalty.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6904562ddd1c81_36906039',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c7ba8caa17e3746b3c230fc37f81e144e355ecd' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/view-penalty.tpl',
      1 => 1761891882,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_6904562ddd1c81_36906039 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
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
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        Thông Tin Lỗi Phạt
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($_smarty_tpl->tpl_vars['task']->value) {?>
                        <!-- Task Details Card -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fa fa-info-circle mr-2"></i>
                                    Thông tin nhiệm vụ
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong><i class="fa fa-map-marker-alt text-danger mr-1"></i> Tên địa điểm:</strong><br>
                                            <span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['task']->value['place_name'];?>
</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong><i class="fa fa-map text-info mr-1"></i> Địa chỉ:</strong><br>
                                            <span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['task']->value['place_address'];?>
</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong><i class="fa fa-gift text-success mr-1"></i> Phần thưởng:</strong><br>
                                            <span class="text-success font-weight-bold"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['task']->value['reward_amount']);?>
 VNĐ</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong><i class="fa fa-tag text-danger mr-1"></i> Trạng thái:</strong><br>
                                            <span class="badge badge-danger badge-lg" style="font-size: 1rem; padding: 0.6rem 1.2rem; background-color: #dc3545; font-weight: 700;">
                                                <i class="fa fa-times-circle mr-1"></i>THẤT BẠI
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penalty Details -->
                        <?php if ($_smarty_tpl->tpl_vars['task']->value['verification_notes']) {?>
                            <div class="alert alert-danger bg-danger-light border-danger mb-3" style="border-left: 5px solid #dc3545; background-color: #fff5f5;">
                                <h5 class="font-weight-bold mb-3" style="color: #dc3545;">
                                    <i class="fa fa-clipboard-list mr-2"></i>
                                    Lý do:
                                </h5>
                                <div style="white-space: pre-wrap; line-height: 1.8; font-size: 1.05rem; color: #721c24; font-weight: 500;">
                                    <?php echo $_smarty_tpl->tpl_vars['task']->value['verification_notes'];?>

                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-secondary mb-3">
                                <i class="fa fa-info-circle mr-1"></i>
                                Chưa có thông tin chi tiết về lỗi phạt.
                            </div>
                        <?php }?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['task']->value['expired_at']) {?>
                            <div class="alert alert-light mb-3">
                                <p class="mb-0">
                                    <strong><i class="fa fa-clock text-danger mr-1"></i> Thời gian hết hạn:</strong>
                                    <span class="text-muted"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expired_at'],"%d/%m/%Y %H:%M:%S");?>
</span>
                                </p>
                            </div>
                        <?php }?>

                        <!-- Timeline Card -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fa fa-history mr-2"></i>
                                    Lịch sử nhiệm vụ
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <?php if ($_smarty_tpl->tpl_vars['task']->value['expired_at']) {?>
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-danger"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Bị phạt / Hết hạn</h6>
                                                <p class="timeline-text mb-0">
                                                    <i class="fa fa-calendar mr-1"></i>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expired_at'],"%d/%m/%Y %H:%M:%S");?>

                                                </p>
                                            </div>
                                        </div>
                                    <?php }?>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['task']->value['completed_at']) {?>
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-warning"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Gửi bằng chứng</h6>
                                                <p class="timeline-text mb-0">
                                                    <i class="fa fa-calendar mr-1"></i>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['completed_at'],"%d/%m/%Y %H:%M:%S","+7 hours");?>

                                                </p>
                                            </div>
                                        </div>
                                    <?php }?>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['task']->value['assigned_at']) {?>
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-info"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Nhận nhiệm vụ</h6>
                                                <p class="timeline-text mb-0">
                                                    <i class="fa fa-calendar mr-1"></i>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['assigned_at'],"%d/%m/%Y %H:%M:%S");?>

                                                </p>
                                            </div>
                                        </div>
                                    <?php }?>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['task']->value['created_at']) {?>
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-secondary"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Tạo chiến dịch</h6>
                                                <p class="timeline-text mb-0">
                                                    <i class="fa fa-calendar mr-1"></i>
                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['created_at'],"%d/%m/%Y %H:%M:%S");?>

                                                </p>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews" class="btn btn-primary btn-lg">
                                <i class="fa fa-arrow-left mr-2"></i>
                                Quay Lại Danh Sách Nhiệm Vụ
                            </a>
                        </div>
                        
                    <?php } else { ?>
                        <!-- Error: Task Not Found -->
                        <div class="alert alert-danger">
                            <h5 class="alert-heading">
                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                Lỗi!
                            </h5>
                            <hr>
                            <p class="mb-0">
                                Không tìm thấy nhiệm vụ hoặc bạn không có quyền xem thông tin này.
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-2"></i>
                                Quay Lại Danh Sách
                            </a>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Timeline Styles */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
    color: #495057;
    font-size: 0.95rem;
}

.timeline-text {
    margin-bottom: 0;
    color: #6c757d;
    font-size: 0.875rem;
}

/* Card styling */
.card {
    border: 1px solid #dee2e6;
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Alert customization */
.alert-warning {
    background-color: #fff3cd;
    border-color: #ffc107;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #dc3545;
}
</style>

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
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
