<?php
/* Smarty version 4.3.4, created on 2025-10-24 06:20:49
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/__feeds_profile_photo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68fb1ac13de507_10904309',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0037b44e2479ad5212bb6758486d04362aadab0a' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/__feeds_profile_photo.tpl',
      1 => 1690152648,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68fb1ac13de507_10904309 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="col-4 mb10">
  <div class="pg_photo pointer <?php if ($_smarty_tpl->tpl_vars['_filter']->value == "avatar") {?>js_profile-picture-change<?php } else { ?>js_profile-cover-change<?php }?>" data-id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
 data-type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
 data-image="<?php echo $_smarty_tpl->tpl_vars['photo']->value['source'];?>
" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['photo']->value['source'];?>
);">
  </div>
</div><?php }
}
