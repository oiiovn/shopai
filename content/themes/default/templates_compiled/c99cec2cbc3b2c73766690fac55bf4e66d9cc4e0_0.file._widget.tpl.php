<?php
/* Smarty version 4.3.4, created on 2025-09-29 06:03:15
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/_widget.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68da21231cb766_31825575',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c99cec2cbc3b2c73766690fac55bf4e66d9cc4e0' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/_widget.tpl',
      1 => 1647975706,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68da21231cb766_31825575 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['widgets']->value) {?>
  <!-- Widgets -->
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['widgets']->value, 'widget');
$_smarty_tpl->tpl_vars['widget']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['widget']->value) {
$_smarty_tpl->tpl_vars['widget']->do_else = false;
?>
    <div class="card">
      <div class="card-header">
        <strong><?php ob_start();
echo $_smarty_tpl->tpl_vars['widget']->value['title'];
$_prefixVariable2 = ob_get_clean();
echo __($_prefixVariable2);?>
</strong>
      </div>
      <div class="card-body"><?php echo $_smarty_tpl->tpl_vars['widget']->value['code'];?>
</div>
    </div>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <!-- Widgets -->
<?php }
}
}
