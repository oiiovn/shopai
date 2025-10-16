<?php
/* Smarty version 4.3.4, created on 2025-10-09 11:05:31
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/reward-history.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e796fbdbf250_02608348',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a7b99c19a48f11f3640c1b7a8f5b712cc0724da3' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/reward-history.tpl',
      1 => 1760007926,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68e796fbdbf250_02608348 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- Loading Overlay -->
<div id="pageLoadingOverlay" class="loading-overlay">
  <div class="loading-spinner">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Đang tải...</span>
    </div>
    <div class="loading-text mt-3">Chờ chút nha...</div>
  </div>
</div>

<?php echo '<script'; ?>
>
// Hide loading overlay when page is fully loaded
document.addEventListener('DOMContentLoaded', function() {
  setTimeout(function() {
    const overlay = document.getElementById('pageLoadingOverlay');
    if (overlay) {
      overlay.style.opacity = '0';
      setTimeout(function() {
        overlay.style.display = 'none';
      }, 300);
    }
  }, 500);
});

// Show loading on navigation
document.addEventListener('click', function(e) {
  const link = e.target.closest('a[href*="google-maps-reviews"]');
  if (link && link.href !== window.location.href) {
    const overlay = document.getElementById('pageLoadingOverlay');
    if (overlay) {
      overlay.style.display = 'flex';
      overlay.style.opacity = '1';
    }
  }
});
<?php echo '</script'; ?>
>

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
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == 'dashboard') {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/dashboard">
                <i class="fa fa-tachometer-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Bảng điều khiển
              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == 'my-requests') {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-requests">
                <i class="fa fa-list main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Chiến dịch đã tạo
              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == 'my-reviews') {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews">
                <i class="fa fa-star main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Đánh giá của tôi
              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == 'create-request') {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/create-request">
                <i class="fa fa-plus main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Tạo chiến dịch
              </a>
            </li>
            <li>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai/recharge">
                <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Nạp tiền
              </a>
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == 'reward-history') {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/reward-history">
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
      
      <!-- mobile pills navigation (mobile only) -->
      <div class="mobile-pills-nav d-block d-md-none mb-4">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/dashboard" 
             class="btn btn-sm <?php if ($_smarty_tpl->tpl_vars['view']->value == 'dashboard') {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?> rounded-pill px-3" 
             style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-requests" 
             class="btn btn-sm <?php if ($_smarty_tpl->tpl_vars['view']->value == 'my-requests') {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?> rounded-pill px-3" 
             style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-list"></i>
            <span>Chiến dịch</span>
          </a>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews" 
             class="btn btn-sm <?php if ($_smarty_tpl->tpl_vars['view']->value == 'my-reviews') {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?> rounded-pill px-3" 
             style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-star"></i>
            <span>Đánh giá</span>
          </a>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/create-request" 
             class="btn btn-sm <?php if ($_smarty_tpl->tpl_vars['view']->value == 'create-request') {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?> rounded-pill px-3" 
             style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-plus"></i>
            <span>Tạo mới</span>
          </a>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai/recharge" 
             class="btn btn-sm btn-outline-success rounded-pill px-3" 
             style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-credit-card"></i>
            <span>Nạp tiền</span>
          </a>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/reward-history" 
             class="btn btn-sm <?php if ($_smarty_tpl->tpl_vars['view']->value == 'reward-history') {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?> rounded-pill px-3" 
             style="display:flex;align-items:center;gap:5px;">
            <i class="fa fa-history"></i>
            <span>Thưởng</span>
          </a>
        </div>
      </div>
      <!-- mobile pills -->

      <!-- content -->
      <div class="row">
        <!-- statistics cards -->
        <?php if ($_smarty_tpl->tpl_vars['reward_history']->value) {?>
          <div class="col-12 mb-4">
            <div class="row">
              <div class="col-md-6">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h4 class="mb-0"><?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['reward_history']->value);?>
</h4>
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
                          <?php $_smarty_tpl->_assignInScope('total_earnings', 0);?>
                          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reward_history']->value, 'reward');
$_smarty_tpl->tpl_vars['reward']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->do_else = false;
?>
                            <?php $_smarty_tpl->_assignInScope('total_earnings', $_smarty_tpl->tpl_vars['total_earnings']->value+$_smarty_tpl->tpl_vars['reward']->value['reward_amount']);?>
                          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                          <?php echo number_format($_smarty_tpl->tpl_vars['total_earnings']->value,0,',','.');?>
 VND
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
        <?php }?>
        
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
              <?php if ($_smarty_tpl->tpl_vars['reward_history']->value) {?>
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
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reward_history']->value, 'reward');
$_smarty_tpl->tpl_vars['reward']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->do_else = false;
?>
                        <tr>
                          <td>
                            <strong><?php echo $_smarty_tpl->tpl_vars['reward']->value['place_name'];?>
</strong><br>
                            <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['reward']->value['place_address'];?>
</small>
                          </td>
                          <td>
                            <span class="text-success font-weight-bold">
                              <?php echo number_format($_smarty_tpl->tpl_vars['reward']->value['reward_amount'],0,',','.');?>
 VND
                            </span>
                          </td>
                          <td>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['reward']->value['created_at'],"%d/%m/%Y %H:%M");?>

                          </td>
                        </tr>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </tbody>
                  </table>
                </div>
                
                <!-- Mobile card view -->
                <div class="d-block d-md-none">
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reward_history']->value, 'reward');
$_smarty_tpl->tpl_vars['reward']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->do_else = false;
?>
                    <div class="card mb-3 border-left-success shadow-sm" 
                         style="border-left: 4px solid #28a745; transition: all 0.3s ease; cursor: pointer;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                      <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div class="flex-grow-1">
                            <h6 class="card-title mb-1 text-dark"><?php echo $_smarty_tpl->tpl_vars['reward']->value['place_name'];?>
</h6>
                            <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['reward']->value['place_address'];?>
</small>
                          </div>
                          <div class="text-end">
                            <span class="badge bg-success fs-6 shadow-sm">
                              <?php echo number_format($_smarty_tpl->tpl_vars['reward']->value['reward_amount'],0,',','.');?>
 VND
                            </span>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted" style="display:flex;align-items:center;gap:5px;">
                            <i class="fa fa-calendar"></i>
                            <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['reward']->value['created_at'],"%d/%m/%Y %H:%M");?>
</span>
                          </small>
                          <small class="text-success" style="display:flex;align-items:center;gap:5px;">
                            <i class="fa fa-check-circle"></i>
                            <span>Hoàn thành</span>
                          </small>
                        </div>
                      </div>
                    </div>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </div>
              <?php } else { ?>
                <div class="text-center py-5">
                  <i class="fa fa-history fa-4x text-muted mb-3"></i>
                  <h5 class="text-muted">Chưa có lịch sử thưởng</h5>
                  <p class="text-muted">Hoàn thành các nhiệm vụ đánh giá để nhận thưởng</p>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews" class="btn btn-primary" style="display:flex;align-items:center;gap:5px;">
                    <i class="fa fa-star"></i>
                    <span>Xem nhiệm vụ</span>
                  </a>
                </div>
              <?php }?>
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

<?php echo '<script'; ?>
>
  // Helper: detect Bootstrap version availability
  function hasBS5(){ return typeof bootstrap !== 'undefined' && bootstrap.Modal; }
  function hasJQModal(){ return typeof $ !== 'undefined' && $.fn && $.fn.modal; }

  // Open
  function showWithdrawModal() {
    var el = document.getElementById('withdrawModal');
    if (!el) return;

    if (hasBS5()) {
      var inst = bootstrap.Modal.getOrCreateInstance(el, {backdrop: true, keyboard: true});
      inst.show();
    } else if (hasJQModal()) {
      $('#withdrawModal').modal({backdrop: true, keyboard: true, show: true});
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
<?php echo '</script'; ?>
>

<!-- Loading and Animation Styles -->
<style>
/* Loading Overlay */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(5px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  transition: opacity 0.3s ease;
}

