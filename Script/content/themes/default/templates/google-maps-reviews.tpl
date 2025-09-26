{include file='_head.tpl'}
{include file='_header.tpl'}

<script>
console.log('🚀 Google Maps Reviews template loaded!');
console.log('🔍 Current view:', '{$view}');
console.log('🔍 Available tasks count:', {if $available_tasks}{$available_tasks|count}{else}0{/if});
</script>

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20">
  <div class="row">

    <!-- google-maps-reviews sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar shop-ai-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <ul class="main-side-nav">
            <li {if $view == 'dashboard'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/dashboard">
                <i class="fa fa-tachometer-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Bảng điều khiển
              </a>
            </li>
            <li {if $view == 'my-requests'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/my-requests">
                <i class="fa fa-list main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Yêu cầu của tôi
              </a>
            </li>
            <li {if $view == 'my-reviews'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/my-reviews">
                <i class="fa fa-star main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Đánh giá của tôi
              </a>
            </li>
            <li {if $view == 'create-request'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/create-request">
                <i class="fa fa-plus main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Tạo yêu cầu
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- google-maps-reviews sidebar -->

    <!-- content panel -->
    <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar shop-ai-mainbar">

      <!-- tabs (mobile only) -->
      <div class="content-tabs rounded-sm shadow-sm clearfix d-block d-md-none">
        <ul>
          <li {if $view == 'dashboard'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/dashboard">
              Bảng điều khiển
            </a>
          </li>
          <li {if $view == 'my-requests'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/my-requests">
              Yêu cầu
            </a>
          </li>
          <li {if $view == 'my-reviews'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/my-reviews">
              Đánh giá
            </a>
          </li>
          <li {if $view == 'create-request'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/create-request">
              Tạo mới
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
            {if $view == 'dashboard'}
              <div class="card-header bg-transparent">
                <strong>Bảng điều khiển</strong>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card bg-primary text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$user_requests|count}</h4>
                            <p class="mb-0">Yêu cầu của tôi</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-list fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-success text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$user_reviews|count}</h4>
                            <p class="mb-0">Đánh giá của tôi</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-star fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-warning text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$available_tasks|count}</h4>
                            <p class="mb-0">Nhiệm vụ có sẵn</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-tasks fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-info text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$user_earnings|number_format:0}</h4>
                            <p class="mb-0">Tổng thu nhập (VND)</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-money-bill-wave fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            {/if}

            {if $view == 'my-requests'}
              <div class="card-header bg-transparent">
                <strong>Yêu cầu của tôi</strong>
              </div>
              <div class="card-body">
                {if $user_requests}
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tên địa điểm</th>
                          <th>Mục tiêu đánh giá</th>
                          <th>Đã hoàn thành</th>
                          <th>Số tiền thưởng</th>
                          <th>Tình trạng</th>
                          <th>Đã tạo</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        {foreach $user_requests as $request}
                          <tr>
                            <td>
                              <strong>{$request.place_name}</strong><br>
                              <small class="text-muted">{$request.place_address}</small>
                            </td>
                            <td>{$request.target_reviews}</td>
                            <td>{$request.completed_reviews}</td>
                            <td>{$request.reward_amount|number_format:0} VND</td>
                            <td>
                              <span class="badge badge-{if $request.status == 'active'}success{elseif $request.status == 'completed'}primary{else}secondary{/if}">
                                {if $request.status == 'active'}Kích hoạt{elseif $request.status == 'completed'}Hoàn thành{elseif $request.status == 'cancelled'}Đã hủy{else}Hết hạn{/if}
                              </span>
                            </td>
                            <td>{$request.created_at|date_format:"%d/%m/%Y"}</td>
                            <td>
                              <button class="btn btn-sm btn-info" onclick="viewRequestDetails({$request.request_id})">
                                <i class="fa fa-eye"></i>
                              </button>
                            </td>
                          </tr>
                        {/foreach}
                      </tbody>
                    </table>
                  </div>
                {else}
                  <div class="text-center py-4">
                    <i class="fa fa-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không tìm thấy yêu cầu nào</h5>
                    <p class="text-muted">Tạo yêu cầu đánh giá Google Maps đầu tiên của bạn</p>
                  </div>
                {/if}
              </div>
            {/if}


            {if $view == 'my-reviews'}
              <div class="card-header bg-transparent">
                <strong>Đánh giá của tôi</strong>
              </div>
              <div class="card-body">
                {if $user_reviews}
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tên địa điểm</th>
                          <th>Đánh giá</th>
                          <th>Nội dung đánh giá</th>
                          <th>Tình trạng</th>
                          <th>Thưởng</th>
                          <th>Đã tạo</th>
                        </tr>
                      </thead>
                      <tbody>
                        {foreach $user_reviews as $review}
                          <tr>
                            <td>{$review.place_name}</td>
                            <td>
                              <div class="rating">
                                {for $i=1 to 5}
                                  <i class="fa fa-star {if $i <= $review.rating}text-warning{else}text-muted{/if}"></i>
                                {/for}
                              </div>
                            </td>
                            <td>{$review.review_text|truncate:50}</td>
                            <td>
                              <span class="badge badge-{if $review.verification_status == 'verified'}success{elseif $review.verification_status == 'rejected'}danger{else}warning{/if}">
                                {if $review.verification_status == 'verified'}Đã xác minh{elseif $review.verification_status == 'rejected'}Bị từ chối{elseif $review.verification_status == 'pending'}Đang chờ{else}Đang tranh chấp{/if}
                              </span>
                            </td>
                            <td>{$review.reward_paid|number_format:0} VND</td>
                            <td>{$review.created_at|date_format:"%d/%m/%Y"}</td>
                          </tr>
                        {/foreach}
                      </tbody>
                    </table>
                  </div>
                {else}
                  <div class="text-center py-4">
                    <i class="fa fa-star fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không tìm thấy đánh giá nào</h5>
                    <p class="text-muted">Bắt đầu nhận nhiệm vụ đánh giá để kiếm tiền</p>
                  </div>
                {/if}
              </div>
            {/if}

            {if $view == 'create-request'}
              <div class="card-header bg-transparent">
                <strong>Tạo chiến dịch đánh giá</strong>
              </div>
              <div class="card-body">
                <!-- Hiển thị số dư hiện tại -->
                <div class="alert alert-info text-center mb-4">
                  <strong>Số dư hiện tại: <span id="currentBalance">{number_format($user_wallet_balance, 0, ',', '.')}</span> VND</strong>
                </div>
                
                <form id="createRequestForm">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="place_name">Tên địa điểm</label>
                        <input type="text" class="form-control" id="place_name" name="place_name" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="place_url">URL địa điểm (Tùy chọn)</label>
                        <input type="url" class="form-control" id="place_url" name="place_url">
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="place_address">Địa chỉ</label>
                    <textarea class="form-control" id="place_address" name="place_address" rows="2" required></textarea>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="reward_amount">Chi phí cho 1 đánh giá 5 sao</label>
                        <input type="number" class="form-control" id="reward_amount" name="reward_amount" value="15000" readonly>
                        <small class="form-text text-muted">Chi phí cố định cho mỗi đánh giá 5 sao</small>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="target_reviews">Số lượng đánh giá</label>
                        <input type="number" class="form-control" id="target_reviews" name="target_reviews" min="1" max="100" value="1" required onchange="calculateTotal()">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="expires_at">Hết hạn lúc</label>
                        <input type="datetime-local" class="form-control" id="expires_at" name="expires_at" required>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Hiển thị hóa đơn -->
                  <div class="card bg-light mb-4">
                    <div class="card-body">
                      <h6 class="card-title">Hóa đơn chiến dịch</h6>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1">Chi phí cho 1 đánh giá: <span id="rewardAmount">15,000</span> VND</p>
                          <p class="mb-1">Số lượng đánh giá: <span id="quantity">1</span></p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1"><strong>Tổng chi phí: <span id="totalCost">15,000</span> VND</strong></p>
                          <p class="mb-1">Số dư sau khi trừ: <span id="remainingBalance">0</span> VND</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary" id="createButton" disabled>
                      <i class="fa fa-plus mr5"></i>
                      Tạo chiến dịch
                    </button>
                    <small class="form-text text-muted d-block mt-2" id="balanceWarning" style="display: none;">
                      Số dư không đủ để tạo chiến dịch này
                    </small>
                  </div>
                </form>
              </div>
            {/if}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.review-task-mini-card {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 8px;
    background: #fff;
    height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.2s ease;
    overflow: hidden;
    position: relative;
}

.review-task-mini-card:hover {
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.review-task-mini-card h6 {
    color: #333;
    font-weight: 600;
    font-size: 13px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card .text-muted {
    font-size: 11px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card .text-warning {
    font-size: 10px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card .text-success {
    font-size: 12px;
    font-weight: 700;
    margin: 0;
}

.review-task-mini-card .btn {
    font-size: 11px;
    padding: 4px 8px;
    height: 24px;
    line-height: 1;
}

.review-task-mini-card .d-flex {
    margin-top: auto;
}

.review-task-mini-card .task-avatar img {
    border: 1px solid #e9ecef;
}

.review-task-mini-card .badge-warning {
    background-color: #ffc107;
    color: #000;
    font-weight: 600;
    position: absolute;
    top: 8px;
    right: 8px;
}

.review-task-mini-card .verified-badge {
    vertical-align: middle;
    display: inline-flex;
    align-items: center;
}

/* Horizontal mini card styles */
.review-task-mini-card-horizontal {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 12px;
    background: #fff;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    position: relative;
    min-height: 80px;
    width: 100%;
    box-sizing: border-box;
}

.review-task-mini-card-horizontal:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.review-task-mini-card-horizontal .task-info {
    flex: 1;
    margin-right: 15px;
    min-width: 0;
    overflow: hidden;
}

.review-task-mini-card-horizontal .task-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.review-task-mini-card-horizontal .task-details {
    display: flex;
    align-items: center;
    gap: 4px;
}

.review-task-mini-card-horizontal .task-avatar {
    margin-right: 8px;
}

.review-task-mini-card-horizontal .task-avatar img {
    width: 32px;
    height: 32px;
    border: 1px solid #e9ecef;
}

.review-task-mini-card-horizontal .task-title {
    font-weight: 600;
    font-size: 14px;
    color: #333;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card-horizontal .task-address {
    font-size: 12px;
    color: #6c757d;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card-horizontal .task-expiry {
    font-size: 11px;
    color: #ffc107;
    margin: 0;
}

.review-task-mini-card-horizontal .task-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    flex-shrink: 0;
    min-width: 120px;
}

.review-task-mini-card-horizontal .task-reward {
    font-size: 14px;
    font-weight: 700;
    color: #28a745;
    margin: 0;
}

.review-task-mini-card-horizontal .btn {
    font-size: 12px;
    padding: 6px 12px;
    height: 32px;
    line-height: 1;
}

.review-task-mini-card-horizontal .badge-warning {
    background-color: #ffc107;
    color: #000;
    font-weight: 600;
    font-size: 9px;
    padding: 2px 6px;
    position: absolute;
    top: 8px;
    right: 8px;
}

.review-task-mini-card-horizontal .verified-badge {
    vertical-align: middle;
    display: inline-flex;
    align-items: center;
}

/* Horizontal scroll container */
.review-tasks-horizontal-scroll {
    display: flex;
    overflow-x: auto;
    gap: 15px;
    padding: 10px 0;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar {
    height: 6px;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.review-task-item {
    flex: 0 0 350px;
    min-width: 350px;
}
</style>

<script>
console.log('🚀 Google Maps Reviews template script starting...');

// Wait for jQuery to be available
function initGoogleMapsReviews() {
  // Set default expiry time (3 days from now) - HCM timezone
  var now = new Date();
  // Convert to HCM timezone (UTC+7)
  var hcmTime = new Date(now.getTime() + (7 * 60 * 60 * 1000));
  hcmTime.setDate(hcmTime.getDate() + 3);
  var expiryTime = hcmTime.toISOString().slice(0, 16);
  
  // Sử dụng vanilla JS thay vì jQuery
  var expiresAtField = document.getElementById('expires_at');
  if (expiresAtField) {
    expiresAtField.value = expiryTime;
  }
  
  // Calculate total immediately on page load
  calculateTotal();
  
  // Handle form submission
  var createForm = document.getElementById('createRequestForm');
  if (createForm) {
    createForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      var formData = new FormData(this);
      formData.append('action', 'create_request');
      
      fetch('{$system['system_url']}/google-maps-reviews.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        console.log('Response:', data);
        if (data.success) {
          alert('Tạo chiến dịch thành công!');
          location.reload();
        } else {
          alert('Lỗi: ' + data.error);
        }
      })
      .catch(error => {
        console.log('Fetch Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại.');
      });
    });
  }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initGoogleMapsReviews);
} else {
  initGoogleMapsReviews();
}

function calculateTotal() {
  var rewardAmountField = document.getElementById('reward_amount');
  var quantityField = document.getElementById('target_reviews');
  var rewardAmount = rewardAmountField ? parseInt(rewardAmountField.value) || 15000 : 15000;
  var quantity = quantityField ? parseInt(quantityField.value) || 1 : 1;
  
  // Parse current balance - extract number from text like "19.800.000 VND"
  var currentBalanceElement = document.getElementById('currentBalance');
  var balanceText = currentBalanceElement ? currentBalanceElement.textContent.trim() : '0';
  var currentBalance = 0;
  
  // Extract number part (everything before "VND")
  var numberMatch = balanceText.match(/([\d.,]+)/);
  if (numberMatch) {
    // Remove all dots and commas, then parse
    var cleanNumber = numberMatch[1].replace(/[.,]/g, '');
    currentBalance = parseInt(cleanNumber) || 0;
  }
  
  var totalCost = rewardAmount * quantity;
  var remainingBalance = currentBalance - totalCost;
  
  // Debug: log values to console
  console.log('Balance Text:', balanceText);
  console.log('Current Balance:', currentBalance);
  console.log('Total Cost:', totalCost);
  console.log('Remaining Balance:', remainingBalance);
  
  // Update display
  var rewardAmountDisplay = document.getElementById('rewardAmount');
  var quantityDisplay = document.getElementById('quantity');
  var totalCostDisplay = document.getElementById('totalCost');
  var remainingBalanceDisplay = document.getElementById('remainingBalance');
  
  if (rewardAmountDisplay) rewardAmountDisplay.textContent = rewardAmount.toLocaleString('vi-VN');
  if (quantityDisplay) quantityDisplay.textContent = quantity;
  if (totalCostDisplay) totalCostDisplay.textContent = totalCost.toLocaleString('vi-VN');
  if (remainingBalanceDisplay) remainingBalanceDisplay.textContent = remainingBalance.toLocaleString('vi-VN') + ' VND';
  
  // Check if balance is sufficient
  var createButton = document.getElementById('createButton');
  var balanceWarning = document.getElementById('balanceWarning');
  
  if (createButton) {
    if (remainingBalance >= 0) {
      createButton.disabled = false;
      if (balanceWarning) balanceWarning.style.display = 'none';
    } else {
      createButton.disabled = true;
      if (balanceWarning) balanceWarning.style.display = 'block';
    }
  }
}

// Global variable to store current task ID
var currentTaskId = null;

// Debug: Log khi script load
console.log('🚀 Google Maps Reviews script loaded');
console.log('🔍 Current task ID:', currentTaskId);
console.log('🔍 showTaskModal function:', typeof showTaskModal);
console.log('🔍 assignTask function:', typeof assignTask);

function showTaskModal(subRequestId, placeName, placeAddress, rewardAmount, expiryDate) {
  console.log('🚀 showTaskModal called with:', {
    subRequestId: subRequestId,
    placeName: placeName,
    placeAddress: placeAddress,
    rewardAmount: rewardAmount,
    expiryDate: expiryDate
  });
  
  currentTaskId = subRequestId;
  console.log('✅ Set currentTaskId to:', currentTaskId);
  alert('🚀 MODAL ĐƯỢC MỞ! currentTaskId: ' + currentTaskId);
  
  // Populate modal content
  var modalPlaceName = document.getElementById('modalPlaceName');
  var modalPlaceAddress = document.getElementById('modalPlaceAddress');
  var modalRewardAmount = document.getElementById('modalRewardAmount');
  var modalExpiry = document.getElementById('modalExpiry');
  
  if (modalPlaceName) modalPlaceName.textContent = placeName;
  if (modalPlaceAddress) modalPlaceAddress.textContent = placeAddress;
  if (modalRewardAmount) modalRewardAmount.textContent = parseInt(rewardAmount).toLocaleString('vi-VN') + ' VND';
  if (modalExpiry) modalExpiry.textContent = expiryDate;
  
  // Show modal using Bootstrap 5
  var modalElement = document.getElementById('taskModal');
  console.log('🔍 Modal element:', modalElement);
  
  if (modalElement) {
    var modal = new bootstrap.Modal(modalElement);
    modal.show();
    console.log('✅ Modal shown successfully');
    
    // Kiểm tra button sau khi modal hiện và bind trực tiếp
    setTimeout(function() {
      var confirmBtn = document.getElementById('confirmAssignBtn');
      console.log('🔍 Button after modal shown:', confirmBtn);
      if (confirmBtn) {
        console.log('✅ Button found after modal shown');
        // Bind trực tiếp
        bindModalButton();
      } else {
        console.error('❌ Button not found after modal shown');
      }
    }, 500);
  } else {
    console.error('❌ taskModal element not found!');
    alert('❌ Lỗi: Không tìm thấy modal taskModal');
  }
}

function assignTask(subRequestId) {
  // Ngăn chặn double-click
  if (window.assigningTask) {
    return;
  }
  window.assigningTask = true;
  
  // Debug: Log thông tin
  console.log('assignTask called with subRequestId:', subRequestId);
  console.log('Current task ID:', currentTaskId);
  
  // Hiển thị tất cả thông tin nhận được
  alert('🔍 DEBUG - Thông tin nhận được:\n\n' +
        '• subRequestId: ' + subRequestId + '\n' +
        '• currentTaskId: ' + currentTaskId + '\n' +
        '• User ID: ' + (window.user ? window.user.user_id : 'Không có') + '\n' +
        '• Username: ' + (window.user ? window.user.user_name : 'Không có') + '\n' +
        '• API URL: {$system['system_url']}/google-maps-reviews.php\n' +
        '• Timestamp: ' + new Date().toLocaleString());
  
  // Chỉ xử lý cho modal - gửi request và ghi vào database
  var apiUrl = '{$system['system_url']}/google-maps-reviews.php';
  console.log('API URL:', apiUrl);
  console.log('Data being sent:', {
    action: 'assign_task',
    sub_request_id: subRequestId
  });
  
  // Sử dụng fetch thay vì jQuery AJAX
  var formData = new FormData();
  formData.append('action', 'assign_task');
  formData.append('sub_request_id', subRequestId);
  
  // Thêm CSRF token nếu có
  var csrfToken = document.querySelector('meta[name="csrf-token"]');
  if (csrfToken) {
    formData.append('csrf_token', csrfToken.getAttribute('content'));
    console.log('Added CSRF token:', csrfToken.getAttribute('content'));
  }
  
  // Thêm user session token nếu có
  var sessionToken = document.querySelector('input[name="user_token"]');
  if (sessionToken) {
    formData.append('user_token', sessionToken.value);
    console.log('Added user token:', sessionToken.value);
  }
  
  // Cập nhật button trước khi gửi request
  var confirmBtn = document.getElementById('confirmAssignBtn');
  if (confirmBtn) {
    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
  }
  
  fetch(apiUrl, {
    method: 'POST',
    body: formData
  })
  .then(response => {
    return response.text().then(text => {
      try {
        return JSON.parse(text);
      } catch (e) {
        return { error: 'Invalid JSON response: ' + text };
      }
    });
  })
  .then(data => {
    if (data.success) {
      // Thành công - cập nhật button modal và ghi vào database
      if (confirmBtn) {
        confirmBtn.className = 'btn btn-success';
        confirmBtn.innerHTML = '<i class="fa fa-check"></i> Đã nhận';
      }
      
      // Sử dụng toast notification của hệ thống
      if (typeof noty_notification !== 'undefined') {
        noty_notification('', '✅ Nhận nhiệm vụ thành công!', '');
      } else if (typeof modal !== 'undefined') {
        modal('#modal-success', { title: 'Thành công', message: '✅ Nhận nhiệm vụ thành công!' });
      } else {
        alert('✅ Nhận nhiệm vụ thành công!');
      }
      
      // Chuyển hướng đến trang My Reviews
      setTimeout(function() {
        window.location.href = '{$system['system_url']}/google-maps-reviews/my-reviews';
      }, 1000);
    } else {
      // Lỗi - khôi phục button modal
      if (confirmBtn) {
        confirmBtn.disabled = false;
        confirmBtn.className = 'btn btn-primary';
        confirmBtn.innerHTML = '<i class="fa fa-hand-paper"></i> Xác nhận nhận nhiệm vụ';
      }
      
      if (typeof noty_notification !== 'undefined') {
        noty_notification('', '❌ ' + data.error, '');
      } else if (typeof modal !== 'undefined') {
        modal('#modal-error', { title: 'Lỗi', message: '❌ ' + data.error });
      } else {
        alert('❌ Lỗi: ' + data.error);
      }
    }
    
    // Reset flag sau khi xử lý xong
    window.assigningTask = false;
  })
  .catch(error => {
    // Lỗi network - khôi phục button modal
    if (confirmBtn) {
      confirmBtn.disabled = false;
      confirmBtn.className = 'btn btn-primary';
      confirmBtn.innerHTML = '<i class="fa fa-hand-paper"></i> Xác nhận nhận nhiệm vụ';
    }
    
    if (typeof modal !== 'undefined') {
      modal('#modal-error', { title: 'Lỗi', message: '❌ Đã xảy ra lỗi. Vui lòng thử lại.' });
    } else {
      alert('❌ Đã xảy ra lỗi. Vui lòng thử lại.');
    }
    
    // Reset flag khi có lỗi
    window.assigningTask = false;
  });
}

// Handle confirm button click - Sử dụng vanilla JS để tránh lỗi jQuery
function bindConfirmButton() {
  var confirmBtn = document.getElementById('confirmAssignBtn');
  
  if (confirmBtn) {
    confirmBtn.addEventListener('click', function() {
      if (currentTaskId) {
        var modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
        assignTask(currentTaskId);
      } else {
        alert('❌ Lỗi: Không tìm thấy ID nhiệm vụ');
      }
    });
  } else {
    setTimeout(bindConfirmButton, 100);
  }
}

// Bind when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bindConfirmButton);
} else {
  bindConfirmButton();
}

// Fallback: Try to bind after a delay
setTimeout(function() {
  var confirmBtn = document.getElementById('confirmAssignBtn');
  if (confirmBtn && !confirmBtn.hasAttribute('data-bound')) {
    console.log('🔄 Fallback binding confirmAssignBtn');
    confirmBtn.setAttribute('data-bound', 'true');
    confirmBtn.addEventListener('click', function() {
      console.log('🎯 Confirm button clicked (fallback), currentTaskId:', currentTaskId);
      alert('🎯 NÚT FALLBACK ĐÃ ĐƯỢC CLICK! currentTaskId: ' + currentTaskId);
      if (currentTaskId) {
        var modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
        assignTask(currentTaskId);
      } else {
        console.error('❌ No currentTaskId found!');
        alert('❌ Lỗi: Không tìm thấy ID nhiệm vụ');
      }
    });
    console.log('✅ Fallback event listener bound');
  }
}, 2000);

// Thêm một cách khác: Bind trực tiếp khi modal hiện
function bindModalButton() {
  var confirmBtn = document.getElementById('confirmAssignBtn');
  if (confirmBtn) {
    console.log('🔗 Direct binding confirmAssignBtn');
    confirmBtn.onclick = function() {
      console.log('🎯 Direct onclick triggered, currentTaskId:', currentTaskId);
      alert('🎯 NÚT DIRECT ĐÃ ĐƯỢC CLICK! currentTaskId: ' + currentTaskId);
      if (currentTaskId) {
        var modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
        assignTask(currentTaskId);
      } else {
        console.error('❌ No currentTaskId found!');
        alert('❌ Lỗi: Không tìm thấy ID nhiệm vụ');
      }
    };
    console.log('✅ Direct onclick bound');
  }
}

function viewRequestDetails(requestId) {
  // Implement view request details
  alert('Xem chi tiết yêu cầu ID: ' + requestId);
}
</script>

{include file='_footer.tpl'}