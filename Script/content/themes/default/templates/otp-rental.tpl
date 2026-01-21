{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- Loading Overlay -->
<div id="pageLoadingOverlay" class="loading-overlay" style="display:none;">
  <div class="loading-spinner">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Đang tải...</span>
    </div>
    <div class="loading-text mt-3">Chờ chút nha...</div>
  </div>
</div>

<!-- OTP Rental Styles -->
<style>
.otp-service-card {
  transition: all 0.3s ease;
  cursor: pointer;
  border: 2px solid transparent;
}
.otp-service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  border-color: #007bff;
}
.otp-service-card.selected {
  border-color: #28a745;
  background-color: #f8fff8;
}
.otp-service-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin: 0 auto 10px;
}
.otp-service-price {
  font-size: 18px;
  font-weight: bold;
  color: #28a745;
}
.otp-phone-display {
  font-size: 32px;
  font-weight: bold;
  letter-spacing: 2px;
  color: #333;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  padding: 20px;
  border-radius: 15px;
  text-align: center;
}
.otp-code-display {
  font-size: 48px;
  font-weight: bold;
  letter-spacing: 8px;
  color: #28a745;
  background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
  padding: 30px;
  border-radius: 15px;
  text-align: center;
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.02); }
}
.otp-timer {
  font-size: 24px;
  font-weight: bold;
  color: #dc3545;
}
.otp-timer.warning {
  animation: blink 1s infinite;
}
@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}
.network-badge {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  margin: 3px;
  cursor: pointer;
  border: 2px solid transparent;
  transition: all 0.2s ease;
}
.network-badge:hover {
  transform: scale(1.05);
}
.network-badge.selected {
  border-color: #007bff;
  background-color: #007bff;
  color: white;
}
.country-tab {
  padding: 10px 20px;
  cursor: pointer;
  border-bottom: 3px solid transparent;
  transition: all 0.2s ease;
}
.country-tab:hover, .country-tab.active {
  border-bottom-color: #007bff;
  color: #007bff;
}
.otp-status-badge {
  padding: 5px 15px;
  border-radius: 20px;
  font-weight: 500;
}
.otp-status-pending { background-color: #fff3cd; color: #856404; }
.otp-status-completed { background-color: #d4edda; color: #155724; }
.otp-status-expired { background-color: #f8d7da; color: #721c24; }
.otp-status-failed { background-color: #e2e3e5; color: #383d41; }

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255,255,255,0.9);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}
.copy-btn {
  cursor: pointer;
  padding: 5px 10px;
  border-radius: 5px;
  transition: all 0.2s ease;
}
.copy-btn:hover {
  background-color: #e9ecef;
}
.copy-btn.copied {
  background-color: #28a745;
  color: white;
}
.btn-outline-primary.btn-sm {
  padding: 3px 8px;
  font-size: 12px;
}
.btn-outline-primary.btn-sm:hover {
  transform: scale(1.1);
}
</style>

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      {include file='_sidebar.tpl'}
    </div>
    <!-- side panel -->

    <!-- otp-rental sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar shop-ai-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <!-- Số dư -->
          <div class="text-center mb-3 p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
            <div class="small">Số dư của bạn</div>
            <div class="h4 mb-0" id="userBalance">{number_format($user->_data['user_wallet_balance'], 0, ',', '.')} đ</div>
            <a href="{$system['system_url']}/shop-ai/recharge" class="btn btn-sm btn-light mt-2">
              <i class="fa fa-plus"></i> Nạp tiền
            </a>
          </div>
          
          <ul class="main-side-nav">
            <li {if $view == 'rent'}class="active"{/if}>
              <a href="{$system['system_url']}/otp-rental?view=rent">
                <i class="fa fa-mobile-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Thuê số mới
              </a>
            </li>
            <li {if $view == 'history'}class="active"{/if}>
              <a href="{$system['system_url']}/otp-rental?view=history">
                <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Lịch sử thuê
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- otp-rental sidebar -->

    <!-- content panel -->
    <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar shop-ai-mainbar">

      <!-- mobile pills navigation -->
      <div class="mobile-pills-nav d-block d-md-none mb-4">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
          <a href="{$system['system_url']}/otp-rental?view=rent" 
             class="btn btn-sm {if $view == 'rent'}btn-primary{else}btn-outline-primary{/if} rounded-pill px-3">
            <i class="fa fa-mobile-alt"></i> Thuê số
          </a>
          <a href="{$system['system_url']}/otp-rental?view=history" 
             class="btn btn-sm {if $view == 'history'}btn-primary{else}btn-outline-primary{/if} rounded-pill px-3">
            <i class="fa fa-history"></i> Lịch sử
          </a>
        </div>
      </div>

      <!-- content -->
      <div class="row">
        <div class="col-12">
          
          {* ==================== SERVICES VIEW ==================== *}
          {if $view == 'services' || $view == ''}
          <div class="card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
              <strong><i class="fa fa-mobile-alt text-primary"></i> Thuê số nhận OTP</strong>
              <span class="badge bg-info">{$config.price_multiplier|default:2}x giá gốc</span>
            </div>
            <div class="card-body">
              
              <!-- Country Tabs -->
              <div class="d-flex border-bottom mb-4">
                <div class="country-tab active" data-country="vn" onclick="switchCountry('vn')">
                  <img src="https://flagcdn.com/24x18/vn.png" alt="VN" class="me-1"> Việt Nam
                </div>
                <div class="country-tab" data-country="la" onclick="switchCountry('la')">
                  <img src="https://flagcdn.com/24x18/la.png" alt="LA" class="me-1"> Lào
                </div>
              </div>
              
              <!-- Services Grid - Vietnam -->
              <div id="services-vn" class="services-container">
                <div class="row">
                  {foreach $services_vn as $service}
                  <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <div class="card otp-service-card h-100" onclick="selectService({$service.service_id}, '{$service.name}', {$service.price * ($config.price_multiplier|default:2)})">
                      <div class="card-body text-center p-3">
                        <div class="otp-service-icon bg-light text-primary">
                          <i class="fas {$service.icon|default:'fa-mobile-alt'}"></i>
                        </div>
                        <h6 class="mb-2">{$service.name}</h6>
                        <div class="otp-service-price">
                          {number_format($service.price * ($config.price_multiplier|default:2), 0, ',', '.')}đ
                        </div>
                        <small class="text-muted">Gốc: {number_format($service.price, 0, ',', '.')}đ</small>
                      </div>
                    </div>
                  </div>
                  {foreachelse}
                  <div class="col-12 text-center py-5">
                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có dịch vụ nào</p>
                  </div>
                  {/foreach}
                </div>
              </div>
              
              <!-- Services Grid - Laos -->
              <div id="services-la" class="services-container" style="display:none;">
                <div class="row">
                  {foreach $services_la as $service}
                  <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <div class="card otp-service-card h-100" onclick="selectService({$service.service_id}, '{$service.name}', {$service.price * ($config.price_multiplier|default:2)})">
                      <div class="card-body text-center p-3">
                        <div class="otp-service-icon bg-light text-success">
                          <i class="fas {$service.icon|default:'fa-mobile-alt'}"></i>
                        </div>
                        <h6 class="mb-2">{$service.name}</h6>
                        <div class="otp-service-price">
                          {number_format($service.price * ($config.price_multiplier|default:2), 0, ',', '.')}đ
                        </div>
                        <small class="text-muted">Gốc: {number_format($service.price, 0, ',', '.')}đ</small>
                      </div>
                    </div>
                  </div>
                  {foreachelse}
                  <div class="col-12 text-center py-5">
                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có dịch vụ nào</p>
                  </div>
                  {/foreach}
                </div>
              </div>
              
            </div>
          </div>
          {/if}
          
          {* ==================== RENT VIEW ==================== *}
          {if $view == 'rent'}
          <div class="card">
            <div class="card-header bg-transparent">
              <strong><i class="fa fa-mobile-alt text-primary"></i> Thuê số mới</strong>
            </div>
            <div class="card-body">
              
              <form id="rentForm">
                <!-- Select Service -->
                <div class="form-group mb-4">
                  <label class="form-label fw-bold">Chọn dịch vụ <span class="text-danger">*</span></label>
                  <select class="form-select form-select-lg" id="serviceSelect" name="service_id" required>
                    <option value="">-- Chọn dịch vụ --</option>
                    {foreach $services as $service}
                    <option value="{$service.service_id}" 
                            data-price="{$service.price * ($config.price_multiplier|default:2)}"
                            data-viotp="{$service.viotp_id}"
                            {if $service_id == $service.service_id}selected{/if}>
                      {$service.name} - {number_format($service.price * ($config.price_multiplier|default:2), 0, ',', '.')}đ
                    </option>
                    {/foreach}
                  </select>
                </div>
                
                <!-- Hướng dẫn -->
                <div class="alert alert-warning mb-4">
                  <i class="fa fa-lightbulb text-warning"></i> <strong>Lưu ý:</strong>
                  <ul class="mb-0 mt-2 ps-3">
                    <li>Shopee ưu tiên gửi OTP theo thứ tự: <strong>Gọi điện (Gửi lại)</strong> → <strong>SMS</strong> → <strong>Zalo</strong></li>
                    <li>Chỉ có thể thuê lại số điện thoại đã nhận OTP thành công</li>
                    <li>Thời gian chờ OTP tối đa: <strong>5 phút</strong> - nên nhấn <strong>Gửi lại OTP</strong> trên Shopee và tiếp tục đợi nhé!</li>
                  </ul>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-lg w-100" id="rentBtn">
                  <i class="fa fa-mobile-alt"></i> Thuê số ngay
                </button>
              </form>
              
            </div>
          </div>
          
          <!-- ==================== DANH SÁCH CHỜ OTP (Hiển thị bên dưới form) ==================== -->
          <div id="activeRequestsContainer" class="mt-4">
            <!-- Các request đang chờ OTP sẽ hiển thị ở đây -->
          </div>
          
          {/if}
          
          {* ==================== ACTIVE VIEW (Waiting for OTP) ==================== *}
          {if $view == 'active'}
          <div class="card">
            <div class="card-header bg-transparent">
              <strong><i class="fa fa-clock text-warning"></i> Đang chờ mã OTP</strong>
            </div>
            <div class="card-body text-center py-5">
              
              <div id="otpWaiting">
                <!-- Phone Number -->
                <div class="mb-4">
                  <label class="text-muted small">SỐ ĐIỆN THOẠI</label>
                  <div class="otp-phone-display" id="phoneDisplay">
                    Đang tải...
                  </div>
                  <button class="btn btn-sm btn-outline-secondary mt-2 copy-btn" onclick="copyToClipboard('phoneDisplay')">
                    <i class="fa fa-copy"></i> Sao chép
                  </button>
                </div>
                
                <!-- Timer -->
                <div class="mb-4">
                  <label class="text-muted small">THỜI GIAN CÒN LẠI</label>
                  <div class="otp-timer" id="otpTimer">
                    <i class="fa fa-hourglass-half"></i> <span id="timerDisplay">05:00</span>
                  </div>
                </div>
                
                <!-- OTP Code (Hidden initially) -->
                <div class="mb-4" id="otpCodeContainer" style="display:none;">
                  <label class="text-muted small">MÃ OTP</label>
                  <div class="otp-code-display" id="otpCodeDisplay">
                    ------
                  </div>
                  <button class="btn btn-success mt-3 copy-btn" onclick="copyToClipboard('otpCodeDisplay')">
                    <i class="fa fa-copy"></i> Sao chép mã OTP
                  </button>
                </div>
                
                <!-- SMS Content (Hidden initially) -->
                <div class="mb-4" id="smsContainer" style="display:none;">
                  <label class="text-muted small">NỘI DUNG SMS</label>
                  <div class="alert alert-secondary" id="smsContent">
                  </div>
                </div>
                
                <!-- Loading Spinner -->
                <div id="otpLoadingSpinner" class="my-4">
                  <div class="spinner-border text-primary" role="status"></div>
                  <p class="mt-2 text-muted">Đang chờ nhận mã OTP...</p>
                </div>
                
                <!-- Actions -->
                <div class="mt-4">
                  <button class="btn btn-outline-danger" onclick="cancelOTPRequest()" id="cancelBtn">
                    <i class="fa fa-times"></i> Hủy & Hoàn tiền
                  </button>
                </div>
              </div>
              
              <!-- Expired/Failed Message -->
              <div id="otpExpired" style="display:none;">
                <i class="fa fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                <h4>Yêu cầu đã hết hạn!</h4>
                <p class="text-muted">Tiền đã được hoàn vào tài khoản của bạn.</p>
                <a href="{$system['system_url']}/otp-rental?view=rent" class="btn btn-primary">
                  <i class="fa fa-redo"></i> Thuê số mới
                </a>
              </div>
              
            </div>
          </div>
          {/if}
          
          {* ==================== HISTORY VIEW ==================== *}
          {if $view == 'history'}
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <strong><i class="fa fa-history text-info"></i> Lịch sử thuê OTP</strong>
                <div class="d-flex gap-2 flex-wrap">
                  <a href="{$system['system_url']}/otp-rental?view=rent" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> <span class="d-none d-sm-inline">Thuê số mới</span><span class="d-sm-none">Thuê</span>
                  </a>
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteExpiredRequests()">
                    <i class="fa fa-trash"></i> <span class="d-none d-sm-inline">Xóa hết hạn</span><span class="d-sm-none">Xóa</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              
              <!-- Desktop Table View -->
              <div class="table-responsive d-none d-md-block">
                <table class="table table-hover mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Dịch vụ</th>
                      <th>Số điện thoại</th>
                      <th>Mã OTP</th>
                      <th>Giá</th>
                      <th>Trạng thái</th>
                      <th>Thời gian</th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach $history as $item}
                    <tr>
                      <td>
                        <strong>{$item.service_name}</strong>
                        {if $item.network_name}
                        <br><small class="text-muted">{$item.network_name}</small>
                        {/if}
                      </td>
                      <td>
                        <code class="bg-light p-1">{$item.phone_number}</code>
                        {if $item.phone_number}
                        <button class="btn btn-sm copy-btn" onclick="copyText('{$item.phone_number}')" title="Sao chép">
                          <i class="fa fa-copy"></i>
                        </button>
                        {if $item.status == 'completed' && $item.can_rerent}
                        <button class="btn btn-sm btn-outline-primary" onclick="reRentNumber({$item.service_id}, '{$item.phone_number}')" title="Thuê lại số này (còn hiệu lực 20 phút)">
                          <i class="fa fa-redo"></i>
                        </button>
                        {/if}
                        {/if}
                      </td>
                      <td>
                        {if $item.code}
                        <span class="badge bg-success fs-6">{$item.code}</span>
                        <button class="btn btn-sm copy-btn" onclick="copyText('{$item.code}')">
                          <i class="fa fa-copy"></i>
                        </button>
                        {else}
                        <span class="text-muted">-</span>
                        {/if}
                      </td>
                      <td>{number_format($item.price, 0, ',', '.')}đ</td>
                      <td>
                        <span class="otp-status-badge otp-status-{$item.status}">
                          {if $item.status == 'pending'}Đang chờ
                          {elseif $item.status == 'completed'}Hoàn thành
                          {elseif $item.status == 'expired'}Hết hạn
                          {else}Thất bại{/if}
                        </span>
                      </td>
                      <td>
                        <small>{$item.created_at|date_format:"%d/%m/%Y %H:%M"}</small>
                      </td>
                    </tr>
                    {foreachelse}
                    <tr>
                      <td colspan="6" class="text-center py-5">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Chưa có lịch sử thuê OTP</p>
                        <a href="{$system['system_url']}/otp-rental?view=rent" class="btn btn-primary mt-3">
                          Thuê số ngay
                        </a>
                      </td>
                    </tr>
                    {/foreach}
                  </tbody>
                </table>
              </div>
              
              <!-- Mobile Card View -->
              <div class="d-md-none p-3" style="background: #f8f9fe;">
                {foreach $history as $item}
                <div class="card mb-3 border-0 shadow-sm" style="background: #fff; border-radius: 12px;">
                  <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div>
                        <strong class="d-block" style="color: #5e72e4;">{$item.service_name}</strong>
                        <small class="text-muted">{$item.created_at|date_format:"%d/%m/%Y %H:%M"}</small>
                      </div>
                      <span class="otp-status-badge otp-status-{$item.status}">
                        {if $item.status == 'pending'}Đang chờ
                        {elseif $item.status == 'completed'}Hoàn thành
                        {elseif $item.status == 'expired'}Hết hạn
                        {else}Thất bại{/if}
                      </span>
                    </div>
                    
                    <div class="row g-2 mb-2">
                      <div class="col-6">
                        <small class="text-muted d-block">Số điện thoại</small>
                        <div class="d-flex align-items-center gap-1">
                          <code style="background: #f0f3ff; color: #5e72e4; padding: 4px 8px; border-radius: 6px; font-size: 13px;">{$item.phone_number}</code>
                          {if $item.phone_number}
                          <button class="btn btn-sm p-1" style="color: #5e72e4;" onclick="copyText('{$item.phone_number}')">
                            <i class="fa fa-copy"></i>
                          </button>
                          {/if}
                        </div>
                      </div>
                      <div class="col-6">
                        <small class="text-muted d-block">Mã OTP</small>
                        {if $item.code}
                        <div class="d-flex align-items-center gap-1">
                          <span class="badge" style="background: #2dce89; font-size: 14px; padding: 6px 10px;">{$item.code}</span>
                          <button class="btn btn-sm p-1" style="color: #2dce89;" onclick="copyText('{$item.code}')">
                            <i class="fa fa-copy"></i>
                          </button>
                        </div>
                        {else}
                        <span class="text-muted">-</span>
                        {/if}
                      </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center pt-2" style="border-top: 1px solid #f0f3ff;">
                      <span style="color: #5e72e4; font-weight: 600;">{number_format($item.price, 0, ',', '.')}đ</span>
                      {if $item.status == 'completed' && $item.can_rerent}
                      <button class="btn btn-sm" style="background: #5e72e4; color: #fff; border-radius: 8px;" onclick="reRentNumber({$item.service_id}, '{$item.phone_number}')">
                        <i class="fa fa-redo"></i> Thuê lại
                      </button>
                      {/if}
                    </div>
                  </div>
                </div>
                {foreachelse}
                <div class="text-center py-5">
                  <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                  <p class="text-muted mb-0">Chưa có lịch sử thuê OTP</p>
                  <a href="{$system['system_url']}/otp-rental?view=rent" class="btn mt-3" style="background: #5e72e4; color: #fff;">
                    Thuê số ngay
                  </a>
                </div>
                {/foreach}
              </div>
              
            </div>
          </div>
          {/if}
          
        </div>
      </div>
      <!-- content -->

    </div>
    <!-- content panel -->

  </div>
</div>
<!-- page content -->

<!-- OTP Rental JavaScript -->
<script>
// Global variables
let selectedServiceId = {$service_id|default:0};
let selectedNetworkId = null;
let currentRequestId = {$request_id|default:0};
let checkInterval = null;
let countdownInterval = null;

// Switch country tab
function switchCountry(country) {
  document.querySelectorAll('.country-tab').forEach(function(tab) { tab.classList.remove('active'); });
  document.querySelector('.country-tab[data-country="' + country + '"]').classList.add('active');
  
  document.querySelectorAll('.services-container').forEach(function(c) { c.style.display = 'none'; });
  document.getElementById('services-' + country).style.display = 'block';
}

// Select service
function selectService(serviceId, serviceName, price) {
  // Highlight card
  document.querySelectorAll('.otp-service-card').forEach(card => card.classList.remove('selected'));
  event.currentTarget.classList.add('selected');
  
  // Update form
  selectedServiceId = serviceId;
  
  // Redirect to rent view
  window.location.href = '{$system['system_url']}/otp-rental?view=rent&service_id=' + serviceId;
}

// Select network
function selectNetwork(element, networkId) {
  document.querySelectorAll('.network-badge').forEach(badge => badge.classList.remove('selected'));
  element.classList.add('selected');
  selectedNetworkId = networkId;
  document.getElementById('networkSelect').value = networkId;
}

// Update price display
function updatePrice() {
  const select = document.getElementById('serviceSelect');
  if (select) {
    const option = select.options[select.selectedIndex];
    const price = option ? option.dataset.price : 0;
    document.getElementById('priceDisplay').textContent = formatCurrency(price) + 'đ';
  }
}

// Format currency
function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN').format(amount);
}

