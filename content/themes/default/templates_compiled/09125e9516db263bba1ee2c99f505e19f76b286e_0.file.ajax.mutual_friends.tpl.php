<?php
/* Smarty version 4.3.4, created on 2025-09-30 08:11:36
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.mutual_friends.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68db90b875e9c1_86858957',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09125e9516db263bba1ee2c99f505e19f76b286e' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.mutual_friends.tpl',
      1 => 1688815326,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__feeds_user.tpl' => 1,
  ),
),false)) {
function content_68db90b875e9c1_86858957 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
  <h6 class="modal-title"><?php echo __("Mutual Friends");?>
 (<?php echo $_smarty_tpl->tpl_vars['total_mutual_friends']->value;?>
)</h6>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <ul>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mutual_friends']->value, '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
      <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_connection'=>"remove"), 0, true);
?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </ul>

  <?php if ($_smarty_tpl->tpl_vars['total_mutual_friends']->value >= $_smarty_tpl->tpl_vars['system']->value['max_results']) {?>
    <!-- see-more -->
    <div class="alert alert-info see-more js_see-more" data-get="mutual_friends" data-uid="<?php echo $_smarty_tpl->tpl_vars['uid']->value;?>
">
      <span><?php echo __("See More");?>
</span>
      <div class="loader loader_small x-hidden"></div>
    </div>
    <!-- see-more -->
  <?php }?>
</div><?php }
}
