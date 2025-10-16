<?php
/* Smarty version 4.3.4, created on 2025-09-30 09:08:17
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/emails/contact_form_email.txt' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68db9e01c5efb2_17819785',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2948fc7455fe58e92c70d22c9039eaacc2edfae5' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/emails/contact_form_email.txt',
      1 => 1693733138,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68db9e01c5efb2_17819785 (Smarty_Internal_Template $_smarty_tpl) {
echo __("Hi");?>
,

<?php echo __("You have a new email message");?>


<?php echo __("Email Subject");?>
: <?php echo $_smarty_tpl->tpl_vars['subject']->value;?>


<?php echo __("Sender Name");?>
: <?php echo $_smarty_tpl->tpl_vars['name']->value;?>


<?php echo __("Sender Email");?>
: <?php echo $_smarty_tpl->tpl_vars['email']->value;?>


<?php echo __("Email Message");?>
: <?php echo $_smarty_tpl->tpl_vars['message']->value;?>


<?php echo __($_smarty_tpl->tpl_vars['system']->value['system_title']);?>
 <?php echo __("Team");
}
}
