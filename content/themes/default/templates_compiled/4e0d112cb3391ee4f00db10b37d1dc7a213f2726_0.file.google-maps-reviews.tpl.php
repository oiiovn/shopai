<?php
/* Smarty version 4.3.4, created on 2025-11-07 11:21:41
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/google-maps-reviews.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_690dd6457e5944_74126625',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e0d112cb3391ee4f00db10b37d1dc7a213f2726' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/google-maps-reviews.tpl',
      1 => 1761892713,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_690dd6457e5944_74126625 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),2=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
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
console.log('🚀 Google Maps Reviews template loaded!');
console.log('🔍 Current view:', '<?php echo $_smarty_tpl->tpl_vars['view']->value;?>
');
console.log('🔍 Available tasks count:', <?php if ($_smarty_tpl->tpl_vars['available_tasks']->value) {
echo smarty_modifier_count($_smarty_tpl->tpl_vars['available_tasks']->value);
} else { ?>0<?php }?>);

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

// Countup Animation
function animateCountup(element) {
  const target = parseInt(element.getAttribute('data-target'));
  const duration = 1000; // 1 second
  const increment = target / (duration / 16); // 60fps
  let current = 0;
  
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    element.textContent = Math.floor(current).toLocaleString('vi-VN');
  }, 16);
}

// Initialize animations when page loads
document.addEventListener('DOMContentLoaded', function() {
  // Animate dashboard cards
  setTimeout(() => {
    const countupElements = document.querySelectorAll('[data-animate="countup"]');
    countupElements.forEach((element, index) => {
      setTimeout(() => {
        animateCountup(element);
      }, index * 100);
    });
  }, 600);
  
  // Add stagger animation to dashboard cards
  const dashboardCards = document.querySelectorAll('#dashboardCards .col-md-3 .card');
  dashboardCards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    setTimeout(() => {
      card.style.transition = 'all 0.6s ease-out';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 150 + 300);
  });
});
<?php echo '</script'; ?>
>

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <!-- side panel -->

    <!-- google-maps-reviews sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar shop-ai-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
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
              <a href="javascript:void(0)" onclick="openTemplatesManager()">
                <i class="fa fa-magic main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Templates GPT
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
        <!-- main content -->
        <div class="col-12">
          <div class="card">
            <?php if ($_smarty_tpl->tpl_vars['view']->value == 'dashboard') {?>
              <div class="card-header bg-transparent">
                <strong>Bảng điều khiển</strong>
              </div>
              <div class="card-body">
                <div class="row" id="dashboardCards">
                  <div class="col-md-3">
                    <div class="card bg-primary text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0" data-animate="countup" data-target="<?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['user_requests']->value);?>
"><?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['user_requests']->value);?>
</h4>
                            <p class="mb-0">Chiến dịch đã tạo</p>
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
                            <h4 class="mb-0" data-animate="countup" data-target="<?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['user_reviews']->value);?>
"><?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['user_reviews']->value);?>
</h4>
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
                            <h4 class="mb-0" data-animate="countup" data-target="<?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['available_tasks']->value);?>
"><?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['available_tasks']->value);?>
</h4>
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
                            <h4 class="mb-0" data-animate="countup" data-target="<?php if ($_smarty_tpl->tpl_vars['reward_history']->value) {
$_smarty_tpl->_assignInScope('dashboard_total_earnings', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reward_history']->value, 'reward');
$_smarty_tpl->tpl_vars['reward']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->do_else = false;
$_smarty_tpl->_assignInScope('dashboard_total_earnings', $_smarty_tpl->tpl_vars['dashboard_total_earnings']->value+$_smarty_tpl->tpl_vars['reward']->value['reward_amount']);
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
echo $_smarty_tpl->tpl_vars['dashboard_total_earnings']->value;
} else { ?>0<?php }?>">
                              <?php if ($_smarty_tpl->tpl_vars['reward_history']->value) {?>
                                <?php $_smarty_tpl->_assignInScope('dashboard_total_earnings', 0);?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reward_history']->value, 'reward');
$_smarty_tpl->tpl_vars['reward']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->do_else = false;
?>
                                  <?php $_smarty_tpl->_assignInScope('dashboard_total_earnings', $_smarty_tpl->tpl_vars['dashboard_total_earnings']->value+$_smarty_tpl->tpl_vars['reward']->value['reward_amount']);?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php echo number_format($_smarty_tpl->tpl_vars['dashboard_total_earnings']->value,0,',','.');?>
 VND
                              <?php } else { ?>
                                0 VND
                              <?php }?>
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

            <?php if ($_smarty_tpl->tpl_vars['view']->value == 'my-requests') {?>
              <div class="card-header bg-transparent">
                <strong>Yêu cầu của tôi</strong>
              </div>
              <div class="card-body">
                <?php if ($_smarty_tpl->tpl_vars['user_requests']->value) {?>
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
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_requests']->value, 'request');
$_smarty_tpl->tpl_vars['request']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['request']->value) {
$_smarty_tpl->tpl_vars['request']->do_else = false;
?>
                          <tr>
                            <td>
                              <strong><?php echo $_smarty_tpl->tpl_vars['request']->value['place_name'];?>
</strong><br>
                              <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['request']->value['place_address'];?>
</small>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['request']->value['target_reviews'];?>
</td>
                            <td><strong class="text-danger"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['request']->value['total_budget'],0);?>
 VND</strong></td>
                            <td>
                              <div class="d-flex flex-column" style="min-width: 140px;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                  <small class="text-muted">
                                    <strong class="text-success"><?php echo $_smarty_tpl->tpl_vars['request']->value['completed_subs'];?>
</strong>/<?php echo $_smarty_tpl->tpl_vars['request']->value['total_valid_subs'];?>
 hoàn thành
                                  </small>
                                  <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['request']->value['progress_percent'];?>
%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $_smarty_tpl->tpl_vars['request']->value['progress_percent'];?>
%" aria-valuenow="<?php echo $_smarty_tpl->tpl_vars['request']->value['progress_percent'];?>
" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="badge badge-<?php if ($_smarty_tpl->tpl_vars['request']->value['completed_subs'] >= $_smarty_tpl->tpl_vars['request']->value['total_valid_subs'] && $_smarty_tpl->tpl_vars['request']->value['total_valid_subs'] > 0) {?>primary<?php } elseif ($_smarty_tpl->tpl_vars['request']->value['status'] == 'active') {?>success<?php } elseif ($_smarty_tpl->tpl_vars['request']->value['status'] == 'completed') {?>primary<?php } else { ?>secondary<?php }?> mt-1" style="font-size: 0.7rem;">
                                  <?php if ($_smarty_tpl->tpl_vars['request']->value['completed_subs'] >= $_smarty_tpl->tpl_vars['request']->value['total_valid_subs'] && $_smarty_tpl->tpl_vars['request']->value['total_valid_subs'] > 0) {?>Đã hoàn thành<?php } elseif ($_smarty_tpl->tpl_vars['request']->value['status'] == 'active') {?>Đang chạy<?php } elseif ($_smarty_tpl->tpl_vars['request']->value['status'] == 'completed') {?>Hoàn thành<?php } elseif ($_smarty_tpl->tpl_vars['request']->value['status'] == 'cancelled') {?>Đã hủy<?php } else { ?>Hết hạn<?php }?>
                                </span>
                              </div>
                            </td>
                            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['request']->value['created_at'],"%d/%m/%Y");?>
</td>
                            <td>
                              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/request-details/<?php echo $_smarty_tpl->tpl_vars['request']->value['request_id'];?>
" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fa fa-external-link-alt mr-1"></i>Xem chi tiết
                              </a>
                            </td>
                          </tr>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      </tbody>
                    </table>
                  </div>
                <?php } else { ?>
                  <div class="text-center py-4">
                    <i class="fa fa-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không tìm thấy yêu cầu nào</h5>
                    <p class="text-muted">Tạo yêu cầu đánh giá Google Maps đầu tiên của bạn</p>
                  </div>
                <?php }?>
              </div>
            <?php }?>


            <?php if ($_smarty_tpl->tpl_vars['view']->value == 'my-reviews') {?>
              <div class="card-header bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                  <strong>Nhiệm vụ đánh giá của tôi</strong>
                </div>
              </div>
              
              <!-- Tabs lọc trạng thái -->
              <div class="card-body border-bottom">
                <ul class="nav nav-pills nav-fill" id="statusTabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                      <i class="fa fa-list mr-1"></i>Tất cả
                      <span class="badge badge-light ml-1"><?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['assigned_tasks']->value);?>
</span>
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="assigned-tab" data-bs-toggle="pill" data-bs-target="#assigned" type="button" role="tab">
                      <i class="fa fa-hand-paper mr-1"></i>Đã nhận
                      <span class="badge badge-warning ml-1"><?php $_smarty_tpl->_assignInScope('assigned_count', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['assigned_tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'assigned') {
$_smarty_tpl->_assignInScope('assigned_count', $_smarty_tpl->tpl_vars['assigned_count']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
echo $_smarty_tpl->tpl_vars['assigned_count']->value;?>
</span>
                    </button>
                  </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="verified-tab" data-bs-toggle="pill" data-bs-target="#verified" type="button" role="tab">
                  <i class="fa fa-shield-alt mr-1"></i>Đang xác minh
                  <span class="badge badge-primary ml-1"><?php $_smarty_tpl->_assignInScope('verified_count', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['assigned_tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'verified') {
$_smarty_tpl->_assignInScope('verified_count', $_smarty_tpl->tpl_vars['verified_count']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
echo $_smarty_tpl->tpl_vars['verified_count']->value;?>
</span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                  <i class="fa fa-check-circle mr-1"></i>Hoàn thành
                  <span class="badge badge-success ml-1"><?php $_smarty_tpl->_assignInScope('completed_count', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['assigned_tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'completed') {
$_smarty_tpl->_assignInScope('completed_count', $_smarty_tpl->tpl_vars['completed_count']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
echo $_smarty_tpl->tpl_vars['completed_count']->value;?>
</span>
                </button>
              </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="expired-tab" data-bs-toggle="pill" data-bs-target="#expired" type="button" role="tab">
                      <i class="fa fa-times-circle mr-1"></i>Hết hạn
                      <span class="badge badge-danger ml-1"><?php $_smarty_tpl->_assignInScope('expired_count', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['assigned_tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'expired' || $_smarty_tpl->tpl_vars['task']->value['status'] == 'timeout') {
$_smarty_tpl->_assignInScope('expired_count', $_smarty_tpl->tpl_vars['expired_count']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
echo $_smarty_tpl->tpl_vars['expired_count']->value;?>
</span>
                    </button>
                  </li>
                </ul>
              </div>
              
              <!-- Tab content -->
              <div class="tab-content" id="statusTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                  <div class="card-body">
                    <?php if ($_smarty_tpl->tpl_vars['assigned_tasks']->value) {?>
                      <div class="row">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['assigned_tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
?>
                          <div class="col-md-6 col-lg-4 mb-3 task-card" data-status="<?php echo $_smarty_tpl->tpl_vars['task']->value['status'];?>
">
                            <div class="card h-100 shadow-sm">
                          <div class="card-body p-2">
                            <!-- Header với tên và trạng thái -->
                            <div class="d-flex justify-content-between align-items-start">
                              <h6 class="card-title mb-0" style="max-width: 180px; font-size: 0.75rem; line-height: 1.0;" title="<?php echo $_smarty_tpl->tpl_vars['task']->value['place_name'];?>
">
                                <?php echo $_smarty_tpl->tpl_vars['task']->value['place_name'];?>

                              </h6>
                              <span class="badge badge-<?php if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'assigned') {?>warning<?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'completed') {?>success<?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'verified') {?>primary<?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'timeout') {?>warning<?php } else { ?>danger<?php }?> badge-sm font-weight-bold">
                                <?php if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'assigned') {?>ĐÃ NHẬN<?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'completed') {?>HOÀN THÀNH<?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'verified') {?>ĐANG XÁC MINH<?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'timeout') {?>HẾT HẠN<?php } else { ?>THẤT BẠI<?php }?>
                              </span>
                            </div>
                            
                            <!-- Địa chỉ và thông tin -->
                            <div>
                              <p class="text-secondary mb-0" style="font-size: 0.6rem; line-height: 1.2;">
                                <i class="fa fa-map-marker-alt mr-1"></i>
                                <?php echo $_smarty_tpl->tpl_vars['task']->value['place_address'];?>

                              </p>
                              <div class="d-flex justify-content-between align-items-center mt-0">
                                <div class="text-success font-weight-bold" style="font-size: 0.65rem;">
                                  <i class="fa fa-money-bill-wave mr-1"></i>
                                  <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['task']->value['reward_amount'],0);?>
 VND
                                </div>
                                <div class="text-secondary" style="font-size: 0.55rem;">
                                  Hạn: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expires_at'],"%d/%m");?>

                                </div>
                              </div>
                              <!-- Ngày nhận nhiệm vụ ngay dưới ngày hết hạn -->
                              <?php if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'assigned') {?>
                                <div class="text-right mt-0">
                                  <small class="text-secondary" style="font-size: 0.5rem;">
                                    Nhận: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['assigned_at'],"%d/%m");?>

                                  </small>
                                </div>
                              <?php }?>
                            </div>
                            
                            <!-- Generated Review Content (GPT) with Countdown -->
                            <?php if (!empty($_smarty_tpl->tpl_vars['task']->value['generated_review_content']) && $_smarty_tpl->tpl_vars['task']->value['status'] == 'assigned') {?>
                              <div class="gpt-review-box gpt-box-loading" 
                                   id="gpt-box-<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
" 
                                   data-assigned-time="<?php echo $_smarty_tpl->tpl_vars['task']->value['assigned_at'];?>
"
                                   data-sub-request-id="<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
">
                                
                                <!-- Header with Countdown -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                  <div class="d-flex align-items-center">
                                    <span class="gpt-badge">
                                      <i class="fa fa-magic mr-1"></i>Đánh giá mẫu GPT
                                    </span>
                                    <span class="gpt-countdown ml-2" id="countdown-<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
">
                                      <i class="far fa-clock"></i> <span class="countdown-text">30:00</span>
                                    </span>
                                  </div>
                                </div>
                                
                                <!-- Review Content with Line Clamp -->
                                <div class="gpt-content-wrapper" id="wrapper-<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
">
                                  <div class="gpt-content line-clamp" id="content-<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
">
                                    <?php echo $_smarty_tpl->tpl_vars['task']->value['generated_review_content'];?>

                                  </div>
                                  <div class="gpt-fade"></div>
                                </div>
                                
                                <!-- Footer Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                  <div class="d-flex" style="gap: 0.3rem;">
                                    <button class="btn-gpt-action btn-copy" 
                                            onclick="copyReviewContent('<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
', this)">
                                      <i class="fa fa-copy mr-1"></i>Copy
                                    </button>
                                    <button class="btn-gpt-action btn-expand" 
                                            id="expand-btn-<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
"
                                            onclick="toggleReviewExpand('<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
')">
                                      <i class="fa fa-chevron-down mr-1"></i>Xem thêm
                                    </button>
                                  </div>
                                  <small class="gpt-char-count" id="char-count-<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
">
                                    0 ký tự
                                  </small>
                                </div>
                              </div>
                            <?php }?>
                            
                            <!-- Action buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                              <?php if ($_smarty_tpl->tpl_vars['task']->value['status'] == 'assigned') {?>
                                <div class="d-flex" style="gap: 0.1rem;">
                                  <?php if ($_smarty_tpl->tpl_vars['task']->value['place_url']) {?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['task']->value['place_url'];?>
" target="_blank" class="btn btn-primary btn-sm">
                                      <i class="fa fa-star mr-1"></i>Đánh giá 5 sao
                                    </a>
                                  <?php } else { ?>
                                    <a href="https://maps.google.com/?q=<?php echo rawurlencode((string)$_smarty_tpl->tpl_vars['task']->value['place_address']);?>
" target="_blank" class="btn btn-primary btn-sm">
                                      <i class="fa fa-star mr-1"></i>Đánh giá 5 sao
                                    </a>
                                  <?php }?>
                                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/submit-proof/<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-camera mr-1"></i>Gửi bằng chứng
                                  </a>
                                </div>
                              <?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'completed') {?>
                                <div class="d-flex align-items-center" style="gap: 0.1rem;">
                                  <span class="text-success small font-weight-bold">
                                    <i class="fa fa-check-circle mr-1"></i>Đã hoàn thành
                                  </span>
                                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/reward-history" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-gift mr-1"></i>Xem thưởng
                                  </a>
                                </div>
                                <small class="text-secondary" style="font-size: 0.6rem;">
                                  <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['completed_at'],"%d/%m");?>

                                </small>
                              <?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'verified') {?>
                                <div class="d-flex align-items-center" style="gap: 0.1rem;">
                                  <span class="text-primary small font-weight-bold">
                                    <i class="fa fa-shield-alt mr-1"></i>Đang xác minh
                                  </span>
                                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/view-proof/<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
" class="btn btn-outline-info btn-sm">
                                    <i class="fa fa-eye mr-1"></i>Xem bằng chứng
                                  </a>
                                </div>
                                <small class="text-secondary" style="font-size: 0.6rem;">
                                  <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['verified_at'],"%d/%m");?>

                                </small>
                              <?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'timeout') {?>
                                <?php if ($_smarty_tpl->tpl_vars['task']->value['verification_notes']) {?>
                                  <small class="text-muted" style="font-size: 0.75rem;">
                                    <?php echo $_smarty_tpl->tpl_vars['task']->value['verification_notes'];?>

                                  </small>
                                <?php } else { ?>
                                  <div class="d-flex align-items-center" style="gap: 0.1rem;">
                                    <span class="text-warning small font-weight-bold">
                                      <i class="fa fa-clock mr-1"></i>Hết hạn
                                    </span>
                                  </div>
                                <?php }?>
                                <small class="text-secondary" style="font-size: 0.6rem;">
                                  <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expired_at'],"%d/%m");?>

                                </small>
                              <?php } elseif ($_smarty_tpl->tpl_vars['task']->value['status'] == 'expired') {?>
                                <div></div>
                                <div class="d-flex flex-column align-items-end" style="gap: 0.2rem;">
                                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/view-penalty/<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
" class="btn btn-outline-danger btn-sm" style="padding: 0.35rem 0.7rem;">
                                    <i class="fa fa-exclamation-triangle" style="margin-right: 0.4rem;"></i>Xem chi tiết
                                  </a>
                                  <small class="text-secondary" style="font-size: 0.6rem;">
                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expired_at'],"%d/%m");?>

                                  </small>
                                </div>
                              <?php } else { ?>
                                <?php if ($_smarty_tpl->tpl_vars['task']->value['verification_notes']) {?>
                                  <small class="text-muted" style="font-size: 0.75rem;">
                                    <?php echo $_smarty_tpl->tpl_vars['task']->value['verification_notes'];?>

                                  </small>
                                <?php } else { ?>
                                  <small class="text-muted" style="font-size: 0.75rem;">
                                    Hết hạn: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expires_at'],"%d/%m");?>

                                  </small>
                                <?php }?>
                              <?php }?>
                            </div>
                          </div>
                            </div>
                          </div>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      </div>
                      
                      <!-- Pagination -->
                      <?php if ($_smarty_tpl->tpl_vars['total_pages']->value > 1) {?>
                        <div class="d-flex justify-content-center mt-4">
                          <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm">
                              <?php if ($_smarty_tpl->tpl_vars['current_page']->value > 1) {?>
                                <li class="page-item">
                                  <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['current_page']->value-1;?>
" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                  </a>
                                </li>
                              <?php }?>
                              
                              <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['total_pages']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['total_pages']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                                <li class="page-item <?php if ($_smarty_tpl->tpl_vars['i']->value == $_smarty_tpl->tpl_vars['current_page']->value) {?>active<?php }?>">
                                  <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                                </li>
                              <?php }
}
?>
                              
                              <?php if ($_smarty_tpl->tpl_vars['current_page']->value < $_smarty_tpl->tpl_vars['total_pages']->value) {?>
                                <li class="page-item">
                                  <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['current_page']->value+1;?>
" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                  </a>
                                </li>
                              <?php }?>
                            </ul>
                          </nav>
                        </div>
                      <?php }?>
                    <?php } else { ?>
                      <div class="text-center py-4">
                        <i class="fa fa-tasks fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có nhiệm vụ nào</h5>
                        <p class="text-muted">Bạn chưa nhận nhiệm vụ đánh giá nào.</p>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/dashboard" class="btn btn-primary">
                          <i class="fa fa-search mr-1"></i>Tìm nhiệm vụ
                        </a>
                      </div>
                    <?php }?>
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
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['view']->value == 'create-request') {?>
              <div class="card-header bg-transparent">
                <strong>Tạo chiến dịch đánh giá</strong>
              </div>
              <div class="card-body">

                <!-- Số dư Wallet Card -->
                <div class="mf-wallet-card mb-4">
                  <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                      <div class="mf-wallet-icon">
                        <i class="fa fa-wallet"></i>
                      </div>
                      <div class="ml-4">
                        <small class="d-block mb-2" style="font-size: 0.85rem; opacity: 0.9;">Số dư ví của bạn</small>
                        <h3 class="mb-0 font-weight-bold" style="letter-spacing: 0.5px;">
                          <span id="currentBalance"><?php echo number_format($_smarty_tpl->tpl_vars['user_wallet_balance']->value,0,',','.');?>
</span> <small style="font-size: 0.65em; font-weight: 500; opacity: 0.9;">VNĐ</small>
                        </h3>
                      </div>
                    </div>
                    <div class="ml-md-4">
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai/recharge" class="btn btn-sm btn-outline-primary" style="border-radius: 20px; padding: 0.5rem 1.5rem; min-width: 110px;">
                        <i class="fa fa-plus-circle mr-2"></i>Nạp tiền
                      </a>
                    </div>
                  </div>
                </div>

                <!-- THÊM class form-modern -->
                <form id="createRequestForm" class="form-modern">
                  
                  <!-- Dropdown chọn địa điểm đã tạo -->
                  <div class="mf-group">
                    <select class="form-control" id="previous_place_selector" style="cursor: pointer;">
                      <option value="">-- Chọn địa điểm đã tạo trước đó (hoặc nhập mới bên dưới) --</option>
                    </select>
                    <label for="previous_place_selector" style="font-size: 0.9rem; color: #007bff;">
                      ⚡ Điền nhanh từ địa điểm cũ
                    </label>
                    <small class="mf-hint">
                      <i class="fa fa-lightbulb-o"></i> Chọn để tự động điền thông tin, tiết kiệm thời gian!
                    </small>
                  </div>

                  <div style="text-align: center; margin: 20px 0; color: #94a3b8; font-size: 0.85rem;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                      <div style="flex: 1; height: 1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent);"></div>
                      <span>hoặc nhập thông tin mới</span>
                      <div style="flex: 1; height: 1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent);"></div>
                    </div>
                  </div>

                  <div class="row g-16">
                    <div class="col-md-6">
                      <div class="mf-group">
                        <input type="text" class="form-control" id="place_name" name="place_name" placeholder=" " required>
                        <label for="place_name">Tên địa điểm</label>
                        <small class="mf-hint">Tên hiển thị trên Google Maps</small>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="mf-group">
                        <input type="url" class="form-control" id="place_url" name="place_url" placeholder=" " required>
                        <label for="place_url">URL địa điểm</label>
                        <small class="mf-hint">Dán liên kết Google Maps/Place</small>
                      </div>
                    </div>
                  </div>

                  <div class="mf-group">
                    <textarea class="form-control" id="place_address" name="place_address" rows="2" placeholder=" " required></textarea>
                    <label for="place_address">Địa chỉ</label>
                  </div>

                  <!-- GPT Template Selector -->
                  <div class="mf-group">
                    <select class="form-control" id="gpt_template_selector" style="cursor: pointer;">
                      <option value="">-- Chọn Template GPT (hoặc tự nhập bên dưới) --</option>
                    </select>
                    <label for="gpt_template_selector" style="font-size: 0.9rem; color: #667eea;">
                      <i class="fa fa-magic mr-1"></i> Template Hướng Dẫn GPT
                    </label>
                    <small class="mf-hint">
                      <i class="fa fa-lightbulb-o mr-1"></i> Chọn template hoặc 
                      <a href="javascript:void(0)" onclick="openTemplatesManager()" style="color: #007bff; font-weight: 600;">
                        tạo template mới
                      </a>
                    </small>
                  </div>

                  <!-- Hướng dẫn GPT -->
                  <div class="mf-group">
                    <textarea class="form-control" id="gpt_instructions" name="gpt_instructions" rows="3" placeholder=" "></textarea>
                    <label for="gpt_instructions">
                      Hướng Dẫn Cho GPT
                    </label>
                    <small class="mf-hint">
                      Hướng dẫn chung cho GPT về tone, phong cách, yêu cầu khi tạo review.
                    </small>
                  </div>

                  <!-- Đánh giá mẫu -->
                  <div class="mf-group">
                    <textarea class="form-control" id="review_template" name="review_template" rows="4" placeholder=" "></textarea>
                    <label for="review_template">
                      Đánh Giá Mẫu (Gợi Ý Cho GPT)
                    </label>
                    <small class="mf-hint">
                      Nội dung review mẫu cụ thể để GPT tham khảo và render theo phong cách tương tự.
                    </small>
                  </div>

                  <div class="row g-16">
                    <div class="col-md-4">
                      <div class="mf-group">
                        <input type="number" class="form-control" id="reward_amount" name="reward_amount" value="10000" readonly placeholder=" ">
                        <label for="reward_amount">Chi phí 1 đánh giá 5★</label>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="mf-group">
                        <input type="number" class="form-control" id="target_reviews" name="target_reviews" min="1" max="100" value="1" required placeholder=" " onchange="calculateTotal()">
                        <label for="target_reviews">Số lượng đánh giá</label>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="mf-group">
                        <input type="datetime-local" class="form-control" id="expires_at" name="expires_at" required placeholder=" ">
                        <label for="expires_at">Hết hạn lúc</label>
                      </div>
                    </div>
                  </div>

                  <!-- Hóa đơn -->
                  <div class="mf-invoice card bg-light mb-4">
                    <div class="card-body">
                      <h6 class="card-title">Hóa đơn chiến dịch</h6>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="mb-1">Chi phí 1 đánh giá: <span id="rewardAmount">10,000</span> VND</p>
                          <p class="mb-1">Số lượng đánh giá: <span id="quantity">1</span></p>
                        </div>
                        <div class="col-md-6">
                          <p class="mb-1"><strong>Tổng chi phí: <span id="totalCost">10,000</span> VND</strong></p>
                          <p class="mb-1">Số dư sau khi trừ: <span id="remainingBalance">0</span> VND</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Warning khi không đủ tiền -->
                  <div id="balanceWarning" class="alert alert-danger mf-balance-warning mb-3" style="display:none;">
                    <div class="d-flex align-items-center">
                      <div class="mr-3">
                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 font-weight-bold">Số dư không đủ!</h6>
                        <p class="mb-0" style="font-size: 0.9rem;">
                          Bạn cần nạp thêm tiền để tạo chiến dịch này. 
                          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai/recharge" class="alert-link font-weight-bold">Nạp tiền ngay</a>
                        </p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary mf-btn btn-lg px-5" id="createButton" disabled>
                      <i class="fa fa-rocket mr-2"></i>Tạo Chiến Dịch Ngay
                    </button>
                  </div>
                </form>
              </div>
            <?php }?>
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
    padding: 16px 12px;
    background: #fff;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    position: relative;
    height: 112px;
    min-height: 112px;
    max-height: 112px;
    width: 100%;
    box-sizing: border-box;
    margin: 8px 0;
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
    margin-top: 8px;
    margin-bottom: 4px;
}

.review-task-mini-card-horizontal .task-details {
    display: flex;
    align-items: center;
    gap: 4px;
}

.review-task-mini-card-horizontal .task-avatar {
    margin-right: 8px;
    width: 32px;
    height: 32px;
    min-width: 32px;
    min-height: 32px;
    flex-shrink: 0;
}

.review-task-mini-card-horizontal .task-avatar img {
    width: 32px !important;
    height: 32px !important;
    min-width: 32px;
    min-height: 32px;
    max-width: 32px;
    max-height: 32px;
    border: 1px solid #e9ecef;
    object-fit: cover;
    display: block;
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
    background-color: #1877F2 !important;
    border-color: #1877F2 !important;
    color: #fff !important;
}

.review-task-mini-card-horizontal .btn:hover {
    background-color: #166fe5 !important;
    border-color: #166fe5 !important;
}

/* Facebook-style sponsored badge */
.sponsored-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.05);
    color: #8e8e8e;
    font-size: 8px;
    font-weight: 400;
    padding: 1px 4px;
    border-radius: 2px;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(0, 0, 0, 0.02);
    text-transform: none;
    letter-spacing: 0.2px;
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
    padding: 0 0 9px 0;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

