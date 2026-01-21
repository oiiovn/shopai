<?php
/* Smarty version 4.3.4, created on 2025-10-16 11:02:13
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/_no_data.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0d0b5daad07_39676829',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2cc344955e30ae3f863824b3454fa2b0a3304a97' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/_no_data.tpl',
      1 => 1760611327,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 1,
  ),
),false)) {
function content_68f0d0b5daad07_39676829 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- no data -->
<div class="text-center text-muted mb20">
  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"empty",'class'=>"mb20",'width'=>"80px",'height'=>"80px"), 0, false);
?>
  <div class="text-md">
    <span class="no-data"><?php echo __("No data to show");?>
</span>
  </div>
</div>
<!-- no data --><?php }
}
