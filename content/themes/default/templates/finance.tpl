{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      {include file='_sidebar.tpl'}
    </div>
    <!-- side panel -->

    <!-- finance sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar finance-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <ul class="main-side-nav">
            <li {if $view == "recharge"}class="active" {/if}>
              <a href="{$system['system_url']}/finance/recharge">
                <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                {__("Nạp tiền")}
              </a>
            </li>
            <li {if $view == "transactions"}class="active" {/if}>
              <a href="{$system['system_url']}/finance/transactions">
                <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                {__("Lịch sử giao dịch")}
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
          <li {if $view == "recharge"}class="active" {/if}>
            <a href="{$system['system_url']}/finance/recharge">
              {__("Nạp tiền")}
            </a>
          </li>
          <li {if $view == "transactions"}class="active" {/if}>
            <a href="{$system['system_url']}/finance/transactions">
              {__("Giao dịch")}
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
            {if $view == "recharge"}
              <div class="card-header bg-transparent">
                <strong>{__("Nạp tiền")}</strong>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8 mx-auto">
                    <!-- Số dư hiện tại -->
                    <div class="alert alert-info text-center">
                      <strong>{__("Số dư hiện tại")}: {number_format($current_balance, 0, ',', '.')} VNĐ</strong>
                    </div>
                    
                    <!-- Admin Contact Info -->
                    {if $admin_info}
                    <div class="admin-contact-info mb-4 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
                      <div class="text-center mb-2">
                        <small class="opacity-75">
                          <i class="fa fa-headset mr-1"></i>Liên hệ hỗ trợ khi cần
                        </small>
                      </div>
                      <div class="d-flex align-items-center justify-content-center flex-wrap">
                        <a href="{$system['system_url']}/{$admin_info.user_name}" class="text-white d-flex align-items-center" style="text-decoration: none;">
                          <img src="{$admin_info.user_picture}" alt="Admin" class="rounded-circle" style="width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.3); margin-right: 5px;">
                          <div class="d-flex align-items-center">
                            <span class="font-weight-bold">{$admin_info.name}</span>
                            {if $admin_info.user_verified}
                              <span class="ml-2" data-bs-toggle="tooltip" title='{__("Verified User")}'>
                                {include file='__svg_icons.tpl' icon="verified_badge" width="15px" height="15px"}
                              </span>
                            {/if}
                          </div>
                        </a>
                        {if $admin_info.zalo}
                        <div class="ml-3">
                          <small>
                            <i class="fab fa-zalo mr-1"></i>Zalo: <strong>{$admin_info.zalo}</strong>
                          </small>
                        </div>
                        {/if}
                      </div>
                    </div>
                    {/if}
                    
                    <!-- Form nạp tiền -->
                    <form method="post" action="{$system['system_url']}/finance/recharge" id="rechargeForm" onsubmit="return false;">
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
                                <i class="fa fa-qrcode mr5"></i>{__("Nạp tiền ngay")}
                              </button>
                            </div>
                            <small class="form-text text-muted mt-2">
                              Số tiền tối thiểu: 10,000 VNĐ - Tối đa: 50,000,000 VNĐ
                            </small>
                            
                            <!-- Quick amount buttons -->
                            <div class="mt-4">
                              <label class="form-label small">{__("Chọn nhanh")}:</label>
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
                    {if $qr_data}
                    <div class="mt-4" id="qrSection">
                      <div class="card">
                        <div class="card-body text-center">
                          <div class="mb-3">
                            <img src="{$qr_data}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
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
                                <strong>{__("Số tiền")}:</strong><br>
                                <span class="h5 text-success">{$amount|number_format} VNĐ</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="alert alert-info">
                                <strong>{__("Nội dung")}:</strong><br>
                                <code>{$qr_content}</code>
                              </div>
                            </div>
                          </div>
                          
                          <div class="alert alert-warning">
                            <strong>{__("Thông tin chuyển khoản")}:</strong><br>
                            <strong>{__("Ngân hàng")}:</strong> ACB<br>
                            <strong>{__("STK")}:</strong> 46241987<br>
                            <strong>{__("Nội dung")}:</strong> {$qr_content}<br>
                            <strong>{__("Thời gian")}:</strong> {$smarty.now|date_format:"%d/%m/%Y %H:%M:%S"}
                          </div>
                          
                          <div class="mt-3">
                            <button type="button" class="btn btn-success mr-2" onclick="saveQRCode()">
                              <i class="fa fa-download mr5"></i>{__("Lưu QR Code")}
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeQR()">
                              {__("Đóng")}
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    {/if}
                    
                    <!-- Thông tin bổ sung -->
                    <div class="mt-4">
                      <div class="alert alert-danger">
                        <h6><i class="fa fa-info-circle mr5"></i>{__("Lưu ý")}</h6>
                        <ul class="mb-0">
                          <li>{__("Giao dịch sẽ được xử lý trong vòng 5-10 phút")}</li>
                          <li>{__("Liên hệ hỗ trợ nếu có vấn đề")}</li>
                          <li>{__("Số tiền tối thiểu: 10,000 VNĐ")}</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- JavaScript for QR functions -->
              <script>
              // Load monitoring script
              {if $qr_data && $qr_content && $amount}
              $(document).ready(function() {
                // Load monitoring script
                $.getScript('{$system.system_url}/js/shop-ai-recharge-monitor.js', function() {
                  console.log('Starting recharge monitoring...');
                  startRechargeMonitoring('{$qr_content}', {$amount}, {$user->_data.user_id});
                }).fail(function() {
                  console.error('Failed to load monitoring script');
                });
              });
              {/if}
              
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
                var user_id = {if isset($user->_data.user_id)}{$user->_data.user_id}{else}1{/if};
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
                  url: '{$system.system_url}/finance.php?action=save_qr_mapping',
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
              </script>
              
            {elseif $view == "transactions"}
              <div class="card-header with-icon">
                {include file='__svg_icons.tpl' icon="wallet" class="main-icon mr10" width="24px" height="24px"}
                {__("Lịch Sử Giao Dịch")}
              </div>
              <div class="card-body">
                
                <!-- Admin Contact Info -->
                {if $admin_info}
                <div class="admin-contact-info mb-4 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
                  <div class="text-center mb-2">
                    <small class="opacity-75">
                      <i class="fa fa-headset mr-1"></i>Liên hệ hỗ trợ khi cần
                    </small>
                  </div>
                  <div class="d-flex align-items-center justify-content-center flex-wrap">
                    <a href="{$system['system_url']}/{$admin_info.user_name}" class="text-white d-flex align-items-center" style="text-decoration: none;">
                      <img src="{$admin_info.user_picture}" alt="Admin" class="rounded-circle mr-2" style="width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.3);">
                      <div class="d-flex align-items-center">
                        <span class="font-weight-bold">{$admin_info.name}</span>
                        {if $admin_info.user_verified}
                          <span class="ml-2" data-bs-toggle="tooltip" title='{__("Verified User")}'>
                            {include file='__svg_icons.tpl' icon="verified_badge" width="15px" height="15px"}
                          </span>
                        {/if}
                      </div>
                    </a>
                    {if $admin_info.zalo}
                    <div class="ml-3">
                      <small>
                        <i class="fab fa-zalo mr-1"></i>Zalo: <strong>{$admin_info.zalo}</strong>
                      </small>
                    </div>
                    {/if}
                  </div>
                </div>
                {/if}
                
                <!-- Wallet transactions -->
                <div class="col-12 mt20">
                  <div class="section-title mt10 mb20">
                    {__("Lịch Sử Giao Dịch")}
                  </div>
                  {if $shop_ai_transactions}
                    <!-- Desktop: Table -->
                    <div class="table-responsive d-none d-md-block">
                      <table class="table table-striped table-bordered table-hover js_dataTable">
                        <thead>
                          <tr>
                            <th width="15%">{__("ID")}</th>
                            <th width="15%">{__("Số Tiền")}</th>
                            <th width="15%">{__("Loại")}</th>
                            <th width="15%">{__("Số Dư Sau")}</th>
                            <th width="25%">{__("Mã QR")}</th>
                            <th width="15%">{__("Thời Gian")}</th>
                          </tr>
                        </thead>
                        <tbody>
                          {assign var="running_balance" value=$current_balance}
                          {foreach $shop_ai_transactions as $transaction}
                            {* Xác định loại giao dịch: cộng tiền hay trừ tiền *}
                            {assign var="is_credit" value=($transaction.type == 'recharge' || $transaction.type == 'otp_refund' || $transaction.type == 'receive')}
                            {* Calculate balance after this transaction *}
                            {if $is_credit}
                              {assign var="balance_after" value=$running_balance}
                              {assign var="running_balance" value=$running_balance-$transaction.amount}
                            {else}
                              {assign var="balance_after" value=$running_balance}
                              {assign var="running_balance" value=$running_balance+$transaction.amount}
                            {/if}
                            <tr>
                              <td>#{$transaction.transaction_id}</td>
                              <td>
                                <strong class="{if $is_credit}text-success{else}text-danger{/if}">
                                  {if $is_credit}+{else}-{/if}{number_format($transaction.amount, 0, ',', '.')} VNĐ
                                </strong>
                              </td>
                              <td>
                                <span class="badge {if $is_credit}bg-success{else}bg-danger{/if}">
                                  {if $is_credit}{__("Nạp Tiền")}{else}{__("Trừ tiền")}{/if}
                                </span>
                              </td>
                              <td>
                                <strong class="text-primary">
                                  {number_format($balance_after, 0, ',', '.')} VNĐ
                                </strong>
                              </td>
                              <td>
                                <small class="text-muted">
                                  {if $transaction.description}
                                    {assign var="qr_code" value=""}
                                    {if strpos($transaction.description, 'QR: ') !== false}
                                      {assign var="qr_parts" value=explode('QR: ', $transaction.description)}
                                      {if isset($qr_parts[1])}
                                        {assign var="qr_code" value=trim($qr_parts[1])}
                                      {/if}
                                    {/if}
                                    {if $qr_code}
                                      <code>{$qr_code}</code>
                                    {else}
                                      {$transaction.description}
                                    {/if}
                                  {else}
                                    -
                                  {/if}
                                </small>
                              </td>
                              <td>
                                <small class="text-muted">
                                  {date('d/m/Y H:i', strtotime($transaction.time))}
                                </small>
                              </td>
                            </tr>
                          {/foreach}
                        </tbody>
                      </table>
                    </div>
                    
                    <!-- Mobile: Cards -->
                    <div class="d-block d-md-none">
                      {assign var="running_balance_mobile" value=$current_balance}
                      {foreach $shop_ai_transactions as $transaction}
                        {* Xác định loại giao dịch: cộng tiền hay trừ tiền *}
                        {assign var="is_credit_mobile" value=($transaction.type == 'recharge' || $transaction.type == 'otp_refund' || $transaction.type == 'receive')}
                        {* Calculate balance after this transaction *}
                        {if $is_credit_mobile}
                          {assign var="balance_after_mobile" value=$running_balance_mobile}
                          {assign var="running_balance_mobile" value=$running_balance_mobile-$transaction.amount}
                        {else}
                          {assign var="balance_after_mobile" value=$running_balance_mobile}
                          {assign var="running_balance_mobile" value=$running_balance_mobile+$transaction.amount}
                        {/if}
                        <div class="card mb-3">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-8">
                                <div class="d-flex align-items-center mb-2">
                                  <span class="badge {if $is_credit_mobile}bg-success{else}bg-danger{/if} mr10">
                                    {if $is_credit_mobile}Nạp Tiền{else}Trừ tiền{/if}
                                  </span>
                                  <small class="text-muted">#{$transaction.transaction_id}</small>
                                </div>
                                <h6 class="mb-1 {if $is_credit_mobile}text-success{else}text-danger{/if} font-weight-bold">
                                  {if $is_credit_mobile}+{else}-{/if}{number_format($transaction.amount, 0, ',', '.')} VNĐ
                                </h6>
                                <p class="text-muted small mb-1">
                                  {if $transaction.description}
                                    {assign var="qr_code" value=""}
                                    {if strpos($transaction.description, 'QR: ') !== false}
                                      {assign var="qr_parts" value=explode('QR: ', $transaction.description)}
                                      {if isset($qr_parts[1])}
                                        {assign var="qr_code" value=trim($qr_parts[1])}
                                      {/if}
                                    {/if}
                                    {if $qr_code}
                                      <code>{$qr_code}</code>
                                    {else}
                                      {$transaction.description}
                                    {/if}
                                  {else}
                                    -
                                  {/if}
                                </p>
                                <small class="text-muted">
                                  {date('d/m/Y H:i', strtotime($transaction.time))}
                                </small>
                              </div>
                              <div class="col-4 text-right">
                                <div class="text-center">
                                  <small class="text-muted d-block">Số dư sau</small>
                                  <strong class="text-primary">
                                    {number_format($balance_after_mobile, 0, ',', '.')} VNĐ
                                  </strong>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      {/foreach}
                    </div>
                  {else}
                    {include file='_no_transactions.tpl'}
                  {/if}
                  
                  <!-- Pagination -->
                  {if $pagination.total_pages > 1}
                    <nav aria-label="Transaction pagination" class="mt20">
                      <ul class="pagination justify-content-center">
                        {if $pagination.has_prev}
                          <li class="page-item">
                            <a class="page-link" href="{$system['system_url']}/finance/transactions?page={$pagination.prev_page}">
                              <i class="fa fa-chevron-left"></i> {__("Trước")}
                            </a>
                          </li>
                        {/if}
                        {assign var="cur" value=$pagination.current_page}
                        {assign var="total" value=$pagination.total_pages}
                        {assign var="start" value=$cur-2}
                        {if $start < 1}{assign var="start" value=1}{/if}
                        {assign var="end" value=$cur+2}
                        {if $end > $total}{assign var="end" value=$total}{/if}
                        {if $start > 1}
                          <li class="page-item {if 1 == $cur}active{/if}"><a class="page-link" href="{$system['system_url']}/finance/transactions?page=1">1</a></li>
                          {if $start > 2}<li class="page-item disabled"><span class="page-link">...</span></li>{/if}
                        {/if}
                        {for $i=$start to $end}
                          <li class="page-item {if $i == $cur}active{/if}"><a class="page-link" href="{$system['system_url']}/finance/transactions?page={$i}">{$i}</a></li>
                        {/for}
                        {if $end < $total}
                          {if $end < $total-1}<li class="page-item disabled"><span class="page-link">...</span></li>{/if}
                          <li class="page-item {if $total == $cur}active{/if}"><a class="page-link" href="{$system['system_url']}/finance/transactions?page={$total}">{$total}</a></li>
                        {/if}
                        {if $pagination.has_next}
                          <li class="page-item">
                            <a class="page-link" href="{$system['system_url']}/finance/transactions?page={$pagination.next_page}">
                              {__("Tiếp")} <i class="fa fa-chevron-right"></i>
                            </a>
                          </li>
                        {/if}
                      </ul>
                    </nav>
                    
                    <!-- Pagination info -->
                    <div class="text-center text-muted small mt10">
                      {__("Hiển thị")} {($pagination.current_page-1)*$pagination.per_page+1} - {min($pagination.current_page*$pagination.per_page, $pagination.total_items)} {__("trong tổng số")} {$pagination.total_items} {__("giao dịch")}
                    </div>
                  {/if}
                </div>
                <!-- wallet transactions -->
                
              </div>
            {/if}
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
          <i class="fa fa-qrcode mr5"></i>{__("Nạp tiền")}
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
                        {__("Số tiền")}
                      </div>
                      <div class="info-value" id="modalAmountDisplay">100.000 VNĐ</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-qrcode text-primary"></i>
                        {__("Nội dung")}
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
                        {__("Ngân hàng")}
                      </div>
                      <div class="info-value">ACB - BUI QUOC VU</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-item">
                      <div class="info-label">
                        <i class="fa fa-credit-card text-warning"></i>
                        {__("Số tài khoản")}
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{__("Đóng")}</button>
        <button type="button" class="btn btn-success" id="saveQRBtn">
          <i class="fa fa-download mr5"></i>{__("Lưu QR")}
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

{include file='_footer.tpl'}
