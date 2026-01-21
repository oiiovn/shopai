<?php
/* Smarty version 4.3.4, created on 2025-10-16 10:43:21
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0cc49440537_70753571',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b1f24bfe524258ce19e0961f6c540aa579209a9a' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/index.tpl',
      1 => 1760611327,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:index.landing.tpl' => 1,
    'file:index.newsfeed.tpl' => 1,
  ),
),false)) {
function content_68f0cc49440537_70753571 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['user']->value->_logged_in && !$_smarty_tpl->tpl_vars['system']->value['newsfeed_public']) {?>
  <?php $_smarty_tpl->_subTemplateRender('file:index.landing.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} else { ?>
  <?php $_smarty_tpl->_subTemplateRender('file:index.newsfeed.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
}