// Simple toast notification
function showToast(message, type, duration) {
  type = type || 'info';
  duration = duration || 3000;
  var toast = document.createElement('div');
  toast.className = 'position-fixed top-0 start-50 translate-middle-x mt-3 px-4 py-3 rounded shadow text-white';
  toast.style.zIndex = '9999';
  toast.style.backgroundColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8';
  toast.innerHTML = message;
  document.body.appendChild(toast);
  setTimeout(function() { toast.remove(); }, duration);
}

// Xóa các request hết hạn
async function deleteExpiredRequests() {
  try {
    var response = await fetch('{$system['system_url']}/otp-rental.php?action=delete_expired', {
      method: 'POST'
    });
    var result = await response.json();
    if (result.success) {
      showToast('Đã xóa', 'success', 2000);
      // Reload trang sau 1 giây
      setTimeout(function() {
        window.location.reload();
      }, 1000);
    }
  } catch (error) {
    showToast('Lỗi: ' + error.message, 'error', 2000);
  }
}

// Thuê lại số điện thoại
async function reRentNumber(serviceId, phoneNumber) {
  if (!confirm('Thuê lại số ' + phoneNumber + '?\n\nLưu ý: Số điện thoại có thể không còn khả dụng.')) {
    return;
  }
  
  showToast('Đang xử lý...', 'info');
  
  try {
    var formData = new FormData();
    formData.append('service_id', serviceId);
    formData.append('prefix', phoneNumber); // Dùng số cũ làm prefix để thuê lại
    
    var response = await fetch('{$system['system_url']}/otp-rental.php?action=rent', {
      method: 'POST',
      body: formData
    });
    
    var result = await response.json();
    
    if (result.success) {
      showToast('Thuê số thành công! SĐT: ' + result.data.phone_number, 'success');
      // Chuyển đến trang thuê số với request mới
      window.location.href = '{$system['system_url']}/otp-rental?view=rent';
    } else {
      showToast('Lỗi: ' + result.message, 'error');
    }
  } catch (error) {
    showToast('Có lỗi xảy ra: ' + error.message, 'error');
  }
}

