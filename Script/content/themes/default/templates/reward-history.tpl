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
              <strong>Lịch sử thưởng</strong>
            </div>
            <div class="card-body">
              {if $reward_history}
                <div class="table-responsive">
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

{include file='_footer.tpl'}
