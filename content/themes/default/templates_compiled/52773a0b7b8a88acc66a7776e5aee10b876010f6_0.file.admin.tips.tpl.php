<?php
/* Smarty version 4.3.4, created on 2025-10-10 15:31:05
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/admin.tips.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e926b9f40980_87161230',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52773a0b7b8a88acc66a7776e5aee10b876010f6' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/admin.tips.tpl',
      1 => 1696411560,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 1,
  ),
),false)) {
function content_68e926b9f40980_87161230 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="card">
  <div class="card-header with-icon">
    <i class="fa fa-dollar-sign mr10"></i><?php echo __("Tips");?>

  </div>

  <form class="js_ajax-forms" data-url="admin/settings.php?edit=tips">
    <div class="card-body">
      <div class="form-table-row">
        <div class="avatar">
          <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"tips",'class'=>"main-icon",'width'=>"40px",'height'=>"40px"), 0, false);
?>
        </div>
        <div>
          <div class="form-label h6"><?php echo __("Tips");?>
</div>
          <div class="form-text d-none d-sm-block">
            <?php echo __("Turn the tips On and Off");?>
<br>
            <?php echo __("Make sure you have enabled");?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/wallet"><?php echo __("Wallet System");?>
</a>
          </div>
        </div>
        <div class="text-end">
          <label class="switch" for="tips_enabled">
            <input type="checkbox" name="tips_enabled" id="tips_enabled" <?php if ($_smarty_tpl->tpl_vars['system']->value['tips_enabled']) {?>checked<?php }?>>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-label">
          <?php echo __("Minimum Tip");?>
 (<?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency'];?>
)
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control" name="tips_min_amount" value="<?php echo $_smarty_tpl->tpl_vars['system']->value['tips_min_amount'];?>
">
          <div class="form-text">
            <?php echo __("The minimum amount of money so user can tip");?>

          </div>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-label">
          <?php echo __("Maximum Tip");?>
 (<?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency'];?>
)
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control" name="tips_max_amount" value="<?php echo $_smarty_tpl->tpl_vars['system']->value['tips_max_amount'];?>
">
          <div class="form-text">
            <?php echo __("The maximum amount of money so user can tip");?>

          </div>
        </div>
      </div>

      <!-- success -->
      <div class="alert alert-success mt15 mb0 x-hidden"></div>
      <!-- success -->

      <!-- error -->
      <div class="alert alert-danger mt15 mb0 x-hidden"></div>
      <!-- error -->
    </div>
    <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary"><?php echo __("Save Changes");?>
</button>
    </div>
  </form>
</div><?php }
}
