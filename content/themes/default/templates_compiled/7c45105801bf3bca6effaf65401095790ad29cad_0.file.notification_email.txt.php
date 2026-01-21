<?php
/* Smarty version 4.3.4, created on 2025-10-11 10:25:50
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/emails/notification_email.txt' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68ea30aeab0497_10141238',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7c45105801bf3bca6effaf65401095790ad29cad' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/emails/notification_email.txt',
      1 => 1693733144,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ea30aeab0497_10141238 (Smarty_Internal_Template $_smarty_tpl) {
echo __("Hi");?>
 <?php echo $_smarty_tpl->tpl_vars['receiver']->value['name'];?>
,

<?php echo $_smarty_tpl->tpl_vars['user']->value->_data['name'];?>
 <?php echo $_smarty_tpl->tpl_vars['notification']->value['message'];?>

<?php echo $_smarty_tpl->tpl_vars['notification']->value['url'];?>


<?php echo __($_smarty_tpl->tpl_vars['system']->value['system_title']);?>
 <?php echo __("Team");
}
}
