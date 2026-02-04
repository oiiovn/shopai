<?php
/* Smarty version 4.3.4, created on 2025-10-18 04:34:11
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/forums.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f318c3649ef3_86998020',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '71aa33f5b00095326ae4cc3b27a5b75b1cbb69c8' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/forums.tpl',
      1 => 1698934756,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:__svg_icons.tpl' => 7,
    'file:_no_data.tpl' => 4,
    'file:admin.forums.recursive_options.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68f318c3649ef3_86998020 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page header -->
<div class="page-header">
  <img class="floating-img d-none d-md-block" src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/headers/undraw_elements_cipa.svg">
  <div class="circle-2"></div>
  <div class="circle-3"></div>
  <div class="inner">
    <h2><?php echo __("Forums");?>
</h2>
    <p class="text-xlg"><?php echo __($_smarty_tpl->tpl_vars['system']->value['system_description_forums']);?>
</p>
  </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> sg-offcanvas" style="margin-top: -25px;">
  <div class="row">

    <!-- side panel -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt20">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <!-- side panel -->

    <!-- content panel -->
    <div class="col-12 sg-offcanvas-mainbar">

      <div class="position-relative">
        <!-- tabs -->
        <div class="content-tabs rounded-sm shadow-sm clearfix">
          <ul>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"home",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, false);
?>
                <?php echo __("Home");?>

              </a>
            </li>
            <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
              <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "my-threads") {?>class="active" <?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/my-threads">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"documents",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                  <?php echo __("My Threads");?>

                </a>
              </li>
              <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "my-replies") {?>class="active" <?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/my-replies">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"comments",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                  <?php echo __("My Replies");?>

                </a>
              </li>
            <?php }?>
            <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "search") {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/search">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"search",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                <?php echo __("Search");?>

              </a>
            </li>
          </ul>
        </div>
        <!-- tabs -->
      </div>

      <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>
        <!-- forums -->
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['forums']->value, 'forum');
$_smarty_tpl->tpl_vars['forum']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['forum']->value) {
$_smarty_tpl->tpl_vars['forum']->do_else = false;
?>
          <div class="forum-category">
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['forum']->value['forum_name']);?>
</a>
            <div class="float-end pointer">
              <i class="fa fa-sort js_forum-toggle"></i>
            </div>
          </div>
          <?php if ($_smarty_tpl->tpl_vars['forum']->value['childs']) {?>
            <div class="js_forum-toggle-wrapper">
              <div class="row forum-head">
                <div class="col-12 col-sm-8 column">
                  <?php echo __("Forums");?>

                </div>
                <div class="col-sm-2 d-none d-sm-block column">
                  <?php echo __("Threads");?>

                </div>
                <div class="col-sm-2 d-none d-sm-block column">
                  <?php echo __("Replies");?>

                </div>
              </div>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['forum']->value['childs'], '_forum');
$_smarty_tpl->tpl_vars['_forum']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_forum']->value) {
$_smarty_tpl->tpl_vars['_forum']->do_else = false;
?>
                <div class="row forum-row">
                  <div class="col-sm-1 d-none d-sm-block column icon">
                    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"comments",'class'=>"main-icon",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                  </div>
                  <div class="col-12 col-sm-7 column">
                    <div class="mb5">
                      <strong><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['_forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['_forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['_forum']->value['forum_name']);?>
</a></strong>
                      <span class="visible-xs-inline-block">(<?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_threads'];?>
 <?php echo __("Threads");?>
 / <?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_replies'];?>
 <?php echo __("Replies");?>
)</span>
                    </div>
                    <div class="mb5">
                      <?php echo __($_smarty_tpl->tpl_vars['_forum']->value['forum_description']);?>

                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['_forum']->value['childs']) {?>
                      <div class="mb5"><strong><?php echo __("Sub-Forums");?>
:</strong></div>
                      <div>
                        <ul class="sub-forums">
                          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_forum']->value['childs'], '__forum', true);
$_smarty_tpl->tpl_vars['__forum']->iteration = 0;
$_smarty_tpl->tpl_vars['__forum']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['__forum']->value) {
$_smarty_tpl->tpl_vars['__forum']->do_else = false;
$_smarty_tpl->tpl_vars['__forum']->iteration++;
$_smarty_tpl->tpl_vars['__forum']->last = $_smarty_tpl->tpl_vars['__forum']->iteration === $_smarty_tpl->tpl_vars['__forum']->total;
$__foreach___forum_2_saved = $_smarty_tpl->tpl_vars['__forum'];
?>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['__forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['_forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['__forum']->value['forum_name']);?>
</a><?php if (!$_smarty_tpl->tpl_vars['__forum']->last) {?>, <?php }?></li>
                          <?php
$_smarty_tpl->tpl_vars['__forum'] = $__foreach___forum_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </ul>
                      </div>
                    <?php }?>
                  </div>
                  <div class="col-sm-2 d-none d-sm-block column text-center">
                    <?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_threads'];?>

                  </div>
                  <div class="col-sm-2 d-none d-sm-block column text-center">
                    <?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_replies'];?>

                  </div>
                </div>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
          <?php }?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <!-- forums -->

        <!-- forums meta -->
        <?php if ($_smarty_tpl->tpl_vars['system']->value['forums_online_enabled'] || $_smarty_tpl->tpl_vars['system']->value['forums_statistics_enabled']) {?>
          <div class="forum-category">
            <?php echo __("What's Going On?");?>

          </div>
          <!-- online users -->
          <?php if ($_smarty_tpl->tpl_vars['system']->value['forums_online_enabled']) {?>
            <div class="forum-meta-head">
              <?php echo __("Who's online");?>
<span class="badge badge-lg bg-secondary ml5"><?php echo smarty_modifier_number_format(count($_smarty_tpl->tpl_vars['online_users']->value),0);?>
</span>
            </div>
            <div class="forum-meta-conent">
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['online_users']->value, '_user', true);
$_smarty_tpl->tpl_vars['_user']->iteration = 0;
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
$_smarty_tpl->tpl_vars['_user']->iteration++;
$_smarty_tpl->tpl_vars['_user']->last = $_smarty_tpl->tpl_vars['_user']->iteration === $_smarty_tpl->tpl_vars['_user']->total;
$__foreach__user_3_saved = $_smarty_tpl->tpl_vars['_user'];
?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];?>
">
                  <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {?>
                    <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_name'];?>

                  <?php } else { ?>
                    <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_user']->value['user_lastname'];?>

                  <?php }?>
                </a>
                <?php if (!$_smarty_tpl->tpl_vars['_user']->last) {?>, <?php }?>
              <?php
$_smarty_tpl->tpl_vars['_user'] = $__foreach__user_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
          <?php }?>
          <!-- online users -->
          <!-- statistics -->
          <?php if ($_smarty_tpl->tpl_vars['system']->value['forums_statistics_enabled']) {?>
            <div class="forum-meta-head">
              <?php echo __("Forum Statistics");?>

            </div>
            <div class="forum-meta-conent">
              <span class="pr10"><strong><?php echo __("Threads");?>
</strong>: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['insights']->value['threads'],0);?>
</span>
              <span class="pr10"><strong><?php echo __("Replies");?>
</strong>: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['insights']->value['replies'],0);?>
</span>
              <span class="pr10"><strong><?php echo __("Members");?>
</strong>: <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['insights']->value['users'],0);?>
</span>
            </div>
          <?php }?>
          <!-- statistics -->
        <?php }?>
        <!-- forums meta -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "forum") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <?php if ($_smarty_tpl->tpl_vars['forum']->value['parents']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['forum']->value['parents']), 'parent');
$_smarty_tpl->tpl_vars['parent']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->do_else = false;
?>
              <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['parent']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['parent']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['parent']->value['forum_name']);?>
</a></li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php }?>
          <li class="breadcrumb-item active"><?php echo __($_smarty_tpl->tpl_vars['forum']->value['forum_name']);?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- forum title & description -->
        <div class="forum-title clearfix">
          <?php if ($_smarty_tpl->tpl_vars['forum']->value['forum_section'] != '0') {?>
            <div class="float-end">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/new-thread/<?php echo $_smarty_tpl->tpl_vars['forum']->value['forum_id'];?>
" class="btn btn-md btn-success">
                <i class="fa fa-edit mr5"></i><?php echo __("Write New Thread");?>

              </a>
            </div>
          <?php }?>
          <h1><?php echo __($_smarty_tpl->tpl_vars['forum']->value['forum_name']);?>
</h1>
          <p><?php echo __($_smarty_tpl->tpl_vars['forum']->value['forum_description']);?>
</p>
        </div>
        <!-- forum title & description -->

        <!-- forum-category -->
        <?php if ($_smarty_tpl->tpl_vars['forum']->value['forum_section'] == '0') {?>
          <div class="forum-category">
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['forum']->value['forum_name']);?>
</a>
          </div>
        <?php }?>
        <!-- forum-category -->

        <!-- childs (forums|sub-forums) -->
        <?php if ($_smarty_tpl->tpl_vars['forum']->value['childs']) {?>
          <div class="row forum-head">
            <div class="col-12 col-sm-8 column">
              <?php if ($_smarty_tpl->tpl_vars['forum']->value['forum_section'] == '0') {
echo __("Forums");
} else {
echo __("Sub-Forums");
}?>
            </div>
            <div class="col-sm-2 d-none d-sm-block column">
              <?php echo __("Threads");?>

            </div>
            <div class="col-sm-2 d-none d-sm-block column">
              <?php echo __("Replies");?>

            </div>
          </div>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['forum']->value['childs'], '_forum');
$_smarty_tpl->tpl_vars['_forum']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_forum']->value) {
$_smarty_tpl->tpl_vars['_forum']->do_else = false;
?>
            <div class="row forum-row">
              <div class="col-sm-1 d-none d-sm-block column icon">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"comments",'class'=>"main-icon",'width'=>"24px",'height'=>"24px"), 0, true);
?>
              </div>
              <div class="col-12 col-sm-7 column">
                <div class="mb5">
                  <strong><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['_forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['_forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['_forum']->value['forum_name']);?>
</a></strong>
                  <span class="visible-xs-inline-block">(<?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_threads'];?>
 <?php echo __("Threads");?>
 / <?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_replies'];?>
 <?php echo __("Replies");?>
)</span>
                </div>
                <div class="mb5">
                  <?php echo __($_smarty_tpl->tpl_vars['_forum']->value['forum_description']);?>

                </div>
                <?php if ($_smarty_tpl->tpl_vars['_forum']->value['childs']) {?>
                  <div class="mb5"><strong><?php echo __("Sub-Forums");?>
:</strong></div>
                  <div>
                    <ul class="sub-forums">
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_forum']->value['childs'], '__forum', true);
$_smarty_tpl->tpl_vars['__forum']->iteration = 0;
$_smarty_tpl->tpl_vars['__forum']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['__forum']->value) {
$_smarty_tpl->tpl_vars['__forum']->do_else = false;
$_smarty_tpl->tpl_vars['__forum']->iteration++;
$_smarty_tpl->tpl_vars['__forum']->last = $_smarty_tpl->tpl_vars['__forum']->iteration === $_smarty_tpl->tpl_vars['__forum']->total;
$__foreach___forum_6_saved = $_smarty_tpl->tpl_vars['__forum'];
?>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['__forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['_forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['__forum']->value['forum_name']);?>
</a><?php if (!$_smarty_tpl->tpl_vars['__forum']->last) {?>, <?php }?></li>
                      <?php
$_smarty_tpl->tpl_vars['__forum'] = $__foreach___forum_6_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>
                  </div>
                <?php }?>
              </div>
              <div class="col-sm-2 d-none d-sm-block column text-center">
                <?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_threads'];?>

              </div>
              <div class="col-sm-2 d-none d-sm-block column text-center">
                <?php echo $_smarty_tpl->tpl_vars['_forum']->value['total_replies'];?>

              </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php }?>
        <!-- childs (forums|sub-forums) -->

        <!-- threads -->
        <?php if ($_smarty_tpl->tpl_vars['forum']->value['forum_section'] != '0') {?>
          <div class="row forum-head threads">
            <div class="col-12 col-sm-8 column">
              <?php echo __("Thread");?>

            </div>
            <div class="col-sm-2 d-none d-sm-block column">
              <?php echo __("Replies");?>
 / <?php echo __("Views");?>

            </div>
            <div class="col-sm-2 d-none d-sm-block column">
              <?php echo __("Last Post");?>

            </div>
          </div>
          <?php if ($_smarty_tpl->tpl_vars['forum']->value['threads']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['forum']->value['threads'], 'thread');
$_smarty_tpl->tpl_vars['thread']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['thread']->value) {
$_smarty_tpl->tpl_vars['thread']->do_else = false;
?>
              <div class="row forum-row">
                <div class="col-12 col-sm-8 column">
                  <div class="mb5">
                    <strong><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</a></strong>
                  </div>
                  <div class="mb5">
                    <?php echo __("By");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['user_fullname'];?>
</a> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
</span>
                  </div>
                </div>
                <div class="col-sm-2 d-none d-sm-block column text-center">
                  <?php echo __("Replies");?>
: <?php echo $_smarty_tpl->tpl_vars['thread']->value['replies'];?>
<br><?php echo __("Views");?>
: <?php echo $_smarty_tpl->tpl_vars['thread']->value['views'];?>

                </div>
                <div class="col-sm-2 d-none d-sm-block column text-center">
                  <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['last_reply'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['last_reply'];?>
</span>
                </div>
              </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

          <?php } else { ?>
            <div class="row forum-row">
              <div class="col-12 column text-center">
                <?php echo __("No Threads");?>

              </div>
            </div>
          <?php }?>
        <?php }?>
        <!-- threads -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "thread") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <?php if ($_smarty_tpl->tpl_vars['thread']->value['forum']['parents']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['thread']->value['forum']['parents']), 'parent');
$_smarty_tpl->tpl_vars['parent']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->do_else = false;
?>
              <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['parent']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['parent']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['parent']->value['forum_name']);?>
</a></li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php }?>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['thread']->value['forum']['forum_name']);?>
</a></li>
          <li class="breadcrumb-item active"><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- thread title -->
        <div class="forum-title clearfix">
          <div class="float-end">
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/new-reply/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
" class="btn btn-md btn-primary">
              <i class="fa fa-reply mr10"></i><?php echo __("Post Reply");?>

            </a>
          </div>
          <h1><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</h1>
        </div>
        <!-- thread title -->

        <!-- thread -->
        <div class="forum-thread <?php if ($_smarty_tpl->tpl_vars['thread']->value['replies'] > 0 && $_smarty_tpl->tpl_vars['selected_page']->value != 1) {?>x-hidden<?php }?>">
          <div class="row">
            <div class="col-12 col-sm-2 text-center">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_name'];?>
"><img class="avatar" src="<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_picture'];?>
"></a>
              <h6 class="mt10">
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['user_fullname'];?>
</a>
              </h6>
              <div class="mb5">
                <?php if ($_smarty_tpl->tpl_vars['thread']->value['user_group'] == 1) {?>
                  <i class="fa fa-shield-alt"></i> <?php echo __("Admin");?>

                <?php } elseif ($_smarty_tpl->tpl_vars['thread']->value['user_group'] == 2) {?>
                  <i class="fab fa-black-tie"></i> <?php echo __("Moderator");?>

                <?php } else { ?>
                  <i class="fa fa-user"></i> <?php echo __("Member");?>

                <?php }?>
              </div>
              <div>
                <small><?php echo __("Joined");?>
: <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_registered'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['user_registered'];?>
</span></small>
              </div>
            </div>
            <div class="col-12 col-sm-10">
              <div class="time clearfix">
                <!-- buttons -->
                <div class="float-end">
                  <?php if ($_smarty_tpl->tpl_vars['thread']->value['manage_thread']) {?>
                    <a data-bs-toggle="tooltip" title='<?php echo __("Edit");?>
' href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/edit-thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
" class="btn btn-sm btn-light btn-icon btn-rounded">
                      <i class="fa fa-pencil-alt"></i>
                    </a>
                    <button data-bs-toggle="tooltip" title='<?php echo __("Delete");?>
' class="btn btn-sm btn-light btn-icon btn-rounded js_delete-forum" data-handle="thread" data-id="<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
">
                      <i class="fa fa-trash-alt"></i>
                    </button>
                  <?php } else { ?>
                    <button data-bs-toggle="tooltip" title='<?php echo __("Report");?>
' class="btn btn-sm btn-light btn-icon btn-rounded" data-toggle="modal" data-url="data/report.php?do=create&handle=forum_thread&id=<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
">
                      <i class="fa fa-flag fa-fw"></i>
                    </button>
                  <?php }?>
                </div>
                <!-- buttons -->
                <!-- time -->
                <small><i class="far fa-clock"></i> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
</span></small>
                <!-- time -->
              </div>
              <div class="text">
                <?php echo $_smarty_tpl->tpl_vars['thread']->value['parsed_text'];?>

              </div>
            </div>
          </div>
        </div>
        <!-- thread -->

        <!-- replies -->
        <?php if ($_smarty_tpl->tpl_vars['thread']->value['replies'] > 0) {?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['thread']->value['thread_replies'], 'reply');
$_smarty_tpl->tpl_vars['reply']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reply']->value) {
$_smarty_tpl->tpl_vars['reply']->do_else = false;
?>
            <div class="forum-thread" id="reply-<?php echo $_smarty_tpl->tpl_vars['reply']->value['reply_id'];?>
">
              <div class="row">
                <div class="col-12 col-sm-2 text-center">
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['user_name'];?>
"><img class="avatar" src="<?php echo $_smarty_tpl->tpl_vars['reply']->value['user_picture'];?>
"></a>
                  <h6 class="mt10">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['user_fullname'];?>
</a>
                  </h6>
                  <div class="mb5">
                    <?php if ($_smarty_tpl->tpl_vars['reply']->value['user_group'] == 1) {?>
                      <i class="fa fa-shield-alt"></i> <?php echo __("Admin");?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['reply']->value['user_group'] == 2) {?>
                      <i class="fab fa-black-tie"></i> <?php echo __("Moderator");?>

                    <?php } else { ?>
                      <i class="fa fa-user"></i> <?php echo __("Member");?>

                    <?php }?>
                  </div>
                  <div>
                    <small><?php echo __("Joined");?>
: <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['reply']->value['user_registered'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['user_registered'];?>
</span></small>
                  </div>
                </div>
                <div class="col-12 col-sm-10">
                  <div class="time clearfix">
                    <!-- buttons -->
                    <div class="float-end">
                      <a data-bs-toggle="tooltip" title='<?php echo __("Link");?>
' href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['title_url'];?>
#reply-<?php echo $_smarty_tpl->tpl_vars['reply']->value['reply_id'];?>
" class="btn btn-sm btn-light btn-icon btn-rounded">
                        <i class="fa fa-link"></i>
                      </a>
                      <?php if ($_smarty_tpl->tpl_vars['reply']->value['manage_reply']) {?>
                        <a data-bs-toggle="tooltip" title='<?php echo __("Edit");?>
' href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/edit-reply/<?php echo $_smarty_tpl->tpl_vars['reply']->value['reply_id'];?>
" class="btn btn-sm btn-light btn-icon btn-rounded">
                          <i class="fa fa-pencil-alt"></i>
                        </a>
                        <button data-bs-toggle="tooltip" title='<?php echo __("Delete");?>
' class="btn btn-sm btn-light btn-icon btn-rounded js_delete-forum" data-handle="reply" data-id="<?php echo $_smarty_tpl->tpl_vars['reply']->value['reply_id'];?>
">
                          <i class="fa fa-trash-alt"></i>
                        </button>
                      <?php } else { ?>
                        <button data-bs-toggle="tooltip" title='<?php echo __("Report");?>
' class="btn btn-sm btn-light btn-icon btn-rounded" data-toggle="modal" data-url="data/report.php?do=create&handle=forum_reply&id=<?php echo $_smarty_tpl->tpl_vars['reply']->value['reply_id'];?>
">
                          <i class="fa fa-flag fa-fw"></i>
                        </button>
                      <?php }?>
                    </div>
                    <!-- buttons -->
                    <!-- time -->
                    <small><i class="far fa-clock"></i> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['reply']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['time'];?>
</span></small>
                    <!-- time -->
                  </div>
                  <div class="text">
                    <?php echo $_smarty_tpl->tpl_vars['reply']->value['parsed_text'];?>

                  </div>
                </div>
              </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <div class="mt10">
            <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

          </div>
        <?php }?>
        <!-- replies -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "new-thread") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <?php if ($_smarty_tpl->tpl_vars['forum']->value['parents']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['forum']->value['parents']), 'parent');
$_smarty_tpl->tpl_vars['parent']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->do_else = false;
?>
              <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['parent']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['parent']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['parent']->value['forum_name']);?>
</a></li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php }?>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['forum']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['forum']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['forum']->value['forum_name']);?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("Write New Thread");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- new thread -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <?php echo __("Write New Thread");?>

          </div>
          <form class="js_ajax-forms" data-url="forums/thread.php?do=create&id=<?php echo $_smarty_tpl->tpl_vars['forum']->value['forum_id'];?>
">
            <div class="card-body">
              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Title");?>

                </label>
                <div class="col-md-10">
                  <input class="form-control" name="title">
                </div>
              </div>

              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Content");?>

                </label>
                <div class="col-md-10">
                  <textarea name="text" class="form-control js_wysiwyg"></textarea>
                </div>
              </div>

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Publish");?>
</button>
            </div>
          </form>
        </div>
        <!-- new thread -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "edit-thread") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <?php if ($_smarty_tpl->tpl_vars['thread']->value['forum']['parents']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['thread']->value['forum']['parents']), 'parent');
$_smarty_tpl->tpl_vars['parent']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->do_else = false;
?>
              <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['parent']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['parent']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['parent']->value['forum_name']);?>
</a></li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php }?>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['thread']->value['forum']['forum_name']);?>
</a></li>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("Edit Thread");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- edit thread -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <?php echo __("Edit Thread");?>

          </div>
          <form class="js_ajax-forms" data-url="forums/thread.php?do=edit&id=<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
">
            <div class="card-body">
              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Title");?>

                </label>
                <div class="col-md-10">
                  <input class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
">
                </div>
              </div>

              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Content");?>

                </label>
                <div class="col-md-10">
                  <textarea name="text" class="form-control js_wysiwyg"><?php echo $_smarty_tpl->tpl_vars['thread']->value['text'];?>
</textarea>
                </div>
              </div>

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Update");?>
</button>
            </div>
          </form>
        </div>
        <!-- edit thread -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "new-reply") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <?php if ($_smarty_tpl->tpl_vars['thread']->value['forum']['parents']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['thread']->value['forum']['parents']), 'parent');
$_smarty_tpl->tpl_vars['parent']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->do_else = false;
?>
              <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['parent']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['parent']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['parent']->value['forum_name']);?>
</a></li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php }?>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['thread']->value['forum']['forum_name']);?>
</a></li>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("Post Reply");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- new reply -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <?php echo __("Post Reply");?>

          </div>
          <form class="js_ajax-forms" data-url="forums/reply.php?do=create&id=<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
">
            <div class="card-body">
              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Content");?>

                </label>
                <div class="col-md-10">
                  <textarea name="text" class="form-control js_wysiwyg"></textarea>
                </div>
              </div>

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Reply");?>
</button>
            </div>
          </form>
        </div>
        <!-- new reply -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "edit-reply") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <?php if ($_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['parents']) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['parents']), 'parent');
$_smarty_tpl->tpl_vars['parent']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parent']->value) {
$_smarty_tpl->tpl_vars['parent']->do_else = false;
?>
              <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['parent']->value['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['parent']->value['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['parent']->value['forum_name']);?>
</a></li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <?php }?>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['forum_name']);?>
</a></li>
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['title'];?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("Edit Reply");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- new reply -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <i class="fa fa-reply mr10"></i><?php echo __("Edit Reply");?>

          </div>
          <form class="js_ajax-forms" data-url="forums/reply.php?do=edit&id=<?php echo $_smarty_tpl->tpl_vars['reply']->value['reply_id'];?>
">
            <div class="card-body">
              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Content");?>

                </label>
                <div class="col-md-10">
                  <textarea name="text" class="form-control js_wysiwyg"><?php echo $_smarty_tpl->tpl_vars['reply']->value['text'];?>
</textarea>
                </div>
              </div>

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Update");?>
</button>
            </div>
          </form>
        </div>
        <!-- new reply -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "my-threads") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("My Threads");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- threads -->
        <?php if ($_smarty_tpl->tpl_vars['threads']->value) {?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['threads']->value, 'thread');
$_smarty_tpl->tpl_vars['thread']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['thread']->value) {
$_smarty_tpl->tpl_vars['thread']->do_else = false;
?>
            <div class="forum-result">
              <div class="head">
                <div class="float-end">
                  <?php echo __("Forum");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['thread']->value['forum']['forum_name']);?>
</a>
                </div>
                <i class="far fa-clock mr5"></i><span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
</span>
              </div>
              <div class="content">
                <div class="mb10">
                  <div class="mb5">
                    <strong class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</a></strong>
                    <div class="float-end text-end">
                      <?php echo __("Replies");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['thread']->value['replies'];?>
</strong><br>
                      <?php echo __("Views");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['thread']->value['views'];?>
</strong>
                    </div>
                  </div>
                  <div class="mb5">
                    <?php echo __("By");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['user_fullname'];?>
</a> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
</span>
                  </div>
                </div>
                <div class="snippet">
                  <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['thread']->value['text_snippet'],300);?>

                </div>
              </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <div class="mt20">
            <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

          </div>
        <?php } else { ?>
          <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php }?>
        <!-- threads -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "my-replies") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("My Replies");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- replies -->
        <?php if ($_smarty_tpl->tpl_vars['replies']->value) {?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['replies']->value, 'reply');
$_smarty_tpl->tpl_vars['reply']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reply']->value) {
$_smarty_tpl->tpl_vars['reply']->do_else = false;
?>
            <div class="forum-result">
              <div class="head">
                <div class="float-end">
                  <?php echo __("Forum");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['forum_name']);?>
</a>
                </div>
                <i class="far fa-clock mr5"></i><span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['reply']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['time'];?>
</span>
              </div>
              <div class="content">
                <div class="mb10">
                  <div class="mb5">
                    <strong class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['title'];?>
</a></strong>
                    <div class="float-end text-end">
                      <?php echo __("Replies");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['replies'];?>
</strong><br>
                      <?php echo __("Views");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['views'];?>
</strong>
                    </div>
                  </div>
                  <div class="mb5">
                    <?php echo __("By");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['user_fullname'];?>
</a> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['time'];?>
</span>
                  </div>
                </div>
                <div class="snippet">
                  <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['reply']->value['text_snippet'],300);?>

                </div>
              </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          <div class="mt20">
            <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

          </div>
        <?php } else { ?>
          <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
        <?php }?>
        <!-- replies -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "search") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("Search");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- search -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"search",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Search");?>

          </div>
          <form action="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/search-results" method="get">
            <div class="card-body">
              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Keyword(s)");?>

                </label>
                <div class="col-md-10">
                  <input class="form-control" name="query" required autofocus>
                </div>
              </div>

              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Search For");?>

                </label>
                <div class="col-md-10">
                  <select class="form-select" name="type">
                    <option value="threads"><?php echo __("Threads");?>
</option>
                    <option value="replies"><?php echo __("Replies");?>
</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">
                <label class="col-md-2 form-label">
                  <?php echo __("Search in Forum(s)");?>

                </label>
                <div class="col-md-10">
                  <select class="form-select" name="forum">
                    <option value="all"><?php echo __("Search All Forums");?>
</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['forums']->value, 'forum');
$_smarty_tpl->tpl_vars['forum']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['forum']->value) {
$_smarty_tpl->tpl_vars['forum']->do_else = false;
?>
                      <?php $_smarty_tpl->_subTemplateRender('file:admin.forums.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="offset-md-2 col-md-10">
                  <div class="checkbox checkbox-primary">
                    <input type="checkbox" name="recursive" id="recursive">
                    <label for="recursive"><?php echo __("Also search in child forums");?>
</label>
                  </div>
                </div>
              </div>

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Search");?>
</button>
            </div>
          </form>
        </div>
        <!-- search -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "search-results") {?>

        <!-- breadcrumb -->
        <ol class="breadcrumb forum-breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/"><i class="fa fa-home"></i> <?php echo __("Home");?>
</a></li>
          <li class="breadcrumb-item active"><?php echo __("Search Results");?>
</li>
        </ol>
        <!-- breadcrumb -->

        <!-- search title -->
        <div class="forum-meta-head mt20">
          <div class="float-end">
            <?php echo __("Results Found");?>
<span class="badge badge-lg bg-secondary ml5"><?php if ($_smarty_tpl->tpl_vars['total']->value) {
echo $_smarty_tpl->tpl_vars['total']->value;
} else { ?>0<?php }?></span>
          </div>
          <?php echo __("Keyword(s)");?>
: <u><?php echo htmlentities($_smarty_tpl->tpl_vars['query']->value,ENT_QUOTES,'utf-8');?>
</u>
        </div>
        <!-- search title -->

        <!-- search results -->
        <?php if ($_smarty_tpl->tpl_vars['type']->value == "threads") {?>
          <!-- threads -->
          <?php if ($_smarty_tpl->tpl_vars['results']->value) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'thread');
$_smarty_tpl->tpl_vars['thread']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['thread']->value) {
$_smarty_tpl->tpl_vars['thread']->do_else = false;
?>
              <div class="forum-result">
                <div class="head">
                  <div class="float-end">
                    <?php echo __("Forum");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['thread']->value['forum']['forum_name']);?>
</a>
                  </div>
                  <i class="far fa-clock mr5"></i><span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
</span>
                </div>
                <div class="content">
                  <div class="mb10">
                    <div class="mb5">
                      <strong class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['thread']->value['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['title'];?>
</a></strong>
                      <div class="float-end text-end">
                        <?php echo __("Replies");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['thread']->value['replies'];?>
</strong><br>
                        <?php echo __("Views");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['thread']->value['views'];?>
</strong>
                      </div>
                    </div>
                    <div class="mb5">
                      <?php echo __("By");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['thread']->value['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['user_fullname'];?>
</a> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['thread']->value['time'];?>
</span>
                    </div>
                  </div>
                  <div class="snippet">
                    <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['thread']->value['text_snippet'],300);?>

                  </div>
                </div>
              </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <div class="mt20">
              <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

            </div>
          <?php } else { ?>
            <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
          <?php }?>
          <!-- threads -->
        <?php } elseif ($_smarty_tpl->tpl_vars['type']->value == "replies") {?>
          <!-- replies -->
          <?php if ($_smarty_tpl->tpl_vars['results']->value) {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'reply');
$_smarty_tpl->tpl_vars['reply']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['reply']->value) {
$_smarty_tpl->tpl_vars['reply']->do_else = false;
?>
              <div class="forum-result">
                <div class="head">
                  <div class="float-end">
                    <?php echo __("Forum");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['forum_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['title_url'];?>
"><?php echo __($_smarty_tpl->tpl_vars['reply']->value['thread']['forum']['forum_name']);?>
</a>
                  </div>
                  <i class="far fa-clock mr5"></i><span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['reply']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['time'];?>
</span>
                </div>
                <div class="content">
                  <div class="mb10">
                    <div class="mb5">
                      <strong class="title"><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums/thread/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['thread_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['title_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['title'];?>
</a></strong>
                      <div class="float-end">
                        <?php echo __("Replies");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['replies'];?>
</strong><br>
                        <?php echo __("Views");?>
: <strong><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['views'];?>
</strong>
                      </div>
                    </div>
                    <div class="mb5">
                      <?php echo __("By");?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['user_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['user_fullname'];?>
</a> <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['reply']->value['thread']['time'];?>
</span>
                    </div>
                  </div>
                  <div class="snippet">
                    <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['reply']->value['text_snippet'],300);?>

                  </div>
                </div>
              </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <div class="mt20">
              <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

            </div>
          <?php } else { ?>
            <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
          <?php }?>
          <!-- replies -->
        <?php }?>
        <!-- search results -->

      <?php }?>
    </div>
    <!-- content panel -->

  </div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