.loading-spinner {
  text-align: center;
  color: #007bff;
}

.loading-text {
  font-size: 1.1rem;
  font-weight: 600;
  color: #495057;
  animation: pulse 1.5s ease-in-out infinite;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
  border-width: 0.3em;
}

/* Card Hover Effects */
.card {
  transition: all 0.3s ease;
  transform: translateY(0);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Pulse Animation */
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}

/* Mobile Pills Navigation Styles */
.mobile-pills-nav {
  padding: 10px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 15px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.mobile-pills-nav .gap-2 > * {
  margin: 0.25rem;
}

.mobile-pills-nav .btn {
  font-size: 0.85rem;
  font-weight: 600;
  transition: all 0.3s ease;
  border-width: 2px;
  min-width: auto;
  white-space: nowrap;
}

.mobile-pills-nav .btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.mobile-pills-nav .btn-primary {
  background: linear-gradient(135deg, #007bff, #0056b3);
  border-color: #007bff;
  box-shadow: 0 2px 8px rgba(0,123,255,0.3);
}

.mobile-pills-nav .btn-outline-primary {
  color: #007bff;
  border-color: #007bff;
  background: rgba(255,255,255,0.9);
}

.mobile-pills-nav .btn-outline-primary:hover {
  background: #007bff;
  color: white;
}

.mobile-pills-nav .btn-outline-success {
  color: #28a745;
  border-color: #28a745;
  background: rgba(255,255,255,0.9);
}

.mobile-pills-nav .btn-outline-success:hover {
  background: #28a745;
  color: white;
}

@media (max-width: 576px) {
  .mobile-pills-nav .btn {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
  }
  
  .mobile-pills-nav .btn i {
    font-size: 0.75rem;
  }
}
</style>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
