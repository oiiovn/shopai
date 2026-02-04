<?php
/* Smarty version 4.3.4, created on 2026-02-02 05:55:57
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.share.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_69803c6d7f7370_95320136',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '74cb021c289250eeadf575b86615b15b7edc9b1e' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ajax.share.tpl',
      1 => 1698842536,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 1,
  ),
),false)) {
function content_69803c6d7f7370_95320136 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal-header">
  <h6 class="modal-title">
    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"share",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, false);
?>
    <?php echo __("Share");?>

  </h6>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div style="margin: 25px auto;">
    <div class="input-group">
      <input type="text" disabled class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
">
      <button type="button" class="btn btn-light js_clipboard" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" data-bs-toggle="tooltip" title='<?php echo __("Copy");?>
'>
        <i class="fas fa-copy"></i>
      </button>
    </div>
  </div>

  <?php if ($_smarty_tpl->tpl_vars['system']->value['social_share_enabled']) {?>
    <div class="post-social-share border-bottom-0">
      <a href="http://www.facebook.com/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-facebook" target="_blank">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="https://twitter.com/intent/tweet?url=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-rounded btn-twitter" target="_blank">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="https://vk.com/share.php?url=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-vk" target="_blank">
        <i class="fab fa-vk"></i>
      </a>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-linkedin" target="_blank">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="https://api.whatsapp.com/send?text=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-whatsapp d-none d-sm-inline-block" target="_blank">
        <i class="fab fa-whatsapp"></i>
      </a>
      <a href="https://reddit.com/submit?url=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-reddit" target="_blank">
        <i class="fab fa-reddit"></i>
      </a>
      <a href="https://pinterest.com/pin/create/button/?url=<?php echo $_smarty_tpl->tpl_vars['share_link']->value;?>
" class="btn btn-sm btn-rounded btn-social-icon btn-pinterest" target="_blank">
        <i class="fab fa-pinterest"></i>
      </a>
    </div>
  <?php }?>

</div><?php }
}