/* Card body for review tasks */
.review-tasks-horizontal-scroll + * .card-body,
.card-body:has(.review-tasks-horizontal-scroll) {
    padding: 9px !important;
}

/* Remove bottom padding for card-header with bg-transparent border-bottom-0 */
.card-header.bg-transparent.border-bottom-0 {
    padding-bottom: 0 !important;
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
    height: 120px;
}
</style>

<?php echo '<script'; ?>
>
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
  
  // Load previous places for quick fill
  loadPreviousPlaces();
  
  // Load GPT templates for quick selection
  loadGPTTemplatesDropdown();
  
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
      
      fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php', {
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
      createButton.innerHTML = '<i class="fa fa-rocket mr-2"></i>Tạo Chiến Dịch Ngay';
      if (balanceWarning) {
        balanceWarning.style.display = 'none';
        balanceWarning.classList.remove('show');
      }
    } else {
      createButton.disabled = true;
      createButton.innerHTML = '<i class="fa fa-lock mr-2"></i>Số Dư Không Đủ';
      if (balanceWarning) {
        balanceWarning.style.display = 'block';
        // Trigger animation
        setTimeout(function() {
          balanceWarning.classList.add('show');
        }, 10);
      }
    }
  }
}

/**
 * Load previous places from database
 */
function loadPreviousPlaces() {
  console.log('🔍 Loading previous places...');
  
  var selector = document.getElementById('previous_place_selector');
  if (!selector) {
    console.log('❌ Selector not found');
    return;
  }
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php?action=get_user_places', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    console.log('✅ Places loaded:', data);
    
    if (data.success && data.places && data.places.length > 0) {
      // Clear existing options except first one
      selector.innerHTML = '<option value="">-- Chọn địa điểm đã tạo trước đó (hoặc nhập mới bên dưới) --</option>';
      
      // Add places to dropdown
      data.places.forEach(function(place, index) {
        var option = document.createElement('option');
        option.value = index;
        option.textContent = place.place_name + ' - ' + (place.place_address.substring(0, 50) + '...');
        option.setAttribute('data-place', JSON.stringify(place));
        selector.appendChild(option);
      });
      
      console.log('✅ Added ' + data.places.length + ' places to dropdown');
      
      // Add change event listener
      selector.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value !== '') {
          var placeData = JSON.parse(selectedOption.getAttribute('data-place'));
          fillFormWithPlace(placeData);
        }
      });
      
    } else {
      console.log('ℹ️ No previous places found');
    }
  })
  .catch(error => {
    console.error('❌ Error loading places:', error);
  });
}

