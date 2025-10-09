{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="container mt20">
  <div class="row">
    <!-- sidebar -->
    <div class="col-12 col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar shop-ai-sidebar d-none d-md-block">
      <div class="card">
        <div class="card-header bg-transparent">
          <strong>Google Maps Reviews</strong>
        </div>
        <div class="card-body">
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
        <!-- statistics cards -->
        {if $reward_history}
          <div class="col-12 mb-4">
            <div class="row">
              <div class="col-md-6">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h4 class="mb-0">{$reward_history|count}</h4>
                        <p class="mb-0">Đánh giá hoàn thành</p>
                      </div>
                      <div class="align-self-center">
                        <i class="fa fa-check-circle fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h4 class="mb-0">
                          {assign var="total_earnings" value=0}
                          {foreach $reward_history as $reward}
                            {assign var="total_earnings" value=$total_earnings+$reward.reward_amount}
                          {/foreach}
                          {number_format($total_earnings, 0, ',', '.')} VND
                        </h4>
                        <p class="mb-0">Tổng thu nhập</p>
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
        
        <!-- main content -->
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="d-flex justify-content-between align-items-center">
                <strong>Lịch sử thưởng</strong>
                <button type="button" class="btn btn-success btn-sm" onclick="showWithdrawModal()">
                  <i class="fa fa-money-bill-wave mr-1"></i>Rút tiền
                </button>
              </div>
            </div>
            <div class="card-body">
              {if $reward_history}
                <!-- Desktop table view -->
                <div class="table-responsive d-none d-md-block">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Địa điểm</th>
                        <th>Số tiền thưởng</th>
                        <th>Ngày hoàn thành</th>
                      </tr>
                    </thead>
                    <tbody>
                      {foreach $reward_history as $reward}
                        <tr>
                          <td>
                            <strong>{$reward.place_name}</strong><br>
                            <small class="text-muted">{$reward.place_address}</small>
                          </td>
                          <td>
                            <span class="text-success font-weight-bold">
                              {number_format($reward.reward_amount, 0, ',', '.')} VND
                            </span>
                          </td>
                          <td>
                            {$reward.created_at|date_format:"%d/%m/%Y %H:%M"}
                          </td>
                        </tr>
                      {/foreach}
                    </tbody>
                  </table>
                </div>
                
                <!-- Mobile card view -->
                <div class="d-block d-md-none">
                  {foreach $reward_history as $reward}
                    <div class="card mb-3 border-left-success shadow-sm" 
                         style="border-left: 4px solid #28a745; transition: all 0.3s ease; cursor: pointer;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                      <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div class="flex-grow-1">
                            <h6 class="card-title mb-1 text-dark">{$reward.place_name}</h6>
                            <small class="text-muted">{$reward.place_address}</small>
                          </div>
                          <div class="text-end">
                            <span class="badge bg-success fs-6 shadow-sm">
                              {number_format($reward.reward_amount, 0, ',', '.')} VND
                            </span>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted">
                            <i class="fa fa-calendar mr-1"></i>
                            {$reward.created_at|date_format:"%d/%m/%Y %H:%M"}
                          </small>
                          <small class="text-success">
                            <i class="fa fa-check-circle mr-1"></i>Hoàn thành
                          </small>
                        </div>
                      </div>
                    </div>
                  {/foreach}
                </div>
              {else}
                <div class="text-center py-5">
                  <i class="fa fa-history fa-4x text-muted mb-3"></i>
                  <h5 class="text-muted">Chưa có lịch sử thưởng</h5>
                  <p class="text-muted">Hoàn thành các nhiệm vụ đánh giá để nhận thưởng</p>
                  <a href="{$system['system_url']}/google-maps-reviews/my-reviews" class="btn btn-primary">
                    <i class="fa fa-star mr-2"></i>Xem nhiệm vụ
                  </a>
                </div>
              {/if}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Tính năng Rút Tiền -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
      <div class="modal-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none;">
        <h5 class="modal-title text-white font-weight-bold">
          <i class="fa fa-money-bill-wave mr-2"></i>Rút Tiền
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <!-- Icon Coming Soon -->
        <div class="text-center mb-4">
          <div class="d-inline-block p-4 rounded-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <i class="fa fa-hammer fa-3x text-white"></i>
          </div>
        </div>
        
        <!-- Thông báo -->
        <div class="text-center mb-4">
          <h4 class="font-weight-bold mb-2">Tính năng đang phát triển</h4>
          <p class="text-muted mb-0">
            Chúng tôi đang hoàn thiện tính năng rút tiền. Vui lòng quay lại sau!
          </p>
        </div>
        
        <!-- Chính sách rút tiền -->
        <div class="alert alert-info" style="border-radius: 12px; background: linear-gradient(180deg, #eef5ff, #ffffff); border: 1px solid #dbe7ff;">
          <h6 class="font-weight-bold mb-3">
            <i class="fa fa-info-circle mr-2"></i>Chính sách rút tiền
          </h6>
          <ul class="mb-0 pl-3" style="list-style: none;">
            <li class="mb-2">
              <i class="fa fa-check-circle text-success mr-2"></i>
              <strong>Số tiền tối thiểu:</strong> 50.000 VNĐ
            </li>
            <li class="mb-0">
              <i class="fa fa-clock text-primary mr-2"></i>
              <strong>Giới hạn:</strong> 1 lần/24 giờ
            </li>
          </ul>
        </div>
        
        <!-- Note -->
        <div class="text-center mt-3">
          <small class="text-muted">
            <i class="fa fa-bell mr-1"></i>
            Bạn sẽ được thông báo khi tính năng sẵn sàng
          </small>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fa fa-times mr-1"></i>Đóng
        </button>
      </div>
    </div>
  </div>
</div>

<script>
function showWithdrawModal() {
  $('#withdrawModal').modal('show');
}
</script>

{include file='_footer.tpl'}