// Active requests storage
let activeRequests = {}; // { requestId: { intervalId, data } }

// Load pending requests khi trang load
async function loadPendingRequests() {
  try {
    const response = await fetch('{$system['system_url']}/otp-rental.php?action=get_pending_requests');
    const result = await response.json();
    
    if (result.success && result.data && result.data.length > 0) {
      result.data.forEach(function(request) {
        // Tránh thêm trùng
        if (document.getElementById('request-' + request.request_id)) return;
        
        addExistingRequest(request);
      });
    }
  } catch (error) {
    console.error('Error loading pending requests:', error);
  }
}

// Thêm request đã có vào danh sách (khi reload trang)
function addExistingRequest(request) {
  const container = document.getElementById('activeRequestsContainer');
  if (!container) return;
  
  const requestId = request.request_id;
  const phoneNumber = request.phone_number || request.re_phone_number || '';
  const serviceName = request.service_display_name || request.service_name || 'Dịch vụ';
  const status = request.status;
  const timeRemaining = parseInt(request.time_remaining_seconds) || 0;
  const code = request.code || '';
  const smsContent = request.sms_content || '';
  
  // Tạo card cho request
  const card = document.createElement('div');
  card.id = 'request-' + requestId;
  
  if (status === 'completed') {
    // Request đã hoàn thành - hiển thị OTP
    card.className = 'card mb-3 border-success';
    card.innerHTML = 
      '<div class="card-header bg-success bg-opacity-25 d-flex justify-content-between align-items-center">' +
        '<span><i class="fa fa-check-circle text-success"></i> <strong>' + serviceName + '</strong></span>' +
        '<span class="badge bg-success">Hoàn thành</span>' +
      '</div>' +
      '<div class="card-body">' +
        '<div class="row align-items-center">' +
          '<div class="col-md-6 mb-3 mb-md-0">' +
            '<label class="text-muted small d-block">SỐ ĐIỆN THOẠI</label>' +
            '<div class="d-flex align-items-center">' +
              '<code class="fs-5 me-2">' + phoneNumber + '</code>' +
              '<button class="btn btn-sm btn-outline-secondary" onclick="copyText(\'' + phoneNumber + '\')">' +
                '<i class="fa fa-copy"></i>' +
              '</button>' +
            '</div>' +
          '</div>' +
          '<div class="col-md-6 mb-3 mb-md-0">' +
            '<label class="text-muted small d-block">MÃ OTP</label>' +
            '<div class="d-flex align-items-center">' +
              '<span class="badge bg-success fs-4 me-2">' + code + '</span>' +
              '<button class="btn btn-sm btn-success" onclick="copyText(\'' + code + '\')">' +
                '<i class="fa fa-copy"></i>' +
              '</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
        (smsContent ? '<div class="mt-3"><label class="text-muted small">Nội dung SMS:</label><div class="alert alert-secondary mb-0 small">' + smsContent + '</div></div>' : '') +
      '</div>';
  } else if (status === 'expired') {
    // Request đã hết hạn
    card.className = 'card mb-3 border-secondary';
    card.innerHTML = 
      '<div class="card-header bg-secondary bg-opacity-25 d-flex justify-content-between align-items-center">' +
        '<span><i class="fa fa-clock text-secondary"></i> <strong>' + serviceName + '</strong></span>' +
        '<span class="badge bg-secondary">Hết hạn</span>' +
      '</div>' +
      '<div class="card-body">' +
        '<div class="row align-items-center">' +
          '<div class="col-md-6 mb-3 mb-md-0">' +
            '<label class="text-muted small d-block">SỐ ĐIỆN THOẠI</label>' +
            '<code class="fs-5">' + phoneNumber + '</code>' +
          '</div>' +
          '<div class="col-md-6 mb-3 mb-md-0">' +
            '<label class="text-muted small d-block">TRẠNG THÁI</label>' +
            '<span class="text-danger">Hết hạn - Đã hoàn tiền</span>' +
          '</div>' +
        '</div>' +
      '</div>';
  } else {
    // Request đang pending - đang chờ OTP
    const mins = Math.floor(timeRemaining / 60);
    const secs = timeRemaining % 60;
    const timerDisplay = mins.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0');
    
    card.className = 'card mb-3 border-warning';
    card.innerHTML = 
      '<div class="card-header bg-warning bg-opacity-25 d-flex justify-content-between align-items-center">' +
        '<span><i class="fa fa-clock text-warning"></i> <strong>' + serviceName + '</strong></span>' +
        '<span class="badge bg-warning text-dark" id="timer-' + requestId + '">' + timerDisplay + '</span>' +
      '</div>' +
      '<div class="card-body">' +
        '<div class="row align-items-center">' +
          '<div class="col-md-6 mb-3 mb-md-0">' +
            '<label class="text-muted small d-block">SỐ ĐIỆN THOẠI</label>' +
            '<div class="d-flex align-items-center">' +
              '<code class="fs-5 me-2" id="phone-' + requestId + '">' + phoneNumber + '</code>' +
              '<button class="btn btn-sm btn-outline-secondary" onclick="copyText(\'' + phoneNumber + '\')">' +
                '<i class="fa fa-copy"></i>' +
              '</button>' +
            '</div>' +
          '</div>' +
          '<div class="col-md-6 mb-3 mb-md-0">' +
            '<label class="text-muted small d-block">MÃ OTP</label>' +
            '<div id="otp-container-' + requestId + '">' +
              '<div class="d-flex align-items-center" id="otp-waiting-' + requestId + '">' +
                '<span class="spinner-border spinner-border-sm text-primary me-2"></span>' +
                '<span class="text-muted">Đang chờ...</span>' +
              '</div>' +
              '<div class="d-none" id="otp-received-' + requestId + '">' +
                '<span class="badge bg-success fs-4 me-2" id="otp-code-' + requestId + '">------</span>' +
                '<button class="btn btn-sm btn-success" onclick="copyOtpCode(' + requestId + ')">' +
                  '<i class="fa fa-copy"></i>' +
                '</button>' +
              '</div>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="mt-3 d-none" id="sms-container-' + requestId + '">' +
          '<label class="text-muted small">Nội dung SMS:</label>' +
          '<div class="alert alert-secondary mb-0 small" id="sms-content-' + requestId + '"></div>' +
        '</div>' +
      '</div>';
    
    // Bắt đầu kiểm tra OTP nếu còn thời gian
    if (timeRemaining > 0) {
      startCheckingRequest(requestId, timeRemaining);
    }
  }
  
  // Thêm vào container
  container.appendChild(card);
  
  // Xóa card sau 30 phút tính từ thời điểm tạo
  var createdTime = new Date(request.created_at).getTime();
  var removeAfter = Math.max(0, (createdTime + 30 * 60 * 1000) - Date.now());
  setTimeout(function() {
    var cardEl = document.getElementById('request-' + requestId);
    if (cardEl) cardEl.remove();
  }, removeAfter);
}