/**
 * Fill form with selected place data
 */
function fillFormWithPlace(place) {
  console.log('📝 Filling form with place:', place);
  
  // Fill form fields
  var placeNameField = document.getElementById('place_name');
  var placeUrlField = document.getElementById('place_url');
  var placeAddressField = document.getElementById('place_address');
  var reviewTemplateField = document.getElementById('review_template');
  
  if (placeNameField) {
    placeNameField.value = place.place_name || '';
    // Trigger event to update floating label
    placeNameField.dispatchEvent(new Event('input'));
    placeNameField.dispatchEvent(new Event('change'));
  }
  
  if (placeUrlField) {
    placeUrlField.value = place.place_url || '';
    placeUrlField.dispatchEvent(new Event('input'));
    placeUrlField.dispatchEvent(new Event('change'));
  }
  
  if (placeAddressField) {
    placeAddressField.value = place.place_address || '';
    placeAddressField.dispatchEvent(new Event('input'));
    placeAddressField.dispatchEvent(new Event('change'));
  }
  
  if (reviewTemplateField) {
    reviewTemplateField.value = place.review_template || '';
    reviewTemplateField.dispatchEvent(new Event('input'));
    reviewTemplateField.dispatchEvent(new Event('change'));
  }
  
  console.log('✅ Form filled successfully');
  
  // Show success notification
  var notification = document.createElement('div');
  notification.style.cssText = 'position: fixed; top: 80px; right: 20px; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3); z-index: 9999; font-size: 14px; animation: slideInRight 0.3s ease-out;';
  notification.innerHTML = '<i class="fa fa-check-circle mr-2"></i>Đã điền thông tin địa điểm: ' + place.place_name;
  document.body.appendChild(notification);
  
  // Remove notification after 3 seconds
  setTimeout(function() {
    notification.style.animation = 'slideOutRight 0.3s ease-out';
    setTimeout(function() {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

/**
 * Load GPT Templates into dropdown
 */
function loadGPTTemplatesDropdown() {
  console.log('🎨 Loading GPT templates dropdown...');
  
  var selector = document.getElementById('gpt_template_selector');
  if (!selector) {
    console.log('❌ GPT Template selector not found');
    return;
  }
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php?action=get_templates', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    console.log('✅ GPT Templates loaded:', data);
    
    if (data.success && data.templates && data.templates.length > 0) {
      // Clear existing options except first one
      selector.innerHTML = '<option value="">-- Chọn Template GPT (hoặc tự nhập bên dưới) --</option>';
      
      // Add templates to dropdown
      var defaultTemplateId = null;
      data.templates.forEach(function(template, index) {
        var option = document.createElement('option');
        option.value = template.template_id;
        option.textContent = template.template_name + (template.is_default == 1 ? ' ⭐' : '');
        option.setAttribute('data-template', JSON.stringify(template));
        selector.appendChild(option);
        
        // Track default template
        if (template.is_default == 1) {
          defaultTemplateId = template.template_id;
        }
      });
      
      console.log('✅ Added ' + data.templates.length + ' templates to dropdown');
      
      // Auto-select default template if exists
      if (defaultTemplateId) {
        selector.value = defaultTemplateId;
        var selectedOption = selector.options[selector.selectedIndex];
        var templateData = JSON.parse(selectedOption.getAttribute('data-template'));
        fillGPTInstructionsField(templateData);
        console.log('✅ Auto-selected default template:', templateData.template_name);
      }
      
      // Add change event listener
      selector.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value !== '') {
          var templateData = JSON.parse(selectedOption.getAttribute('data-template'));
          fillGPTInstructionsField(templateData);
        }
      });
      
    } else {
      console.log('ℹ️ No GPT templates found');
    }
  })
  .catch(error => {
    console.error('❌ Error loading GPT templates:', error);
  });
}

