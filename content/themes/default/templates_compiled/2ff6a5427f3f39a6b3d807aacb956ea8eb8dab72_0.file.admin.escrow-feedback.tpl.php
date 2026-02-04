<?php
/* Smarty version 4.3.4, created on 2026-02-03 23:43:48
  from '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/admin.escrow-feedback.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6982883480c6e9_62577800',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ff6a5427f3f39a6b3d807aacb956ea8eb8dab72' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/content/themes/default/templates/admin.escrow-feedback.tpl',
      1 => 1770162123,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6982883480c6e9_62577800 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Applications/XAMPP/xamppfiles/htdocs/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div class="card">
  <div class="card-header with-icon">
    <i class="fa fa-handshake mr10"></i><?php echo __("Phản hồi Giao dịch trung gian");?>

  </div>
  <div class="card-body">
    <div class="row mb20">
      <div class="col-md-4">
        <div class="card bg-primary text-white">
          <div class="card-body text-center">
            <h3 class="mb0"><?php echo $_smarty_tpl->tpl_vars['escrow_stats']->value['total'];?>
</h3>
            <small><?php echo __("Tổng phản hồi");?>
</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-success text-white">
          <div class="card-body text-center">
            <h3 class="mb0"><?php echo $_smarty_tpl->tpl_vars['escrow_stats']->value['interest'];?>
</h3>
            <small><?php echo __("Quan tâm & muốn sử dụng");?>
</small>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-info text-white">
          <div class="card-body text-center">
            <h3 class="mb0"><?php echo $_smarty_tpl->tpl_vars['escrow_stats']->value['feedback'];?>
</h3>
            <small><?php echo __("Góp ý hệ thống");?>
</small>
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th><?php echo __("Người gửi");?>
</th>
            <th><?php echo __("Loại");?>
</th>
            <th><?php echo __("Nội dung");?>
</th>
            <th><?php echo __("Thời gian");?>
</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($_smarty_tpl->tpl_vars['escrow_rows']->value) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['escrow_rows']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
              <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
                <td>
                  <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['user_name'];?>
">
                    <img class="tbl-image" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_picture'];?>
" alt="">
                    <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['row']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['row']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['user_lastname'];
}?>
                  </a>
                </td>
                <td>
                  <?php if ($_smarty_tpl->tpl_vars['row']->value['type'] == 'interest') {?>
                    <span class="badge bg-success"><?php echo $_smarty_tpl->tpl_vars['row']->value['type_label'];?>
</span>
                  <?php } else { ?>
                    <span class="badge bg-info"><?php echo $_smarty_tpl->tpl_vars['row']->value['type_label'];?>
</span>
                  <?php }?>
                </td>
                <td><?php if ($_smarty_tpl->tpl_vars['row']->value['message']) {
echo nl2br((string) $_smarty_tpl->tpl_vars['row']->value['message'], (bool) 1);
} else { ?>&mdash;<?php }?></td>
                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['created_at'],"%d/%m/%Y %H:%M");?>
</td>
              </tr>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php } else { ?>
            <tr>
              <td colspan="5" class="text-center text-muted"><?php echo __("Chưa có phản hồi nào.");?>
</td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php }
}