// Handle rent form submit
document.addEventListener('DOMContentLoaded', function() {
  const rentForm = document.getElementById('rentForm');
  if (rentForm) {
    // Load pending requests khi trang được tải
    loadPendingRequests();
    
    rentForm.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const serviceId = document.getElementById('serviceSelect').value;
      if (!serviceId) {
        showToast('Vui lòng chọn dịch vụ', 'error');
        return;
      }
      
      const btn = document.getElementById('rentBtn');
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang xử lý...';
      
      try {
        const formData = new FormData(rentForm);
        const response = await fetch('{$system['system_url']}/otp-rental.php?action=rent', {
          method: 'POST',
          body: formData
        });
        
        const result = await response.json();
        console.log('Rent result:', result);
        
        if (result.success) {
          // Thêm vào danh sách chờ OTP (không hiện thông báo)
          addActiveRequest(result.data);
          
          // Cập nhật số dư
          if (result.data.new_balance !== undefined) {
            document.getElementById('userBalance').textContent = formatCurrency(result.data.new_balance) + ' đ';
          }
          
        } else {
          showToast('Lỗi: ' + result.message, 'error');
        }
      } catch (error) {
        console.error('Rent error:', error);
        showToast('Có lỗi xảy ra: ' + error.message, 'error');
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-mobile-alt"></i> Thuê số ngay';
      }
    });
    
    // Update price when service changes
    document.getElementById('serviceSelect').addEventListener('change', updatePrice);
    updatePrice();
  }
  
  // If on active view, start checking for OTP
  if (currentRequestId > 0) {
    startOTPCheck();
  }
});

