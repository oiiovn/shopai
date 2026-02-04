<?php
/* Smarty version 4.3.4, created on 2025-11-11 13:41:44
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/page.virtual-orders.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_69133d182901c6_13867061',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f595bd3bce0543457298ebf97c6f2c3148c25c1' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/page.virtual-orders.tpl',
      1 => 1762868456,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 2,
  ),
),false)) {
function content_69133d182901c6_13867061 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['spage']->value['page_business_type_id'] != 1) {?>
  <div class="alert alert-warning">
    <?php echo __("Tính năng đơn ảo chỉ áp dụng cho loại hình kinh doanh phù hợp.");?>

  </div>
<?php } elseif (!$_smarty_tpl->tpl_vars['spage']->value['i_admin']) {?>
  <div class="alert alert-info">
    <?php echo __("Chỉ quản trị viên trang mới có thể truy cập mục này.");?>

  </div>
<?php } else { ?>
  <?php if ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'guide') {?>
    <div class="card page-virtual-orders page-virtual-orders-guide">
      <div class="card-header bg-transparent d-flex align-items-center">
        <strong><?php echo __("Hướng dẫn");?>
</strong>
      </div>
      <div class="card-body">
        <div class="alert alert-info mb0">
          <?php echo __("Video hướng dẫn sẽ được cập nhật trực tiếp trong hệ thống. Hiện tại chức năng đang được hoàn thiện.");?>

        </div>
      </div>
    </div>
<?php } elseif ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'create') {?>
    <div class="card page-virtual-orders">
      <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"task_add",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, false);
?>
          <strong>Tạo đơn ảo</strong>
        </div>
        <span class="badge bg-primary text-uppercase"><?php echo __("Beta");?>
</span>
      </div>
      <div class="card-body">
        <p class="text-muted mb20">
          <?php echo __("Điền thông tin bên dưới để tạo một đơn ảo. Các cộng tác viên sẽ nhìn thấy chiến dịch của bạn và có thể nhận thực hiện.");?>

        </p>

        <form class="js_virtual-order-create" data-page-id="<?php echo $_smarty_tpl->tpl_vars['spage']->value['page_id'];?>
">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label"><?php echo __("Tên chiến dịch");?>
</label>
              <input type="text" name="campaign_title" class="form-control" placeholder="<?php echo __("VD: Đơn thử nghiệm RED #1");?>
">
            </div>
            <div class="col-md-6">
              <label class="form-label"><?php echo __("Ngân sách tối đa (VNĐ)");?>
 </label>
              <input type="number" min="0" step="1000" name="budget_limit" class="form-control" placeholder="100000">
            </div>
            <div class="col-md-6">
              <label class="form-label"><?php echo __("Số lượng đơn mục tiêu");?>
</label>
              <input type="number" min="1" name="target_quantity" class="form-control" placeholder="10">
            </div>
            <div class="col-md-6">
              <label class="form-label"><?php echo __("Thời hạn chiến dịch");?>
</label>
              <input type="datetime-local" name="deadline" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label"><?php echo __("Mô tả nhiệm vụ");?>
 <small class="text-muted">(<?php echo __("Chi tiết sản phẩm, bước thực hiện, lưu ý");?>
)</small></label>
              <textarea name="campaign_description" rows="5" class="form-control" placeholder="<?php echo __("Nhập mô tả chi tiết cho đơn ảo...");?>
"></textarea>
            </div>
          </div>

          <div class="mt4 d-flex align-items-center justify-content-between">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="virtual-order-terms" name="accept_terms">
              <label class="form-check-label" for="virtual-order-terms">
                <?php echo __("Tôi đồng ý với chính sách đơn ảo của Shop-ai");?>

              </label>
            </div>
            <button type="submit" class="btn btn-primary">
              <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"send",'class'=>"main-icon mr5",'width'=>"20px",'height'=>"20px"), 0, true);
?>
              <?php echo __("Đăng chiến dịch");?>

            </button>
          </div>
        </form>
      </div>
    </div>
  <?php } else { ?>
    <div class="card page-virtual-orders">
      <div class="card-header bg-transparent d-flex align-items-center">
        <strong>
          <?php if ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'new') {?>
            <?php echo __("Đơn mới");?>

          <?php } elseif ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'received') {?>
            <?php echo __("Đã nhận");?>

          <?php } elseif ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'placed') {?>
            <?php echo __("Đã đặt");?>

          <?php } elseif ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'reviewed') {?>
            <?php echo __("Đã đánh giá");?>

          <?php } elseif ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'completed') {?>
            <?php echo __("Hoàn thành");?>

          <?php } elseif ($_smarty_tpl->tpl_vars['__virtual_orders_tab']->value == 'failed') {?>
            <?php echo __("Thất bại");?>

          <?php }?>
        </strong>
      </div>
      <div class="card-body text-center text-muted py-5">
        <?php echo __("Tính năng đang được phát triển. Vui lòng quay lại sau.");?>

      </div>
    </div>
  <?php }
}?>

<?php }
}
