<?php
/* Smarty version 4.3.4, created on 2025-10-11 06:34:12
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/_review_tasks_mini_card.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e9fa6457da18_76969804',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cc7a75be0d55495847d153e96cc6f2edaae248e9' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/_review_tasks_mini_card.tpl',
      1 => 1760164444,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 1,
  ),
),false)) {
function content_68e9fa6457da18_76969804 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<!-- review tasks -->
<?php if ($_smarty_tpl->tpl_vars['available_tasks']->value) {?>
  <div class="card">
    <div class="card-header bg-transparent border-bottom-0">
      <strong class="text-muted">
        <i class="fa fa-map-marker-alt mr5"></i>
        <?php echo __("Nhiệm vụ đánh giá Google Maps");?>

      </strong>
    </div>
    <div class="card-body" style="padding: 9px;">
      <div class="review-tasks-horizontal-scroll">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['available_tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
?>
        <div class="review-task-item" style="height: 120px;">
          <div class="review-task-mini-card-horizontal" style="border: 1px solid #e9ecef; border-radius: 6px; padding: 16px 12px; background: #fff; height: 112px; display: flex; align-items: center; margin: 8px 0;">
            <span class="sponsored-badge">Được tài trợ</span>
            
            <div class="task-info">
              <div class="task-header">
                <div class="task-details">
                  <div class="task-avatar">
                    <?php if ($_smarty_tpl->tpl_vars['task']->value['user_picture']) {?>
                      <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['task']->value['user_picture'];?>
"
                           alt=""
                           width="32"
                           height="32"
                           style="width: 32px; height: 32px; object-fit: cover;"
                           class="rounded-circle">
                    <?php } else { ?>
                      <?php if ($_smarty_tpl->tpl_vars['task']->value['user_gender'] == '1') {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_profile_male.png"
                             alt=""
                             width="32"
                             height="32"
                             style="width: 32px; height: 32px; object-fit: cover;"
                             class="rounded-circle">
                      <?php } elseif ($_smarty_tpl->tpl_vars['task']->value['user_gender'] == '2') {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_profile_female.png"
                             alt=""
                             width="32"
                             height="32"
                             style="width: 32px; height: 32px; object-fit: cover;"
                             class="rounded-circle">
                      <?php } else { ?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/blank_profile.png"
                             alt=""
                             width="32"
                             height="32"
                             style="width: 32px; height: 32px; object-fit: cover;"
                             class="rounded-circle">
                      <?php }?>
                    <?php }?>
                  </div>
                  <div>
                    <small class="text-muted">
                      <?php if ($_smarty_tpl->tpl_vars['task']->value['user_firstname']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['task']->value['user_firstname'];?>

                      <?php } else { ?>
                        <?php echo __("Người dùng");?>

                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['task']->value['user_verified']) {?>
                        <span class="verified-badge d-inline-flex align-items-center ml-1"
                              data-bs-toggle="tooltip"
                              title='<?php echo __("Verified User");?>
'>
                          <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"verified_badge",'width'=>"12px",'height'=>"12px"), 0, true);
?>
                        </span>
                      <?php }?>
                    </small>
                  </div>
                </div>
              </div>
              
              <div class="task-title"><?php echo $_smarty_tpl->tpl_vars['task']->value['place_name'];?>
</div>
              <div class="task-address">
                <i class="fa fa-map-marker-alt mr5"></i>
                <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['task']->value['place_address'],40);?>

              </div>
              <div class="task-expiry">
                <i class="fa fa-clock mr5"></i>
                Hết hạn: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expires_at'],"%d/%m/%Y");?>

              </div>
            </div>
            
            <div class="task-actions">
              <div class="task-reward">
                <?php echo number_format($_smarty_tpl->tpl_vars['task']->value['reward_amount'],0,',','.');?>
 VND
              </div>
              <button class="btn btn-primary" onclick="showTaskModal(<?php echo $_smarty_tpl->tpl_vars['task']->value['sub_request_id'];?>
, '<?php echo strtr((string)$_smarty_tpl->tpl_vars['task']->value['place_name'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
                       "\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
                       "`" => "\\`", "\${" => "\\\$\{"));?>
', '<?php echo strtr((string)$_smarty_tpl->tpl_vars['task']->value['place_address'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
                       "\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
                       "`" => "\\`", "\${" => "\\\$\{"));?>
', '<?php echo $_smarty_tpl->tpl_vars['task']->value['reward_amount'];?>
', '<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['task']->value['expires_at'],"%d/%m/%Y");?>
')">
                <?php echo __("Nhận");?>

              </button>
            </div>
          </div>
        </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </div>
    </div>
  </div>
<?php }?>

<!-- Task Detail Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">
          <i class="fa fa-map-marker-alt mr5"></i>
          Chi tiết nhiệm vụ đánh giá
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6 class="text-muted mb-3">Thông tin địa điểm</h6>
            <div class="task-detail-info">
              <div class="detail-item mb-3">
                <strong>Tên địa điểm:</strong>
                <div class="mt-1" id="modalPlaceName"></div>
              </div>
              <div class="detail-item mb-3">
                <strong>Địa chỉ:</strong>
                <div class="mt-1" id="modalPlaceAddress"></div>
              </div>
              <div class="detail-item mb-3">
                <strong>Hết hạn:</strong>
                <div class="mt-1 text-warning" id="modalExpiry"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h6 class="text-muted mb-3">Thông tin thưởng</h6>
            <div class="reward-info text-center">
              <div class="reward-amount mb-3">
                <div class="h3 text-success" id="modalRewardAmount"></div>
                <small class="text-muted">Số tiền thưởng</small>
              </div>
              <div class="alert alert-info">
                <i class="fa fa-info-circle mr5"></i>
                <strong>Lưu ý:</strong> Bạn cần đánh giá 5 sao trên Google Maps để nhận thưởng
              </div>
            </div>
          </div>
        </div>
        
        <div class="task-requirements mt-4">
          <h6 class="text-muted mb-3">Yêu cầu thực hiện</h6>
          <div class="requirements-list">
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Tìm kiếm địa điểm trên Google Maps</span>
            </div>
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Đánh giá 5 sao cho địa điểm</span>
            </div>
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Viết đánh giá tích cực (tối thiểu 20 ký tự)</span>
            </div>
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Chụp ảnh màn hình đánh giá để xác minh</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times mr5"></i>
          Hủy
        </button>
        <button type="button" class="btn btn-primary" id="confirmAssignBtn">
          <i class="fa fa-hand-paper mr5"></i>
          Xác nhận nhận nhiệm vụ
        </button>
      </div>
    </div>
  </div>
</div>
<!-- review tasks -->

<?php }
}
