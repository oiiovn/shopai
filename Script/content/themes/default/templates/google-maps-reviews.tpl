{include file='_head.tpl'}
{include file='_header.tpl'}

<script>
console.log('🚀 Google Maps Reviews template loaded!');
console.log('🔍 Current view:', '{$view}');
console.log('🔍 Available tasks count:', {if $available_tasks}{$available_tasks|count}{else}0{/if});
</script>

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      {include file='_sidebar.tpl'}
    </div>
    <!-- side panel -->

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
            <li>
              <a href="{$system['system_url']}/shop-ai/recharge">
                <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Nạp tiền
              </a>
            </li>
            <li {if $view == 'reward-history'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/reward-history">
                <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Lịch sử thưởng
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
          <li>
            <a href="{$system['system_url']}/shop-ai/recharge">
              Nạp tiền
            </a>
          </li>
          <li {if $view == 'reward-history'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/reward-history">
              Lịch sử thưởng
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
                          <th>Mục tiêu</th>
                          <th>Tổng chi</th>
                          <th>Tình trạng</th>
                          <th>Đã tạo</th>
                          <th>Chi tiết</th>
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
                            <td><strong class="text-danger">{$request.total_budget|number_format:0} VND</strong></td>
                            <td>
                              <div class="d-flex flex-column" style="min-width: 140px;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                  <small class="text-muted">
                                    <strong class="text-success">{$request.completed_subs}</strong>/{$request.total_valid_subs} hoàn thành
                                  </small>
                                  <small class="text-muted">{$request.progress_percent}%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: {$request.progress_percent}%" aria-valuenow="{$request.progress_percent}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="badge badge-{if $request.completed_subs >= $request.total_valid_subs && $request.total_valid_subs > 0}primary{elseif $request.status == 'active'}success{elseif $request.status == 'completed'}primary{else}secondary{/if} mt-1" style="font-size: 0.7rem;">
                                  {if $request.completed_subs >= $request.total_valid_subs && $request.total_valid_subs > 0}Đã hoàn thành{elseif $request.status == 'active'}Đang chạy{elseif $request.status == 'completed'}Hoàn thành{elseif $request.status == 'cancelled'}Đã hủy{else}Hết hạn{/if}
                                </span>
                              </div>
                            </td>
                            <td>{$request.created_at|date_format:"%d/%m/%Y"}</td>
                            <td>
                              <a href="{$system['system_url']}/google-maps-reviews/request-details/{$request.request_id}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fa fa-external-link-alt mr-1"></i>Xem chi tiết
                              </a>
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
                <div class="d-flex justify-content-between align-items-center">
                  <strong>Nhiệm vụ đánh giá của tôi</strong>
                  <span class="badge badge-info">{$assigned_tasks|count} nhiệm vụ</span>
                </div>
              </div>
              
              <!-- Tabs lọc trạng thái -->
              <div class="card-body border-bottom">
                <ul class="nav nav-pills nav-fill" id="statusTabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                      <i class="fa fa-list mr-1"></i>Tất cả
                      <span class="badge badge-light ml-1">{$assigned_tasks|count}</span>
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="assigned-tab" data-bs-toggle="pill" data-bs-target="#assigned" type="button" role="tab">
                      <i class="fa fa-hand-paper mr-1"></i>Đã nhận
                      <span class="badge badge-warning ml-1">{assign var="assigned_count" value=0}{foreach $assigned_tasks as $task}{if $task.status == 'assigned'}{assign var="assigned_count" value=$assigned_count+1}{/if}{/foreach}{$assigned_count}</span>
                    </button>
                  </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="verified-tab" data-bs-toggle="pill" data-bs-target="#verified" type="button" role="tab">
                  <i class="fa fa-shield-alt mr-1"></i>Đang xác minh
                  <span class="badge badge-primary ml-1">{assign var="verified_count" value=0}{foreach $assigned_tasks as $task}{if $task.status == 'verified'}{assign var="verified_count" value=$verified_count+1}{/if}{/foreach}{$verified_count}</span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                  <i class="fa fa-check-circle mr-1"></i>Hoàn thành
                  <span class="badge badge-success ml-1">{assign var="completed_count" value=0}{foreach $assigned_tasks as $task}{if $task.status == 'completed'}{assign var="completed_count" value=$completed_count+1}{/if}{/foreach}{$completed_count}</span>
                </button>
              </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="expired-tab" data-bs-toggle="pill" data-bs-target="#expired" type="button" role="tab">
                      <i class="fa fa-times-circle mr-1"></i>Hết hạn
                      <span class="badge badge-danger ml-1">{assign var="expired_count" value=0}{foreach $assigned_tasks as $task}{if $task.status == 'expired' || $task.status == 'timeout'}{assign var="expired_count" value=$expired_count+1}{/if}{/foreach}{$expired_count}</span>
                    </button>
                  </li>
                </ul>
              </div>
              
              <!-- Tab content -->
              <div class="tab-content" id="statusTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                  <div class="card-body">
                    {if $assigned_tasks}
                      <div class="row">
                        {foreach $assigned_tasks as $task}
                          <div class="col-md-6 col-lg-4 mb-3 task-card" data-status="{$task.status}">
                            <div class="card h-100 shadow-sm">
                          <div class="card-body p-2">
                            <!-- Header với tên và trạng thái -->
                            <div class="d-flex justify-content-between align-items-start">
                              <h6 class="card-title mb-0" style="max-width: 180px; font-size: 0.75rem; line-height: 1.0;" title="{$task.place_name}">
                                {$task.place_name}
                              </h6>
                              <span class="badge badge-{if $task.status == 'assigned'}warning{elseif $task.status == 'completed'}success{elseif $task.status == 'verified'}primary{else}danger{/if} badge-sm font-weight-bold">
                                {if $task.status == 'assigned'}ĐÃ NHẬN{elseif $task.status == 'completed'}HOÀN THÀNH{elseif $task.status == 'verified'}ĐANG XÁC MINH{else}HẾT HẠN{/if}
                              </span>
                            </div>
                            
                            <!-- Địa chỉ và thông tin -->
                            <div>
                              <p class="text-secondary mb-0" style="font-size: 0.6rem; line-height: 1.2;">
                                <i class="fa fa-map-marker-alt mr-1"></i>
                                {$task.place_address}
                              </p>
                              <div class="d-flex justify-content-between align-items-center mt-0">
                                <div class="text-success font-weight-bold" style="font-size: 0.65rem;">
                                  <i class="fa fa-money-bill-wave mr-1"></i>
                                  {$task.reward_amount|number_format:0} VND
                                </div>
                                <div class="text-secondary" style="font-size: 0.55rem;">
                                  Hạn: {$task.expires_at|date_format:"%d/%m"}
                                </div>
                              </div>
                              <!-- Ngày nhận nhiệm vụ ngay dưới ngày hết hạn -->
                              {if $task.status == 'assigned'}
                                <div class="text-right mt-0">
                                  <small class="text-secondary" style="font-size: 0.5rem;">
                                    Nhận: {$task.assigned_at|date_format:"%d/%m"}
                                  </small>
                                </div>
                              {/if}
                            </div>
                            
                            <!-- Generated Review Content (GPT) with Countdown -->
                            {if !empty($task.generated_review_content) && $task.status == 'assigned'}
                              <div class="gpt-review-box gpt-box-loading" 
                                   id="gpt-box-{$task.sub_request_id}" 
                                   data-assigned-time="{$task.assigned_at}"
                                   data-sub-request-id="{$task.sub_request_id}">
                                
                                <!-- Header with Countdown -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                  <div class="d-flex align-items-center">
                                    <span class="gpt-badge">
                                      <i class="fa fa-magic mr-1"></i>Đánh giá mẫu GPT
                                    </span>
                                    <span class="gpt-countdown ml-2" id="countdown-{$task.sub_request_id}">
                                      <i class="far fa-clock"></i> <span class="countdown-text">30:00</span>
                                    </span>
                                  </div>
                                </div>
                                
                                <!-- Review Content with Line Clamp -->
                                <div class="gpt-content-wrapper" id="wrapper-{$task.sub_request_id}">
                                  <div class="gpt-content line-clamp" id="content-{$task.sub_request_id}">
                                    {$task.generated_review_content}
                                  </div>
                                  <div class="gpt-fade"></div>
                                </div>
                                
                                <!-- Footer Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                  <div class="d-flex" style="gap: 0.3rem;">
                                    <button class="btn-gpt-action btn-copy" 
                                            onclick="copyReviewContent('{$task.sub_request_id}', this)">
                                      <i class="fa fa-copy mr-1"></i>Copy
                                    </button>
                                    <button class="btn-gpt-action btn-expand" 
                                            id="expand-btn-{$task.sub_request_id}"
                                            onclick="toggleReviewExpand('{$task.sub_request_id}')">
                                      <i class="fa fa-chevron-down mr-1"></i>Xem thêm
                                    </button>
                                  </div>
                                  <small class="gpt-char-count" id="char-count-{$task.sub_request_id}">
                                    0 ký tự
                                  </small>
                                </div>
                              </div>
                            {/if}
                            
                            <!-- Action buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                              {if $task.status == 'assigned'}
                                <div class="d-flex" style="gap: 0.1rem;">
                                  {if $task.place_url}
                                    <a href="{$task.place_url}" target="_blank" class="btn btn-primary btn-sm">
                                      <i class="fa fa-star mr-1"></i>Đánh giá 5 sao
                                    </a>
                                  {else}
                                    <a href="https://maps.google.com/?q={$task.place_address|urlencode}" target="_blank" class="btn btn-primary btn-sm">
                                      <i class="fa fa-star mr-1"></i>Đánh giá 5 sao
                                    </a>
                                  {/if}
                                  <a href="{$system['system_url']}/google-maps-reviews/submit-proof/{$task.sub_request_id}" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-camera mr-1"></i>Gửi bằng chứng
                                  </a>
                                </div>
                              {elseif $task.status == 'completed'}
                                <div class="d-flex align-items-center" style="gap: 0.1rem;">
                                  <span class="text-success small font-weight-bold">
                                    <i class="fa fa-check-circle mr-1"></i>Đã hoàn thành
                                  </span>
                                  <a href="{$system['system_url']}/google-maps-reviews/view-proof/{$task.sub_request_id}" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-gift mr-1"></i>Xem phần thưởng
                                  </a>
                                </div>
                                <small class="text-secondary" style="font-size: 0.6rem;">
                                  {$task.completed_at|date_format:"%d/%m"}
                                </small>
                              {elseif $task.status == 'verified'}
                                <div class="d-flex align-items-center" style="gap: 0.1rem;">
                                  <span class="text-primary small font-weight-bold">
                                    <i class="fa fa-shield-alt mr-1"></i>Đang xác minh
                                  </span>
                                  <a href="{$system['system_url']}/google-maps-reviews/view-proof/{$task.sub_request_id}" class="btn btn-outline-info btn-sm">
                                    <i class="fa fa-eye mr-1"></i>Xem bằng chứng
                                  </a>
                                </div>
                                <small class="text-secondary" style="font-size: 0.6rem;">
                                  {$task.verified_at|date_format:"%d/%m"}
                                </small>
                              {elseif $task.status == 'expired'}
                                <div class="d-flex align-items-center" style="gap: 0.1rem;">
                                  <span class="text-danger small font-weight-bold">
                                    <i class="fa fa-clock mr-1"></i>Hết hạn
                                  </span>
                                  <a href="{$system['system_url']}/google-maps-reviews/view-penalty/{$task.sub_request_id}" class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-exclamation-triangle mr-1"></i>Xem lỗi phạt
                                  </a>
                                </div>
                                <small class="text-secondary" style="font-size: 0.6rem;">
                                  {$task.expired_at|date_format:"%d/%m"}
                                </small>
                              {else}
                                {if $task.verification_notes}
                                  <small class="text-muted" style="font-size: 0.75rem;">
                                    {$task.verification_notes}
                                  </small>
                                {else}
                                  <small class="text-muted" style="font-size: 0.75rem;">
                                    Hết hạn: {$task.expires_at|date_format:"%d/%m"}
                                  </small>
                                {/if}
                              {/if}
                            </div>
                          </div>
                            </div>
                          </div>
                        {/foreach}
                      </div>
                      
                      <!-- Pagination -->
                      {if $total_pages > 1}
                        <div class="d-flex justify-content-center mt-4">
                          <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm">
                              {if $current_page > 1}
                                <li class="page-item">
                                  <a class="page-link" href="?page={$current_page-1}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                  </a>
                                </li>
                              {/if}
                              
                              {for $i=1 to $total_pages}
                                <li class="page-item {if $i == $current_page}active{/if}">
                                  <a class="page-link" href="?page={$i}">{$i}</a>
                                </li>
                              {/for}
                              
                              {if $current_page < $total_pages}
                                <li class="page-item">
                                  <a class="page-link" href="?page={$current_page+1}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                  </a>
                                </li>
                              {/if}
                            </ul>
                          </nav>
                        </div>
                      {/if}
                    {else}
                      <div class="text-center py-4">
                        <i class="fa fa-tasks fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có nhiệm vụ nào</h5>
                        <p class="text-muted">Bạn chưa nhận nhiệm vụ đánh giá nào.</p>
                        <a href="{$system['system_url']}/google-maps-reviews/dashboard" class="btn btn-primary">
                          <i class="fa fa-search mr-1"></i>Tìm nhiệm vụ
                        </a>
                      </div>
                    {/if}
                  </div>
                </div>
                
                <!-- Tab Đã nhận -->
                <div class="tab-pane fade" id="assigned" role="tabpanel">
                  <div class="card-body">
                    <div class="row" id="assigned-tasks">
                      <!-- Sẽ được lọc bằng JavaScript -->
                    </div>
                  </div>
                </div>
                
            <!-- Tab Đang xác minh -->
            <div class="tab-pane fade" id="verified" role="tabpanel">
              <div class="card-body">
                <div class="row" id="verified-tasks">
                  <!-- Sẽ được lọc bằng JavaScript -->
                </div>
              </div>
            </div>
            
            <!-- Tab Hoàn thành -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
              <div class="card-body">
                <div class="row" id="completed-tasks">
                  <!-- Sẽ được lọc bằng JavaScript -->
                </div>
              </div>
            </div>
                
                <!-- Tab Hết hạn -->
                <div class="tab-pane fade" id="expired" role="tabpanel">
                  <div class="card-body">
                    <div class="row" id="expired-tasks">
                      <!-- Sẽ được lọc bằng JavaScript -->
                    </div>
                  </div>
                </div>
              </div>
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
                  
                  <div class="form-group">
                    <label for="review_template">
                      Đánh giá mẫu (gợi ý cho GPT) 
                      <i class="fa fa-magic text-primary ml-2"></i>
                    </label>
                    <textarea class="form-control" id="review_template" name="review_template" rows="4" 
                              placeholder="Ví dụ: Nhà hàng này có không gian đẹp, món ăn ngon, phục vụ tốt. Tôi thích món bò nướng và salad tươi..."></textarea>
                    <small class="form-text text-muted">
                      <i class="fa fa-info-circle"></i> GPT sẽ tự động tạo đánh giá độc đáo (200-300 ký tự) dựa trên gợi ý của bạn. Mỗi người nhận task sẽ có nội dung đánh giá khác nhau.
                    </small>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="reward_amount">Chi phí cho 1 đánh giá 5 sao</label>
                        <input type="number" class="form-control" id="reward_amount" name="reward_amount" value="10000" readonly>
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
                          <p class="mb-1">Chi phí cho 1 đánh giá: <span id="rewardAmount">10,000</span> VND</p>
                          <p class="mb-1">Số lượng đánh giá: <span id="quantity">1</span></p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1"><strong>Tổng chi phí: <span id="totalCost">10,000</span> VND</strong></p>
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
/* ===============================
   FIX ẨN GPT BOX & LAYOUT CARD
   =============================== */

/* Mặc định card */
.card.h-100 {
  min-height: 140px;
  max-height: 160px;
  transition: all 0.3s ease;
  cursor: pointer;
  overflow: visible !important; /* Cho phép GPT box tràn tự nhiên */
}

/* Khi card có GPT box (và box CHƯA expired) thì bỏ giới hạn chiều cao */
.task-card:has(.gpt-review-box:not(.expired)) .card.h-100 {
  max-height: none !important;
  min-height: 220px;
}

/* Khi GPT box đã expired, card trả về kích thước ban đầu */
.task-card:has(.gpt-review-box.expired) .card.h-100 {
  max-height: 160px !important;
  min-height: 140px !important;
}

/* Fallback nếu :has() chưa được hỗ trợ */
.card.h-100.has-gpt-expanded {
  max-height: none !important;
  min-height: 220px;
}

.card.h-100.has-gpt-expired {
  max-height: 160px !important;
  min-height: 140px !important;
}

/* Hover effect cho cards */
.card.h-100:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  border-color: #007bff;
}

.card-body.p-2 {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
  padding: 1rem !important;
}

/* Thu hẹp nội dung card - Giảm 1/3 kích thước */
.card-body .d-flex {
  gap: 0.05rem;
}

.card-body p {
  line-height: 1.0;
  margin-bottom: 0.05rem;
  padding: 0.1rem 0;
}

.card-body > div {
  margin-bottom: 0.1rem;
  padding: 0.05rem 0;
}

.card-body > div:last-child {
  margin-bottom: 0;
}

/* Tạo khoảng cách an toàn cho text */
.card-body h6 {
  padding: 0.05rem 0;
}

.card-body .text-secondary {
  padding: 0.05rem 0;
}

.badge-sm {
  font-size: 0.7rem;
  padding: 0.25rem 0.5rem;
}

/* Đảm bảo text không bị overflow */
.text-truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Responsive grid */
@media (max-width: 768px) {
  .col-md-6 {
    margin-bottom: 1rem;
  }
}

@media (min-width: 992px) {
  .col-lg-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
  }
}