// Thêm request vào danh sách chờ
function addActiveRequest(data) {
  const container = document.getElementById('activeRequestsContainer');
  if (!container) return;
  
  const requestId = data.request_id;
  const phoneNumber = data.phone_number || data.re_phone_number || '';
  const serviceName = document.getElementById('serviceSelect').options[document.getElementById('serviceSelect').selectedIndex].text.split(' - ')[0];
  
  // Tạo card cho request
  const card = document.createElement('div');
  card.id = 'request-' + requestId;
  card.className = 'card mb-3 border-warning';
  card.innerHTML = 
    '<div class="card-header bg-warning bg-opacity-25 d-flex justify-content-between align-items-center">' +
      '<span><i class="fa fa-clock text-warning"></i> <strong>' + serviceName + '</strong></span>' +
      '<span class="badge bg-warning text-dark" id="timer-' + requestId + '">05:00</span>' +
    '</div>' +
    '<div class="card-body">' +
      '<div class="row align-items-center">' +
        '<div class="col-md-6 mb-3 mb-md-0">' +
          '<label class="text-muted small d-block">SỐ ĐIỆN THOẠI</label>' +
          '<div class="d-flex align-items-center">' +
            '<code class="fs-5 me-2" id="phone-' + requestId + '">' + phoneNumber + '</code>' +
            '<button class="btn btn-sm btn-outline-secondary" onclick="copyText(\'' + phoneNumber + '\')">' +
              '<i class="fa fa-copy"></i>' +
            '</button>' +
          '</div>' +
        '</div>' +
        '<div class="col-md-6 mb-3 mb-md-0">' +
          '<label class="text-muted small d-block">MÃ OTP</label>' +
          '<div id="otp-container-' + requestId + '">' +
            '<div class="d-flex align-items-center" id="otp-waiting-' + requestId + '">' +
              '<span class="spinner-border spinner-border-sm text-primary me-2"></span>' +
              '<span class="text-muted">Đang chờ...</span>' +
            '</div>' +
            '<div class="d-none" id="otp-received-' + requestId + '">' +
              '<span class="badge bg-success fs-4 me-2" id="otp-code-' + requestId + '">------</span>' +
              '<button class="btn btn-sm btn-success" onclick="copyOtpCode(' + requestId + ')">' +
                '<i class="fa fa-copy"></i>' +
              '</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>' +
      '<div class="mt-3 d-none" id="sms-container-' + requestId + '">' +
        '<label class="text-muted small">Nội dung SMS:</label>' +
        '<div class="alert alert-secondary mb-0 small" id="sms-content-' + requestId + '"></div>' +
      '</div>' +
    '</div>';
  
  // Thêm vào đầu container
  container.insertBefore(card, container.firstChild);
  
  // Bắt đầu kiểm tra OTP (5 phút), sau đó giữ hiển thị thêm 25 phút nữa
  startCheckingRequest(requestId, 300); // 5 phút = 300 giây
  
  // Xóa card sau 30 phút
  setTimeout(function() {
    var cardEl = document.getElementById('request-' + requestId);
    if (cardEl) cardEl.remove();
  }, 30 * 60 * 1000); // 30 phút
}

