<?php
/* Smarty version 4.3.4, created on 2025-10-16 10:43:21
  from '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/index.newsfeed.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68f0cc4948e809_77778773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e2015455a7021f878ab8f032fddf505743d51384' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/shopai1/Script/content/themes/default/templates/index.newsfeed.tpl',
      1 => 1760611327,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:_announcements.tpl' => 1,
    'file:__svg_icons.tpl' => 7,
    'file:_publisher.tpl' => 1,
    'file:_boosted_post.tpl' => 1,
    'file:_review_tasks_mini_card.tpl' => 1,
    'file:_posts.tpl' => 10,
    'file:__feeds_page.tpl' => 2,
    'file:_no_data.tpl' => 1,
    'file:_ads.tpl' => 1,
    'file:_ads_campaigns.tpl' => 1,
    'file:_widget.tpl' => 1,
    'file:__feeds_user.tpl' => 1,
    'file:__feeds_group.tpl' => 1,
    'file:__feeds_event.tpl' => 1,
    'file:_footer_mini.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68f0cc4948e809_77778773 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <!-- side panel -->

    <!-- content panel -->
    <div class="col-md-8 col-lg-9 sg-offcanvas-mainbar">
      <div class="row">
        <!-- center panel -->
        <div class="col-lg-8">

          <!-- announcments -->
          <?php $_smarty_tpl->_subTemplateRender('file:_announcements.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <!-- announcments -->

          <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>

            <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
              <!-- stories -->
              <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_add_stories'] || ($_smarty_tpl->tpl_vars['system']->value['stories_enabled'] && !empty($_smarty_tpl->tpl_vars['stories']->value['array']))) {?>
                <div class="card">
                  <div class="card-header bg-transparent border-bottom-0">
                    <strong class="text-muted"><?php echo __("Stories");?>
</strong>
                    <?php if ($_smarty_tpl->tpl_vars['has_story']->value) {?>
                      <div class="float-end">
                        <button data-bs-toggle="tooltip" title='<?php echo __("Delete Your Story");?>
' class="btn btn-sm btn-icon btn-rounded btn-danger js_story-deleter">
                          <i class="fa fa-trash-alt"></i>
                        </button>
                      </div>
                    <?php }?>
                  </div>
                  <div class="card-body pt5 stories-wrapper">
                    <div id="stories" data-json='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['stories']->value["json"],ENT_QUOTES,'UTF-8');?>
'>
                      <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_add_stories']) {?>
                        <div class="add-story" data-toggle="modal" data-url="posts/story.php?do=create">
                          <div class="img" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_picture'];?>
);">
                          </div>
                          <div class="add">
                            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"add",'class'=>"main-icon",'width'=>"18px",'height'=>"18px"), 0, false);
?>
                          </div>
                        </div>
                      <?php }?>
                    </div>
                  </div>
                </div>
              <?php }?>
              <!-- stories -->

              <!-- publisher -->
              <?php $_smarty_tpl->_subTemplateRender('file:_publisher.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_handle'=>"me",'_node_can_monetize_content'=>$_smarty_tpl->tpl_vars['user']->value->_data['can_monetize_content'],'_node_monetization_enabled'=>$_smarty_tpl->tpl_vars['user']->value->_data['user_monetization_enabled'],'_node_monetization_plans'=>$_smarty_tpl->tpl_vars['user']->value->_data['user_monetization_plans'],'_privacy'=>true), 0, false);
?>
              <!-- publisher -->

              <!-- pro users -->
              <?php if ($_smarty_tpl->tpl_vars['pro_members']->value) {?>
                <div class="d-block d-lg-none">
                  <div class="card bg-indigo border-0">
                    <div class="card-header ptb20 bg-transparent border-bottom-0">
                      <?php if ($_smarty_tpl->tpl_vars['system']->value['packages_enabled'] && !$_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {?>
                        <div class="float-end">
                          <small><a class="text-white text-underline" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages"><?php echo __("Upgrade");?>
</a></small>
                        </div>
                      <?php }?>
                      <h6 class="pb0">
                        <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"pro",'class'=>"mr5",'width'=>"20px",'height'=>"20px",'style'=>"fill: #fff;"), 0, true);
?>
                        <?php echo __("Pro Users");?>

                      </h6>
                    </div>
                    <div class="card-body pt0 plr5">
                      <div class="pro-box-wrapper <?php if (count($_smarty_tpl->tpl_vars['pro_members']->value) > 3) {?>js_slick<?php } else { ?>full-opacity<?php }?>">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pro_members']->value, '_member');
$_smarty_tpl->tpl_vars['_member']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_member']->value) {
$_smarty_tpl->tpl_vars['_member']->do_else = false;
?>
                          <a class="user-box text-white" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['_member']->value['user_name'];?>
">
                            <img alt="" src="<?php echo $_smarty_tpl->tpl_vars['_member']->value['user_picture'];?>
" />
                            <div class="name">
                              <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {?>
                                <?php echo $_smarty_tpl->tpl_vars['_member']->value['user_name'];?>

                              <?php } else { ?>
                                <?php echo $_smarty_tpl->tpl_vars['_member']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_member']->value['user_lastname'];?>

                              <?php }?>
                            </div>
                          </a>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
              <!-- pro users -->

              <!-- pro pages -->
              <?php if ($_smarty_tpl->tpl_vars['promoted_pages']->value) {?>
                <div class="d-block d-lg-none">
                  <div class="card bg-teal border-0">
                    <div class="card-header ptb20 bg-transparent border-bottom-0">
                      <?php if ($_smarty_tpl->tpl_vars['system']->value['packages_enabled'] && !$_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {?>
                        <div class="float-end">
                          <small><a class="text-white text-underline" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages"><?php echo __("Upgrade");?>
</a></small>
                        </div>
                      <?php }?>
                      <h6 class="pb0">
                        <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"pro",'class'=>"mr5",'width'=>"20px",'height'=>"20px",'style'=>"fill: #fff;"), 0, true);
?>
                        <?php echo __("Pro Pages");?>

                      </h6>
                    </div>
                    <div class="card-body pt0 plr5">
                      <div class="pro-box-wrapper <?php if (count($_smarty_tpl->tpl_vars['promoted_pages']->value) > 3) {?>js_slick<?php } else { ?>full-opacity<?php }?>">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['promoted_pages']->value, '_page');
$_smarty_tpl->tpl_vars['_page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_page']->value) {
$_smarty_tpl->tpl_vars['_page']->do_else = false;
?>
                          <a class="user-box text-white" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_name'];?>
">
                            <img alt="<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_title'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_picture'];?>
" />
                            <div class="name" title="<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_title'];?>
">
                              <?php echo $_smarty_tpl->tpl_vars['_page']->value['page_title'];?>

                            </div>
                          </a>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
              <!-- pro pages -->
            <?php }?>

            <!-- boosted post -->
            <?php if ($_smarty_tpl->tpl_vars['boosted_post']->value) {?>
              <?php $_smarty_tpl->_subTemplateRender('file:_boosted_post.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('post'=>$_smarty_tpl->tpl_vars['boosted_post']->value), 0, false);
?>
            <?php }?>
            <!-- boosted post -->

            <!-- review tasks -->
            <?php $_smarty_tpl->_subTemplateRender('file:_review_tasks_mini_card.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <!-- review tasks -->

            <!-- posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"newsfeed"), 0, false);
?>
            <!-- posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "popular") {?>
            <!-- popular posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"popular",'_title'=>__("Popular Posts")), 0, true);
?>
            <!-- popular posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "discover") {?>
            <!-- discover posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"discover",'_title'=>__("Discover Posts")), 0, true);
?>
            <!-- discover posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "saved") {?>
            <!-- saved posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"saved",'_title'=>__("Saved Posts")), 0, true);
?>
            <!-- saved posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "memories") {?>
            <!-- page header -->
            <div class="page-header mini rounded mb10">
              <div class="circle-1"></div>
              <div class="circle-2"></div>
              <div class="inner">
                <h2><?php echo __("Memories");?>
</h2>
                <p class="text-lg"><?php echo __("Enjoy looking back on your memories");?>
</p>
              </div>
            </div>
            <!-- page header -->

            <!-- memories posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"memories",'_title'=>__("ON THIS DAY"),'_filter'=>"all"), 0, true);
?>
            <!-- memories posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "articles") {?>
            <!-- articles posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"posts_profile",'_id'=>$_smarty_tpl->tpl_vars['user']->value->_data['user_id'],'_filter'=>"article",'_title'=>__("My Articles")), 0, true);
?>
            <!-- articles posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "products") {?>
            <!-- products posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"posts_profile",'_id'=>$_smarty_tpl->tpl_vars['user']->value->_data['user_id'],'_filter'=>"product",'_title'=>__("My Products")), 0, true);
?>
            <!-- products posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "funding_requests") {?>
            <!-- funding posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"posts_profile",'_id'=>$_smarty_tpl->tpl_vars['user']->value->_data['user_id'],'_filter'=>"funding",'_title'=>__("My Funding Requests")), 0, true);
?>
            <!-- funding posts -->

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "boosted_posts") {?>
            <?php if ($_smarty_tpl->tpl_vars['user']->value->_is_admin || $_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {?>
              <!-- boosted posts -->
              <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"boosted",'_title'=>__("My Boosted Posts")), 0, true);
?>
              <!-- boosted posts -->
            <?php } else { ?>
              <!-- upgrade -->
              <div class="alert alert-warning">
                <div class="icon">
                  <i class="fa fa-id-card fa-2x"></i>
                </div>
                <div class="text">
                  <strong><?php echo __("Membership");?>
</strong><br>
                  <?php echo __("Choose the Plan That's Right for You");?>
, <?php echo __("Check the package from");?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages"><?php echo __("Here");?>
</a>
                </div>
              </div>
              <div class="text-center">
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages" class="btn btn-primary"><i class="fa fa-rocket mr5"></i><?php echo __("Upgrade to Pro");?>
</a>
              </div>
              <!-- upgrade -->
            <?php }?>

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "boosted_pages") {?>
            <?php if ($_smarty_tpl->tpl_vars['user']->value->_is_admin || $_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {?>
              <div class="card">
                <div class="card-header">
                  <strong><?php echo __("My Boosted Pages");?>
</strong>
                </div>
                <div class="card-body">
                  <?php if ($_smarty_tpl->tpl_vars['boosted_pages']->value) {?>
                    <ul>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['boosted_pages']->value, '_page');
$_smarty_tpl->tpl_vars['_page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_page']->value) {
$_smarty_tpl->tpl_vars['_page']->do_else = false;
?>
                        <?php $_smarty_tpl->_subTemplateRender('file:__feeds_page.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list"), 0, true);
?>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>

                    <?php if (count($_smarty_tpl->tpl_vars['boosted_pages']->value) >= $_smarty_tpl->tpl_vars['system']->value['max_results_even']) {?>
                      <!-- see-more -->
                      <div class="alert alert-info see-more js_see-more" data-get="boosted_pages">
                        <span><?php echo __("See More");?>
</span>
                        <div class="loader loader_small x-hidden"></div>
                      </div>
                      <!-- see-more -->
                    <?php }?>
                  <?php } else { ?>
                    <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                  <?php }?>
                </div>
              </div>
            <?php } else { ?>
              <!-- upgrade -->
              <div class="alert alert-warning">
                <div class="icon">
                  <i class="fa fa-id-card fa-2x"></i>
                </div>
                <div class="text">
                  <strong><?php echo __("Membership");?>
</strong><br>
                  <?php echo __("Choose the Plan That's Right for You");?>
, <?php echo __("Check the package from");?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages"><?php echo __("Here");?>
</a>
                </div>
              </div>
              <div class="text-center">
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages" class="btn btn-primary"><i class="fa fa-rocket mr5"></i><?php echo __("Upgrade to Pro");?>
</a>
              </div>
              <!-- upgrade -->
            <?php }?>

          <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "watch") {?>
            <!-- videos posts -->
            <?php $_smarty_tpl->_subTemplateRender('file:_posts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_get'=>"discover",'_filter'=>"video",'_title'=>__("Watch")), 0, true);
?>
            <!-- videos posts -->

          <?php }?>
        </div>
        <!-- center panel -->

        <!-- right panel -->
        <div class="col-lg-4 js_sticky-sidebar">

          <!-- pro users -->
          <?php if ($_smarty_tpl->tpl_vars['pro_members']->value) {?>
            <div class="d-none d-lg-block">
              <div class="card bg-indigo border-0">
                <div class="card-header ptb20 bg-transparent border-bottom-0">
                  <?php if ($_smarty_tpl->tpl_vars['system']->value['packages_enabled'] && !$_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {?>
                    <div class="float-end">
                      <small><a class="text-white text-underline" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages"><?php echo __("Upgrade");?>
</a></small>
                    </div>
                  <?php }?>
                  <h6 class="pb0">
                    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"pro",'class'=>"mr5",'width'=>"20px",'height'=>"20px",'style'=>"fill: #fff;"), 0, true);
?>
                    <?php echo __("Pro Users");?>

                  </h6>
                </div>
                <div class="card-body pt0 plr5">
                  <div class="pro-box-wrapper <?php if (count($_smarty_tpl->tpl_vars['pro_members']->value) > 3) {?>js_slick<?php } else { ?>full-opacity<?php }?>">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pro_members']->value, '_member');
$_smarty_tpl->tpl_vars['_member']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_member']->value) {
$_smarty_tpl->tpl_vars['_member']->do_else = false;
?>
                      <a class="user-box text-white" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['_member']->value['user_name'];?>
">
                        <img alt="" src="<?php echo $_smarty_tpl->tpl_vars['_member']->value['user_picture'];?>
" />
                        <div class="name">
                          <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {?>
                            <?php echo $_smarty_tpl->tpl_vars['_member']->value['user_name'];?>

                          <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['_member']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['_member']->value['user_lastname'];?>

                          <?php }?>
                        </div>
                      </a>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
          <!-- pro users -->

          <!-- pro pages -->
          <?php if ($_smarty_tpl->tpl_vars['promoted_pages']->value) {?>
            <div class="d-none d-lg-block">
              <div class="card bg-teal border-0">
                <div class="card-header ptb20 bg-transparent border-bottom-0">
                  <?php if ($_smarty_tpl->tpl_vars['system']->value['packages_enabled'] && !$_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {?>
                    <div class="float-end">
                      <small><a class="text-white text-underline" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/packages"><?php echo __("Upgrade");?>
</a></small>
                    </div>
                  <?php }?>
                  <h6 class="pb0">
                    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"pro",'class'=>"mr5",'width'=>"20px",'height'=>"20px",'style'=>"fill: #fff;"), 0, true);
?>
                    <?php echo __("Pro Pages");?>

                  </h6>
                </div>
                <div class="card-body pt0 plr5">
                  <div class="pro-box-wrapper <?php if (count($_smarty_tpl->tpl_vars['promoted_pages']->value) > 3) {?>js_slick<?php } else { ?>full-opacity<?php }?>">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['promoted_pages']->value, '_page');
$_smarty_tpl->tpl_vars['_page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_page']->value) {
$_smarty_tpl->tpl_vars['_page']->do_else = false;
?>
                      <a class="user-box text-white" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_name'];?>
">
                        <img alt="<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_title'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_picture'];?>
" />
                        <div class="name" title="<?php echo $_smarty_tpl->tpl_vars['_page']->value['page_title'];?>
">
                          <?php echo $_smarty_tpl->tpl_vars['_page']->value['page_title'];?>

                        </div>
                      </a>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
          <!-- pro pages -->

          <!-- trending -->
          <?php if ($_smarty_tpl->tpl_vars['trending_hashtags']->value) {?>
            <div class="card bg-red border-0">
              <div class="card-header pt20 pb10 bg-transparent border-bottom-0">
                <h6 class="mb0">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"trend",'class'=>"mr5",'width'=>"20px",'height'=>"20px",'style'=>"fill: #fff;"), 0, true);
?>
                  <?php echo __("Trending");?>

                </h6>
              </div>
              <div class="card-body pt0">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['trending_hashtags']->value, 'hashtag');
$_smarty_tpl->tpl_vars['hashtag']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['hashtag']->value) {
$_smarty_tpl->tpl_vars['hashtag']->do_else = false;
?>
                  <a class="trending-item" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/search/hashtag/<?php echo $_smarty_tpl->tpl_vars['hashtag']->value['hashtag'];?>
">
                    <span class="hash">
                      #<?php echo $_smarty_tpl->tpl_vars['hashtag']->value['hashtag'];?>

                    </span>
                    <span class="frequency">
                      <?php echo $_smarty_tpl->tpl_vars['hashtag']->value['frequency'];?>
 <?php echo __("Posts");?>

                    </span>
                  </a>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </div>
            </div>
          <?php }?>
          <!-- trending -->

          <?php $_smarty_tpl->_subTemplateRender('file:_ads.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <?php $_smarty_tpl->_subTemplateRender('file:_ads_campaigns.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <?php $_smarty_tpl->_subTemplateRender('file:_widget.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

          <!-- friend suggestions -->
          <?php if ($_smarty_tpl->tpl_vars['new_people']->value) {?>
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/people"><?php echo __("See All");?>
</a></small>
                </div>
                <?php echo __("Friend Suggestions");?>

              </div>
              <div class="card-body with-list">
                <ul>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['new_people']->value, '_user');
$_smarty_tpl->tpl_vars['_user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_user']->value) {
$_smarty_tpl->tpl_vars['_user']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_user.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_connection'=>"add"), 0, true);
?>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
              </div>
            </div>
          <?php }?>
          <!-- friend suggestions -->

          <!-- suggested pages -->
          <?php if ($_smarty_tpl->tpl_vars['new_pages']->value) {?>
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages"><?php echo __("See All");?>
</a></small>
                </div>
                <?php echo __("Suggested Pages");?>

              </div>
              <div class="card-body with-list">
                <ul>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['new_pages']->value, '_page');
$_smarty_tpl->tpl_vars['_page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_page']->value) {
$_smarty_tpl->tpl_vars['_page']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_page.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list"), 0, true);
?>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
              </div>
            </div>
          <?php }?>
          <!-- suggested pages -->

          <!-- suggested groups -->
          <?php if ($_smarty_tpl->tpl_vars['new_groups']->value) {?>
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups"><?php echo __("See All");?>
</a></small>
                </div>
                <?php echo __("Suggested Groups");?>

              </div>
              <div class="card-body with-list">
                <ul>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['new_groups']->value, '_group');
$_smarty_tpl->tpl_vars['_group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_group']->value) {
$_smarty_tpl->tpl_vars['_group']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_group.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list"), 0, true);
?>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
              </div>
            </div>
          <?php }?>
          <!-- suggested groups -->

          <!-- suggested events -->
          <?php if ($_smarty_tpl->tpl_vars['new_events']->value) {?>
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/events"><?php echo __("See All");?>
</a></small>
                </div>
                <?php echo __("Suggested Events");?>

              </div>
              <div class="card-body with-list">
                <ul>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['new_events']->value, '_event');
$_smarty_tpl->tpl_vars['_event']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['_event']->value) {
$_smarty_tpl->tpl_vars['_event']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:__feeds_event.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_tpl'=>"list",'_small'=>true), 0, true);
?>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
              </div>
            </div>
          <?php }?>
          <!-- suggested events -->

          <!-- invitation widget -->
          <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_invite_users']) {?>
            <div class="card">
              <div class="card-body text-center">
                <div class="mb10">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"invitation",'class'=>"main-icon",'width'=>"60px",'height'=>"60px"), 0, true);
?>
                </div>
                <a class="btn btn-sm btn-primary rounded-pill" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/settings/invitations"><?php echo __("Invite Your Friends");?>
</a>
              </div>
            </div>
          <?php }?>
          <!-- invitation widget -->

          <!-- mini footer -->
          <?php $_smarty_tpl->_subTemplateRender('file:_footer_mini.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <!-- mini footer -->

        </div>
        <!-- right panel -->
      </div>
    </div>
    <!-- content panel -->

  </div>
</div>

<style>
.review-task-mini-card {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 8px;
    background: #fff;
    height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.2s ease;
    overflow: hidden;
    position: relative;
}

.review-task-mini-card:hover {
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.review-task-mini-card h6 {
    color: #333;
    font-weight: 600;
    font-size: 13px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card .text-muted {
    font-size: 11px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card .text-warning {
    font-size: 10px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card .text-success {
    font-size: 12px;
    font-weight: 700;
    margin: 0;
}

.review-task-mini-card .btn {
    font-size: 11px;
    padding: 4px 8px;
    height: 24px;
    line-height: 1;
}

.review-task-mini-card .d-flex {
    margin-top: auto;
}


.review-task-mini-card .task-avatar img {
    border: 1px solid #e9ecef;
}

.review-task-mini-card .badge-warning {
    background-color: #ffc107;
    color: #000;
    font-weight: 600;
    position: absolute;
    top: 8px;
    right: 8px;
}

.review-task-mini-card .verified-badge {
    vertical-align: middle;
    display: inline-flex;
    align-items: center;
}

/* Horizontal mini card styles */
.review-task-mini-card-horizontal {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 16px 12px;
    background: #fff;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    position: relative;
    height: 112px;
    min-height: 112px;
    max-height: 112px;
    width: 100%;
    box-sizing: border-box;
    margin: 8px 0;
}

