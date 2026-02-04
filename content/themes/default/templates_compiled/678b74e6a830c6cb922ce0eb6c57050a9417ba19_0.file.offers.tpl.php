<?php
/* Smarty version 4.3.4, created on 2025-10-10 15:38:56
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/offers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e92890c291c5_87261637',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '678b74e6a830c6cb922ce0eb6c57050a9417ba19' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/offers.tpl',
      1 => 1685452324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_ads.tpl' => 1,
    'file:_need_subscription.tpl' => 2,
    'file:_no_data.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_68e92890c291c5_87261637 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page header -->
<div class="page-header">
  <img class="floating-img d-none d-md-block" src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/headers/undraw_discount_d4bd.svg">
  <div class="circle-2"></div>
  <div class="circle-3"></div>
  <div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?>">
    <h2><?php echo __("Offers");?>
</h2>
    <p class="text-xlg"><?php echo __($_smarty_tpl->tpl_vars['system']->value['system_description_offers']);?>
</p>
    <div class="row mt20">
      <div class="col-sm-9 col-lg-6 mx-sm-auto">
        <form class="js_search-form" data-handle="offers">
          <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder='<?php echo __("Search for offers");?>
'>
            <button type="submit" class="btn btn-light"><?php echo __("Search");?>
</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> mt20 sg-offcanvas">
  <div class="row">

    <!-- left panel -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar">
      <!-- categories -->
      <div class="card">
        <div class="card-body with-nav">
          <ul class="side-nav">
            <?php if ($_smarty_tpl->tpl_vars['view']->value != "category") {?>
              <li class="active">
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/offers">
                  <?php echo __("All");?>

                </a>
              </li>
            <?php } else { ?>
              <li>
                <?php if ($_smarty_tpl->tpl_vars['current_category']->value['parent']) {?>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/offers/category/<?php echo $_smarty_tpl->tpl_vars['current_category']->value['parent']['category_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['current_category']->value['parent']['category_url'];?>
">
                    <i class="fas fa-arrow-alt-circle-left mr5"></i><?php echo __($_smarty_tpl->tpl_vars['current_category']->value['parent']['category_name']);?>

                  </a>
                <?php } else { ?>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/offers">
                    <?php if ($_smarty_tpl->tpl_vars['current_category']->value['sub_categories']) {?><i class="fas fa-arrow-alt-circle-left mr5"></i><?php }
echo __("All");?>

                  </a>
                <?php }?>
              </li>
            <?php }?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
              <li <?php if ($_smarty_tpl->tpl_vars['view']->value == "category" && $_smarty_tpl->tpl_vars['current_category']->value['category_id'] == $_smarty_tpl->tpl_vars['category']->value['category_id']) {?>class="active" <?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/offers/category/<?php echo $_smarty_tpl->tpl_vars['category']->value['category_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['category']->value['category_url'];?>
">
                  <?php echo __($_smarty_tpl->tpl_vars['category']->value['category_name']);?>

                  <?php if ($_smarty_tpl->tpl_vars['category']->value['sub_categories']) {?>
                    <span class="float-end"><i class="fas fa-angle-right"></i></span>
                  <?php }?>
                </a>
              </li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </ul>
        </div>
      </div>
      <!-- categories -->
    </div>
    <!-- left panel -->

    <!-- right panel -->
    <div class="col-md-8 col-lg-9 sg-offcanvas-mainbar">

      <?php $_smarty_tpl->_subTemplateRender('file:_ads.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

      <?php if ($_smarty_tpl->tpl_vars['view']->value == "search") {?>
        <div class="bs-callout bs-callout-info mt0">
          <!-- results counter -->
          <span class="badge rounded-pill badge-lg bg-secondary"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span> <?php echo __("results were found for the search for");?>
 "<strong class="text-primary"><?php echo htmlentities($_smarty_tpl->tpl_vars['query']->value,ENT_QUOTES,'utf-8');?>
</strong>"
          <!-- results counter -->
        </div>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['view']->value == '' && $_smarty_tpl->tpl_vars['promoted_offers']->value) {?>
        <div class="articles-widget-header">
          <div class="articles-widget-title"><?php echo __("Promoted Offers");?>
</div>
        </div>
        <div class="row mb20">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['promoted_offers']->value, 'post');
$_smarty_tpl->tpl_vars['post']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->do_else = false;
?>
            <div class="col-md-6 col-lg-4">
              <div class="card product boosted">
                <div class="boosted-icon" data-bs-toggle="tooltip" title="<?php echo __("Promoted");?>
">
                  <i class="fa fa-bullhorn"></i>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['post']->value['needs_subscription']) {?>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">
                    <div class="ptb20 plr20">
                      <?php $_smarty_tpl->_subTemplateRender('file:_need_subscription.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    </div>
                  </a>
                <?php } else { ?>
                  <div class="product-image">
                    <div class="product-price with-offer">
                      <i class="far fa-calendar-alt mr5"></i><?php echo __("Expires");?>
: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['post']->value['offer']['end_date'],$_smarty_tpl->tpl_vars['system']->value['system_date_format']);?>

                    </div>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['post']->value['offer']['thumbnail'];?>
">
                    <div class="product-overlay">
                      <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">
                        <?php echo __("More");?>

                      </a>
                    </div>
                  </div>
                  <div class="product-info">
                    <div class="product-meta title">
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
" class="title"><?php echo $_smarty_tpl->tpl_vars['post']->value['offer']['meta_title'];?>
</a>
                    </div>
                  </div>
                <?php }?>
              </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
        <div class="articles-widget-header clearfix">
          <!-- sort -->
          <div class="float-end">
            <div class="dropdown">
              <button type="button" class="btn btn-sm btn-light dropdown-toggle ml10" data-bs-toggle="dropdown" data-display="static">
                <?php if (!$_smarty_tpl->tpl_vars['sort']->value || $_smarty_tpl->tpl_vars['sort']->value == "latest") {?>
                  <i class="fas fa-bars fa-fw"></i> <?php echo __("Latest");?>

                <?php } elseif ($_smarty_tpl->tpl_vars['sort']->value == "expire-soon") {?>
                  <i class="fas fa-sort-amount-down fa-fw"></i> <?php echo __("Expire Soon");?>

                <?php } elseif ($_smarty_tpl->tpl_vars['sort']->value == "expire-latest") {?>
                  <i class="fas fa-sort-amount-down-alt fa-fw"></i> <?php echo __("Expire Latest");?>

                <?php }?>
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <a href="?<?php if ($_smarty_tpl->tpl_vars['distance']->value) {?>distance=<?php echo $_smarty_tpl->tpl_vars['distance']->value;?>
&<?php }?>sort=latest" class="dropdown-item"><i class="fas fa-bars fa-fw mr10"></i><?php echo __("Latest");?>
</a>
                <a href="?<?php if ($_smarty_tpl->tpl_vars['distance']->value) {?>distance=<?php echo $_smarty_tpl->tpl_vars['distance']->value;?>
&<?php }?>sort=expire-soon" class="dropdown-item"><i class="fas fa-sort-amount-down fa-fw mr10"></i><?php echo __("Expire Soon");?>
</a>
                <a href="?<?php if ($_smarty_tpl->tpl_vars['distance']->value) {?>distance=<?php echo $_smarty_tpl->tpl_vars['distance']->value;?>
&<?php }?>sort=expire-latest" class="dropdown-item"><i class="fas fa-sort-amount-down-alt fa-fw mr10"></i><?php echo __("Expire Latest");?>
</a>
              </div>
            </div>
          </div>
          <!-- sort -->
          <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in && $_smarty_tpl->tpl_vars['system']->value['location_finder_enabled']) {?>
            <!-- location filter -->
            <div class="float-end">
              <div class="dropdown">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" data-display="static">
                  <i class="fa fa-map-marker-alt mr5"></i><?php echo __("Location");?>

                </button>
                <div class="dropdown-menu dropdown-menu-end">
                  <form class="ptb15 plr15" method="get" action="?">
                    <div class="form-group">
                      <label class="form-label"><?php echo __("Distance");?>
</label>
                      <div>
                        <?php if ($_smarty_tpl->tpl_vars['sort']->value) {?>
                          <input type="hidden" name="sort" value="<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
">
                        <?php }?>
                        <div class="d-grid mb10">
                          <input type="range" class="custom-range" min="1" max="5000" name="distance" value="<?php if ($_smarty_tpl->tpl_vars['distance']->value) {
echo $_smarty_tpl->tpl_vars['distance']->value;
} else { ?>5000<?php }?>" oninput="this.form.distance_value.value=this.value">
                        </div>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon1"><?php if ($_smarty_tpl->tpl_vars['system']->value['system_distance'] == "mile") {
echo __("ML");
} else {
echo __("KM");
}?></span>
                          <input disabled type="number" class="form-control" min="1" max="5000" name="distance_value" value="<?php if ($_smarty_tpl->tpl_vars['distance']->value) {
echo $_smarty_tpl->tpl_vars['distance']->value;
} else { ?>5000<?php }?>" oninput="this.form.distance.value=this.value">
                        </div>
                      </div>
                    </div>
                    <div class="d-grid">
                      <button type="submit" class="btn btn-sm btn-primary"><?php echo __("Filter");?>
</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- location filter -->
          <?php }?>
          <div class="articles-widget-title"><?php echo __("Offers");?>
</div>
        </div>

        <div class="row">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'post');
$_smarty_tpl->tpl_vars['post']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->do_else = false;
?>
            <div class="col-md-6 col-lg-4">
              <div class="card product">
                <?php if ($_smarty_tpl->tpl_vars['post']->value['needs_subscription']) {?>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">
                    <div class="ptb20 plr20">
                      <?php $_smarty_tpl->_subTemplateRender('file:_need_subscription.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    </div>
                  </a>
                <?php } else { ?>
                  <div class="product-image">
                    <div class="product-price with-offer">
                      <i class="far fa-calendar-alt mr5"></i><?php echo __("Expires");?>
: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['post']->value['offer']['end_date'],$_smarty_tpl->tpl_vars['system']->value['system_date_format']);?>

                    </div>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['post']->value['offer']['thumbnail'];?>
">
                    <div class="product-overlay">
                      <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
">
                        <?php echo __("More");?>

                      </a>
                    </div>
                  </div>
                  <div class="product-info">
                    <div class="product-meta title">
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/posts/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_id'];?>
" class="title"><?php echo $_smarty_tpl->tpl_vars['post']->value['offer']['meta_title'];?>
</a>
                    </div>
                  </div>
                <?php }?>
              </div>
            </div>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>

        <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

      <?php } else { ?>
        <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php }?>
    </div>
    <!-- right panel -->

  </div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