// Copy OTP code
function copyOtpCode(requestId) {
  const el = document.getElementById('otp-code-' + requestId);
  if (el) copyText(el.textContent);
}

// Bắt đầu kiểm tra OTP cho một request
function startCheckingRequest(requestId, timeRemaining) {
  // Đếm ngược timer
  var remaining = timeRemaining;
  var timerInterval = setInterval(function() {
    remaining--;
    var mins = Math.floor(remaining / 60);
    var secs = remaining % 60;
    var timerEl = document.getElementById('timer-' + requestId);
    if (timerEl) {
      timerEl.textContent = mins.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0');
      if (remaining <= 60) {
        timerEl.classList.remove('bg-warning', 'text-dark');
        timerEl.classList.add('bg-danger');
      }
    }
    if (remaining <= 0) {
      clearInterval(timerInterval);
      markRequestExpired(requestId);
    }
  }, 1000);
  
  // Kiểm tra OTP mỗi 3 giây
  var checkInterval = setInterval(async function() {
    try {
      var response = await fetch('{$system['system_url']}/otp-rental.php?action=check_otp&request_id=' + requestId);
      var result = await response.json();
      
      if (result.success && result.status === 'completed') {
        // Đã nhận OTP!
        clearInterval(checkInterval);
        clearInterval(timerInterval);
        markRequestCompleted(requestId, result.data);
      } else if (!result.success && result.expired) {
        // Đã hết hạn
        clearInterval(checkInterval);
        clearInterval(timerInterval);
        markRequestExpired(requestId);
      }
    } catch (error) {
      console.error('Error checking OTP:', error);
    }
  }, 3000);
  
  // Lưu interval IDs
  activeRequests[requestId] = { checkInterval: checkInterval, timerInterval: timerInterval };
}

