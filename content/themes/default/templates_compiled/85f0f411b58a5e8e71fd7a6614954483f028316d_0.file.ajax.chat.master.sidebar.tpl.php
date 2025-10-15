<?php
/* Smarty version 4.3.4, created on 2025-10-13 07:59:31
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.chat.master.sidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68ecb163745441_92692888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '85f0f411b58a5e8e71fd7a6614954483f028316d' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.chat.master.sidebar.tpl',
      1 => 1690119784,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ecb163745441_92692888 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebar_friends']->value, '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
  <div class="chat-avatar-wrapper clickable js_chat-start" data-uid="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_id'];?>
" data-name="<?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['_user']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_lastname'];
}?>" data-link="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];?>
" data-picture="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_picture'];?>
" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {?> <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_lastname'];?>
 <?php }?>">
    <div class="chat-avatar">
      <img src="<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_picture'];?>
" alt="" />
      <i class="online-status fa fa-circle <?php if ($_smarty_tpl->tpl_vars['_user']->value['user_is_online']) {?>online<?php } else { ?>offline<?php }?>"></i>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['system']->value['chat_status_enabled'] && !$_smarty_tpl->tpl_vars['_user']->value['user_is_online']) {?>
      <div class="last-seen">
        <span class='js_moment' data-time='<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_last_seen'];?>
'><?php echo $_smarty_tpl->tpl_vars['_user']->value['user_last_seen'];?>
</span>
      </div>
    <?php } else { ?>
      <div class="pb10"></div>
    <?php }?>
  </div>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
