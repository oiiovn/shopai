<?php
/* Smarty version 4.3.4, created on 2025-10-02 11:51:33
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/otp-rental-history.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68de67457193b0_98358263',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '495cf0028335ced0c13cd59204782f5ca1d5ef16' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/otp-rental-history.tpl',
      1 => 1759405557,
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
function content_68de67457193b0_98358263 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel (mobile only) -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <!-- side panel -->

    <!-- OTP Rental Sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar otp-rental-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <ul class="main-side-nav">
            <li>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental">
                <i class="fa fa-mobile-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                <?php echo __("Thuê OTP");?>

              </a>
            </li>
            <li class="active">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental/history">
                <i class="fa fa-history main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                <?php echo __("Lịch sử thuê");?>

              </a>
            </li>
            <li>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet">
                <i class="fa fa-credit-card main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                <?php echo __("Nạp tiền");?>

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
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental">
              <?php echo __("Thuê OTP");?>

            </a>
          </li>
          <li class="active">
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental/history">
              <?php echo __("Lịch sử");?>

            </a>
          </li>
          <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet">
              <?php echo __("Nạp tiền");?>

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
                      <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance']) {?>
                        <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance']);?>
 VND
                      <?php } else { ?>
                        0 VND
                      <?php }?>
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
                            <input type="text" class="form-control" name="search" placeholder="Số điện thoại, mã OTP..." value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['search']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Dịch vụ</label>
                            <select class="form-select" name="service">
                              <option value="">Tất cả</option>
                              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['services']->value, 'service');
$_smarty_tpl->tpl_vars['service']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
$_smarty_tpl->tpl_vars['service']->do_else = false;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['service']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['selected_service']->value == $_smarty_tpl->tpl_vars['service']->value['id']) {?>selected<?php }?>>
                                  <?php echo $_smarty_tpl->tpl_vars['service']->value['name'];?>

                                </option>
                              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select class="form-select" name="status">
                              <option value="">Tất cả</option>
                              <option value="0" <?php if ($_smarty_tpl->tpl_vars['selected_status']->value == '0') {?>selected<?php }?>>Đợi tin nhắn</option>
                              <option value="1" <?php if ($_smarty_tpl->tpl_vars['selected_status']->value == '1') {?>selected<?php }?>>Hoàn thành</option>
                              <option value="2" <?php if ($_smarty_tpl->tpl_vars['selected_status']->value == '2') {?>selected<?php }?>>Hết hạn</option>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Từ ngày</label>
                            <input type="date" class="form-control" name="from_date" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['from_date']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
                          </div>
                          <div class="col-md-2">
                            <label class="form-label fw-bold">Đến ngày</label>
                            <input type="date" class="form-control" name="to_date" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['to_date']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
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
                        Hiển thị <strong><?php echo (($tmp = $_smarty_tpl->tpl_vars['start_record']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
</strong> - <strong><?php echo (($tmp = $_smarty_tpl->tpl_vars['end_record']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
</strong> 
                        trong tổng số <strong><?php echo (($tmp = $_smarty_tpl->tpl_vars['total_records']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp);?>
</strong> kết quả
                      </span>
                    </div>
                    <div>
                      <span class="text-muted">
                        Trang <strong><?php echo (($tmp = $_smarty_tpl->tpl_vars['current_page']->value ?? null)===null||$tmp==='' ? 1 ?? null : $tmp);?>
</strong> / <strong><?php echo (($tmp = $_smarty_tpl->tpl_vars['total_pages']->value ?? null)===null||$tmp==='' ? 1 ?? null : $tmp);?>
</strong>
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
                    <?php if ($_smarty_tpl->tpl_vars['rentals']->value) {?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rentals']->value, 'rental');
$_smarty_tpl->tpl_vars['rental']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rental']->value) {
$_smarty_tpl->tpl_vars['rental']->do_else = false;
?>
                        <tr>
                          <td><?php echo $_smarty_tpl->tpl_vars['rental']->value['id'];?>
</td>
                          <td>
                            <span class="badge bg-info"><?php echo $_smarty_tpl->tpl_vars['rental']->value['service_name'];?>
</span>
                          </td>
                          <td>
                            <span class="badge bg-primary"><?php echo $_smarty_tpl->tpl_vars['rental']->value['phone_number'];?>
</span>
                          </td>
                          <td>
                            <?php if ($_smarty_tpl->tpl_vars['rental']->value['code']) {?>
                              <span class="badge bg-success"><?php echo $_smarty_tpl->tpl_vars['rental']->value['code'];?>
</span>
                            <?php } else { ?>
                              <span class="text-muted">-</span>
                            <?php }?>
                          </td>
                          <td>
                            <?php if ($_smarty_tpl->tpl_vars['rental']->value['status'] == 0) {?>
                              <span class="badge bg-warning">Đợi tin nhắn</span>
                            <?php } elseif ($_smarty_tpl->tpl_vars['rental']->value['status'] == 1) {?>
                              <span class="badge bg-success">Hoàn thành</span>
                            <?php } elseif ($_smarty_tpl->tpl_vars['rental']->value['status'] == 2) {?>
                              <span class="badge bg-danger">Hết hạn</span>
                            <?php } else { ?>
                              <span class="badge bg-secondary">Không xác định</span>
                            <?php }?>
                          </td>
                          <td>
                            <small class="text-muted">
                              <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['rental']->value['created_time'],"%d/%m/%Y %H:%M");?>

                            </small>
                          </td>
                          <td>
                            <strong class="text-success">
                              <?php echo smarty_modifier_number_format(($_smarty_tpl->tpl_vars['rental']->value['price']*1.2));?>
 VND
                            </strong>
                            <small class="text-muted d-block">
                              (Gốc: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['rental']->value['price']);?>
 VND)
                            </small>
                          </td>
                          <td>
                            <?php if ($_smarty_tpl->tpl_vars['rental']->value['status'] == 0) {?>
                              <button class="btn btn-sm btn-outline-primary" onclick="checkOTP(<?php echo $_smarty_tpl->tpl_vars['rental']->value['id'];?>
)">
                                <i class="fa fa-refresh"></i> Kiểm tra
                              </button>
                            <?php } elseif ($_smarty_tpl->tpl_vars['rental']->value['status'] == 1) {?>
                              <button class="btn btn-sm btn-outline-success" onclick="copyOTP('<?php echo $_smarty_tpl->tpl_vars['rental']->value['code'];?>
')">
                                <i class="fa fa-copy"></i> Copy
                              </button>
                            <?php } else { ?>
                              <span class="text-muted">-</span>
                            <?php }?>
                          </td>
                        </tr>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                      <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                          <i class="fa fa-inbox fa-2x mb-2"></i><br>
                          Không có lịch sử thuê nào
                        </td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <?php if ($_smarty_tpl->tpl_vars['total_pages']->value > 1) {?>
                <div class="row mt-4">
                  <div class="col-12">
                    <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-center">
                        <?php if ($_smarty_tpl->tpl_vars['current_page']->value > 1) {?>
                          <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['current_page']->value-1;?>
&<?php echo http_build_query($_smarty_tpl->tpl_vars['filter_params']->value);?>
">
                              <i class="fa fa-chevron-left"></i>
                            </a>
                          </li>
                        <?php }?>
                        
                        <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? min($_smarty_tpl->tpl_vars['total_pages']->value,$_smarty_tpl->tpl_vars['current_page']->value+2)+1 - (max(1,$_smarty_tpl->tpl_vars['current_page']->value-2)) : max(1,$_smarty_tpl->tpl_vars['current_page']->value-2)-(min($_smarty_tpl->tpl_vars['total_pages']->value,$_smarty_tpl->tpl_vars['current_page']->value+2))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = max(1,$_smarty_tpl->tpl_vars['current_page']->value-2), $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                          <li class="page-item <?php if ($_smarty_tpl->tpl_vars['i']->value == $_smarty_tpl->tpl_vars['current_page']->value) {?>active<?php }?>">
                            <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
&<?php echo http_build_query($_smarty_tpl->tpl_vars['filter_params']->value);?>
">
                              <?php echo $_smarty_tpl->tpl_vars['i']->value;?>

                            </a>
                          </li>
                        <?php }
}
?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['current_page']->value < $_smarty_tpl->tpl_vars['total_pages']->value) {?>
                          <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['current_page']->value+1;?>
&<?php echo http_build_query($_smarty_tpl->tpl_vars['filter_params']->value);?>
">
                              <i class="fa fa-chevron-right"></i>
                            </a>
                          </li>
                        <?php }?>
                      </ul>
                    </nav>
                  </div>
                </div>
              <?php }?>

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

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
function checkOTP(rentalId) {
    // AJAX call to check OTP
    $.ajax({
        url: '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental',
        method: 'POST',
        data: {
            action: 'check_otp',
            rental_id: rentalId
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + response.message);
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
<?php echo '</script'; ?>
>
<?php }
}