.review-task-mini-card-horizontal:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.review-task-mini-card-horizontal .task-info {
    flex: 1;
    margin-right: 15px;
    min-width: 0;
    overflow: hidden;
}

.review-task-mini-card-horizontal .task-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 8px;
    margin-bottom: 4px;
}

.review-task-mini-card-horizontal .task-details {
    display: flex;
    align-items: center;
    gap: 4px;
}

.review-task-mini-card-horizontal .task-avatar {
    margin-right: 8px;
    width: 32px;
    height: 32px;
    min-width: 32px;
    min-height: 32px;
    flex-shrink: 0;
}

.review-task-mini-card-horizontal .task-avatar img {
    width: 32px !important;
    height: 32px !important;
    min-width: 32px;
    min-height: 32px;
    max-width: 32px;
    max-height: 32px;
    border: 1px solid #e9ecef;
    object-fit: cover;
    display: block;
}

.review-task-mini-card-horizontal .task-title {
    font-weight: 600;
    font-size: 14px;
    color: #333;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card-horizontal .task-address {
    font-size: 12px;
    color: #6c757d;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-mini-card-horizontal .task-expiry {
    font-size: 11px;
    color: #ffc107;
    margin: 0;
}

.review-task-mini-card-horizontal .task-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    flex-shrink: 0;
    min-width: 120px;
}