/* Tab styling */
.nav-pills .nav-link {
  border-radius: 20px;
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  margin: 0 0.25rem;
  transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
  background-color: #f8f9fa;
  transform: translateY(-1px);
}

.nav-pills .nav-link.active {
  background-color: #007bff;
  color: white;
  box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

/* ===============================
   GPT REVIEW BOX
   =============================== */
.gpt-review-box {
  background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
  border: none;
  border-radius: 8px;
  padding: 10px;
  margin: 0.5rem 0;
  box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
  transition: all 0.3s ease;
  max-width: 100%;
  overflow: visible !important;
  position: relative;
  z-index: 5;
}

.gpt-review-box:hover {
  box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
  transform: translateY(-1px);
}

.gpt-review-box.expanded {
  overflow: visible !important;
  z-index: 10;
}

/* Header */
.gpt-badge {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  padding: 0.25rem 0.6rem;
  border-radius: 12px;
  font-size: 0.65rem;
  font-weight: 600;
  white-space: nowrap;
}

/* Countdown */
.gpt-countdown {
  display: inline-flex;
  align-items: center;
  background: #fff3cd;
  color: #856404;
  padding: 0.2rem 0.5rem;
  border-radius: 10px;
  font-size: 0.6rem;
  font-weight: 600;
  border: 1px solid #ffc107;
}

.gpt-countdown.warning {
  background: #f8d7da;
  color: #721c24;
  border-color: #f5c6cb;
  animation: pulse 1s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

/* Nội dung GPT */
.gpt-content-wrapper {
  position: relative;
  margin: 0.5rem 0;
}

.gpt-content {
  font-size: 0.7rem;
  line-height: 1.5;
  color: #333;
  word-wrap: break-word;
  overflow-wrap: break-word;
  white-space: pre-wrap;
  transition: max-height 0.3s ease;
}

/* Line clamp */
.gpt-content.line-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  max-height: 3.2rem;
}

.gpt-content.expanded {
  display: block;
  -webkit-line-clamp: unset;
  max-height: none;
}

/* Fade Effect */
.gpt-fade {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 1.5rem;
  background: linear-gradient(to bottom, transparent, #f8f9ff);
  pointer-events: none;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.gpt-content-wrapper.expanded .gpt-fade {
  opacity: 0;
}

/* Action Buttons */
.btn-gpt-action {
  background: white;
  border: 1.5px solid #007bff;
  color: #007bff;
  padding: 0.3rem 0.6rem;
  border-radius: 6px;
  font-size: 0.65rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-gpt-action:hover {
  background: #007bff;
  color: white;
  transform: translateY(-1px);
  box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
}

.btn-gpt-action.btn-copy {
  background: #28a745;
  border-color: #28a745;
  color: white;
}

.btn-gpt-action.btn-copy:hover {
  background: #218838;
}

.btn-gpt-action.copied {
  background: #17a2b8;
  border-color: #17a2b8;
  color: white;
}

/* Ký tự đếm */
.gpt-char-count {
  font-size: 0.6rem;
  color: #6c757d;
  font-weight: 600;
  padding: 0.2rem 0.4rem;
  background: #e9ecef;
  border-radius: 8px;
}

.gpt-char-count.valid {
  color: #28a745;
  background: #d4edda;
}

.gpt-char-count.invalid {
  color: #dc3545;
  background: #f8d7da;
}

/* Ẩn box mặc định khi loading, JS sẽ show nếu chưa expired */
.gpt-review-box.gpt-box-loading {
  opacity: 0;
  pointer-events: none;
}

/* Show box khi JS đã check */
.gpt-review-box.gpt-box-active {
  opacity: 1;
  pointer-events: auto;
  transition: opacity 0.3s ease;
}

/* Khi hết hạn thì ẩn box */
.gpt-review-box.expired {
  display: none !important;
}

/* ===============================
   BUTTON & RESPONSIVE TINH GỌN
   =============================== */

/* Button loading state */
.btn:disabled {
  cursor: not-allowed;
  pointer-events: none;
}

.btn .fa-spinner {
  animation: fa-spin 1s infinite linear;
}

@keyframes fa-spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.btn-sm {
  font-size: 0.55rem;
  padding: 0.08rem 0.2rem;
  line-height: 0.9;
  transition: all 0.2s ease;
}

.btn-sm:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-primary.btn-sm {
  background-color: #007bff;
  border-color: #007bff;
  font-weight: 500;
}

.btn-outline-success.btn-sm {
  border-width: 1px;
}

/* Responsive */
@media (max-width: 576px) {
  .gpt-review-box { padding: 8px; }
  .gpt-content { font-size: 0.65rem; }
  .btn-gpt-action { font-size: 0.6rem; padding: 0.25rem 0.5rem; }
  .gpt-char-count { font-size: 0.55rem; }
}

.nav-pills .nav-link .badge {
  font-size: 0.7rem;
  padding: 0.2rem 0.4rem;
}

/* Tab content */
.tab-content {
  min-height: 300px;
}

/* Empty state */
.empty-state {
  text-align: center;
  padding: 3rem 1rem;
  color: #6c757d;
}

.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

/* Card buttons */
.btn-sm {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
  line-height: 1.2;
}

/* Card spacing */
.mb-1 {
  margin-bottom: 0.25rem !important;
}

/* Button styling */
.btn-primary.btn-sm {
  background-color: #007bff;
  border-color: #007bff;
  font-weight: 500;
  font-size: 0.7rem;
  padding: 0.2rem 0.4rem;
}

.btn-primary.btn-sm:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.btn-outline-success.btn-sm {
  font-size: 0.7rem;
  padding: 0.2rem 0.4rem;
  border-width: 1px;
}

.btn-outline-info.btn-sm {
  font-size: 0.7rem;
  padding: 0.2rem 0.4rem;
  border-width: 1px;
}

/* Badge styling - Trạng thái nổi bật */
.badge-sm {
  font-size: 0.65rem;
  padding: 0.3rem 0.5rem;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.2s ease;
}

/* Badge hover effects */
.badge-sm:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Pagination styling */
.pagination-sm .page-link {
  font-size: 0.8rem;
  padding: 0.25rem 0.5rem;
}

.pagination-sm .page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
}

.pagination-sm .page-link:hover {
  background-color: #e9ecef;
  border-color: #dee2e6;
}

.badge-warning {
  background-color: #ffc107 !important;
  color: #000 !important;
}

.badge-success {
  background-color: #28a745 !important;
  color: #fff !important;
}

.badge-primary {
  background-color: #007bff !important;
  color: #fff !important;
}

.badge-danger {
  background-color: #dc3545 !important;
  color: #fff !important;
}

/* Text colors - Sửa chữ trắng thành xám */
.text-secondary {
  color: #6c757d !important;
}

/* Card spacing - Thu hẹp khoảng cách tối đa */
.mb-1 {
  margin-bottom: 0 !important;
}

/* Flex column buttons - Gap nhỏ nhất */
.d-flex.flex-column {
  gap: 0.1rem;
}

/* Button styling - Thu nhỏ buttons tối đa */
.btn-sm {
  font-size: 0.55rem;
  padding: 0.08rem 0.2rem;
  line-height: 0.9;
  transition: all 0.2s ease;
}

/* Button hover effects */
.btn-sm:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-primary.btn-sm:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.btn-outline-success.btn-sm:hover {
  background-color: #28a745;
  border-color: #28a745;
  color: white;
}

.btn-outline-info.btn-sm:hover {
  background-color: #17a2b8;
  border-color: #17a2b8;
  color: white;
}

/* Buttons ngang - Gap nhỏ */
.d-flex .btn-sm {
  margin-right: 0.05rem;
}

.d-flex .btn-sm:last-child {
  margin-right: 0;
}

/* Text sizing - Thu nhỏ text tối đa */
.card-title {
  font-size: 0.75rem;
  line-height: 1.0;
  word-wrap: break-word;
  overflow-wrap: break-word;
}

/* Compact layout - Gap tối thiểu */
.card-body .d-flex {
  gap: 0.03rem;
}

/* Line height tối ưu - Thu hẹp tối đa */
.card-body p {
  line-height: 1.2;
  margin-bottom: 0;
  word-wrap: break-word;
  overflow-wrap: break-word;
  white-space: normal;
}

/* Loại bỏ margin thừa */
.card-body h6 {
  margin-bottom: 0;
}

.card-body .d-flex {
  margin-bottom: 0;
}

/* Thu hẹp khoảng cách giữa các section */
.card-body > div {
  margin-bottom: 0;
}

.card-body > div:last-child {
  margin-bottom: 0;
}

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
      
      var createButton = document.getElementById('createButton');
      if (!createButton) return;
      
      // Vô hiệu hóa nút và hiển thị loading state
      createButton.disabled = true;
      var originalButtonHTML = createButton.innerHTML;
      createButton.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Đang tạo chiến dịch...';
      createButton.style.opacity = '0.7';
      
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
          // Thành công - Hiển thị success state
          createButton.innerHTML = '<i class="fa fa-check mr-2"></i>Thành công! Đang tải lại...';
          createButton.classList.remove('btn-primary');
          createButton.classList.add('btn-success');
          createButton.style.opacity = '1';
          
          // Reload sau 1.5 giây để user thấy success message
          setTimeout(function() {
            location.reload();
          }, 1500);
        } else {
          // Lỗi - Khôi phục nút
          alert('Lỗi: ' + data.error);
          createButton.innerHTML = originalButtonHTML;
          createButton.disabled = false;
          createButton.style.opacity = '1';
        }
      })
      .catch(error => {
        console.log('Fetch Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        
        // Khôi phục nút
        createButton.innerHTML = originalButtonHTML;
        createButton.disabled = false;
        createButton.style.opacity = '1';
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
  var rewardAmount = rewardAmountField ? parseInt(rewardAmountField.value) || 10000 : 10000;
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

// Tab filtering functionality
function initTabFiltering() {
  // Lấy tất cả task cards
  var allTasks = document.querySelectorAll('.task-card');
  
  // Lưu trữ tất cả tasks để có thể hiển thị lại
  var tasksByStatus = {
    'assigned': [],
    'completed': [],
    'verified': [],
    'expired': []
  };
  
  // Phân loại tasks theo status
  allTasks.forEach(function(task) {
    var status = task.getAttribute('data-status');
    // Timeout cũng được xếp vào nhóm expired
    if (status === 'timeout') {
      tasksByStatus['expired'].push(task.outerHTML);
    } else if (tasksByStatus[status]) {
      tasksByStatus[status].push(task.outerHTML);
    }
  });
  
  // Xử lý tab switching
  var tabButtons = document.querySelectorAll('#statusTabs button[data-bs-toggle="pill"]');
  tabButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      var targetId = button.getAttribute('data-bs-target').substring(1); // Bỏ dấu #
      var targetContainer = document.getElementById(targetId + '-tasks');
      
      if (targetContainer) {
        if (targetId === 'all') {
          // Hiển thị tất cả tasks
          var allTasksHtml = '';
          allTasks.forEach(function(task) {
            allTasksHtml += task.outerHTML;
          });
          targetContainer.innerHTML = allTasksHtml;
        } else {
          // Hiển thị tasks theo status
          targetContainer.innerHTML = tasksByStatus[targetId].join('');
        }
      }
    });
  });
  
  // Khởi tạo tab đầu tiên
  if (allTasks.length > 0) {
    var firstTab = document.getElementById('all-tasks');
    if (firstTab) {
      var allTasksHtml = '';
      allTasks.forEach(function(task) {
        allTasksHtml += task.outerHTML;
      });
      firstTab.innerHTML = allTasksHtml;
    }
  }
}

