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
                <button type="button" class="btn btn-success btn-sm" onclick="showWithdrawModal()" style="display:flex;align-items:center;gap:5px;">
                  <i class="fa fa-money-bill-wave"></i>
                  <span>Rút tiền</span>
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
                          <small class="text-muted" style="display:flex;align-items:center;gap:5px;">
                            <i class="fa fa-calendar"></i>
                            <span>{$reward.created_at|date_format:"%d/%m/%Y %H:%M"}</span>
                          </small>
                          <small class="text-success" style="display:flex;align-items:center;gap:5px;">
                            <i class="fa fa-check-circle"></i>
                            <span>Hoàn thành</span>
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
                  <a href="{$system['system_url']}/google-maps-reviews/my-reviews" class="btn btn-primary" style="display:flex;align-items:center;gap:5px;">
                    <i class="fa fa-star"></i>
                    <span>Xem nhiệm vụ</span>
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

<!-- Modal: Rút Tiền -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content withdraw-modal">
      <div class="modal-header withdraw-modal__header">
        <h5 class="modal-title" id="withdrawModalTitle" style="display:flex;align-items:center;gap:5px;">
          <i class="fa fa-money-bill-wave"></i>
          <span>Rút tiền</span>
        </h5>

        <!-- Close (BS5 + BS4) -->
        <button type="button" class="btn-close d-inline-block" aria-label="Close"
                data-bs-dismiss="modal" data-dismiss="modal"></button>
        <!-- Fallback cho BS4 nếu thiếu .btn-close (hiện dấu ×) -->
        <button type="button" class="close d-none" aria-label="Close"
                data-bs-dismiss="modal" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body withdraw-modal__body">
        <!-- Icon -->
        <div class="withdraw-modal__icon">
          <i class="fa fa-hammer"></i>
        </div>

        <!-- Thông báo -->
        <div class="text-center mb-3">
          <h4 class="font-weight-bold mb-2">Tính năng đang phát triển</h4>
          <p class="text-muted mb-0">Chúng tôi đang hoàn thiện tính năng rút tiền. Vui lòng quay lại sau!</p>
        </div>

        <!-- Chính sách -->
        <div class="withdraw-modal__policy">
          <h6 class="font-weight-bold mb-3" style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-info-circle"></i>
            <span>Chính sách rút tiền</span>
          </h6>
          <ul class="mb-0 pl-0">
            <li style="display:flex;align-items:center;gap:5px;"><i class="fa fa-check-circle"></i><span><strong>Min:</strong> 50.000&nbsp;VNĐ</span></li>
            <li style="display:flex;align-items:center;gap:5px;"><i class="fa fa-clock"></i><span><strong>Giới hạn:</strong> 1 lần / 24 giờ</span></li>
          </ul>
        </div>

        <div class="text-center mt-3">
          <small class="text-muted" style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-bell"></i>
            <span>Bạn sẽ được thông báo khi tính năng sẵn sàng</span>
          </small>
        </div>
      </div>

      <div class="modal-footer withdraw-modal__footer">
<button class="btn btn-light" data-bs-dismiss="modal" style="display:flex;align-items:center;gap:5px;">
  <i class="fa fa-times"></i>
  <span>Đóng</span>
</button>

      </div>
    </div>
  </div>
</div>

<style>
  :root{
    --wd-primary:#4F46E5; /* indigo-600 */
    --wd-accent:#7C3AED;  /* violet-600 */
    --wd-success:#16A34A; /* green-600 */
    --wd-bg:#ffffff;
    --wd-soft:#f6f7ff;
    --wd-border:#e5e7eb;
  }
  .withdraw-modal{
    border:0; border-radius:16px; overflow:hidden; background:var(--wd-bg);
    box-shadow:0 20px 45px rgba(0,0,0,.15);
  }
  .withdraw-modal__header{
    background:linear-gradient(135deg, var(--wd-primary), var(--wd-accent));
    color:#fff; border:0; align-items:center;
  }
  .withdraw-modal__header .modal-title{
    font-weight:700; display:flex; align-items:center;
  }
  .withdraw-modal__body{
    padding:24px;
    background:linear-gradient(180deg, #FAFBFF 0%, #FFF 100%);
  }
  .withdraw-modal__icon{
    width:84px; height:84px; border-radius:50%;
    margin:0 auto 16px auto;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg, #EEF2FF, #EDE9FE);
    color:var(--wd-primary); font-size:34px;
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.7), 0 6px 16px rgba(79,70,229,.15);
  }
  .withdraw-modal__policy{
    border:1px solid var(--wd-border);
    border-radius:12px;
    background:linear-gradient(180deg, #F8FAFF, #FFFFFF);
    padding:16px 16px 12px;
  }
  .withdraw-modal__policy ul{ list-style:none; }
  .withdraw-modal__policy li{ margin-bottom:8px; }
  .withdraw-modal__policy i{ color:var(--wd-success); }
  .withdraw-modal__footer{ border:0; padding:16px 20px; }
  /* Fallback: nếu .btn-close không có icon hệ thống, ẩn nó và show .close */
  .btn-close:not(:hover){ outline:none; box-shadow:none; }
  .btn-close{ width: 1em; height:1em; background:transparent; border:0; filter: invert(1); opacity: 0.8; }
  .btn-close:hover{ opacity: 1; }
  .btn-close + .close{ display:none; } /* nếu .btn-close render ok thì ẩn .close cũ */
</style>

<script>
  // Helper: detect Bootstrap version availability
  function hasBS5(){ return typeof bootstrap !== 'undefined' && bootstrap.Modal; }
  function hasJQModal(){ return typeof $ !== 'undefined' && $.fn && $.fn.modal; }

  // Open
  function showWithdrawModal() {
    var el = document.getElementById('withdrawModal');
    if (!el) return;

    if (hasBS5()) {
      var inst = bootstrap.Modal.getOrCreateInstance(el, {ldelim}backdrop: true, keyboard: true{rdelim});
      inst.show();
    } else if (hasJQModal()) {
      $('#withdrawModal').modal({ldelim}backdrop: true, keyboard: true, show: true{rdelim});
    } else {
      alert('Modal library not loaded');
    }
  }

  // Close (cho mọi nút có data-(bs-)dismiss="modal")
  function closeWithdrawModal() {
    var el = document.getElementById('withdrawModal');
    if (!el) return;

    if (hasBS5()) {
      var inst = bootstrap.Modal.getInstance(el) || bootstrap.Modal.getOrCreateInstance(el);
      inst.hide();
    } else if (hasJQModal()) {
      $('#withdrawModal').modal('hide');
    }
  }

  // Bật ESC (BS5 tự có; BS4 cũng có nếu keyboard:true)
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeWithdrawModal();
  });
</script>

{include file='_footer.tpl'}
