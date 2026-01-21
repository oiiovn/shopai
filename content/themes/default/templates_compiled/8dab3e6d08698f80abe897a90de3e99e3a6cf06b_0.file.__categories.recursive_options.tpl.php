<?php
/* Smarty version 4.3.4, created on 2025-09-29 06:03:14
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/__categories.recursive_options.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68da2122e20fd4_25633391',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8dab3e6d08698f80abe897a90de3e99e3a6cf06b' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/__categories.recursive_options.tpl',
      1 => 1664801264,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__categories.recursive_options.tpl' => 2,
  ),
),false)) {
function content_68da2122e20fd4_25633391 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
?>
<option <?php if ($_smarty_tpl->tpl_vars['data_category']->value == $_smarty_tpl->tpl_vars['category']->value['category_id']) {?>selected style="font-weight: 600;" class="bg-info" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['category']->value['category_id'];?>
">
  <?php echo str_repeat("- - ",$_smarty_tpl->tpl_vars['category']->value['iteration']);
echo __(smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['category_name'],30));?>

</option>
<?php if ($_smarty_tpl->tpl_vars['category']->value['sub_categories']) {?>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value['sub_categories'], '_category');
$_smarty_tpl->tpl_vars['_category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_category']->value) {
$_smarty_tpl->tpl_vars['_category']->do_else = false;
?>
    <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('category'=>$_smarty_tpl->tpl_vars['_category']->value), 0, true);
?>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
}