// Đánh dấu request đã nhận OTP
function markRequestCompleted(requestId, data) {
  const card = document.getElementById('request-' + requestId);
  if (!card) return;
  
  // Thay đổi style
  card.classList.remove('border-warning');
  card.classList.add('border-success');
  card.querySelector('.card-header').classList.remove('bg-warning', 'bg-opacity-25');
  card.querySelector('.card-header').classList.add('bg-success', 'bg-opacity-25');
  card.querySelector('.card-header i').classList.remove('fa-clock', 'text-warning');
  card.querySelector('.card-header i').classList.add('fa-check-circle', 'text-success');
  
  // Hiển thị mã OTP
  document.getElementById('otp-waiting-' + requestId).classList.add('d-none');
  document.getElementById('otp-received-' + requestId).classList.remove('d-none');
  document.getElementById('otp-code-' + requestId).textContent = data.code || '------';
  
  // Hiển thị SMS
  if (data.sms_content) {
    document.getElementById('sms-container-' + requestId).classList.remove('d-none');
    document.getElementById('sms-content-' + requestId).textContent = data.sms_content;
  }
  
  // Cập nhật timer
  document.getElementById('timer-' + requestId).textContent = 'Hoàn thành';
  document.getElementById('timer-' + requestId).classList.remove('bg-warning', 'bg-danger', 'text-dark');
  document.getElementById('timer-' + requestId).classList.add('bg-success');
  
  // Thông báo
  showToast('Đã nhận mã OTP: ' + data.code, 'success');
  playNotificationSound();
}