/**
 * Copy review content to clipboard
 */
function copyReviewContent(subRequestId, button) {
  var contentElement = document.getElementById('content-' + subRequestId);
  if (!contentElement) {
    alert('❌ Không tìm thấy nội dung đánh giá');
    return;
  }
  
  var content = contentElement.textContent || contentElement.innerText;
  content = content.trim();
  
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(content)
      .then(function() {
        var originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fa fa-check mr-1"></i>Đã copy!';
        button.classList.add('copied');
        
        setTimeout(function() {
          button.innerHTML = originalHTML;
          button.classList.remove('copied');
        }, 2000);
      })
      .catch(function(err) {
        console.error('Copy failed:', err);
        fallbackCopyTextToClipboard(content, button);
      });
  } else {
    fallbackCopyTextToClipboard(content, button);
  }
}

/**
 * Toggle expand/collapse review content
 */
function toggleReviewExpand(subRequestId) {
  var contentElement = document.getElementById('content-' + subRequestId);
  var wrapperElement = document.getElementById('wrapper-' + subRequestId);
  var boxElement = document.getElementById('gpt-box-' + subRequestId);
  var button = document.getElementById('expand-btn-' + subRequestId);
  
  if (!contentElement || !wrapperElement || !button || !boxElement) return;
  
  var parentCard = boxElement.closest('.card.h-100');
  var isExpanded = contentElement.classList.contains('expanded');
  
  if (isExpanded) {
    contentElement.classList.remove('expanded');
    wrapperElement.classList.remove('expanded');
    boxElement.classList.remove('expanded');
    button.innerHTML = '<i class="fa fa-chevron-down mr-1"></i>Xem thêm';
    
    if (parentCard) {
      parentCard.classList.remove('has-gpt-expanded');
    }
  } else {
    contentElement.classList.add('expanded');
    wrapperElement.classList.add('expanded');
    boxElement.classList.add('expanded');
    button.innerHTML = '<i class="fa fa-chevron-up mr-1"></i>Thu gọn';
    
    if (parentCard) {
      parentCard.classList.add('has-gpt-expanded');
    }
  }
}

