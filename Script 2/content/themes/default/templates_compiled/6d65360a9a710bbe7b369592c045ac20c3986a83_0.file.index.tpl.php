<?php
/* Smarty version 4.3.4, created on 2025-10-16 06:40:34
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script 2/content/themes/default/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f093620eeb46_35353155',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6d65360a9a710bbe7b369592c045ac20c3986a83' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script 2/content/themes/default/templates/index.tpl',
      1 => 1760240015,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:index.landing.tpl' => 1,
    'file:index.newsfeed.tpl' => 1,
  ),
),false)) {
function content_68f093620eeb46_35353155 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['user']->value->_logged_in && !$_smarty_tpl->tpl_vars['system']->value['newsfeed_public']) {?>
  <?php $_smarty_tpl->_subTemplateRender('file:index.landing.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} else { ?>
  <?php $_smarty_tpl->_subTemplateRender('file:index.newsfeed.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
}