/**
 * Fill review_template field with selected GPT template
 */
function fillGPTInstructionsField(template) {
  console.log('📝 Filling GPT instructions with:', template);
  
  var gptInstructionsField = document.getElementById('gpt_instructions');
  
  if (gptInstructionsField) {
    gptInstructionsField.value = template.gpt_prompt || '';
    // Trigger event to update floating label
    gptInstructionsField.dispatchEvent(new Event('input'));
    gptInstructionsField.dispatchEvent(new Event('change'));
  }
  
  console.log('✅ GPT instructions filled successfully');
  
  // Show success notification
  var notification = document.createElement('div');
  notification.style.cssText = 'position: fixed; top: 80px; right: 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); z-index: 9999; font-size: 14px; animation: slideInRight 0.3s ease-out;';
  notification.innerHTML = '<i class="fa fa-magic mr-2"></i>Đã áp dụng template: ' + template.template_name;
  document.body.appendChild(notification);
  
  // Remove notification after 3 seconds
  setTimeout(function() {
    notification.style.animation = 'slideOutRight 0.3s ease-out';
    setTimeout(function() {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
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
        '• API URL: <?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php\n' +
        '• Timestamp: ' + new Date().toLocaleString());
  
  // Chỉ xử lý cho modal - gửi request và ghi vào database
  var apiUrl = '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php';
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
        window.location.href = '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews';
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

// ===============================
// Modern Form Kit - Auto floating labels
// ===============================
document.addEventListener('DOMContentLoaded', function(){
  if(!document.querySelector('.form-modern')) return;
  document.querySelectorAll('.form-modern .form-control').forEach(function(el){
    // Nếu input đã có value do server render -> đảm bảo label nổi
    if(el.value) el.dispatchEvent(new Event('focus'));
    el.addEventListener('blur', function(){
      // blur để trả label về trạng thái đúng khi rời focus
    });
  });
});

// ==================================================
// GPT TEMPLATES MANAGER FUNCTIONS
// ==================================================

/**
 * Open Templates Manager Modal
 */
function openTemplatesManager() {
  console.log('🎨 Opening Templates Manager...');
  
  var modal = document.getElementById('templatesManagerModal');
  if (modal) {
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
    
    // Add backdrop if not exists
    if (!document.getElementById('templatesManagerBackdrop')) {
      var backdrop = document.createElement('div');
      backdrop.className = 'modal-backdrop fade show';
      backdrop.id = 'templatesManagerBackdrop';
      document.body.appendChild(backdrop);
      
      // Close on backdrop click
      backdrop.onclick = function() {
        closeTemplatesManager();
      };
    }
    
    // Add click handlers for close buttons
    var closeButtons = modal.querySelectorAll('[data-dismiss="modal"]');
    closeButtons.forEach(function(btn) {
      btn.onclick = function() {
        closeTemplatesManager();
      };
    });
  }
  
  loadTemplates();
}

/**
 * Close Templates Manager Modal
 */
function closeTemplatesManager() {
  console.log('🚪 Closing Templates Manager...');
  
  var modal = document.getElementById('templatesManagerModal');
  if (modal) {
    modal.style.display = 'none';
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
  }
  
  // Remove backdrop
  var backdrop = document.getElementById('templatesManagerBackdrop');
  if (backdrop) {
    backdrop.remove();
  }
}

/**
 * Load user's templates
 */
function loadTemplates() {
  console.log('📥 Loading templates...');
  
  var listContainer = document.getElementById('templatesList');
  if (!listContainer) return;
  
  // Show loading
  listContainer.innerHTML = '<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x text-muted"></i><p class="mt-3 text-muted">Đang tải templates...</p></div>';
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php?action=get_templates', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
  })
  .then(response => response.json())
  .then(data => {
    console.log('✅ Templates loaded:', data);
    
    if (data.success && data.templates) {
      if (data.templates.length === 0) {
        listContainer.innerHTML = `
          <div class="text-center py-5">
            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
            <p class="text-muted">Chưa có template nào. Tạo template đầu tiên nhé!</p>
            <button class="btn btn-primary mt-3" onclick="openTemplateEditor()">
              <i class="fa fa-plus mr-1"></i> Tạo Template Đầu Tiên
            </button>
          </div>
        `;
      } else {
        renderTemplates(data.templates);
      }
    } else {
      listContainer.innerHTML = '<div class="alert alert-danger">Lỗi: ' + (data.error || 'Không thể tải templates') + '</div>';
    }
  })
  .catch(error => {
    console.error('❌ Error loading templates:', error);
    listContainer.innerHTML = '<div class="alert alert-danger">Đã xảy ra lỗi khi tải templates</div>';
  });
}

/**
 * Render templates list
 */
function renderTemplates(templates) {
  var listContainer = document.getElementById('templatesList');
  if (!listContainer) return;
  
  var html = '';
  templates.forEach(function(tpl) {
    var isDefault = tpl.is_default == 1;
    var cardClass = isDefault ? 'template-card default-template' : 'template-card';
    var starIcon = isDefault ? '<i class="fa fa-star mr-1" style="color: #f59e0b;"></i>' : '';
    var defaultBadge = isDefault ? '<span class="template-badge default"><i class="fa fa-star mr-1"></i>Mặc định</span>' : '';
    var usageCount = tpl.usage_count || 0;
    var description = tpl.template_description ? '<div class="template-description">' + escapeHtml(tpl.template_description) + '</div>' : '';
    var setDefaultBtn = !isDefault ? '<button class="btn btn-sm btn-warning" onclick="setAsDefaultTemplate(' + tpl.template_id + ')"><i class="fa fa-star mr-1"></i> Đặt mặc định</button>' : '';
    
    html += '<div class="' + cardClass + '">' +
      '<div class="template-header">' +
        '<div>' +
          '<div class="template-name">' +
            starIcon + escapeHtml(tpl.template_name) +
          '</div>' +
          description +
        '</div>' +
        '<div>' +
          defaultBadge +
          '<span class="template-badge usage"><i class="fa fa-chart-line mr-1"></i>' + usageCount + ' lần</span>' +
        '</div>' +
      '</div>' +
      '<div class="template-prompt">' +
        '<strong><i class="fa fa-comment mr-1"></i>Hướng dẫn GPT:</strong><br>' +
        escapeHtml(tpl.gpt_prompt) +
      '</div>' +
      '<div class="template-actions">' +
        '<button class="btn btn-sm btn-info" onclick="editTemplate(' + tpl.template_id + ')">' +
          '<i class="fa fa-edit mr-1"></i> Sửa' +
        '</button>' +
        setDefaultBtn +
        '<button class="btn btn-sm btn-danger" onclick="deleteTemplate(' + tpl.template_id + ', \'' + escapeHtml(tpl.template_name) + '\')">' +
          '<i class="fa fa-trash mr-1"></i> Xóa' +
        '</button>' +
      '</div>' +
    '</div>';
  });
  
  listContainer.innerHTML = html;
}

/**
 * Open Template Editor (Create or Edit)
 */
function openTemplateEditor(templateId) {
  console.log('✏️ Opening template editor for ID:', templateId);
  
  // Hide templates manager modal first
  closeTemplatesManager();
  
  // Show template editor modal
  var editorModal = document.getElementById('templateEditorModal');
  if (!editorModal) {
    console.error('❌ Template editor modal not found');
    return;
  }
  
  editorModal.style.display = 'block';
  editorModal.classList.add('show');
  document.body.classList.add('modal-open');
  
  // Add backdrop
  if (!document.getElementById('editorModalBackdrop')) {
    var backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.id = 'editorModalBackdrop';
    document.body.appendChild(backdrop);
  }
  
  // Add click handlers for close buttons
  var closeButtons = editorModal.querySelectorAll('[data-dismiss="modal"]');
  closeButtons.forEach(function(btn) {
    btn.onclick = function() {
      closeTemplateEditor();
    };
  });
  
  // Close when clicking outside modal
  editorModal.onclick = function(e) {
    if (e.target === editorModal) {
      closeTemplateEditor();
    }
  };
  
  // Reset form
  var form = document.getElementById('templateEditorForm');
  if (form) {
    form.reset();
  }
  document.getElementById('edit_template_id').value = '';
  
  if (templateId) {
    // Edit mode: Load template data
    document.getElementById('templateEditorTitle').innerHTML = '<i class="fa fa-edit mr-2"></i>Chỉnh Sửa Template';
    
    // Show loading overlay (không thay đổi innerHTML)
    showEditorLoading(true);
    
    // Find template from current list
    fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php?action=get_templates', {
      method: 'GET',
      credentials: 'same-origin'
    })
    .then(response => {
      console.log('📥 Get templates response:', response.status);
      return response.json();
    })
    .then(data => {
      console.log('📄 Templates data:', data);
      
      // Hide loading
      showEditorLoading(false);
      
      if (data.success && data.templates) {
        var template = data.templates.find(t => t.template_id == templateId);
        if (template) {
          // Fill form with template data
          document.getElementById('edit_template_id').value = template.template_id;
          document.getElementById('edit_template_name').value = template.template_name;
          document.getElementById('edit_template_description').value = template.template_description || '';
          document.getElementById('edit_gpt_prompt').value = template.gpt_prompt;
          document.getElementById('edit_is_default').checked = template.is_default == 1;
        } else {
          showNotification('error', 'Không tìm thấy template');
          closeTemplateEditor();
        }
      } else {
        showNotification('error', 'Lỗi tải dữ liệu template: ' + (data.error || 'Unknown'));
        closeTemplateEditor();
      }
    })
    .catch(error => {
      console.error('❌ Error loading template:', error);
      showEditorLoading(false);
      showNotification('error', 'Đã xảy ra lỗi khi tải template: ' + error.message);
      closeTemplateEditor();
    });
  } else {
    // Create mode
    document.getElementById('templateEditorTitle').innerHTML = '<i class="fa fa-plus mr-2"></i>Tạo Template Mới';
  }
}

