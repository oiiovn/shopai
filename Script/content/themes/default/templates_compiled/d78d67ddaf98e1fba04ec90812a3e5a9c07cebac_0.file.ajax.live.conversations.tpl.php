<?php
/* Smarty version 4.3.4, created on 2025-10-16 10:43:40
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/ajax.live.conversations.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0cc5c8dd164_98524247',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd78d67ddaf98e1fba04ec90812a3e5a9c07cebac' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/ajax.live.conversations.tpl',
      1 => 1760611327,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__feeds_conversation.tpl' => 1,
  ),
),false)) {
function content_68f0cc5c8dd164_98524247 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['conversations']->value, 'conversation');
$_smarty_tpl->tpl_vars['conversation']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['conversation']->value) {
$_smarty_tpl->tpl_vars['conversation']->do_else = false;
?>
  <?php $_smarty_tpl->_subTemplateRender('file:__feeds_conversation.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
