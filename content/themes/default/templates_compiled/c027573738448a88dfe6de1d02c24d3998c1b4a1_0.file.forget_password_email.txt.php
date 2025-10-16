<?php
/* Smarty version 4.3.4, created on 2025-09-29 10:24:34
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/emails/forget_password_email.txt' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68da5e624a8b69_71684029',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c027573738448a88dfe6de1d02c24d3998c1b4a1' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/emails/forget_password_email.txt',
      1 => 1693733140,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68da5e624a8b69_71684029 (Smarty_Internal_Template $_smarty_tpl) {
echo __("Hi");?>


<?php echo __("To complete the reset password process, please copy this token");?>
:

<?php echo __("Token");?>
: <?php echo $_smarty_tpl->tpl_vars['reset_key']->value;?>


<?php echo __($_smarty_tpl->tpl_vars['system']->value['system_title']);?>
 <?php echo __("Team");
}
}
