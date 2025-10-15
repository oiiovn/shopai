<?php
/* Smarty version 4.3.4, created on 2025-10-02 11:50:46
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/_sidebar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68de67169b8b42_24730522',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '94308fb54bf9608b6c4017c7ba546f0de0a51840' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/_sidebar.tpl',
      1 => 1759405750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 29,
  ),
),false)) {
function content_68de67169b8b42_24730522 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="card main-side-nav-card">
  <div class="card-body with-nav">
    <ul class="main-side-nav">

      <!-- favorites -->
      <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && ($_smarty_tpl->tpl_vars['view']->value == '' || $_smarty_tpl->tpl_vars['view']->value == "discover" || $_smarty_tpl->tpl_vars['view']->value == "popular")) {?>class="active" <?php }?>>
        <?php if (!$_smarty_tpl->tpl_vars['user']->value->_logged_in || (!$_smarty_tpl->tpl_vars['system']->value['popular_posts_enabled'] && !$_smarty_tpl->tpl_vars['system']->value['discover_posts_enabled'])) {?>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"newsfeed",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, false);
?>
            <?php echo __("News Feed");?>

          </a>
        <?php } else { ?>
          <a href="#newsfeed" data-bs-toggle="collapse" <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && ($_smarty_tpl->tpl_vars['view']->value == "discover" || $_smarty_tpl->tpl_vars['view']->value == "popular")) {?>aria-expanded="true" <?php }?>>
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"newsfeed",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("News Feed");?>

          </a>
          <div class='collapse <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && ($_smarty_tpl->tpl_vars['view']->value == "discover" || $_smarty_tpl->tpl_vars['view']->value == "popular")) {?>show<?php }?>' id="newsfeed">
            <ul>
              <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == '') {?>class="active" <?php }?>>
                <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"posts_recent",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                  <?php echo __("Recent Updates");?>

                </a>
              </li>
              <?php if ($_smarty_tpl->tpl_vars['system']->value['popular_posts_enabled']) {?>
                <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "popular") {?>class="active" <?php }?>>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/popular">
                    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"popularity",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                    <?php echo __("Popular Posts");?>

                  </a>
                </li>
              <?php }?>
              <?php if ($_smarty_tpl->tpl_vars['system']->value['discover_posts_enabled']) {?>
                <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "discover") {?>class="active" <?php }?>>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/discover">
                    <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"posts_discover",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                    <?php echo __("Discover Posts");?>

                  </a>
                </li>
              <?php }?>
            </ul>
          </div>
        <?php }?>
      </li>

      <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_write_articles']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "articles") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/articles">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"articles",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("My Articles");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_sell_products']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "products") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/products">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"products",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("My Products");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_raise_funding']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "funding_requests") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/funding_requests">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"money-bag",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("My Funding");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "saved") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/saved">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"saved",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Saved Posts");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
        <?php if ($_smarty_tpl->tpl_vars['system']->value['memories_enabled']) {?>
          <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "memories") {?>class="active" <?php }?>>
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/memories">
              <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"memories",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
              <?php echo __("Memories");?>

            </a>
          </li>
        <?php }?>
      <?php }?>
      <!-- favorites -->

      <!-- advertising -->
      <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
        <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_create_ads'] || $_smarty_tpl->tpl_vars['system']->value['wallet_enabled'] || $_smarty_tpl->tpl_vars['system']->value['packages_enabled']) {?>
          <li class="ptb5">
            <small class="text-muted"><?php echo mb_strtoupper((string) __("Advertising") ?? '', 'UTF-8');?>
</small>
          </li>

          <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['can_create_ads']) {?>
            <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "ads") {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/ads">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"ads",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                <?php echo __("Ads Manager");?>

              </a>
            </li>
          <?php }?>

          <?php if ($_smarty_tpl->tpl_vars['system']->value['wallet_enabled']) {?>
            <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "wallet") {?>class="active" <?php }?>>
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"wallet",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
                <?php echo __("Wallet");?>

              </a>
            </li>
          <?php }?>

          <?php if ($_smarty_tpl->tpl_vars['system']->value['packages_enabled']) {?>
            <a href="#boosted" data-bs-toggle="collapse" <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && ($_smarty_tpl->tpl_vars['view']->value == "boosted_posts" || $_smarty_tpl->tpl_vars['view']->value == "boosted_pages")) {?>aria-expanded="true" <?php }?>>
              <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"boosted",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
              <?php echo __("Boosted");?>

            </a>
            <div class='collapse <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && ($_smarty_tpl->tpl_vars['view']->value == "boosted_posts" || $_smarty_tpl->tpl_vars['view']->value == "boosted_pages")) {?>show<?php }?>' id="boosted">
              <ul>
                <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "boosted_posts") {?>class="active" <?php }?>>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/boosted/posts">
                    <?php echo __("Boosted Posts");?>

                  </a>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['system']->value['pages_enabled']) {?>
                  <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "boosted_pages") {?>class="active" <?php }?>>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/boosted/pages">
                      <?php echo __("Boosted Pages");?>

                    </a>
                  </li>
                <?php }?>
              </ul>
            </div>
          <?php }?>
        <?php }?>
      <?php }?>
      <!-- advertising -->

      <!-- explore -->
      <li class="ptb5">
        <small class="text-muted"><?php echo mb_strtoupper((string) __("explore") ?? '', 'UTF-8');?>
</small>
      </li>

      <?php if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "people") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/people">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"find_people",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("People");?>

          </a>
        </li>
      <?php }?>

      <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "shop-ai") {?>class="active" <?php }?>>
        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/shop-ai">
          <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"market",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
          <?php echo __("Check số shopee");?>

        </a>
      </li>
      
      <?php if ($_smarty_tpl->tpl_vars['system']->value['otp_rental_enabled']) {?>
      <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "otp-rental") {?>class="active" <?php }?>>
        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/otp-rental">
          <i class="fa fa-mobile-alt main-icon mr10" style="width: 24px; height: 24px; font-size: 18px;"></i>
          <?php echo __("Thuê OTP");?>

        </a>
      </li>
      <?php }?>
      
      <?php if ($_smarty_tpl->tpl_vars['system']->value['google_maps_reviews_enabled']) {?>
      <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "google-maps-reviews") {?>class="active" <?php }?>>
        <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/google-maps-reviews">
          <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"map",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
          <?php echo __("Google Maps Reviews");?>

        </a>
      </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['pages_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "pages") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"pages",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Pages");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['groups_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "groups") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/groups">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"groups",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Groups");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['events_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "events") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/events">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"events",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Events");?>

          </a>
        </li>
      <?php }?>

      <?php ob_start();
if ($_smarty_tpl->tpl_vars['user']->value->_logged_in) {
$_prefixVariable1 = ob_get_clean();
echo $_prefixVariable1;?>

        <?php if ($_smarty_tpl->tpl_vars['system']->value['watch_enabled']) {?>
          <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "index" && $_smarty_tpl->tpl_vars['view']->value == "watch") {?>class="active" <?php }?>>
            <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/watch">
              <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"watch",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
              <?php echo __("Watch");?>

            </a>
          </li>
        <?php }?>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['blogs_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "blogs") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/blogs">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"blogs",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Blogs");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['market_enabled']) {?>
        <li>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/market">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"market",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Marketplace");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['funding_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "funding") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/funding">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"funding",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Funding");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['pages_enabled'] && $_smarty_tpl->tpl_vars['system']->value['offers_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "offers") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/offers">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"offers",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Offers");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['pages_enabled'] && $_smarty_tpl->tpl_vars['system']->value['jobs_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "jobs") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/jobs">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"jobs",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Jobs");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['forums_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "forums") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/forums">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"forums",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Forums");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['movies_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "movies") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/movies">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"movies",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Movies");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['games_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "games") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/games">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"games",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Games");?>

          </a>
        </li>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['system']->value['developers_apps_enabled'] || $_smarty_tpl->tpl_vars['system']->value['developers_share_enabled']) {?>
        <li <?php if ($_smarty_tpl->tpl_vars['page']->value == "developers") {?>class="active" <?php }?>>
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/developers<?php if (!$_smarty_tpl->tpl_vars['system']->value['developers_apps_enabled']) {?>/share<?php }?>">
            <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"developers",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, true);
?>
            <?php echo __("Developers");?>

          </a>
        </li>
      <?php }?>

      <!-- explore -->
    </ul>
  </div>
</div><?php }
}
