<?php
/* Smarty version 4.3.4, created on 2025-10-10 15:36:56
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.offer.publisher.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e92818a32e55_64824461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '11ad0adb1a6ec059af4ae7abb1a6aeae2620f8f2' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.offer.publisher.tpl',
      1 => 1689527922,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 1,
    'file:__categories.recursive_options.tpl' => 1,
    'file:__custom_fields.tpl' => 1,
  ),
),false)) {
function content_68e92818a32e55_64824461 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
  <h6 class="modal-title">
    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"offers",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, false);
?></i><?php echo __("Create New Offer");?>

  </h6>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="js_ajax-forms" data-url="posts/offer.php?do=publish">
  <div class="modal-body">
    <div class="row">
      <!-- discount type -->
      <div class="form-group col-md-6">
        <label class="form-label"><?php echo __("Type");?>
</label>
        <select class="form-select" id="js_discount-type" name="discount_type">
          <option value="discount_percent"><?php echo __("Discount Percent");?>
</option>
          <option value="discount_amount"><?php echo __("Discount Amount");?>
</option>
          <option value="buy_get_discount"><?php echo __("Buy X Get Y Discount");?>
</option>
          <option value="spend_get_off"><?php echo __("Spend X Get Y Off");?>
</option>
          <option value="free_shipping"><?php echo __("Free Shipping");?>
</option>
        </select>
      </div>
      <!-- discount type -->
      <!-- discount percent -->
      <div id="js_discount-percent" class="form-group col-md-6">
        <label class="form-label"><?php echo __("Discount Percent");?>
</label>
        <select class="form-select" name="discount_percent">
          <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 99+1 - (1) : 1-(99)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
            <option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
%</option>
          <?php }
}
?>
        </select>
      </div>
      <!-- discount percent -->
      <!-- discount amount -->
      <div id="js_discount-amount" class="form-group col-md-6 x-hidden">
        <label class="form-label"><?php echo __("Discount Amount");?>
</label>
        <div class="input-group">
          <?php if ($_smarty_tpl->tpl_vars['system']->value['system_currency_dir'] == "left") {?>
            <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
          <?php }?>
          <input name="discount_amount" type="text" class="form-control" placeholder="0.00">
          <?php if ($_smarty_tpl->tpl_vars['system']->value['system_currency_dir'] == "right") {?>
            <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
          <?php }?>
        </div>
      </div>
      <!-- discount amount -->
    </div>
    <!-- buy get discount -->
    <div id="js_buy-get-discount" class="x-hidden">
      <div class="row">
        <div class="form-group col-md-6">
          <label class="form-label"><?php echo __("Buy");?>
</label>
          <input name="buy_x" type="text" class="form-control">
          <div class="form-text">
            <?php echo __("Enter numric value (Example: 5)");?>

          </div>
        </div>
        <div class="form-group col-md-6">
          <label class="form-label"><?php echo __("Get");?>
</label>
          <input name="get_y" type="text" class="form-control">
          <div class="form-text">
            <?php echo __("Enter numric value (Example: 2)");?>

          </div>
        </div>
      </div>
    </div>
    <!-- buy get discount -->
    <!-- spend get off -->
    <div id="js_spend-get-off" class="x-hidden">
      <div class="row">
        <div class="form-group col-md-6">
          <label class="form-label"><?php echo __("Spend");?>
</label>
          <div class="input-group">
            <?php if ($_smarty_tpl->tpl_vars['system']->value['system_currency_dir'] == "left") {?>
              <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
            <?php }?>
            <input name="spend_x" type="text" class="form-control" placeholder="0.00">
            <?php if ($_smarty_tpl->tpl_vars['system']->value['system_currency_dir'] == "right") {?>
              <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
            <?php }?>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label class="form-label"><?php echo __("Amount Off");?>
</label>
          <div class="input-group">
            <?php if ($_smarty_tpl->tpl_vars['system']->value['system_currency_dir'] == "left") {?>
              <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
            <?php }?>
            <input name="amount_y" type="text" class="form-control" placeholder="0.00">
            <?php if ($_smarty_tpl->tpl_vars['system']->value['system_currency_dir'] == "right") {?>
              <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
    <!-- spend get off -->
    <div class="row">
      <!-- end date -->
      <div class="form-group col-md-6">
        <label class="form-label"><?php echo __("End Date");?>
</label>
        <input type="datetime-local" class="form-control" name="end_date">
      </div>
      <!-- end date -->
      <!-- category -->
      <div class="form-group col-md-6">
        <label class="form-label"><?php echo __("Category");?>
</label>
        <select class="form-select" name="category">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['offers_categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
            <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </select>
      </div>
      <!-- category -->
    </div>
    <!-- title -->
    <div class="form-group">
      <label class="form-label"><?php echo __("Discounted Items and/or Services");?>
</label>
      <input name="title" type="text" class="form-control">
    </div>
    <!-- title -->
    <!-- description -->
    <div class="form-group">
      <label class="form-label"><?php echo __("Description");?>
</label>
      <textarea name="description" rows="5" dir="auto" class="form-control"></textarea>
    </div>
    <!-- description -->
    <!-- custom fields -->
    <?php if ($_smarty_tpl->tpl_vars['custom_fields']->value) {?>
      <?php $_smarty_tpl->_subTemplateRender('file:__custom_fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_custom_fields'=>$_smarty_tpl->tpl_vars['custom_fields']->value,'_registration'=>true), 0, false);
?>
    <?php }?>
    <!-- custom fields -->
    <!-- thumbnail -->
    <div class="form-group">
      <label class="form-label"><?php echo __("Thumbnail");?>
</label>
      <div class="x-image">
        <div class="x-image-loader">
          <div class="progress x-progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <i class="fa fa-camera fa-lg js_x-uploader" data-handle="x-image"></i>
        <input type="hidden" class="js_x-image-input" name="thumbnail" value="">
      </div>
    </div>
    <!-- thumbnail -->
    <!-- error -->
    <div class="alert alert-danger mt15 mb0 x-hidden"></div>
    <!-- error -->
  </div>
  <div class="modal-footer">
    <input type="hidden" name="page_id" value="<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
">
    <button type="submit" class="btn btn-primary"><?php echo __("Publish");?>
</button>
  </div>
</form>

<?php echo '<script'; ?>
>
  $(function() {
    /* handle offer input dependencies */
    $('#js_discount-type').on('change', function() {
      switch ($(this).val()) {
        case "discount_percent":
          $("#js_discount-percent").show();
          $("#js_discount-amount").hide();
          $("#js_buy-get-discount").hide();
          $("#js_spend-get-off").hide();
          break;

        case "discount_amount":
          $("#js_discount-percent").hide();
          $("#js_discount-amount").show();
          $("#js_buy-get-discount").hide();
          $("#js_spend-get-off").hide();
          break;

        case "buy_get_discount":
          $("#js_discount-percent").hide();
          $("#js_discount-amount").hide();
          $("#js_buy-get-discount").show();
          $("#js_spend-get-off").hide();
          break;

        case "spend_get_off":
          $("#js_discount-percent").hide();
          $("#js_discount-amount").hide();
          $("#js_buy-get-discount").hide();
          $("#js_spend-get-off").show();
          break;

        case "free_shipping":
          $("#js_discount-percent").hide();
          $("#js_discount-amount").hide();
          $("#js_buy-get-discount").hide();
          $("#js_spend-get-off").hide();
          break;
      }
    });
  });
<?php echo '</script'; ?>
><?php }
}
