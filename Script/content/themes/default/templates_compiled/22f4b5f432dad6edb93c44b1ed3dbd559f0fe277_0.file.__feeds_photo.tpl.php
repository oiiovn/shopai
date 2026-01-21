<?php
/* Smarty version 4.3.4, created on 2025-10-16 11:23:09
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/__feeds_photo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0d59d57bf24_86224715',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22f4b5f432dad6edb93c44b1ed3dbd559f0fe277' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/__feeds_photo.tpl',
      1 => 1760611327,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68f0d59d57bf24_86224715 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="<?php if ($_smarty_tpl->tpl_vars['_small']->value) {?>col-4<?php } else { ?>col-6 col-md-4 col-lg-2<?php }?> <?php if ($_smarty_tpl->tpl_vars['photo']->value['blur']) {?>x-blured<?php }?>">
  <a class="pg_photo <?php if (!$_smarty_tpl->tpl_vars['_small']->value) {?>large<?php }?> js_lightbox" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/photos/<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-image="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['photo']->value['source'];?>
" data-context="<?php echo $_smarty_tpl->tpl_vars['_context']->value;?>
" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['photo']->value['source'];?>
);">
    <?php if (!$_smarty_tpl->tpl_vars['_small']->value && ($_smarty_tpl->tpl_vars['_manage']->value || $_smarty_tpl->tpl_vars['photo']->value['manage'])) {?>
      <!-- delete -->
      <div class="pg_photo-delete-btn">
        <button type="button" class="btn-close js_delete-photo" data-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-bs-toggle="tooltip" title='<?php echo __("Delete");?>
'></button>
      </div>
      <!-- delete -->
      <?php if ($_smarty_tpl->tpl_vars['_can_pin']->value) {?>
        <!-- pin -->
        <div class="pg_photo-pin-btn <?php if ($_smarty_tpl->tpl_vars['photo']->value['pinned']) {?>js_unpin-photo pinned<?php } else { ?>js_pin-photo<?php }?>" data-id="<?php echo $_smarty_tpl->tpl_vars['photo']->value['photo_id'];?>
" data-bs-toggle="tooltip" title='<?php echo __("Pin");?>
'>
          <i class="fa-solid fa-paperclip"></i>
        </div>
        <!-- pin -->
      <?php }?>
    <?php }?>
  </a>
</div><?php }
}