/**
 * Show/Hide loading overlay in editor
 */
function showEditorLoading(show) {
  var overlay = document.getElementById('editorLoadingOverlay');
  
  if (show) {
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.id = 'editorLoadingOverlay';
      overlay.style.cssText = 'position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; z-index: 1000;';
      overlay.innerHTML = '<div class="text-center"><i class="fa fa-spinner fa-spin fa-3x text-primary"></i><p class="mt-3">Đang tải dữ liệu...</p></div>';
      
      var modalBody = document.querySelector('#templateEditorModal .modal-body');
      if (modalBody) {
        modalBody.style.position = 'relative';
        modalBody.appendChild(overlay);
      }
    }
    overlay.style.display = 'flex';
  } else {
    if (overlay) {
      overlay.style.display = 'none';
    }
  }
}

/**
 * Close Template Editor Modal
 */
function closeTemplateEditor() {
  var editorModal = document.getElementById('templateEditorModal');
  if (editorModal) {
    editorModal.style.display = 'none';
    editorModal.classList.remove('show');
    document.body.classList.remove('modal-open');
  }
  
  // Remove backdrop
  var backdrop = document.getElementById('editorModalBackdrop');
  if (backdrop) {
    backdrop.remove();
  }
  
  // Show templates manager modal back
  openTemplatesManager();
}