/**
 * Update character count display
 */
function updateCharCount(subRequestId) {
  var contentElement = document.getElementById('content-' + subRequestId);
  var charCountElement = document.getElementById('char-count-' + subRequestId);
  
  if (!contentElement || !charCountElement) return;
  
  var content = contentElement.textContent || contentElement.innerText;
  var length = content.trim().length;
  
  charCountElement.textContent = length + ' ký tự';
  
  charCountElement.classList.remove('valid', 'invalid');
  if (length >= 200 && length <= 300) {
    charCountElement.classList.add('valid');
  } else if (length > 0) {
    charCountElement.classList.add('invalid');
  }
}

/**
 * Initialize countdown timer for GPT review box
 */
function initCountdownTimer(subRequestId, assignedTime) {
  var assignedDate = new Date(assignedTime.replace(' ', 'T'));
  var expiryDate = new Date(assignedDate.getTime() + 30 * 60 * 1000);
  
  var countdownElement = document.getElementById('countdown-' + subRequestId);
  var boxElement = document.getElementById('gpt-box-' + subRequestId);
  
  if (!countdownElement || !boxElement) return;
  
  var now = new Date();
  if (expiryDate <= now) {
    // Đã hết hạn - ẩn box ngay
    boxElement.classList.add('expired');
    boxElement.classList.remove('gpt-box-loading');
    var parentCard = boxElement.closest('.card.h-100');
    if (parentCard) {
      parentCard.classList.remove('has-gpt-expanded');
      parentCard.classList.add('has-gpt-expired');
    }
    return;
  }
  
  // Chưa hết hạn - show box
  boxElement.classList.remove('gpt-box-loading');
  boxElement.classList.add('gpt-box-active');
  
  var countdownInterval = setInterval(function() {
    var now = new Date();
    var timeLeft = expiryDate - now;
    
    if (timeLeft <= 0) {
      clearInterval(countdownInterval);
      boxElement.classList.add('expired');
      
      var parentCard = boxElement.closest('.card.h-100');
      if (parentCard) {
        parentCard.classList.remove('has-gpt-expanded');
        parentCard.classList.add('has-gpt-expired');
      }
      
      return;
    }
    
    var minutes = Math.floor(timeLeft / 60000);
    var seconds = Math.floor((timeLeft % 60000) / 1000);
    
    var display = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    var textElement = countdownElement.querySelector('.countdown-text');
    if (textElement) {
      textElement.textContent = display;
    }
    
    if (minutes < 5) {
      countdownElement.classList.add('warning');
    } else {
      countdownElement.classList.remove('warning');
    }
  }, 1000);
}

