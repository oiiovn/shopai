<?php
/* Smarty version 4.3.4, created on 2025-10-08 14:08:25
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/google-maps-request-details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e6705941a979_75607521',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '65487da5ee7f0d9bb3971a9bc3f9132390343aba' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/google-maps-request-details.tpl',
      1 => 1759932500,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:__svg_icons.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68e6705941a979_75607521 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),2=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.count.php','function'=>'smarty_modifier_count',),3=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">

    <!-- content panel -->
    <div class="col-12">
      
      <!-- Back button -->
      <div class="mb-3">
        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-requests" class="btn btn-secondary">
          <i class="fa fa-arrow-left mr-1"></i>Quay lại danh sách chiến dịch
        </a>
      </div>

      <!-- Campaign Info Card -->
      <div class="card mb-3 shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="fa fa-map-marker-alt mr-2"></i>
            Thông tin chiến dịch
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="text-muted mb-3"><i class="fa fa-info-circle mr-2"></i>Thông tin địa điểm</h6>
              <div class="mb-3">
                <strong>Tên địa điểm:</strong>
                <div class="mt-1"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['place_name'];?>
</div>
              </div>
              <div class="mb-3">
                <strong>Địa chỉ:</strong>
                <div class="mt-1 text-muted"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['place_address'];?>
</div>
              </div>
              <?php if ($_smarty_tpl->tpl_vars['campaign']->value['place_url']) {?>
                <div class="mb-3">
                  <strong>Link Google Maps:</strong>
                  <div class="mt-1">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['place_url'];?>
" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="fa fa-external-link-alt mr-1"></i>Xem trên Google Maps
                    </a>
                  </div>
                </div>
              <?php }?>
            </div>
            <div class="col-md-6">
              <h6 class="text-muted mb-3"><i class="fa fa-chart-line mr-2"></i>Thông tin chiến dịch</h6>
              <div class="mb-2">
                <strong>Mục tiêu:</strong>
                <span class="badge badge-info ml-2"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['target_reviews'];?>
 đánh giá</span>
              </div>
              <div class="mb-2">
                <strong>Chi phí mỗi đánh giá:</strong>
                <span class="text-danger ml-2"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['campaign']->value['reward_amount'],0);?>
 VND</span>
              </div>
              <div class="mb-2">
                <strong>Tổng chi:</strong>
                <span class="text-danger font-weight-bold ml-2"><?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['campaign']->value['total_budget'],0);?>
 VND</span>
              </div>
              <div class="mb-2">
                <strong>Hết hạn:</strong>
                <span class="text-warning ml-2"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['campaign']->value['expires_at'],"%d/%m/%Y %H:%M");?>
</span>
              </div>
              <div class="mb-2">
                <strong>Trạng thái:</strong>
                <span class="badge badge-<?php if ($_smarty_tpl->tpl_vars['campaign']->value['status'] == 'active') {?>success<?php } elseif ($_smarty_tpl->tpl_vars['campaign']->value['status'] == 'completed') {?>primary<?php } else { ?>secondary<?php }?> ml-2">
                  <?php if ($_smarty_tpl->tpl_vars['campaign']->value['status'] == 'active') {?>Kích hoạt<?php } elseif ($_smarty_tpl->tpl_vars['campaign']->value['status'] == 'completed') {?>Hoàn thành<?php } elseif ($_smarty_tpl->tpl_vars['campaign']->value['status'] == 'cancelled') {?>Đã hủy<?php } else { ?>Hết hạn<?php }?>
                </span>
              </div>
              <div class="mb-2">
                <strong>Ngày tạo:</strong>
                <span class="text-muted ml-2"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['campaign']->value['created_at'],"%d/%m/%Y %H:%M");?>
</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sub-requests List -->
      <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <i class="fa fa-tasks mr-2"></i>
              Danh sách nhiệm vụ con
            </h5>
            <span class="badge badge-primary badge-lg" style="font-size: 14px; padding: 8px 15px;">
              <?php echo smarty_modifier_count($_smarty_tpl->tpl_vars['sub_requests']->value);?>
/<?php echo $_smarty_tpl->tpl_vars['campaign']->value['target_reviews'];?>

            </span>
          </div>
        </div>
        <div class="card-body">
          <?php if ($_smarty_tpl->tpl_vars['sub_requests']->value) {?>
            <div class="table-responsive">
              <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                  <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="20%">Người nhận</th>
                    <th width="15%" class="text-center">Số sao</th>
                    <th width="35%">Nội dung đánh giá</th>
                    <th width="15%" class="text-center">Trạng thái</th>
                    <th width="10%" class="text-center">Thông tin</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sub_requests']->value, 'sub', false, 'index');
$_smarty_tpl->tpl_vars['sub']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->do_else = false;
?>
                    <tr>
                      <td class="text-center"><strong class="text-primary"><?php echo $_smarty_tpl->tpl_vars['index']->value+1;?>
</strong></td>
                      <td>
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['assigned_user_id']) {?>
                          <div class="d-flex align-items-center">
                            <?php if ($_smarty_tpl->tpl_vars['sub']->value['user_picture']) {?>
                              <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['sub']->value['user_picture'];?>
" 
                                   alt="" 
                                   class="rounded-circle mr-2" 
                                   style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                            <?php } else { ?>
                              <?php if ($_smarty_tpl->tpl_vars['sub']->value['user_gender'] == '1') {?>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_profile_male.png" 
                                     alt="" 
                                     class="rounded-circle mr-2" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                              <?php } elseif ($_smarty_tpl->tpl_vars['sub']->value['user_gender'] == '2') {?>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_profile_female.png" 
                                     alt="" 
                                     class="rounded-circle mr-2" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                              <?php } else { ?>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_profile.png" 
                                     alt="" 
                                     class="rounded-circle mr-2" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                              <?php }?>
                            <?php }?>
                            <div>
                              <div>
                                <strong><?php if ($_smarty_tpl->tpl_vars['sub']->value['user_firstname']) {
echo $_smarty_tpl->tpl_vars['sub']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['sub']->value['user_lastname'];
} else {
echo $_smarty_tpl->tpl_vars['sub']->value['user_name'];
}?></strong>
                                <?php if ($_smarty_tpl->tpl_vars['sub']->value['user_verified']) {?>
                                  <span class="verified-badge ml-1">
                                    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"verified_badge",'width'=>"14px",'height'=>"14px"), 0, true);
?>
                                  </span>
                                <?php }?>
                              </div>
                              <small class="text-muted">@<?php echo $_smarty_tpl->tpl_vars['sub']->value['user_name'];?>
</small>
                            </div>
                          </div>
                        <?php } else { ?>
                          <span class="text-muted font-italic">
                            <i class="fa fa-user-slash mr-1"></i>Chưa có người nhận
                          </span>
                        <?php }?>
                      </td>
                      <td class="text-center">
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars']) {?>
                          <div class="text-warning mb-1" style="font-size: 18px;">
                            <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars']+1 - (1) : 1-($_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars'])+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                              <i class="fa fa-star"></i>
                            <?php }
}
?>
                            <?php if ($_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars'] < 5) {?>
                              <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 5+1 - ($_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars']+1) : $_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars']+1-(5)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars']+1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
                                <i class="far fa-star"></i>
                              <?php }
}
?>
                            <?php }?>
                          </div>
                        <?php } else { ?>
                          <span class="text-muted">-</span>
                        <?php }?>
                      </td>
                      <td>
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['gpt_review_content']) {?>
                          <div class="mb-1" style="max-height: 60px; overflow: hidden;">
                            <em>"<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['sub']->value['gpt_review_content'],100,"...",true);?>
"</em>
                          </div>
                          <?php if ($_smarty_tpl->tpl_vars['sub']->value['review_url']) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['sub']->value['review_url'];?>
" target="_blank" class="text-primary small">
                              <i class="fa fa-external-link-alt mr-1"></i>Xem review trên Google
                            </a>
                          <?php }?>
                        <?php } else { ?>
                          <span class="text-muted font-italic">Chưa có nội dung</span>
                        <?php }?>
                      </td>
                      <td class="text-center">
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'available') {?>
                          <span class="badge badge-warning badge-status" style="background-color: #ffc107; color: #000; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-clock mr-1"></i>CHƯA NHẬN
                          </span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'assigned') {?>
                          <span class="badge badge-info badge-status" style="background-color: #17a2b8; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-hand-paper mr-1"></i>ĐÃ NHẬN
                          </span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'completed') {?>
                          <span class="badge badge-success badge-status" style="background-color: #28a745; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-check-circle mr-1"></i>HOÀN THÀNH
                          </span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'verified') {?>
                          <span class="badge badge-primary badge-status" style="background-color: #007bff; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-shield-alt mr-1"></i>ĐÃ XÁC MINH
                          </span>
                        <?php } else { ?>
                          <span class="badge badge-danger badge-status" style="background-color: #dc3545; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-times-circle mr-1"></i>HẾT HỊ̀N
                          </span>
                        <?php }?>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary" 
                                onclick='showDetailsModal(<?php echo $_smarty_tpl->tpl_vars['sub']->value['sub_request_id'];?>
, "<?php echo $_smarty_tpl->tpl_vars['sub']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['sub']->value['user_lastname'];?>
", "<?php echo $_smarty_tpl->tpl_vars['sub']->value['gpt_rating_stars'];?>
", "<?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['sub']->value['gpt_review_content'], ENT_QUOTES, 'UTF-8', true);?>
", "<?php echo $_smarty_tpl->tpl_vars['sub']->value['assigned_at'];?>
", "<?php echo $_smarty_tpl->tpl_vars['sub']->value['completed_at'];?>
", "<?php echo $_smarty_tpl->tpl_vars['sub']->value['reward_amount'];?>
")'
                                title="Xem chi tiết">
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
            
            <!-- Summary Stats -->
            <div class="row mt-4">
              <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      <?php $_smarty_tpl->_assignInScope('available_count', 0);?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sub_requests']->value, 'sub');
$_smarty_tpl->tpl_vars['sub']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->do_else = false;
?>
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'available') {
$_smarty_tpl->_assignInScope('available_count', $_smarty_tpl->tpl_vars['available_count']->value+1);
}?>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      <?php echo $_smarty_tpl->tpl_vars['available_count']->value;?>

                    </h3>
                    <p class="mb-0"><i class="fa fa-clock mr-1"></i>Chưa nhận</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="card bg-info text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      <?php $_smarty_tpl->_assignInScope('assigned_count', 0);?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sub_requests']->value, 'sub');
$_smarty_tpl->tpl_vars['sub']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->do_else = false;
?>
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'assigned') {
$_smarty_tpl->_assignInScope('assigned_count', $_smarty_tpl->tpl_vars['assigned_count']->value+1);
}?>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      <?php echo $_smarty_tpl->tpl_vars['assigned_count']->value;?>

                    </h3>
                    <p class="mb-0"><i class="fa fa-hand-paper mr-1"></i>Đã nhận</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="card bg-success text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      <?php $_smarty_tpl->_assignInScope('completed_count', 0);?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sub_requests']->value, 'sub');
$_smarty_tpl->tpl_vars['sub']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->do_else = false;
?>
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'completed' || $_smarty_tpl->tpl_vars['sub']->value['status'] == 'verified') {
$_smarty_tpl->_assignInScope('completed_count', $_smarty_tpl->tpl_vars['completed_count']->value+1);
}?>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      <?php echo $_smarty_tpl->tpl_vars['completed_count']->value;?>

                    </h3>
                    <p class="mb-0"><i class="fa fa-check-circle mr-1"></i>Hoàn thành</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      <?php $_smarty_tpl->_assignInScope('expired_count', 0);?>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sub_requests']->value, 'sub');
$_smarty_tpl->tpl_vars['sub']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->do_else = false;
?>
                        <?php if ($_smarty_tpl->tpl_vars['sub']->value['status'] == 'expired') {
$_smarty_tpl->_assignInScope('expired_count', $_smarty_tpl->tpl_vars['expired_count']->value+1);
}?>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      <?php echo $_smarty_tpl->tpl_vars['expired_count']->value;?>

                    </h3>
                    <p class="mb-0"><i class="fa fa-times-circle mr-1"></i>Hết hạn</p>
                  </div>
                </div>
              </div>
            </div>
            
          <?php } else { ?>
            <div class="text-center py-5">
              <i class="fa fa-tasks fa-4x text-muted mb-3"></i>
              <h5 class="text-muted">Chưa có nhiệm vụ con nào</h5>
              <p class="text-muted">Các nhiệm vụ con sẽ được tạo tự động khi bạn tạo chiến dịch.</p>
            </div>
          <?php }?>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">
          <i class="fa fa-info-circle mr-2"></i>Chi tiết đánh giá
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6><i class="fa fa-user mr-2"></i>Người đánh giá</h6>
            <p id="modalUserName" class="text-muted">-</p>
          </div>
          <div class="col-md-6">
            <h6><i class="fa fa-star mr-2"></i>Đánh giá</h6>
            <div id="modalRating" class="text-warning">-</div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h6><i class="fa fa-comment mr-2"></i>Nội dung đánh giá</h6>
            <p id="modalReviewContent" class="text-muted">-</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <h6><i class="fa fa-calendar-alt mr-2"></i>Ngày nhận</h6>
            <p id="modalAssignedDate" class="text-muted">-</p>
          </div>
          <div class="col-md-6">
            <h6><i class="fa fa-check-circle mr-2"></i>Ngày hoàn thành</h6>
            <p id="modalCompletedDate" class="text-muted">-</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times mr-1"></i>Đóng
        </button>
      </div>
    </div>
  </div>
</div>

<?php echo '<script'; ?>
>
function showDetailsModal(subRequestId, userName, rating, reviewContent, assignedDate, completedDate, rewardAmount) {
  try {
    // Set user name
    document.getElementById('modalUserName').textContent = userName || 'Chưa có người nhận';
    
    // Set rating
    var ratingElement = document.getElementById('modalRating');
    if (rating && rating > 0) {
      var stars = '';
      for (var i = 1; i <= 5; i++) {
        if (i <= rating) {
          stars += '<i class="fa fa-star"></i> ';
        } else {
          stars += '<i class="fa fa-star-o"></i> ';
        }
      }
      ratingElement.innerHTML = stars;
    } else {
      ratingElement.textContent = 'Chưa có đánh giá';
    }
    
    // Set review content
    document.getElementById('modalReviewContent').textContent = reviewContent || 'Chưa có nội dung đánh giá';
    
    // Set assigned date
    document.getElementById('modalAssignedDate').textContent = assignedDate || 'Chưa được giao';
    
    // Set completed date
    document.getElementById('modalCompletedDate').textContent = completedDate || 'Chưa hoàn thành';
    
    // Show modal
    var modalElement = document.getElementById('detailsModal');
    if (modalElement) {
      var modal = new bootstrap.Modal(modalElement);
      modal.show();
    }
    
  } catch (e) {
    console.error('❌ Error showing details modal:', e);
    alert('Lỗi hiển thị chi tiết: ' + e.message);
  }
}
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