/**
 * Save Template (Create or Update)
 */
function saveTemplate() {
  console.log('💾 Saving template...');
  
  var form = document.getElementById('templateEditorForm');
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  
  // Get save button and show loading
  var saveBtn = document.querySelector('#templateEditorModal button[onclick="saveTemplate()"]');
  if (!saveBtn) {
    saveBtn = document.querySelector('#templateEditorModal .btn-primary');
  }
  
  var originalHtml = saveBtn ? saveBtn.innerHTML : '';
  if (saveBtn) {
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Đang lưu...';
  }
  
  var formData = new FormData(form);
  var templateId = document.getElementById('edit_template_id').value;
  var action = templateId ? 'update_template' : 'create_template';
  formData.append('action', action);
  
  console.log('📤 Sending', action, 'request...');
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php', {
    method: 'POST',
    body: formData,
    credentials: 'same-origin'
  })
  .then(response => {
    console.log('📥 Response status:', response.status);
    if (!response.ok) {
      throw new Error('HTTP error! status: ' + response.status);
    }
    return response.json();
  })
  .then(data => {
    console.log('✅ Save response:', data);
    
    if (data.success) {
      // Show success message
      showNotification('success', data.message || 'Lưu template thành công!');
      
      // Close editor modal
      closeTemplateEditor();
      
      // Reload templates list
      loadTemplates();
    } else {
      showNotification('error', data.error || 'Không thể lưu template');
    }
  })
  .catch(error => {
    console.error('❌ Error saving template:', error);
    showNotification('error', 'Đã xảy ra lỗi khi lưu template: ' + error.message);
  })
  .finally(() => {
    // Reset button
    if (saveBtn) {
      saveBtn.disabled = false;
      saveBtn.innerHTML = originalHtml;
    }
  });
}

/**
 * Edit Template
 */
function editTemplate(templateId) {
  openTemplateEditor(templateId);
}

/**
 * Delete Template - Show confirmation modal
 */
function deleteTemplate(templateId, templateName) {
  console.log('🗑️ Preparing to delete template:', templateId, templateName);
  
  // Store data for confirmation
  window.pendingDeleteTemplate = {
    id: templateId,
    name: templateName
  };
  
  // Update modal content
  document.getElementById('deleteTemplateName').textContent = templateName;
  
  // Show modal
  var deleteModal = document.getElementById('deleteTemplateModal');
  if (deleteModal) {
    deleteModal.style.display = 'block';
    deleteModal.classList.add('show');
    document.body.classList.add('modal-open');
    
    // Add backdrop
    var backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.id = 'deleteModalBackdrop';
    document.body.appendChild(backdrop);
  }
}

/**
 * Confirm Delete Template - Actually delete
 */
function confirmDeleteTemplate() {
  if (!window.pendingDeleteTemplate) {
    console.error('❌ No pending delete operation');
    return;
  }
  
  var templateId = window.pendingDeleteTemplate.id;
  var templateName = window.pendingDeleteTemplate.name;
  
  console.log('🗑️ Confirming delete for template:', templateId);
  
  // Disable button and show loading
  var confirmBtn = document.getElementById('confirmDeleteBtn');
  var originalHtml = confirmBtn.innerHTML;
  confirmBtn.disabled = true;
  confirmBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Đang xóa...';
  
  var formData = new FormData();
  formData.append('action', 'delete_template');
  formData.append('template_id', templateId);
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php', {
    method: 'POST',
    body: formData,
    credentials: 'same-origin'
  })
  .then(response => response.json())
  .then(data => {
    console.log('✅ Delete response:', data);
    
    // Close modal
    closeDeleteModal();
    
    if (data.success) {
      // Show success message
      showNotification('success', data.message || 'Xóa template thành công!');
      // Reload templates list
      loadTemplates();
    } else {
      showNotification('error', data.error || 'Không thể xóa template');
    }
  })
  .catch(error => {
    console.error('❌ Error deleting template:', error);
    closeDeleteModal();
    showNotification('error', 'Đã xảy ra lỗi khi xóa template');
  })
  .finally(() => {
    // Reset button
    confirmBtn.disabled = false;
    confirmBtn.innerHTML = originalHtml;
    window.pendingDeleteTemplate = null;
  });
}

