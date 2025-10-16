<?php
/* Smarty version 4.3.4, created on 2025-09-29 13:02:41
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.lightbox.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68da8371637239_23302256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6140c92ff613b6a0ce5c0edd31950e2db08ee569' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.lightbox.tpl',
      1 => 1647975800,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__feeds_post_photo.tpl' => 1,
  ),
),false)) {
function content_68da8371637239_23302256 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('post', $_smarty_tpl->tpl_vars['photo']->value['post']);?>

<div class="lightbox-post" data-id="<?php if ($_smarty_tpl->tpl_vars['photo']->value['is_single']) {
echo $_smarty_tpl->tpl_vars['post']->value['post_id'];
} else {
echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];
}?>">
  <div class="js_scroller" data-slimScroll-height="100%">
    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_post_photo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_lightbox'=>true), 0, false);
?>
  </div>
</div><?php }
}
