<?php
/* Smarty version 4.3.4, created on 2026-01-31 14:47:30
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/finance.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_697e16025954b0_45954811',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '268e5a9ac13ef65d76c2dba3f32f3df2f05674ee' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/finance.tpl',
      1 => 1769870836,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:__svg_icons.tpl' => 3,
    'file:_no_transactions.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_697e16025954b0_45954811 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <!-- side panel -->

    <!-- finance sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar finance-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <ul class="main-side-nav">
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "recharge") {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/recharge">
                <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                <?php echo __("Nạp tiền");?>

              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "transactions") {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/transactions">
                <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                <?php echo __("Lịch sử giao dịch");?>

              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- finance sidebar -->

    <!-- content panel -->
    <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar finance-mainbar">

      <!-- tabs (mobile only) -->
      <div class="content-tabs rounded-sm shadow-sm clearfix d-block d-md-none">
        <ul>
          <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "recharge") {?>class="active" <?php }?>>
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/recharge">
              <?php echo __("Nạp tiền");?>

            </a>
          </li>
          <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "transactions") {?>class="active" <?php }?>>
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/transactions">
              <?php echo __("Giao dịch");?>

            </a>
          </li>
        </ul>
      </div>
      <!-- tabs -->

      <!-- content -->
      <div class="row">
        <!-- main content -->
        <div class="col-12">
          <div class="card">
            <?php if ($_smarty_tpl->tpl_vars['view']->value == "recharge") {?>
              <div class="card-header bg-transparent">
                <strong><?php echo __("Nạp tiền");?>
</strong>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8 mx-auto">
                    <!-- Số dư hiện tại -->
                    <div class="alert alert-info text-center">
                      <strong><?php echo __("Số dư hiện tại");?>
: <?php echo number_format($_smarty_tpl->tpl_vars['current_balance']->value,0,',','.');?>
 VNĐ</strong>
                    </div>
                    
                    <!-- Admin Contact Info -->
                    <?php if ($_smarty_tpl->tpl_vars['admin_info']->value) {?>
                    <div class="admin-contact-info mb-4 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
                      <div class="text-center mb-2">
                        <small class="opacity-75">
                          <i class="fa fa-headset mr-1"></i>Liên hệ hỗ trợ khi cần
                        </small>
                      </div>
                      <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['admin_info']->value['user_name'];?>
" class="text-white d-flex align-items-center" style="text-decoration: none;">
                          <img src="<?php echo $_smarty_tpl->tpl_vars['admin_info']->value['user_picture'];?>
" alt="Admin" class="rounded-circle" style="width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.3); margin-right: 5px;">
                          <div class="d-flex align-items-center">
                            <span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['admin_info']->value['name'];?>
</span>
                            <?php if ($_smarty_tpl->tpl_vars['admin_info']->value['user_verified']) {?>
                              <span class="ml-2" data-bs-toggle="tooltip" title='<?php echo __("Verified User");?>
'>
                                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"verified_badge",'width'=>"15px",'height'=>"15px"), 0, false);
?>
                              </span>
                            <?php }?>
                          </div>
                        </a>
                        <?php if ($_smarty_tpl->tpl_vars['admin_info']->value['zalo']) {?>
                        <div class="ml-3">
                          <small>
                            <i class="fab fa-zalo mr-1"></i>Zalo: <strong><?php echo $_smarty_tpl->tpl_vars['admin_info']->value['zalo'];?>
</strong>
                          </small>
                        </div>
                        <?php }?>
                      </div>
                    </div>
                    <?php }?>
                    
                    <!-- Form nạp tiền -->
                    <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/recharge" id="rechargeForm" onsubmit="return false;">
                      <div class="row justify-content-center">
                        <div class="col-md-8">
                          <div class="form-group">
                            <div class="input-group">
                              <input type="text" 
                                     class="form-control" 
                                     id="amountInput" 
                                     name="amount" 
                                     placeholder="Nhập số tiền" 
                                     oninput="validateAndFormatAmount(this)"
                                     required>
                              <button type="button" 
                                      class="btn btn-primary" 
                                      data-bs-toggle="modal" 
                                      data-bs-target="#rechargeModal" 
                                      onclick="openRechargeModal(); return false;"
                                      id="rechargeBtn"
                                      disabled>
                                <i class="fa fa-qrcode mr5"></i><?php echo __("Nạp tiền ngay");?>

                              </button>
                            </div>
                            <small class="form-text text-muted mt-2">
                              Số tiền tối thiểu: 10,000 VNĐ - Tối đa: 50,000,000 VNĐ
                            </small>
                            
                            <!-- Quick amount buttons -->
                            <div class="mt-4">
                              <label class="form-label small"><?php echo __("Chọn nhanh");?>
:</label>
                              <!-- Mobile: Single row scroll -->
                              <div class="quick-select-container d-block d-md-none">
                                <div class="quick-select-scroll">
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(30000)">30K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(50000)">50K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(100000)">100K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(200000)">200K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(500000)">500K</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(1000000)">1M</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(2000000)">2M</button>
                                  <button type="button" class="btn btn-outline-primary quick-select-btn" onclick="setQuickAmount(5000000)">5M</button>
                                </div>
                              </div>
                              <!-- Desktop: Grid layout -->
                              <div class="quick-select-grid d-none d-md-block">
                                <div class="row g-2">
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(30000)">30K</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(50000)">50K</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(100000)">100K</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(200000)">200K</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(500000)">500K</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(1000000)">1M</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(2000000)">2M</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(5000000)">5M</button>
                                  </div>
                                  <div class="col-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="setQuickAmount(10000000)">10M</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <!-- Amount preview -->
                            <div class="mt-3" id="amountPreview" style="display: none;">
                              <div class="alert alert-success text-center">
                                <strong>Số tiền sẽ nạp: <span id="previewAmount">0</span> VNĐ</strong>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    
                    <!-- QR Code Display -->
                    <?php if ($_smarty_tpl->tpl_vars['qr_data']->value) {?>
                    <div class="mt-4" id="qrSection">
                      <div class="card">
                        <div class="card-body text-center">
                          <div class="mb-3">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['qr_data']->value;?>
" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                          </div>
                          
                          <!-- Payment Status -->
                          <div id="payment-status">
                            <div class="alert alert-info">
                              <i class="fa fa-clock-o mr5"></i>Đang chờ thanh toán...
                            </div>
                          </div>
                          
                          <!-- Payment Countdown -->
                          <div id="payment-countdown" class="mb-3">
                            <div class="text-muted mb-2">Thời gian còn lại:</div>
                            <div class="h4 text-primary" id="countdown-timer">15:00</div>
                            <div class="progress">
                              <div class="progress-bar bg-info" id="countdown-progress" style="width: 100%"></div>
                            </div>
                          </div>
                          
                          <!-- Payment Message -->
                          <div id="payment-message"></div>
                          
                          <div class="row">
                            <div class="col-md-6">
                              <div class="alert alert-info">
                                <strong><?php echo __("Số tiền");?>
:</strong><br>
                                <span class="h5 text-success"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['amount']->value);?>
 VNĐ</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="alert alert-info">
                                <strong><?php echo __("Nội dung");?>
:</strong><br>
                                <code><?php echo $_smarty_tpl->tpl_vars['qr_content']->value;?>
</code>
                              </div>
                            </div>
                          </div>
                          
                          <div class="alert alert-warning">
                            <strong><?php echo __("Thông tin chuyển khoản");?>
:</strong><br>
                            <strong><?php echo __("Ngân hàng");?>
:</strong> ACB<br>
                            <strong><?php echo __("STK");?>
:</strong> 46241987<br>
                            <strong><?php echo __("Nội dung");?>
:</strong> <?php echo $_smarty_tpl->tpl_vars['qr_content']->value;?>
<br>
                            <strong><?php echo __("Thời gian");?>
:</strong> <?php echo smarty_modifier_date_format(time(),"%d/%m/%Y %H:%M:%S");?>

                          </div>
                          
                          <div class="mt-3">
                            <button type="button" class="btn btn-success mr-2" onclick="saveQRCode()">
                              <i class="fa fa-download mr5"></i><?php echo __("Lưu QR Code");?>

                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeQR()">
                              <?php echo __("Đóng");?>

                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php }?>
                    
                    <!-- Thông tin bổ sung -->
                    <div class="mt-4">
                      <div class="alert alert-danger">
                        <h6><i class="fa fa-info-circle mr5"></i><?php echo __("Lưu ý");?>
</h6>
                        <ul class="mb-0">
                          <li><?php echo __("Giao dịch sẽ được xử lý trong vòng 5-10 phút");?>
</li>
                          <li><?php echo __("Liên hệ hỗ trợ nếu có vấn đề");?>
</li>
                          <li><?php echo __("Số tiền tối thiểu: 10,000 VNĐ");?>
</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- JavaScript for QR functions -->
              <?php echo '<script'; ?>
>
              // Load monitoring script
              <?php if ($_smarty_tpl->tpl_vars['qr_data']->value && $_smarty_tpl->tpl_vars['qr_content']->value && $_smarty_tpl->tpl_vars['amount']->value) {?>
              $(document).ready(function() {
                // Load monitoring script
                $.getScript('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/js/shop-ai-recharge-monitor.js', function() {
                  console.log('Starting recharge monitoring...');
                  startRechargeMonitoring('<?php echo $_smarty_tpl->tpl_vars['qr_content']->value;?>
', <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
, <?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_id'];?>
);
                }).fail(function() {
                  console.error('Failed to load monitoring script');
                });
              });
              <?php }?>
              
              function saveQRCode() {
                var qrImg = document.querySelector('#qrSection img');
                if (qrImg) {
                  var link = document.createElement('a');
                  link.download = 'qr-code-' + Date.now() + '.png';
                  link.href = qrImg.src;
                  link.click();
                }
              }
              
              function closeQR() {
                var qrSection = document.getElementById('qrSection');
                if (qrSection) {
                  qrSection.style.display = 'none';
                }
              }
              
              // Function to validate and format amount input
              function validateAndFormatAmount(input) {
                // Remove all non-digit characters
                let value = input.value.replace(/\D/g, '');
                
                // Convert to number for validation
                let numValue = parseInt(value) || 0;
                
                // Format with thousand separators
                if (value) {
                  input.value = numValue.toLocaleString('vi-VN');
                } else {
                  input.value = '';
                }
                
                // Update preview and button state
                updateAmountPreview(numValue);
                updateRechargeButtonState(numValue);
              }
              
              function setQuickAmount(amount) {
                const input = document.getElementById('amountInput');
                input.value = amount.toLocaleString('vi-VN');
                
                updateAmountPreview(amount);
                updateRechargeButtonState(amount);
                
                // Auto-generate QR if modal is open
                if ($('#rechargeModal').hasClass('show')) {
                  updateQRCode(amount);
                }
              }
              
              // Function to update amount preview
              function updateAmountPreview(amount) {
                if (amount && amount >= 10000) {
                  document.getElementById('previewAmount').textContent = amount.toLocaleString('vi-VN');
                  document.getElementById('amountPreview').style.display = 'block';
                } else {
                  document.getElementById('amountPreview').style.display = 'none';
                }
              }
              
              // Function to update recharge button state
              function updateRechargeButtonState(amount) {
                const btn = document.getElementById('rechargeBtn');
                const isValid = amount && amount >= 10000 && amount <= 50000000;
                
                if (isValid) {
                  btn.disabled = false;
                  btn.classList.remove('btn-secondary');
                  btn.classList.add('btn-primary');
                  btn.style.opacity = '1';
                } else {
                  btn.disabled = true;
                  btn.classList.remove('btn-primary');
                  btn.classList.add('btn-secondary');
                  btn.style.opacity = '0.6';
                }
              }
              
              // Function to open modal and auto-generate QR
              function openRechargeModal() {
                // Prevent form submission
                event.preventDefault();
                event.stopPropagation();
                
                // Get clean numeric amount from formatted input
                var amount = getCleanAmount();
                
                // Validate amount
                if (!amount || amount < 10000) {
                  alert('Số tiền tối thiểu là 10,000 VNĐ');
                  document.getElementById('amountInput').focus();
                  return false;
                }
                
                if (amount > 50000000) {
                  alert('Số tiền tối đa là 50,000,000 VNĐ');
                  document.getElementById('amountInput').focus();
                  return false;
                }
                
                // Auto-generate QR code with entered amount
                updateQRCode(amount);
                
                return false;
              }
              
              // Function to update QR code when amount changes
              function updateQRCode(amount) {
                if (!amount) {
                  $('#modalQRSection').hide();
                  return;
                }
                
                // Generate unique content giống với PHP format
                var user_id = <?php if ((isset($_smarty_tpl->tpl_vars['user']->value->_data['user_id']))) {
echo $_smarty_tpl->tpl_vars['user']->value->_data['user_id'];
} else { ?>1<?php }?>;
                var timestamp = Math.floor(Date.now() / 1000);
                var random_string = Math.random().toString(36).substring(2, 8).toUpperCase();
                var qr_content = 'RZ' + user_id + timestamp + random_string; // Format giống PHP
                
                // Show loading
                $('#modalQRImage').attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjMwMCIgZmlsbD0iI2Y4ZjlmYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM2Yzc1N2QiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5U4bqjIG3hu5kgUVIuLi48L3RleHQ+PC9zdmc+');
                $('#modalAmountDisplay').text(parseInt(amount).toLocaleString('vi-VN') + ' VNĐ');
                $('#modalContentDisplay').text(qr_content);
                
                // Show QR section and buttons
                $('#modalQRSection').show();
                $('#saveQRBtn').show();
                
                // Save QR mapping to database first
                saveQRMapping(qr_content, user_id, amount, function(success) {
                  if (success) {
                    // Generate QR using VietQR API after saving successfully
                    generateVietQR(amount, qr_content);
                  } else {
                    alert('Lỗi lưu QR code. Vui lòng thử lại.');
                  }
                });
              }
              
              // Function to generate QR using VietQR
              function generateVietQR(amount, content) {
                // VietQR configuration
                var accountNo = '46241987';  // STK ACB thật
                var accountName = 'ACB Account';
                var bankCode = '970416'; // ACB Bank code for VietQR
                var bankName = 'ACB';
                
                // Method 1: Try VietQR API with proper EMV format
                var vietqr_api_url = 'https://api.vietqr.io/v2/generate';
                var vietqr_data = {
                  accountNo: accountNo,
                  accountName: accountName,
                  acqId: bankCode,
                  amount: parseInt(amount),
                  addInfo: content,
                  format: 'text',
                  template: 'compact'
                };
                
                // Method 2: VietQR image service with proper format
                var timestamp = Date.now();
                var qr_image_url = 'https://img.vietqr.io/image/' + bankCode + '-' + accountNo + '-' + amount + '-' + encodeURIComponent(content) + '.jpg?t=' + timestamp;
                
                // Method 3: Create VietQR dynamic URL for fallback
                var qr_url = 'https://vietqr.net/transfer/' + bankCode + '-' + accountNo + '?amount=' + amount + '&addInfo=' + encodeURIComponent(content);
                var fallback_url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + encodeURIComponent(qr_url);
                
                // Try VietQR API first (most reliable for dynamic QR)
                $.ajax({
                  url: vietqr_api_url,
                  method: 'POST',
                  data: JSON.stringify(vietqr_data),
                  contentType: 'application/json',
                  success: function(response) {
                    if (response.data && response.data.qrDataURL) {
                      $('#modalQRImage').attr('src', response.data.qrDataURL);
                    } else {
                      // Fallback to VietQR image service
                      tryVietQRImageService();
                    }
                  },
                  error: function() {
                    // Fallback to VietQR image service
                    tryVietQRImageService();
                  }
                });
                
                function tryVietQRImageService() {
                  var img = new Image();
                  
                  img.onload = function() {
                    $('#modalQRImage').attr('src', img.src);
                  };
                  
                  img.onerror = function() {
                    // Final fallback to QR Server with VietQR URL
                    $('#modalQRImage').attr('src', fallback_url);
                  };
                  
                  img.src = qr_image_url;
                }
              }
              
              // Function to get clean numeric value from formatted input
              function getCleanAmount() {
                const input = document.getElementById('amountInput');
                return parseInt(input.value.replace(/\D/g, '')) || 0;
              }
              
              // Function to save QR mapping via AJAX
              function saveQRMapping(qrCode, userId, amount, callback) {
                $.ajax({
                  url: '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance.php?action=save_qr_mapping',
                  method: 'POST',
                  contentType: 'application/json',
                  data: JSON.stringify({
                    qr_code: qrCode,
                    user_id: userId,
                    amount: amount
                  }),
                  success: function(response) {
                    console.log('QR mapping saved:', response);
                    if (response.success) {
                      callback(true);
                    } else {
                      console.error('Failed to save QR mapping:', response.message);
                      callback(false);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.error('AJAX error saving QR mapping:', error);
                    callback(false);
                  }
                });
              }
              
              // Save QR Code function
              function saveQRCode() {
                var qrImg = document.getElementById('modalQRImage');
                if (qrImg) {
                  var link = document.createElement('a');
                  link.download = 'qr-code-' + Date.now() + '.png';
                  link.href = qrImg.src;
                  link.click();
                }
              }
              
              // Initialize when document is ready
              $(document).ready(function() {
                // Save QR Code
                $('#saveQRBtn').click(function(e) {
                  e.preventDefault();
                  saveQRCode();
                });
                
                // Prevent form submission
                $('#rechargeForm').on('submit', function(e) {
                  e.preventDefault();
                  return false;
                });
                
                // Reset modal when closed
                $('#rechargeModal').on('hidden.bs.modal', function() {
                  $('#modalQRSection').hide();
                  $('#saveQRBtn').hide();
                });
                
                // Show QR section when modal is shown
                $('#rechargeModal').on('shown.bs.modal', function() {
                  var amount = getCleanAmount();
                  if (amount && amount >= 10000) {
                    updateQRCode(amount);
                  }
                });
                
                // Initial button state - disabled with secondary style
                updateRechargeButtonState(0);
                
                // Auto-generate QR when amount changes (if modal is open)
                $('#amountInput').on('input', function() {
                  var amount = getCleanAmount();
                  if (amount && amount >= 10000 && $('#rechargeModal').hasClass('show')) {
                    updateQRCode(amount);
                  }
                });
              });
              <?php echo '</script'; ?>
>
              
            <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "transactions") {?>
              <div class="card-header with-icon">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"wallet",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                <?php echo __("Lịch Sử Giao Dịch");?>

              </div>
              <div class="card-body">
                
                <!-- Admin Contact Info -->
                <?php if ($_smarty_tpl->tpl_vars['admin_info']->value) {?>
                <div class="admin-contact-info mb-4 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
                  <div class="text-center mb-2">
                    <small class="opacity-75">
                      <i class="fa fa-headset mr-1"></i>Liên hệ hỗ trợ khi cần
                    </small>
                  </div>
                  <div class="d-flex align-items-center justify-content-center flex-wrap">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['admin_info']->value['user_name'];?>
" class="text-white d-flex align-items-center" style="text-decoration: none;">
                      <img src="<?php echo $_smarty_tpl->tpl_vars['admin_info']->value['user_picture'];?>
" alt="Admin" class="rounded-circle mr-2" style="width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.3);">
                      <div class="d-flex align-items-center">
                        <span class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['admin_info']->value['name'];?>
</span>
                        <?php if ($_smarty_tpl->tpl_vars['admin_info']->value['user_verified']) {?>
                          <span class="ml-2" data-bs-toggle="tooltip" title='<?php echo __("Verified User");?>
'>
                            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"verified_badge",'width'=>"15px",'height'=>"15px"), 0, true);
?>
                          </span>
                        <?php }?>
                      </div>
                    </a>
                    <?php if ($_smarty_tpl->tpl_vars['admin_info']->value['zalo']) {?>
                    <div class="ml-3">
                      <small>
                        <i class="fab fa-zalo mr-1"></i>Zalo: <strong><?php echo $_smarty_tpl->tpl_vars['admin_info']->value['zalo'];?>
</strong>
                      </small>
                    </div>
                    <?php }?>
                  </div>
                </div>
                <?php }?>
                
                <!-- Wallet transactions -->
                <div class="col-12 mt20">
                  <div class="section-title mt10 mb20">
                    <?php echo __("Lịch Sử Giao Dịch");?>

                  </div>
                  <?php if ($_smarty_tpl->tpl_vars['shop_ai_transactions']->value) {?>
                    <!-- Desktop: Table -->
                    <div class="table-responsive d-none d-md-block">
                      <table class="table table-striped table-bordered table-hover js_dataTable">
                        <thead>
                          <tr>
                            <th width="15%"><?php echo __("ID");?>
</th>
                            <th width="15%"><?php echo __("Số Tiền");?>
</th>
                            <th width="15%"><?php echo __("Loại");?>
</th>
                            <th width="15%"><?php echo __("Số Dư Sau");?>
</th>
                            <th width="25%"><?php echo __("Mã QR");?>
</th>
                            <th width="15%"><?php echo __("Thời Gian");?>
</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $_smarty_tpl->_assignInScope('running_balance', $_smarty_tpl->tpl_vars['current_balance']->value);?>
                          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shop_ai_transactions']->value, 'transaction');
$_smarty_tpl->tpl_vars['transaction']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaction']->value) {
$_smarty_tpl->tpl_vars['transaction']->do_else = false;
?>
                                                        <?php $_smarty_tpl->_assignInScope('is_credit', ($_smarty_tpl->tpl_vars['transaction']->value['type'] == 'recharge' || $_smarty_tpl->tpl_vars['transaction']->value['type'] == 'otp_refund'));?>
                                                        <?php if ($_smarty_tpl->tpl_vars['is_credit']->value) {?>
                              <?php $_smarty_tpl->_assignInScope('balance_after', $_smarty_tpl->tpl_vars['running_balance']->value);?>
                              <?php $_smarty_tpl->_assignInScope('running_balance', $_smarty_tpl->tpl_vars['running_balance']->value-$_smarty_tpl->tpl_vars['transaction']->value['amount']);?>
                            <?php } else { ?>
                              <?php $_smarty_tpl->_assignInScope('balance_after', $_smarty_tpl->tpl_vars['running_balance']->value);?>
                              <?php $_smarty_tpl->_assignInScope('running_balance', $_smarty_tpl->tpl_vars['running_balance']->value+$_smarty_tpl->tpl_vars['transaction']->value['amount']);?>
                            <?php }?>
                            <tr>
                              <td>#<?php echo $_smarty_tpl->tpl_vars['transaction']->value['transaction_id'];?>
</td>
                              <td>
                                <strong class="<?php if ($_smarty_tpl->tpl_vars['is_credit']->value) {?>text-success<?php } else { ?>text-danger<?php }?>">
                                  <?php if ($_smarty_tpl->tpl_vars['is_credit']->value) {?>+<?php } else { ?>-<?php }
echo number_format($_smarty_tpl->tpl_vars['transaction']->value['amount'],0,',','.');?>
 VNĐ
                                </strong>
                              </td>
                              <td>
                                <span class="badge <?php if ($_smarty_tpl->tpl_vars['is_credit']->value) {?>bg-success<?php } else { ?>bg-danger<?php }?>">
                                  <?php if ($_smarty_tpl->tpl_vars['is_credit']->value) {
echo __("Nạp Tiền");
} else {
echo __("Trừ tiền");
}?>
                                </span>
                              </td>
                              <td>
                                <strong class="text-primary">
                                  <?php echo number_format($_smarty_tpl->tpl_vars['balance_after']->value,0,',','.');?>
 VNĐ
                                </strong>
                              </td>
                              <td>
                                <small class="text-muted">
                                  <?php if ($_smarty_tpl->tpl_vars['transaction']->value['description']) {?>
                                    <?php $_smarty_tpl->_assignInScope('qr_code', '');?>
                                    <?php if (strpos($_smarty_tpl->tpl_vars['transaction']->value['description'],'QR: ') !== false) {?>
                                      <?php $_smarty_tpl->_assignInScope('qr_parts', explode('QR: ',$_smarty_tpl->tpl_vars['transaction']->value['description']));?>
                                      <?php if ((isset($_smarty_tpl->tpl_vars['qr_parts']->value[1]))) {?>
                                        <?php $_smarty_tpl->_assignInScope('qr_code', trim($_smarty_tpl->tpl_vars['qr_parts']->value[1]));?>
                                      <?php }?>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['qr_code']->value) {?>
                                      <code><?php echo $_smarty_tpl->tpl_vars['qr_code']->value;?>
</code>
                                    <?php } else { ?>
                                      <?php echo $_smarty_tpl->tpl_vars['transaction']->value['description'];?>

                                    <?php }?>
                                  <?php } else { ?>
                                    -
                                  <?php }?>
                                </small>
                              </td>
                              <td>
                                <small class="text-muted">
                                  <?php echo date('d/m/Y H:i',strtotime($_smarty_tpl->tpl_vars['transaction']->value['time']));?>

                                </small>
                              </td>
                            </tr>
                          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </tbody>
                      </table>
                    </div>
                    
                    <!-- Mobile: Cards -->
                    <div class="d-block d-md-none">
                      <?php $_smarty_tpl->_assignInScope('running_balance_mobile', $_smarty_tpl->tpl_vars['current_balance']->value);?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shop_ai_transactions']->value, 'transaction');
$_smarty_tpl->tpl_vars['transaction']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaction']->value) {
$_smarty_tpl->tpl_vars['transaction']->do_else = false;
?>
                                                <?php $_smarty_tpl->_assignInScope('is_credit_mobile', ($_smarty_tpl->tpl_vars['transaction']->value['type'] == 'recharge' || $_smarty_tpl->tpl_vars['transaction']->value['type'] == 'otp_refund'));?>
                                                <?php if ($_smarty_tpl->tpl_vars['is_credit_mobile']->value) {?>
                          <?php $_smarty_tpl->_assignInScope('balance_after_mobile', $_smarty_tpl->tpl_vars['running_balance_mobile']->value);?>
                          <?php $_smarty_tpl->_assignInScope('running_balance_mobile', $_smarty_tpl->tpl_vars['running_balance_mobile']->value-$_smarty_tpl->tpl_vars['transaction']->value['amount']);?>
                        <?php } else { ?>
                          <?php $_smarty_tpl->_assignInScope('balance_after_mobile', $_smarty_tpl->tpl_vars['running_balance_mobile']->value);?>
                          <?php $_smarty_tpl->_assignInScope('running_balance_mobile', $_smarty_tpl->tpl_vars['running_balance_mobile']->value+$_smarty_tpl->tpl_vars['transaction']->value['amount']);?>
                        <?php }?>
                        <div class="card mb-3">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-8">
                                <div class="d-flex align-items-center mb-2">
                                  <span class="badge <?php if ($_smarty_tpl->tpl_vars['is_credit_mobile']->value) {?>bg-success<?php } else { ?>bg-danger<?php }?> mr10">
                                    <?php if ($_smarty_tpl->tpl_vars['is_credit_mobile']->value) {?>Nạp Tiền<?php } else { ?>Trừ tiền<?php }?>
                                  </span>
                                  <small class="text-muted">#<?php echo $_smarty_tpl->tpl_vars['transaction']->value['transaction_id'];?>
</small>
                                </div>
                                <h6 class="mb-1 <?php if ($_smarty_tpl->tpl_vars['is_credit_mobile']->value) {?>text-success<?php } else { ?>text-danger<?php }?> font-weight-bold">
                                  <?php if ($_smarty_tpl->tpl_vars['is_credit_mobile']->value) {?>+<?php } else { ?>-<?php }
echo number_format($_smarty_tpl->tpl_vars['transaction']->value['amount'],0,',','.');?>
 VNĐ
                                </h6>
                                <p class="text-muted small mb-1">
                                  <?php if ($_smarty_tpl->tpl_vars['transaction']->value['description']) {?>
                                    <?php $_smarty_tpl->_assignInScope('qr_code', '');?>
                                    <?php if (strpos($_smarty_tpl->tpl_vars['transaction']->value['description'],'QR: ') !== false) {?>
                                      <?php $_smarty_tpl->_assignInScope('qr_parts', explode('QR: ',$_smarty_tpl->tpl_vars['transaction']->value['description']));?>
                                      <?php if ((isset($_smarty_tpl->tpl_vars['qr_parts']->value[1]))) {?>
                                        <?php $_smarty_tpl->_assignInScope('qr_code', trim($_smarty_tpl->tpl_vars['qr_parts']->value[1]));?>
                                      <?php }?>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['qr_code']->value) {?>
                                      <code><?php echo $_smarty_tpl->tpl_vars['qr_code']->value;?>
</code>
                                    <?php } else { ?>
                                      <?php echo $_smarty_tpl->tpl_vars['transaction']->value['description'];?>

                                    <?php }?>
                                  <?php } else { ?>
                                    -
                                  <?php }?>
                                </p>
                                <small class="text-muted">
                                  <?php echo date('d/m/Y H:i',strtotime($_smarty_tpl->tpl_vars['transaction']->value['time']));?>

                                </small>
                              </div>
                              <div class="col-4 text-right">
                                <div class="text-center">
                                  <small class="text-muted d-block">Số dư sau</small>
                                  <strong class="text-primary">
                                    <?php echo number_format($_smarty_tpl->tpl_vars['balance_after_mobile']->value,0,',','.');?>
 VNĐ
                                  </strong>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </div>
                  <?php } else { ?>
                    <?php $_smarty_tpl->_subTemplateRender('file:_no_transactions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                  <?php }?>
                  
                  <!-- Pagination -->
                  <?php if ($_smarty_tpl->tpl_vars['pagination']->value['total_pages'] > 1) {?>
                    <nav aria-label="Transaction pagination" class="mt20">
                      <ul class="pagination justify-content-center">
                        <?php if ($_smarty_tpl->tpl_vars['pagination']->value['has_prev']) {?>
                          <li class="page-item">
                            <a class="page-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/transactions?page=<?php echo $_smarty_tpl->tpl_vars['pagination']->value['prev_page'];?>
">
                              <i class="fa fa-chevron-left"></i> <?php echo __("Trước");?>

                            </a>
                          </li>
                        <?php }?>
                        
                        <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['pagination']->value['total_pages']+1 - (1) : 1-($_smarty_tpl->tpl_vars['pagination']->value['total_pages'])+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                          <li class="page-item <?php if ($_smarty_tpl->tpl_vars['i']->value == $_smarty_tpl->tpl_vars['pagination']->value['current_page']) {?>active<?php }?>">
                            <a class="page-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/transactions?page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                          </li>
                        <?php }
}
?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['pagination']->value['has_next']) {?>
                          <li class="page-item">
                            <a class="page-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/finance/transactions?page=<?php echo $_smarty_tpl->tpl_vars['pagination']->value['next_page'];?>
">
                              <?php echo __("Tiếp");?>
 <i class="fa fa-chevron-right"></i>
                            </a>
                          </li>
                        <?php }?>
                      </ul>
                    </nav>
                    
                    <!-- Pagination info -->
                    <div class="text-center text-muted small mt10">
                      <?php echo __("Hiển thị");?>
 <?php echo ($_smarty_tpl->tpl_vars['pagination']->value['current_page']-1)*$_smarty_tpl->tpl_vars['pagination']->value['per_page']+1;?>
 - <?php echo min($_smarty_tpl->tpl_vars['pagination']->value['current_page']*$_smarty_tpl->tpl_vars['pagination']->value['per_page'],$_smarty_tpl->tpl_vars['pagination']->value['total_items']);?>
 <?php echo __("trong tổng số");?>
 <?php echo $_smarty_tpl->tpl_vars['pagination']->value['total_items'];?>
 <?php echo __("giao dịch");?>

                    </div>
                  <?php }?>
                </div>
                <!-- wallet transactions -->
                
              </div>
            <?php }?>
          </div>
        </div>
      </div>
      <!-- content -->

    </div>
    <!-- content panel -->

  </div>
</div>
<!-- page content -->

<!-- Recharge Modal -->
<div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="rechargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rechargeModalLabel">
          <i class="fa fa-qrcode mr5"></i><?php echo __("Nạp tiền");?>

        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <!-- QR Code Display trong Modal -->
        <div id="modalQRSection" class="mt-4" style="display: none;">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-3">
                <img id="modalQRImage" src="" alt="QR Code" class="img-fluid" style="max-width: 300px;">
              </div>
              
              <!-- Thông tin thanh toán đẹp -->
              <div class="payment-info-card">
                <div class="row">
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-money-bill-wave text-success"></i>
                        <?php echo __("Số tiền");?>

                      </div>
                      <div class="info-value" id="modalAmountDisplay">100.000 VNĐ</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-qrcode text-primary"></i>
                        <?php echo __("Nội dung");?>

                      </div>
                      <div class="info-value" id="modalContentDisplay">-</div>
                    </div>
                  </div>
                </div>
                
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-university text-info"></i>
                        <?php echo __("Ngân hàng");?>

                      </div>
                      <div class="info-value">ACB - BUI QUOC VU</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-credit-card text-warning"></i>
                        <?php echo __("Số tài khoản");?>

                      </div>
                      <div class="info-value">PHATLOC46241987</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __("Đóng");?>
</button>
        <button type="button" class="btn btn-success" id="saveQRBtn">
          <i class="fa fa-download mr5"></i><?php echo __("Lưu QR");?>

        </button>
      </div>
    </div>
  </div>
</div>

<style>
.payment-info-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 15px;
  padding: 25px;
  color: white;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  margin-top: 20px;
}

.info-item {
  text-align: center;
  margin-bottom: 15px;
}

.info-label {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 8px;
  opacity: 0.9;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.info-value {
  font-size: 16px;
  font-weight: 700;
  background: rgba(255,255,255,0.2);
  padding: 8px 12px;
  border-radius: 8px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.3);
  word-break: break-all;
}

.info-value:empty::before {
  content: "-";
  opacity: 0.7;
}

.modal-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 15px 15px 0 0;
}

.modal-content {
  border-radius: 15px;
  border: none;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.modal-body {
  padding: 30px;
}

#modalQRImage {
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  border: 3px solid #fff;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 25px;
  padding: 12px 30px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