/**
 * Close Delete Modal
 */
function closeDeleteModal() {
  var deleteModal = document.getElementById('deleteTemplateModal');
  if (deleteModal) {
    deleteModal.style.display = 'none';
    deleteModal.classList.remove('show');
    document.body.classList.remove('modal-open');
  }
  
  // Remove backdrop
  var backdrop = document.getElementById('deleteModalBackdrop');
  if (backdrop) {
    backdrop.remove();
  }
  
  window.pendingDeleteTemplate = null;
}

/**
 * Show Notification using system modal
 */
function showNotification(type, message) {
  console.log('📢 Notification:', type, message);
  
  if (typeof modal === 'function') {
    // Use system modal if available
    if (type === 'success') {
      modal('#modal-success', {
        title: 'Thành công',
        message: message
      });
    } else {
      modal('#modal-error', {
        title: 'Lỗi',
        message: message
      });
    }
  } else {
    // Fallback to alert
    if (type === 'success') {
      alert('✅ ' + message);
    } else {
      alert('❌ ' + message);
    }
  }
}

/**
 * Set as Default Template
 */
function setAsDefaultTemplate(templateId) {
  console.log('⭐ Setting default template:', templateId);
  
  var formData = new FormData();
  formData.append('action', 'set_default_template');
  formData.append('template_id', templateId);
  
  fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php', {
    method: 'POST',
    body: formData,
    credentials: 'same-origin'
  })
  .then(response => response.json())
  .then(data => {
    console.log('✅ Set default response:', data);
    
    if (data.success) {
      showNotification('success', data.message || 'Đã đặt làm template mặc định!');
      loadTemplates();
    } else {
      showNotification('error', data.error || 'Không thể đặt template mặc định');
    }
  })
  .catch(error => {
    console.error('❌ Error setting default:', error);
    showNotification('error', 'Đã xảy ra lỗi khi đặt template mặc định');
  });
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
  if (!text) return '';
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
}

<?php echo '</script'; ?>
>

<style>
/* ===============================
   MODERN FORM KIT – Floating labels
   Safe: không đụng id/name/JS/Backend
   =============================== */

:root{
  --mf-radius: 12px;
  --mf-ring: 2px;
  --mf-border: #e5e7eb;
  --mf-border-focus: #007bff;
  --mf-bg: #ffffff;
  --mf-bg-muted:#f7f8fb;
  --mf-text:#111827;
  --mf-muted:#6b7280;
  --mf-valid:#22c55e;
  --mf-invalid:#ef4444;
  --mf-shadow: 0 8px 24px rgba(16,24,40,.06);
}

.form-modern .g-16{ row-gap:16px; }
.form-modern .mf-btn{
  padding:.6rem 1rem;border-radius:10px;font-weight:600;
  box-shadow:0 6px 14px rgba(0,123,255,.18);
}

/* Group */
.form-modern .mf-group{
  position:relative; margin:14px 0;
}

/* Control */
.form-modern .form-control{
  background:var(--mf-bg);
  border:1.5px solid var(--mf-border);
  border-radius:var(--mf-radius);
  padding: 18px 14px 12px 14px;
  font-size: .95rem;
  line-height:1.3;
  color:var(--mf-text);
  transition:.18s ease;
  box-shadow:none;
}
.form-modern .form-control[readonly],
.form-modern .form-control:read-only{
  background: var(--mf-bg-muted);
  color:#4b5563;
  cursor:not-allowed;
}
.form-modern .form-control:focus{
  outline: none;
  border-color: var(--mf-border-focus);
  box-shadow: 0 0 0 var(--mf-ring) rgba(0,123,255,.15);
}

/* Floating labels */
.form-modern .mf-group > label{
  position:absolute; left:12px; top:12px;
  padding:0 6px;
  background:transparent;
  color:var(--mf-muted);
  font-size:.93rem; line-height:1;
  transform-origin:left top;
  transition:.18s ease;
  pointer-events:none;
}
.form-modern .form-control::placeholder{ color:transparent; }

/* Khi có value hoặc focus -> nổi lên */
.form-modern .form-control:not(:placeholder-shown) + label,
.form-modern .form-control:focus + label,
.form-modern .form-control:-webkit-autofill + label{
  top:-8px;
  background:var(--mf-bg);
  border-radius:8px;
  font-size:.75rem;
  color:#3b82f6;
  padding:0 6px;
  box-shadow: 0 0 0 4px var(--mf-bg);
}

/* Textarea chiều cao đẹp hơn */
.form-modern textarea.form-control{
  min-height:110px; resize:vertical;
  padding-top:22px;
}

/* Hint dưới mỗi field */
.form-modern .mf-hint{
  display:block; margin-top:6px; font-size:.8rem; color:#6b7280;
}

