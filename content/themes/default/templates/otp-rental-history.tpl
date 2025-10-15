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

    <!-- OTP Rental Sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar otp-rental-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <ul class="main-side-nav">
            <li>
              <a href="{$system['system_url']}/otp-rental">
                <i class="fa fa-mobile-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                {__("Thuê OTP")}
              </a>
            </li>
            <li class="active">
              <a href="{$system['system_url']}/otp-rental/history">
                <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                {__("Lịch sử thuê")}
              </a>
            </li>
            <li>
              <a href="{$system['system_url']}/wallet">
                <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                {__("Nạp tiền")}
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- OTP Rental Sidebar -->

    <!-- content panel -->
    <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar otp-rental-mainbar">

      <!-- tabs (mobile only) -->
      <div class="content-tabs rounded-sm shadow-sm clearfix d-block d-md-none">
        <ul>
          <li>
            <a href="{$system['system_url']}/otp-rental">
              {__("Thuê OTP")}
            </a>
          </li>
          <li class="active">
            <a href="{$system['system_url']}/otp-rental/history">
              {__("Lịch sử")}
            </a>
          </li>
          <li>
            <a href="{$system['system_url']}/wallet">
              {__("Nạp tiền")}
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
            <div class="card-header bg-primary text-white">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h1 class="page-title mb-1">
                    <i class="fa fa-history mr-2"></i>
                    Lịch sử thuê OTP
                  </h1>
                  <p class="page-description mb-0">Xem lại tất cả các lần thuê OTP của bạn</p>
                </div>
                <div class="col-md-4 text-end">
                  <div class="d-flex align-items-center justify-content-end">
                    <i class="fa fa-wallet mr-2"></i>
                    <span class="me-2">Số dư:</span>
                    <span class="badge bg-light text-dark fs-6" id="userBalance">
                      {if $user->_data['user_wallet_balance']}
                        {$user->_data['user_wallet_balance']|number_format} VND
                      {else}
                        0 VND
                      {/if}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              
              <!-- Filters -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card border-0 shadow-sm">
                    <div class="card-body">
                      <form id="filterForm" method="GET">
                        <div class="row g-3">
                          <div class="col-md-3">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" placeholder="Số điện thoại, mã OTP..." value="{$search|default:''}">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Dịch vụ</label>
                            <select class="form-select" name="service">
                              <option value="">Tất cả</option>
                              {foreach $services as $service}
                                <option value="{$service.service_id}" {if $selected_service == $service.service_id}selected{/if}>
                                  {$service.name}
                                </option>
                              {/foreach}
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select class="form-select" name="status">
                              <option value="">Tất cả</option>
                              <option value="pending" {if $selected_status == 'pending'}selected{/if}>Đợi tin nhắn</option>
                              <option value="completed" {if $selected_status == 'completed'}selected{/if}>Hoàn thành</option>
                              <option value="expired" {if $selected_status == 'expired'}selected{/if}>Hết hạn</option>
                              <option value="failed" {if $selected_status == 'failed'}selected{/if}>Thất bại</option>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Từ ngày</label>
                            <input type="date" class="form-control" name="from_date" value="{$from_date|default:''}">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Đến ngày</label>
                            <input type="date" class="form-control" name="to_date" value="{$to_date|default:''}">
                          </div>
                          <div class="col-md-1">
                            <label class="form-label fw-bold">&nbsp;</label>
                            <div class="d-grid">
                              <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Results Summary -->
              <div class="row mb-3">
                <div class="col-12">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <span class="text-muted">
                        Hiển thị <strong>{$start_record|default:0}</strong> - <strong>{$end_record|default:0}</strong> 
                        trong tổng số <strong>{$total_records|default:0}</strong> kết quả
                      </span>
                    </div>
                    <div>
                      <span class="text-muted">
                        Trang <strong>{$current_page|default:1}</strong> / <strong>{$total_pages|default:1}</strong>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- History Table -->
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Dịch vụ</th>
                      <th>Số điện thoại</th>
                      <th>Mã OTP</th>
                      <th>Trạng thái</th>
                      <th>Thời gian</th>
                      <th>Giá</th>
                      <th>Thao tác</th>
                    </tr>
                  </thead>
                  <tbody id="historyTable">
                    {if $rentals}
                      {foreach $rentals as $rental}
                        <tr>
                          <td>{$rental.request_id}</td>
                          <td>
                            <span class="badge bg-info">{$rental.service_name|default:$rental.service_name}</span>
                          </td>
                          <td>
                            <span class="badge bg-primary">{$rental.phone_number}</span>
                          </td>
                          <td>
                            {if $rental.otp_code}
                              <span class="badge bg-success">{$rental.otp_code}</span>
                            {else}
                              <span class="text-muted">-</span>
                            {/if}
                          </td>
                          <td>
                            {if $rental.status == 'pending'}
                              <span class="badge bg-warning">Đợi tin nhắn</span>
                            {elseif $rental.status == 'completed'}
                              <span class="badge bg-success">Hoàn thành</span>
                            {elseif $rental.status == 'expired'}
                              <span class="badge bg-danger">Hết hạn</span>
                            {elseif $rental.status == 'failed'}
                              <span class="badge bg-danger">Thất bại</span>
                            {else}
                              <span class="badge bg-secondary">Không xác định</span>
                            {/if}
                          </td>
                          <td>
                            <small class="text-muted">
                              {$rental.created_at|date_format:"%d/%m/%Y %H:%M"}
                            </small>
                          </td>
                          <td>
                            <strong class="text-success">
                              {$rental.price|number_format} VND
                            </strong>
                          </td>
                          <td>
                            {if $rental.status == 'pending'}
                              <button class="btn btn-sm btn-outline-primary" onclick="checkOTP('{$rental.viotp_request_id}')">
                                <i class="fa fa-refresh"></i> Kiểm tra
                              </button>
                            {elseif $rental.status == 'completed' && $rental.otp_code}
                              <button class="btn btn-sm btn-outline-success" onclick="copyOTP('{$rental.otp_code}')">
                                <i class="fa fa-copy"></i> Copy
                              </button>
                            {else}
                              <span class="text-muted">-</span>
                            {/if}
                          </td>
                        </tr>
                      {/foreach}
                    {else}
                      <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                          <i class="fa fa-inbox fa-2x mb-2"></i><br>
                          Không có lịch sử thuê nào
                        </td>
                      </tr>
                    {/if}
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              {if $total_pages > 1}
                <div class="row mt-4">
                  <div class="col-12">
                    <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-center">
                        {if $current_page > 1}
                          <li class="page-item">
                            <a class="page-link" href="?page={$current_page-1}&{http_build_query($filter_params)}">
                              <i class="fa fa-chevron-left"></i>
                            </a>
                          </li>
                        {/if}
                        
                        {for $i = max(1, $current_page-2) to min($total_pages, $current_page+2)}
                          <li class="page-item {if $i == $current_page}active{/if}">
                            <a class="page-link" href="?page={$i}&{http_build_query($filter_params)}">
                              {$i}
                            </a>
                          </li>
                        {/for}
                        
                        {if $current_page < $total_pages}
                          <li class="page-item">
                            <a class="page-link" href="?page={$current_page+1}&{http_build_query($filter_params)}">
                              <i class="fa fa-chevron-right"></i>
                            </a>
                          </li>
                        {/if}
                      </ul>
                    </nav>
                  </div>
                </div>
              {/if}

            </div>
          </div>
        </div>
        <!-- main content -->
      </div>
      <!-- content -->
    </div>
    <!-- content panel -->
  </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}

<script>
function checkOTP(requestId) {
    // AJAX call to check OTP
    $.ajax({
        url: '{$system['system_url']}/otp-rental',
        method: 'POST',
        data: {
            action: 'check_otp',
            request_id: requestId
        },
        success: function(response) {
            if (response.success) {
                if (response.data.status == 'completed' && response.data.code) {
                    alert('Đã nhận được mã OTP: ' + response.data.code);
                } else if (response.data.status == 'expired') {
                    alert('Số điện thoại đã hết hạn');
                } else {
                    alert('Chưa có mã OTP, vui lòng đợi thêm');
                }
                location.reload();
            } else {
                alert('Lỗi: ' + (response.error || response.message || 'Không thể kiểm tra OTP'));
            }
        },
        error: function() {
            alert('Có lỗi xảy ra khi kiểm tra OTP');
        }
    });
}

function copyOTP(code) {
    navigator.clipboard.writeText(code).then(function() {
        alert('Đã copy mã OTP: ' + code);
    }).catch(function() {
        alert('Không thể copy mã OTP');
    });
}
</script>