// Đánh dấu request hết hạn
function markRequestExpired(requestId) {
  const card = document.getElementById('request-' + requestId);
  if (!card) return;
  
  card.classList.remove('border-warning');
  card.classList.add('border-secondary');
  card.querySelector('.card-header').classList.remove('bg-warning', 'bg-opacity-25');
  card.querySelector('.card-header').classList.add('bg-secondary', 'bg-opacity-25');
  
  document.getElementById('otp-waiting-' + requestId).innerHTML = '<span class="text-danger">Hết hạn - Đã hoàn tiền</span>';
  document.getElementById('timer-' + requestId).textContent = 'Hết hạn';
  document.getElementById('timer-' + requestId).classList.remove('bg-warning', 'text-dark');
  document.getElementById('timer-' + requestId).classList.add('bg-secondary');
}

// Start OTP check interval
function startOTPCheck() {
  // Initial check
  checkOTPStatus();
  
  // Check every 3 seconds
  checkInterval = setInterval(checkOTPStatus, 3000);
}

// Check OTP status
async function checkOTPStatus() {
  try {
    var response = await fetch('{$system['system_url']}/otp-rental.php?action=check_otp&request_id=' + currentRequestId);
    var result = await response.json();
    
    if (result.success) {
      if (result.status === 'completed') {
        // OTP received!
        clearInterval(checkInterval);
        clearInterval(countdownInterval);
        
        document.getElementById('otpLoadingSpinner').style.display = 'none';
        document.getElementById('otpCodeContainer').style.display = 'block';
        document.getElementById('otpCodeDisplay').textContent = result.data.code || '------';
        document.getElementById('cancelBtn').style.display = 'none';
        
        if (result.data.sms_content) {
          document.getElementById('smsContainer').style.display = 'block';
          document.getElementById('smsContent').textContent = result.data.sms_content;
        }
        
        // Play sound notification
        playNotificationSound();
        
      } else if (result.status === 'pending') {
        // Still waiting
        document.getElementById('phoneDisplay').textContent = result.data.phone_number || 'Đang tải...';
        
        // Update timer
        if (result.data.time_remaining) {
          updateTimer(result.data.time_remaining);
        }
      }
    } else {
      if (result.expired) {
        // Request expired
        clearInterval(checkInterval);
        clearInterval(countdownInterval);
        
        document.getElementById('otpWaiting').style.display = 'none';
        document.getElementById('otpExpired').style.display = 'block';
      }
    }
  } catch (error) {
    console.error('Error checking OTP:', error);
  }
}

// Update countdown timer
function updateTimer(seconds) {
  var timerDisplay = document.getElementById('timerDisplay');
  var timerContainer = document.getElementById('otpTimer');
  
  if (seconds <= 0) {
    timerDisplay.textContent = '00:00';
    timerContainer.classList.add('warning');
    return;
  }
  
  var minutes = Math.floor(seconds / 60);
  var secs = seconds % 60;
  timerDisplay.textContent = minutes.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0');
  
  if (seconds <= 60) {
    timerContainer.classList.add('warning');
  }
  
  // Start local countdown
  if (!countdownInterval) {
    var remaining = seconds;
    countdownInterval = setInterval(function() {
      remaining--;
      if (remaining <= 0) {
        clearInterval(countdownInterval);
        return;
      }
      var m = Math.floor(remaining / 60);
      var s = remaining % 60;
      timerDisplay.textContent = m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
    }, 1000);
  }
}

// Cancel OTP request
async function cancelOTPRequest() {
  if (!confirm('Xác nhận hủy?\n\nBạn sẽ được hoàn lại tiền nếu chưa nhận được mã OTP')) {
    return;
  }
  
  try {
    const response = await fetch('{$system['system_url']}/otp-rental.php?action=cancel', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ request_id: currentRequestId })
    });
    
    const data = await response.json();
    
    if (data.success) {
      showSuccess('Đã hủy', data.message, function() {
        window.location.href = '{$system['system_url']}/otp-rental';
      });
    } else {
      showAlert('Lỗi', data.message, 'error');
    }
  } catch (error) {
    showAlert('Lỗi', 'Có lỗi xảy ra', 'error');
  }
}

// Copy to clipboard
function copyToClipboard(elementId) {
  const element = document.getElementById(elementId);
  const text = element.textContent.trim();
  copyText(text);
}

function copyText(text) {
  navigator.clipboard.writeText(text).then(() => {
    // Show a simple toast
    const toast = document.createElement('div');
    toast.className = 'position-fixed top-50 start-50 translate-middle bg-success text-white px-4 py-2 rounded';
    toast.style.zIndex = '9999';
    toast.textContent = 'Đã sao chép: ' + text;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 1500);
  }).catch(() => {
    // Fallback for older browsers
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    alert('Đã sao chép: ' + text);
  });
}

// Play notification sound
function playNotificationSound() {
  try {
    const audio = new Audio('{$system['system_url']}/includes/assets/sounds/notification.mp3');
    audio.play();
  } catch (e) {
    console.log('Cannot play sound');
  }
}

// Clean up on page leave
window.addEventListener('beforeunload', function() {
  if (checkInterval) clearInterval(checkInterval);
  if (countdownInterval) clearInterval(countdownInterval);
});
</script>

{include file='_footer.tpl'}