/* Wallet Card */
.mf-wallet-card{
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 10px 30px rgba(102,126,234,.25);
  color: white;
}
.mf-wallet-icon{
  width: 56px;
  height: 56px;
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: white;
}
.mf-wallet-card h3{
  text-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.mf-wallet-card .btn-outline-primary{
  background: rgba(255,255,255,0.95);
  border: none;
  color: #667eea;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
}
.mf-wallet-card .btn-outline-primary:hover{
  background: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

/* Alert làm mềm */
.modern-alert{
  background: linear-gradient(180deg, #eef5ff, #ffffff);
  border:1px solid #dbe7ff; border-radius:14px;
  box-shadow: var(--mf-shadow);
}

/* Invoice card nhấn nhẹ */
.mf-invoice{
  border:1px dashed #cbd5e1 !important;
  border-radius:14px;
  background:#fbfdff !important;
}

/* Nút primary mượt */
.form-modern .btn.btn-primary.mf-btn{
  background: linear-gradient(135deg, #1d4ed8, #3b82f6);
  border:0;
  transition: all 0.3s ease;
}
.form-modern .btn.btn-primary.mf-btn:not(:disabled):hover{
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0,123,255,.3);
}

/* Balance Warning - Nổi bật */
.mf-balance-warning{
  border-radius: 14px;
  border: 2px solid #dc3545;
  background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
  box-shadow: 0 8px 24px rgba(220,53,69,0.2);
  opacity: 0;
  transform: translateY(-10px);
  transition: all 0.3s ease;
  color: #1a1a1a !important;
}
.mf-balance-warning.show{
  opacity: 1;
  transform: translateY(0);
  animation: shake 0.5s ease-in-out;
}
.mf-balance-warning i{
  color: #dc3545;
  filter: drop-shadow(0 2px 4px rgba(220,53,69,0.3));
}
.mf-balance-warning h6{
  color: #b91c1c !important;
  font-size: 1.1rem;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.mf-balance-warning p{
  color: #374151 !important;
  font-weight: 500;
}
.mf-balance-warning .alert-link{
  color: #b91c1c !important;
  text-decoration: underline;
  font-weight: 700;
  transition: all 0.2s;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.mf-balance-warning .alert-link:hover{
  color: #991b1b !important;
  transform: scale(1.05);
  text-decoration: none;
}

/* Shake animation */
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
  20%, 40%, 60%, 80% { transform: translateX(5px); }
}

/* Button khi disabled - làm rõ hơn */
.form-modern .btn.btn-primary.mf-btn:disabled{
  background: #cbd5e1;
  color: #64748b;
  box-shadow: none;
  cursor: not-allowed;
  opacity: 0.6;
}

/* Validation states */
.form-modern .form-control:required:user-invalid{ border-color: var(--mf-invalid); }
.form-modern .form-control:required:user-valid{ border-color: var(--mf-valid); }

/* Dark mode - ĐÃ VÔ HIỆU HÓA để giữ chế độ sáng */
/*
@media (prefers-color-scheme: dark){
  :root{
    --mf-border:#334155; --mf-border-focus:#60a5fa;
    --mf-bg:#0b1220; --mf-bg-muted:#0f172a;
    --mf-text:#e5e7eb; --mf-muted:#9ca3af;
    --mf-shadow: 0 8px 24px rgba(2,6,23,.6);
  }
  .modern-alert{ background:linear-gradient(180deg,#0f172a,#0b1220); border-color:#1f2a44; }
  .mf-invoice{ background:#0f172a !important; border-color:#23304d !important; }
  .form-modern .form-control:focus{
    box-shadow:0 0 0 var(--mf-ring) rgba(96,165,250,.25);
  }
}
*/
</style>

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

/* Countup Animation */
@keyframes countup {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

[data-animate="countup"] {
  animation: countup 0.6s ease-out forwards;
  opacity: 0;
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

/* Stagger Animation for Dashboard Cards */
#dashboardCards .col-md-3:nth-child(1) .card { animation-delay: 0.1s; }
#dashboardCards .col-md-3:nth-child(2) .card { animation-delay: 0.2s; }
#dashboardCards .col-md-3:nth-child(3) .card { animation-delay: 0.3s; }
#dashboardCards .col-md-3:nth-child(4) .card { animation-delay: 0.4s; }

/* Pulse Animation */
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}

/* Skeleton Loading */
.skeleton {
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: skeleton-loading 1.5s infinite;
}

@keyframes skeleton-loading {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Notification Animations */
@keyframes slideInRight {
  from {
    transform: translateX(400px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOutRight {
  from {
    transform: translateX(0);
    opacity: 1;
  }
  to {
    transform: translateX(400px);
    opacity: 0;
  }
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

/* Modal Close Button Hover Effect */
.modal-header .close:hover {
  background: rgba(255,255,255,0.35) !important;
  transform: rotate(90deg);
}

.modal-header .close:active {
  background: rgba(255,255,255,0.5) !important;
  transform: rotate(90deg) scale(0.95);
}
</style>

<!-- ========================================
     GPT TEMPLATES MANAGER MODAL
     ======================================== -->
<div class="modal fade" id="templatesManagerModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
        <h5 class="modal-title">
          <i class="fa fa-magic mr-2"></i>
          Quản Lý Templates GPT
        </h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1; background: rgba(255,255,255,0.2); border: none; border-radius: 50%; width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 24px; line-height: 1;">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        
        <!-- Header Actions -->
        <div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h6 class="mb-0" style="color: #6b7280;">
              <i class="fa fa-lightbulb-o mr-1"></i>
              Quản lý templates GPT
            </h6>
          </div>
          <button class="btn btn-primary btn-sm" onclick="openTemplateEditor()">
            <i class="fa fa-plus mr-1"></i> Tạo Template Mới
          </button>
        </div>

        <!-- Templates List -->
        <div id="templatesList" class="templates-list">
          <!-- Will be populated by JavaScript -->
          <div class="text-center py-5">
            <i class="fa fa-spinner fa-spin fa-3x text-muted"></i>
            <p class="mt-3 text-muted">Đang tải templates...</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ========================================
     DELETE TEMPLATE CONFIRMATION MODAL
     ======================================== -->
<div class="modal fade" id="deleteTemplateModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
      <div class="modal-body text-center" style="padding: 40px 30px;">
        <!-- Icon -->
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
          <i class="fa fa-trash" style="font-size: 36px; color: white;"></i>
        </div>
        
        <!-- Title -->
        <h4 style="color: #2d3748; margin-bottom: 15px; font-weight: 600;">
          Xác nhận xóa template?
        </h4>
        
        <!-- Message -->
        <p style="color: #718096; font-size: 15px; margin-bottom: 10px;">
          Bạn có chắc chắn muốn xóa template
        </p>
        <p style="color: #2d3748; font-weight: 600; font-size: 16px; margin-bottom: 15px;">
          "<span id="deleteTemplateName"></span>"
        </p>
        <p style="color: #e53e3e; font-size: 14px; margin-bottom: 30px;">
          <i class="fa fa-exclamation-triangle mr-1"></i>
          Hành động này không thể hoàn tác!
        </p>
        
        <!-- Buttons -->
        <div style="display: flex; gap: 10px; justify-content: center;">
          <button type="button" class="btn btn-light" onclick="closeDeleteModal()" style="min-width: 120px; border-radius: 8px; padding: 10px 20px; font-weight: 600;">
            <i class="fa fa-times mr-1"></i> Hủy
          </button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn" onclick="confirmDeleteTemplate()" style="min-width: 120px; border-radius: 8px; padding: 10px 20px; font-weight: 600; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); border: none;">
            <i class="fa fa-trash mr-1"></i> Xóa ngay
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ========================================
     TEMPLATE EDITOR MODAL
     ======================================== -->
<div class="modal fade" id="templateEditorModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none;">
        <h5 class="modal-title" id="templateEditorTitle">
          <i class="fa fa-edit mr-2"></i>
          Tạo Template Mới
        </h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1; background: rgba(255,255,255,0.2); border: none; border-radius: 50%; width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 24px; line-height: 1;">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="templateEditorForm">
          <input type="hidden" id="edit_template_id" name="template_id" value="">
          
          <div class="form-group">
            <label for="edit_template_name">
              <i class="fa fa-tag mr-1"></i> Tên Template <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="edit_template_name" name="template_name" 
                   placeholder="VD: Review Nhà Hàng, Review Spa, Review Khách Sạn..." required>
            <small class="form-text text-muted">Tên ngắn gọn để dễ nhận biết</small>
          </div>

          <div class="form-group">
            <label for="edit_template_description">
              <i class="fa fa-info-circle mr-1"></i> Mô Tả
            </label>
            <input type="text" class="form-control" id="edit_template_description" name="template_description" 
                   placeholder="Mô tả ngắn về template này...">
            <small class="form-text text-muted">Tùy chọn: Giải thích template này dùng để làm gì</small>
          </div>

          <div class="form-group">
            <label for="edit_gpt_prompt">
              <i class="fa fa-comment mr-1"></i> Hướng Dẫn Yêu Cầu GPT <span class="text-danger">*</span>
            </label>
            <textarea class="form-control" id="edit_gpt_prompt" name="gpt_prompt" rows="6" 
                      placeholder="VD: Tạo đánh giá chân thực cho nhà hàng, nhấn mạnh chất lượng món ăn, phục vụ, không gian. Dùng ngôn ngữ lịch sự, chuyên nghiệp. Độ dài 200-300 ký tự." required></textarea>
            <small class="form-text text-muted">
              <strong>Mục đích:</strong> Hướng dẫn này sẽ được điền vào ô "Đánh giá mẫu" khi chọn template, giúp GPT tạo review đúng phong cách.
            </small>
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="edit_is_default" name="is_default" value="1">
              <label class="custom-control-label" for="edit_is_default">
                <i class="fa fa-star mr-1"></i> Đặt làm template mặc định
              </label>
            </div>
            <small class="form-text text-muted">Template mặc định sẽ được chọn tự động khi tạo chiến dịch mới</small>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fa fa-times mr-1"></i> Hủy
        </button>
        <button type="button" class="btn btn-primary" onclick="saveTemplate()">
          <i class="fa fa-save mr-1"></i> Lưu Template
        </button>
      </div>
    </div>
  </div>
</div>

<style>
/* Templates Manager Styles */
.templates-list {
  max-height: 500px;
  overflow-y: auto;
}

.template-card {
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 16px;
  transition: all 0.3s ease;
  background: white;
}

.template-card:hover {
  border-color: #667eea;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
  transform: translateY(-2px);
}

.template-card.default-template {
  border-color: #f59e0b;
  background: linear-gradient(135deg, #fff7ed 0%, #fffbeb 100%);
}

.template-card .template-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 12px;
}

.template-card .template-name {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 4px;
}

.template-card .template-description {
  font-size: 0.9rem;
  color: #6b7280;
  margin-bottom: 8px;
}

.template-card .template-prompt {
  font-size: 0.85rem;
  color: #4b5563;
  background: #f9fafb;
  padding: 10px;
  border-radius: 8px;
  border-left: 3px solid #667eea;
  margin-bottom: 12px;
  max-height: 80px;
  overflow: hidden;
  position: relative;
}

.template-card .template-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.template-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  margin-right: 8px;
}

.template-badge.default {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
}

.template-badge.usage {
  background: #e5e7eb;
  color: #6b7280;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1050;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background-color: rgba(0,0,0,0.5);
}

.modal.show {
  display: block;
}

.modal-dialog {
  position: relative;
  width: auto;
  margin: 30px auto;
  max-width: 500px;
}

.modal-content {
  position: relative;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,.2);
  border-radius: 6px;
  box-shadow: 0 3px 9px rgba(0,0,0,.5);
  background-clip: padding-box;
  outline: 0;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1040;
  background-color: #000;
}
</style>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