.review-task-mini-card-horizontal .task-reward {
    font-size: 14px;
    font-weight: 700;
    color: #28a745;
    margin: 0;
}

.review-task-mini-card-horizontal .btn {
    font-size: 12px;
    padding: 6px 12px;
    height: 32px;
    line-height: 1;
    background-color: #1877F2 !important;
    border-color: #1877F2 !important;
    color: #fff !important;
}

.review-task-mini-card-horizontal .btn:hover {
    background-color: #166fe5 !important;
    border-color: #166fe5 !important;
}

/* Facebook-style sponsored badge */
.sponsored-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.05);
    color: #8e8e8e;
    font-size: 8px;
    font-weight: 400;
    padding: 1px 4px;
    border-radius: 2px;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(0, 0, 0, 0.02);
    text-transform: none;
    letter-spacing: 0.2px;
}

.review-task-mini-card-horizontal .verified-badge {
    vertical-align: middle;
    display: inline-flex;
    align-items: center;
}

/* Horizontal scroll container */
.review-tasks-horizontal-scroll {
    display: flex;
    overflow-x: auto;
    gap: 15px;
    padding: 0 0 9px 0;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

/* Card body for review tasks */
.review-tasks-horizontal-scroll + * .card-body,
.card-body:has(.review-tasks-horizontal-scroll) {
    padding: 9px !important;
}

/* Remove bottom padding for card-header with bg-transparent border-bottom-0 */
.card-header.bg-transparent.border-bottom-0 {
    padding-bottom: 0 !important;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar {
    height: 6px;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.review-tasks-horizontal-scroll::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.review-task-item {
    flex: 0 0 350px;
    min-width: 350px;
    height: 120px;
}

</style>

<?php echo '<script'; ?>
>
// Global variable to store current task ID
var currentTaskId = null;

function showTaskModal(subRequestId, placeName, placeAddress, rewardAmount, expiryDate) {
  currentTaskId = subRequestId;
  
  // Populate modal content using vanilla JS
  var modalPlaceName = document.getElementById('modalPlaceName');
  var modalPlaceAddress = document.getElementById('modalPlaceAddress');
  var modalRewardAmount = document.getElementById('modalRewardAmount');
  var modalExpiry = document.getElementById('modalExpiry');
  
  if (modalPlaceName) modalPlaceName.textContent = placeName;
  if (modalPlaceAddress) modalPlaceAddress.textContent = placeAddress;
  if (modalRewardAmount) modalRewardAmount.textContent = parseInt(rewardAmount).toLocaleString('vi-VN') + ' VND';
  if (modalExpiry) modalExpiry.textContent = expiryDate;
  
  // Show modal using Bootstrap 5
  var modalElement = document.getElementById('taskModal');
  if (modalElement) {
    var modal = new bootstrap.Modal(modalElement);
    modal.show();
  }
}

function assignTask(taskId) {
    // Ngăn chặn double-click
    if (window.assigningTask) {
        return;
    }
    window.assigningTask = true;
    
    // Sử dụng fetch thay vì jQuery AJAX
    var formData = new FormData();
    formData.append('action', 'assign_task');
    formData.append('sub_request_id', taskId);
    
    fetch('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                return { error: 'Invalid JSON response: ' + text };
            }
        });
    })
    .then(data => {
        if (data.success) {
            // Sử dụng toast notification của hệ thống
            if (typeof noty_notification !== 'undefined') {
                noty_notification('', '✅ Nhận nhiệm vụ thành công!', '');
            } else if (typeof modal !== 'undefined') {
                modal('#modal-success', { title: 'Thành công', message: '✅ Nhận nhiệm vụ thành công!' });
            } else {
                alert('✅ Nhận nhiệm vụ thành công!');
            }
            // Chuyển hướng đến trang My Reviews
            setTimeout(function() {
                window.location.href = '<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews/my-reviews';
            }, 1000);
        } else {
            // Sử dụng toast notification lỗi của hệ thống
            if (typeof noty_notification !== 'undefined') {
                noty_notification('', '❌ ' + data.error, '');
            } else if (typeof modal !== 'undefined') {
                modal('#modal-error', { title: 'Lỗi', message: '❌ ' + data.error });
            } else {
                alert('❌ Lỗi: ' + data.error);
            }
        }
        
        // Reset flag sau khi xử lý xong
        window.assigningTask = false;
    })
    .catch(error => {
        if (typeof noty_notification !== 'undefined') {
            noty_notification('', '❌ Đã xảy ra lỗi. Vui lòng thử lại.', '');
        } else if (typeof modal !== 'undefined') {
            modal('#modal-error', { title: 'Lỗi', message: '❌ Đã xảy ra lỗi. Vui lòng thử lại.' });
        } else {
            alert('❌ Đã xảy ra lỗi. Vui lòng thử lại.');
        }
        // Reset flag khi có lỗi
        window.assigningTask = false;
    });
}

// Handle confirm button click - Sử dụng vanilla JS
function bindConfirmButton() {
  var confirmBtn = document.getElementById('confirmAssignBtn');
  if (confirmBtn) {
    confirmBtn.addEventListener('click', function() {
      if (currentTaskId) {
        var modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
        assignTask(currentTaskId);
      } else {
        alert('❌ Lỗi: Không tìm thấy ID nhiệm vụ');
      }
    });
  } else {
    setTimeout(bindConfirmButton, 100);
  }
}

// Bind when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', bindConfirmButton);
} else {
  bindConfirmButton();
}

// Fallback: Try to bind after a delay
setTimeout(function() {
  var confirmBtn = document.getElementById('confirmAssignBtn');
  if (confirmBtn && !confirmBtn.hasAttribute('data-bound')) {
    confirmBtn.setAttribute('data-bound', 'true');
    confirmBtn.addEventListener('click', function() {
      if (currentTaskId) {
        var modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
        assignTask(currentTaskId);
      } else {
        alert('❌ Lỗi: Không tìm thấy ID nhiệm vụ');
      }
    });
  }
}, 2000);
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
