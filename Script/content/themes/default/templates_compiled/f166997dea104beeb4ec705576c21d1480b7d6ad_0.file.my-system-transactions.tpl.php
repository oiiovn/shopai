<?php
/* Smarty version 4.3.4, created on 2025-10-16 10:54:46
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/my-system-transactions.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0cef6c15cc4_38298141',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f166997dea104beeb4ec705576c21d1480b7d6ad' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/my-system-transactions.tpl',
      1 => 1760611801,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68f0cef6c15cc4_38298141 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/vendor/smarty/smarty/libs/plugins/modifier.implode.php','function'=>'smarty_modifier_implode',),));
?>
<!-- transactions management -->


<!-- Filters and Search -->
<div class="card mb20">
  <div class="card-header">
    <div class="row align-items-center">
      <div class="col">
        <strong><i class="fa fa-filter mr10"></i><?php echo __("Bộ Lọc và Tìm Kiếm");?>
</strong>
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-danger btn-sm" id="clearFiltersBtn" onclick="clearFilters()" style="display: none;">
          <i class="fa fa-times mr5"></i><?php echo __("Xóa Lọc");?>

        </button>
        <button class="btn btn-primary btn-sm" id="filterBtn" onclick="filterTransactions()" style="width: 85px; height: 32px; text-align: center;">
          <i class="fa fa-search mr5"></i><?php echo __("Lọc");?>

        </button>
        <button class="btn btn-success btn-sm ml5" onclick="exportTransactions()">
          <i class="fa fa-download mr5"></i><?php echo __("Xuất Excel");?>

        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label"><?php echo __("Loại Giao Dịch");?>
</label>
          <select class="form-control" id="transaction_type">
            <option value="" <?php if ($_smarty_tpl->tpl_vars['current_type']->value == '') {?>selected<?php }?> style="color: #6c757d; font-style: italic;"><?php echo __("Tất cả");?>
</option>
            <option value="recharge" <?php if ($_smarty_tpl->tpl_vars['current_type']->value == "recharge") {?>selected<?php }?>><?php echo __("Nạp tiền");?>
</option>
            <option value="withdraw" <?php if ($_smarty_tpl->tpl_vars['current_type']->value == "withdraw") {?>selected<?php }?>><?php echo __("Rút tiền");?>
</option>
          </select>
        </div>
      </div>
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label"><?php echo __("Khoảng Thời Gian");?>
</label>
          <select class="form-control" id="time_range">
            <option value="" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == '') {?>selected<?php }?> style="color: #6c757d; font-style: italic;"><?php echo __("Tất cả");?>
</option>
            <option value="today" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == "today") {?>selected<?php }?>><?php echo __("Hôm nay");?>
</option>
            <option value="yesterday" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == "yesterday") {?>selected<?php }?>><?php echo __("Hôm qua");?>
</option>
            <option value="week" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == "week") {?>selected<?php }?>><?php echo __("7 ngày qua");?>
</option>
            <option value="month" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == "month") {?>selected<?php }?>><?php echo __("30 ngày qua");?>
</option>
            <option value="quarter" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == "quarter") {?>selected<?php }?>><?php echo __("3 tháng qua");?>
</option>
            <option value="year" <?php if ($_smarty_tpl->tpl_vars['current_time_range']->value == "year") {?>selected<?php }?>><?php echo __("1 năm qua");?>
</option>
          </select>
        </div>
      </div>
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label"><?php echo __("Tìm kiếm theo User ID");?>
</label>
          <input type="text" class="form-control" id="search_user_id" placeholder="<?php echo __('Nhập User ID hoặc tên');?>
" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['current_search_user']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
        </div>
      </div>
      <div class="col-md-3 mb10">
        <div class="form-group">
          <label class="form-label"><?php echo __("Số tiền (VNĐ)");?>
</label>
          <input type="number" class="form-control" id="search_amount" placeholder="<?php echo __('Nhập số tiền');?>
" step="1000" min="0" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['current_search_amount']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Filters and Search -->

<!-- Transactions Table -->
<div class="card" id="transactionsTableCard">
  <div class="card-header">
    <div class="row align-items-center">
      <div class="col">
        <strong><i class="fa fa-list mr10"></i><?php echo __("Danh Sách Giao Dịch");?>
</strong>
      </div>
      <div class="col-auto">
        <span class="badge badge-info"><?php echo __("Tổng: ".((string)$_smarty_tpl->tpl_vars['total_transactions']->value)." giao dịch");?>
</span>
      </div>
    </div>
  </div>
  <div class="card-body" id="transactionsTableBody">
    
    <?php if ($_smarty_tpl->tpl_vars['has_transactions']->value) {?>
      <!-- Transaction Table -->
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead class="bg-light">
            <tr>
              <th style="width: 80px;"><?php echo __("ID");?>
</th>
              <th style="width: 150px;"><?php echo __("User");?>
</th>
              <th style="width: 100px;"><?php echo __("Loại");?>
</th>
              <th style="width: 120px;"><?php echo __("Số Tiền");?>
</th>
              <th style="width: 200px;"><?php echo __("Mô Tả");?>
</th>
              <th style="width: 150px;"><?php echo __("Thời Gian");?>
</th>
              <th style="width: 100px;"><?php echo __("Thao Tác");?>
</th>
            </tr>
          </thead>
          <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['transactions']->value, 'transaction');
$_smarty_tpl->tpl_vars['transaction']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaction']->value) {
$_smarty_tpl->tpl_vars['transaction']->do_else = false;
?>
              <tr>
                <td class="text-center">
                  <strong>#<?php echo $_smarty_tpl->tpl_vars['transaction']->value['transaction_id'];?>
</strong>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['transaction']->value['user_picture'];?>
" 
                         class="rounded-circle mr10" width="30" height="30">
                    <div>
                      <div class="font-weight-bold"><?php echo $_smarty_tpl->tpl_vars['transaction']->value['user_display_name'];?>
</div>
                      <small class="text-muted">ID: <?php echo $_smarty_tpl->tpl_vars['transaction']->value['user_id'];?>
</small>
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  <?php if ($_smarty_tpl->tpl_vars['transaction']->value['type'] == "recharge") {?>
                    <span style="background-color: #198754; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                      <i class="fa fa-arrow-up mr5"></i><?php echo __("NẠP TIỀN");?>

                    </span>
                  <?php } elseif ($_smarty_tpl->tpl_vars['transaction']->value['type'] == "withdraw") {?>
                    <span style="background-color: #dc3545; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                      <i class="fa fa-arrow-down mr5"></i><?php echo __("RÚT TIỀN");?>

                    </span>
                  <?php } else { ?>
                    <span style="background-color: #6c757d; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                      <i class="fa fa-question mr5"></i><?php echo __("KHÁC");?>

                    </span>
                  <?php }?>
                </td>
                <td class="text-right">
                  <span class="font-weight-bold <?php if ($_smarty_tpl->tpl_vars['transaction']->value['type'] == 'recharge') {?>text-success<?php } elseif ($_smarty_tpl->tpl_vars['transaction']->value['type'] == 'withdraw') {?>text-danger<?php } else { ?>text-secondary<?php }?>">
                    <?php echo $_smarty_tpl->tpl_vars['transaction']->value['formatted_amount'];?>

                  </span>
                </td>
                <td>
                  <span class="text-muted"><?php echo (($tmp = $_smarty_tpl->tpl_vars['transaction']->value['description'] ?? null)===null||$tmp==='' ? '-' ?? null : $tmp);?>
</span>
                </td>
                <td class="text-center">
                  <small><?php echo $_smarty_tpl->tpl_vars['transaction']->value['formatted_time'];?>
</small>
                </td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-primary" onclick="viewTransactionDetails(<?php echo $_smarty_tpl->tpl_vars['transaction']->value['transaction_id'];?>
)">
                    <i class="fa fa-eye"></i>
                  </button>
                </td>
              </tr>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if ($_smarty_tpl->tpl_vars['total_pages']->value > 1) {?>
        <div class="text-center mt20">
          <nav>
            <ul class="pagination justify-content-center">
              <!-- Previous Page -->
              <li class="page-item <?php if ($_smarty_tpl->tpl_vars['current_page']->value <= 1) {?>disabled<?php }?>">
                <?php if ($_smarty_tpl->tpl_vars['current_page']->value > 1) {?>
                  <a class="page-link" href="javascript:void(0)" onclick="loadPage(<?php echo $_smarty_tpl->tpl_vars['current_page']->value-1;?>
)">
                    <i class="fa fa-chevron-left mr5"></i><?php echo __("Trước");?>

                  </a>
                <?php } else { ?>
                  <span class="page-link">
                    <i class="fa fa-chevron-left mr5"></i><?php echo __("Trước");?>

                  </span>
                <?php }?>
              </li>

              <!-- Page Numbers -->
              <?php
$_smarty_tpl->tpl_vars['page'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['page']->step = 1;$_smarty_tpl->tpl_vars['page']->total = (int) ceil(($_smarty_tpl->tpl_vars['page']->step > 0 ? min($_smarty_tpl->tpl_vars['total_pages']->value,$_smarty_tpl->tpl_vars['current_page']->value+2)+1 - (max(1,$_smarty_tpl->tpl_vars['current_page']->value-2)) : max(1,$_smarty_tpl->tpl_vars['current_page']->value-2)-(min($_smarty_tpl->tpl_vars['total_pages']->value,$_smarty_tpl->tpl_vars['current_page']->value+2))+1)/abs($_smarty_tpl->tpl_vars['page']->step));
if ($_smarty_tpl->tpl_vars['page']->total > 0) {
for ($_smarty_tpl->tpl_vars['page']->value = max(1,$_smarty_tpl->tpl_vars['current_page']->value-2), $_smarty_tpl->tpl_vars['page']->iteration = 1;$_smarty_tpl->tpl_vars['page']->iteration <= $_smarty_tpl->tpl_vars['page']->total;$_smarty_tpl->tpl_vars['page']->value += $_smarty_tpl->tpl_vars['page']->step, $_smarty_tpl->tpl_vars['page']->iteration++) {
$_smarty_tpl->tpl_vars['page']->first = $_smarty_tpl->tpl_vars['page']->iteration === 1;$_smarty_tpl->tpl_vars['page']->last = $_smarty_tpl->tpl_vars['page']->iteration === $_smarty_tpl->tpl_vars['page']->total;?>
                <li class="page-item <?php if ($_smarty_tpl->tpl_vars['page']->value == $_smarty_tpl->tpl_vars['current_page']->value) {?>active<?php }?>">
                  <a class="page-link" href="javascript:void(0)" onclick="loadPage(<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
)">
                    <?php echo $_smarty_tpl->tpl_vars['page']->value;?>

                  </a>
                </li>
              <?php }
}
?>

              <!-- Next Page -->
              <li class="page-item <?php if ($_smarty_tpl->tpl_vars['current_page']->value >= $_smarty_tpl->tpl_vars['total_pages']->value) {?>disabled<?php }?>">
                <?php if ($_smarty_tpl->tpl_vars['current_page']->value < $_smarty_tpl->tpl_vars['total_pages']->value) {?>
                  <a class="page-link" href="javascript:void(0)" onclick="loadPage(<?php echo $_smarty_tpl->tpl_vars['current_page']->value+1;?>
)">
                    <?php echo __("Sau");?>
<i class="fa fa-chevron-right ml5"></i>
                  </a>
                <?php } else { ?>
                  <span class="page-link">
                    <?php echo __("Sau");?>
<i class="fa fa-chevron-right ml5"></i>
                  </span>
                <?php }?>
              </li>
            </ul>
          </nav>
        </div>
      <?php }?>
    <?php } else { ?>
      <!-- No Transactions Message -->
      <div class="text-center text-muted" style="padding: 60px 20px;">
        <i class="fa fa-exchange-alt fa-5x mb20" style="opacity: 0.3;"></i>
        <h4 class="mb10"><?php echo __("Chưa có giao dịch nào");?>
</h4>
        <p class="text-muted"><?php echo __("Không tìm thấy giao dịch phù hợp với bộ lọc");?>
</p>
      </div>
    <?php }?>

        <?php if ((isset($_smarty_tpl->tpl_vars['debug_info']->value))) {?>
      <div class="card mt20">
        <div class="card-header bg-warning">
          <strong><i class="fa fa-bug mr10"></i><?php echo __("Debug Information");?>
</strong>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <strong><?php echo __("Total Transactions:");?>
</strong> <?php echo $_smarty_tpl->tpl_vars['debug_info']->value['total_transactions'];?>
<br>
              <strong><?php echo __("Current Page:");?>
</strong> <?php echo $_smarty_tpl->tpl_vars['debug_info']->value['current_page'];?>
<br>
              <strong><?php echo __("Total Pages:");?>
</strong> <?php echo $_smarty_tpl->tpl_vars['debug_info']->value['total_pages'];?>
<br>
            </div>
            <div class="col-md-6">
              <strong><?php echo __("Where Clause:");?>
</strong> <code><?php echo (($tmp = $_smarty_tpl->tpl_vars['debug_info']->value['where_clause'] ?? null)===null||$tmp==='' ? 'None' ?? null : $tmp);?>
</code><br>
              <strong><?php echo __("Parameters:");?>
</strong> <code><?php echo smarty_modifier_implode($_smarty_tpl->tpl_vars['debug_info']->value['params'],', ');?>
</code><br>
              <strong><?php echo __("Parameter Types:");?>
</strong> <code><?php echo $_smarty_tpl->tpl_vars['debug_info']->value['param_types'];?>
</code><br>
            </div>
          </div>
        </div>
      </div>
    <?php }?>

  </div>
</div>
<!-- Transactions Table -->

<!-- Custom Modal Styles -->
<style>
  .modal-dialog-centered {
    animation: modalSlideDown 0.3s ease-out;
  }
  
  @keyframes modalSlideDown {
    from {
      opacity: 0;
      transform: translateY(-50px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .detail-item {
    transition: all 0.3s ease;
  }
  
  .detail-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  
  .btn-close-white {
    filter: brightness(0) invert(1);
    opacity: 0.8;
    transition: opacity 0.2s;
  }
  
  .btn-close-white:hover {
    opacity: 1;
  }
  
  .avatar-placeholder {
    transition: transform 0.3s ease;
  }
  
  .avatar-placeholder:hover {
    transform: scale(1.1);
  }
  
  #transactionModal .modal-footer .btn {
    transition: all 0.3s ease;
  }
  
  #transactionModal .modal-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }
</style>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
      <!-- Modal Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 20px 30px;">
        <div>
          <h5 class="modal-title mb-0" style="font-weight: 600;">
            <i class="fa fa-file-invoice mr-2"></i><?php echo __("Chi Tiết Giao Dịch");?>

          </h5>
          <small class="d-block mt-1" style="opacity: 0.9;">ID: <span id="modal_transaction_id">-</span></small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" style="padding: 30px;">
        <!-- User Info Card -->
        <div class="card mb-3" style="border: none; background: #f8f9fa; border-radius: 10px;">
          <div class="card-body p-3">
            <h6 class="text-muted mb-3" style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
              <i class="fa fa-user mr-1"></i> Thông Tin Người Dùng
            </h6>
            <div class="d-flex align-items-center">
              <div class="avatar-placeholder" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px; margin-right: 15px;">
                U
              </div>
              <div>
                <div style="font-weight: 600; font-size: 16px; color: #2d3748;">User Name</div>
                <small class="text-muted">User ID: <span id="modal_user_id">-</span></small>
              </div>
            </div>
          </div>
        </div>

        <!-- Transaction Details Grid -->
        <div class="row g-3">
          <!-- Transaction Type -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-tag mr-1"></i> Loại Giao Dịch
              </label>
              <div id="modal_type" style="font-weight: 600; font-size: 15px; color: #2d3748;">-</div>
            </div>
          </div>

          <!-- Amount -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-money-bill-wave mr-1"></i> Số Tiền
              </label>
              <div id="modal_amount" style="font-weight: 700; font-size: 20px; color: #48bb78;">-</div>
            </div>
          </div>

          <!-- Time -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-clock mr-1"></i> Thời Gian
              </label>
              <div id="modal_date" style="font-weight: 600; font-size: 15px; color: #2d3748;">-</div>
            </div>
          </div>

          <!-- Status Badge -->
          <div class="col-md-6">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-check-circle mr-1"></i> Trạng Thái
              </label>
              <div>
                <span class="badge" style="background: #48bb78; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px;">
                  <i class="fa fa-check mr-1"></i> Hoàn Thành
                </span>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="col-12">
            <div class="detail-item" style="background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0;">
              <label class="d-block mb-2" style="font-size: 12px; color: #718096; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                <i class="fa fa-align-left mr-1"></i> Mô Tả
              </label>
              <div id="modal_description" style="color: #4a5568; line-height: 1.6;">-</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; padding: 20px 30px; border-top: 1px solid #e2e8f0;">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px; font-weight: 500;">
          <i class="fa fa-times mr-1"></i> <?php echo __("Đóng");?>

        </button>
        <button type="button" class="btn btn-primary" style="border-radius: 8px; padding: 10px 20px; font-weight: 500; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
          <i class="fa fa-edit mr-1"></i> <?php echo __("Cập Nhật");?>

        </button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript Functions -->
<?php echo '<script'; ?>
>
// Store initial values to detect changes
let initialValues = {};

// Auto-filter timer
let filterTimeout;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  const inputs = ['transaction_type', 'time_range', 'search_user_id', 'search_amount'];
  
  // Store initial values (empty values for comparison)
  inputs.forEach(function(id) {
    initialValues[id] = '';
  });
  
  // Check if any filters are currently applied on page load
  checkIfFiltersApplied();
  
  // Add event listeners to detect changes and auto-filter
  inputs.forEach(function(id) {
    const element = document.getElementById(id);
    
    // For dropdowns (select), filter immediately on change
    if (element.tagName === 'SELECT') {
      element.addEventListener('change', function() {
        checkIfFiltersApplied();
        autoFilter();
      });
    }
    
    // For text inputs, add debounced auto-filter
    else {
      element.addEventListener('input', function() {
        checkIfFiltersApplied();
        
        // Clear existing timeout
        clearTimeout(filterTimeout);
        
        // Set new timeout for auto-filter (500ms delay)
        filterTimeout = setTimeout(function() {
          autoFilter();
        }, 500);
      });
      
      // Also filter on Enter key
      element.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          clearTimeout(filterTimeout);
          autoFilter();
        }
      });
    }
  });
});

function checkIfFiltersApplied() {
  const inputs = ['transaction_type', 'time_range', 'search_user_id', 'search_amount'];
  let hasFilters = false;
  
  inputs.forEach(function(id) {
    const value = document.getElementById(id).value.trim();
    if (value !== '') {
      hasFilters = true;
    }
  });
  
  // Show/hide clear button based on whether filters are applied
  const clearBtn = document.getElementById('clearFiltersBtn');
  if (hasFilters) {
    clearBtn.style.display = 'inline-block';
  } else {
    clearBtn.style.display = 'none';
  }
}

function autoFilter() {
  // Show loading state
  const filterBtn = document.getElementById('filterBtn');
  
  // Keep button text the same, just disable it
  filterBtn.disabled = true;
  
  // Perform filter
  performFilter();
  
  // Reset button after a short delay
  setTimeout(function() {
    filterBtn.disabled = false;
  }, 1000);
}

function filterTransactions() {
  // Show loading state
  const filterBtn = document.getElementById('filterBtn');
  
  // Keep button text the same, just disable it
  filterBtn.disabled = true;
  
  // Perform filter
  performFilter();
  
  // Reset button after a short delay
  setTimeout(function() {
    filterBtn.disabled = false;
  }, 1000);
}

function performFilter() {
  // Get filter values
  const type = document.getElementById('transaction_type').value;
  const timeRange = document.getElementById('time_range').value;
  const searchUser = document.getElementById('search_user_id').value;
  const searchAmount = document.getElementById('search_amount').value;
  
  // Build URL with parameters
  const params = new URLSearchParams();
  params.append('page', '1'); // Reset to first page
  params.append('ajax', '1'); // AJAX request flag
  
  if (type) params.append('type', type);
  if (timeRange) params.append('time_range', timeRange);
  if (searchUser) params.append('search_user', searchUser);
  if (searchAmount) params.append('search_amount', searchAmount);
  
  // Show loading state
  showTableLoading();
  
  // Make AJAX request
  fetch('?view=transactions&' + params.toString(), {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(data => {
    // AJAX response is just the card-body content
    // Target only the transactions table card-body by ID
    const currentTableContent = document.getElementById('transactionsTableBody');
    if (currentTableContent) {
      // Replace table content directly
      currentTableContent.innerHTML = data;
      
      // Update URL without reload
      window.history.pushState({}, '', '?view=transactions&' + params.toString().replace('&ajax=1', ''));
      
      // Check filters after update
      checkIfFiltersApplied();
    }
  })
  .catch(error => {
    console.error('Filter error:', error);
    // Fallback to page reload
    window.location.href = '?view=transactions&' + params.toString().replace('&ajax=1', '');
  })
  .finally(() => {
    hideTableLoading();
  });
}

function clearFilters() {
  // Clear all filter inputs
  document.getElementById('transaction_type').value = '';
  document.getElementById('time_range').value = '';
  document.getElementById('search_user_id').value = '';
  document.getElementById('search_amount').value = '';
  
  // Perform filter with empty values
  performFilter();
}

function showTableLoading() {
  const tableContent = document.getElementById('transactionsTableBody');
  if (tableContent) {
    tableContent.innerHTML = `
      <div class="text-center" style="padding: 60px 20px;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
          <span class="sr-only">Đang tải...</span>
        </div>
        <h5 class="mt-3">Đang lọc dữ liệu...</h5>
        <p class="text-muted">Vui lòng chờ trong giây lát</p>
      </div>
    `;
  }
}

function hideTableLoading() {
  // Loading will be replaced by new content from AJAX response
}


function loadPage(page) {
  // Get current filter values
  const type = document.getElementById('transaction_type').value;
  const timeRange = document.getElementById('time_range').value;
  const searchUser = document.getElementById('search_user_id').value;
  const searchAmount = document.getElementById('search_amount').value;
  
  // Build URL with parameters
  const params = new URLSearchParams();
  params.append('page', page);
  params.append('ajax', '1'); // AJAX request flag
  
  if (type) params.append('type', type);
  if (timeRange) params.append('time_range', timeRange);
  if (searchUser) params.append('search_user', searchUser);
  if (searchAmount) params.append('search_amount', searchAmount);
  
  // Show loading state
  showTableLoading();
  
  // Make AJAX request
  fetch('?view=transactions&' + params.toString(), {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(data => {
    // AJAX response is just the card-body content
    // Target only the transactions table card-body by ID
    const currentTableContent = document.getElementById('transactionsTableBody');
    if (currentTableContent) {
      // Replace table content directly
      currentTableContent.innerHTML = data;
      
      // Update URL without reload
      window.history.pushState({}, '', '?view=transactions&' + params.toString().replace('&ajax=1', ''));
      
      // Scroll to top of table
      document.getElementById('transactionsTableCard').scrollIntoView({ behavior: 'smooth' });
    }
  })
  .catch(error => {
    console.error('Page load error:', error);
    // Fallback to page reload
    window.location.href = '?view=transactions&' + params.toString().replace('&ajax=1', '');
  })
  .finally(() => {
    hideTableLoading();
  });
}

function exportTransactions() {
  // Placeholder for export functionality
  console.log('Exporting transactions...');
}

function viewTransactionDetails(transactionId) {
  // Placeholder for view details functionality
  var modal = document.getElementById('transactionModal');
  if (modal) {
    var bsModal = new bootstrap.Modal(modal);
    bsModal.show();
  }
}
<?php echo '</script'; ?>
>

<!-- transactions management --><?php }
}