/**
 * Initialize all GPT review boxes on page load
 */
function initGPTReviewBoxes() {
  var gptBoxes = document.querySelectorAll('.gpt-review-box.gpt-box-loading');
  
  if (gptBoxes.length === 0) {
    return;
  }
  
  gptBoxes.forEach(function(box) {
    var subRequestId = box.getAttribute('data-sub-request-id');
    var assignedTime = box.getAttribute('data-assigned-time');
    
    if (subRequestId && assignedTime) {
      updateCharCount(subRequestId);
      initCountdownTimer(subRequestId, assignedTime);
    }
  });
}

/**
 * Fallback copy method for older browsers
 */
function fallbackCopyTextToClipboard(text, button) {
  var textArea = document.createElement("textarea");
  textArea.value = text;
  textArea.style.position = "fixed";
  textArea.style.top = 0;
  textArea.style.left = 0;
  textArea.style.width = "2em";
  textArea.style.height = "2em";
  textArea.style.padding = 0;
  textArea.style.border = "none";
  textArea.style.outline = "none";
  textArea.style.boxShadow = "none";
  textArea.style.background = "transparent";
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();
  
  try {
    var successful = document.execCommand('copy');
    if (successful) {
      var originalHTML = button.innerHTML;
      button.innerHTML = '<i class="fa fa-check mr-1"></i>Đã copy!';
      button.classList.add('copied');
      
      setTimeout(function() {
        button.innerHTML = originalHTML;
        button.classList.remove('copied');
      }, 2000);
    } else {
      alert('❌ Không thể copy. Vui lòng copy thủ công.');
    }
  } catch (err) {
    console.error('Fallback: Oops, unable to copy', err);
    alert('❌ Không thể copy. Vui lòng copy thủ công.');
  }
  
  document.body.removeChild(textArea);
}

// Bind when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', function() {
    bindConfirmButton();
    initTabFiltering();
    initGPTReviewBoxes();
  });
} else {
  bindConfirmButton();
  initTabFiltering();
  initGPTReviewBoxes();
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
</script>

{include file='_footer.tpl'}