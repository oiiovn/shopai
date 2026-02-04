<?php
/* Smarty version 4.3.4, created on 2026-01-15 14:02:56
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ads.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6968f39053cbf7_06111045',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5df0e9c810ea722b4d0b22173e5138cf432370e9' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/ads.tpl',
      1 => 1699255882,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_head.tpl' => 1,
    'file:_header.tpl' => 1,
    'file:_sidebar.tpl' => 1,
    'file:__svg_icons.tpl' => 1,
    'file:_no_data.tpl' => 1,
    'file:_footer.tpl' => 1,
  ),
),false)) {
function content_6968f39053cbf7_06111045 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
$_smarty_tpl->_subTemplateRender('file:_head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:_header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- page header -->
<div class="page-header">
  <img class="floating-img d-none d-md-block" src="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/content/themes/<?php echo $_smarty_tpl->tpl_vars['system']->value['theme'];?>
/images/headers/undraw_growth_analytics_8btt.svg">
  <div class="circle-2"></div>
  <div class="circle-3"></div>
  <div class="inner">
    <h2><?php echo __("Ads Manager");?>
</h2>
    <p class="text-xlg"><?php echo __("Manage Ads, Create new Campaign");?>
</p>
  </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="<?php if ($_smarty_tpl->tpl_vars['system']->value['fluid_design']) {?>container-fluid<?php } else { ?>container<?php }?> sg-offcanvas" style="margin-top: -25px;">
  <div class="row">

    <!-- side panel -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar">
      <?php $_smarty_tpl->_subTemplateRender('file:_sidebar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>
    <!-- side panel -->

    <!-- content panel -->
    <div class="col-12 sg-offcanvas-mainbar">

      <!-- tabs -->
      <div class="position-relative">
        <div class="content-tabs rounded-sm shadow-sm clearfix">
          <ul>
            <li class="active">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/ads">
                <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"ads",'class'=>"main-icon mr10",'width'=>"24px",'height'=>"24px"), 0, false);
?>
                <?php echo __("Ads Campaigns");?>

              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- tabs -->

      <!-- adblock-warning-message -->
      <div class="adblock-warning-message mtb10">
        <?php echo __("Turn off the ad blocker or add this web page's URL as an exception so you use ads system without any problems");?>
, <?php echo __("After you turn off the ad blocker, you'll need to refresh your screen");?>

      </div>
      <!-- adblock-warning-message -->

      <?php if ($_smarty_tpl->tpl_vars['view']->value == '') {?>

        <!-- ads campaigns -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <a class="btn btn-md btn-primary float-end" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/ads/new">
              <i class="fa fa-plus-circle mr5"></i><?php echo __("New Campaign");?>

            </a>
            <?php echo __("My Campaigns");?>

          </div>
          <div class="card-body">
            <?php if ($_smarty_tpl->tpl_vars['campaigns']->value) {?>
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover js_dataTable">
                  <thead>
                    <tr>
                      <th><?php echo __("Title");?>
</th>
                      <th><?php echo __("Start - End Date");?>
</th>
                      <th><?php echo __("Budget");?>
</th>
                      <th><?php echo __("Spend");?>
</th>
                      <th><?php echo __("Bidding");?>
</th>
                      <th><?php echo __("Clicks/Views");?>
</th>
                      <th><?php echo __("Status");?>
</th>
                      <th><?php echo __("Created");?>
</th>
                      <th><?php echo __("Actions");?>
</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['campaigns']->value, 'campaign');
$_smarty_tpl->tpl_vars['campaign']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['campaign']->value) {
$_smarty_tpl->tpl_vars['campaign']->do_else = false;
?>
                      <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_title'];?>
</td>
                        <td>
                          <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['campaign']->value['campaign_start_date'],"%e %B %Y");?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['campaign']->value['campaign_end_date'],"%e %B %Y");?>

                        </td>
                        <td><?php echo print_money(smarty_modifier_number_format($_smarty_tpl->tpl_vars['campaign']->value['campaign_budget'],2));?>
</td>
                        <td><?php echo print_money(smarty_modifier_number_format($_smarty_tpl->tpl_vars['campaign']->value['campaign_spend'],2));?>
</td>
                        <td>
                          <span class="badge bg-secondary">
                            <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_bidding'] == "click") {?>
                              <i class="fa fa-hand-pointer mr5"></i><?php echo __("Click");?>

                            <?php } else { ?>
                              <i class="fa fa-eye mr5"></i><?php echo __("View");?>

                            <?php }?>
                          </span>
                        </td>
                        <td>
                          <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_bidding'] == "click") {?>
                            <?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_clicks'];?>
 <?php echo __("Clicks");?>

                          <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_views'];?>
 <?php echo __("Views");?>

                          <?php }?>
                        </td>
                        <td>
                          <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_is_declined']) {?>
                            <span class="badge rounded-pill badge-lg bg-danger"><?php echo __("Declined");?>
</span>
                          <?php } else { ?>
                            <?php if (!$_smarty_tpl->tpl_vars['campaign']->value['campaign_is_approved']) {?>
                              <span class="badge rounded-pill badge-lg bg-warning"><?php echo __("Approval Pending");?>
</span>
                            <?php } else { ?>
                              <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_is_active']) {?>
                                <span class="badge rounded-pill badge-lg bg-success"><?php echo __("Active");?>
</span>
                              <?php } else { ?>
                                <span class="badge rounded-pill badge-lg bg-danger"><?php echo __("Not Active");?>
</span>
                              <?php }?>
                            <?php }?>
                          <?php }?>
                        </td>
                        <td>
                          <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_created_date'];?>
"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_created_date'];?>
</span>
                        </td>
                        <td>
                          <a data-bs-toggle="tooltip" title='<?php echo __("Edit");?>
' href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/ads/edit/<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_id'];?>
" class="btn btn-sm btn-icon btn-rounded btn-primary">
                            <i class="fa fa-pencil-alt"></i>
                          </a>
                          <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_is_approved']) {?>
                            <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_is_active']) {?>
                              <button data-bs-toggle="tooltip" title='<?php echo __("Stop");?>
' class="btn btn-sm btn-icon btn-rounded btn-warning js_ads-stop-campaign" data-id="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_id'];?>
">
                                <i class="fas fa-stop-circle"></i>
                              </button>
                            <?php } else { ?>
                              <button data-bs-toggle="tooltip" title='<?php echo __("Resume");?>
' class="btn btn-sm btn-icon btn-rounded btn-success js_ads-resume-campaign" data-id="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_id'];?>
">
                                <i class="fas fa-play-circle"></i>
                              </button>
                            <?php }?>
                          <?php }?>
                          <button data-bs-toggle="tooltip" title='<?php echo __("Delete");?>
' class="btn btn-sm btn-icon btn-rounded btn-danger js_ads-delete-campaign" data-id="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_id'];?>
">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </tbody>
                </table>
              </div>
            <?php } else { ?>
              <?php $_smarty_tpl->_subTemplateRender('file:_no_data.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <?php }?>
          </div>
        </div>
        <!-- ads campaigns -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "new") {?>

        <!-- new campaign -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <div class="float-end">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/ads" class="btn btn-md btn-light">
                <i class="fa fa-arrow-circle-left mr5"></i><?php echo __("Go Back");?>

              </a>
            </div>
            <?php echo __("New Campaign");?>

          </div>
          <form class="js_ajax-forms" data-url="ads/campaign.php?do=create">
            <div class="card-body">
              <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance'] == 0) {?>
                <div class="bs-callout bs-callout-danger mt0">
                  <?php echo __("Your current wallet credit is");?>
: <strong><?php echo print_money(smarty_modifier_number_format($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance'],2));?>
</strong> <?php echo __("You need to");?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet"><?php echo __("Replenish your wallet credit");?>
</a>
                </div>
              <?php }?>

              <?php if ($_smarty_tpl->tpl_vars['system']->value['ads_approval_enabled']) {?>
                <div class="bs-callout bs-callout-warning mt0">
                  <?php echo __("Your campaign will need to be approved by admin before publishing");?>

                </div>
              <?php }?>

              <div class="row">
                <!-- campaign details & target audience -->
                <div class="col-sm-6">
                  <!-- campaign details -->
                  <div class="section-title mb20">
                    <i class="fa fa-cog mr5"></i><?php echo __("Campaign Details");?>

                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_title"><?php echo __("Campaign Title");?>
</label>
                    <input type="text" class="form-control" name="campaign_title" id="campaign_title">
                    <div class="form-text">
                      <?php echo __("Set a title for your campaign");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_start_date"><?php echo __("Campaign Start Date");?>
</label>
                    <input type="datetime-local" class="form-control" name="campaign_start_date">
                    <div class="form-text">
                      <?php echo __("Set Campaign start datetime (UTC)");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_end_date"><?php echo __("Campaign End Date");?>
</label>
                    <input type="datetime-local" class="form-control" name="campaign_end_date">
                    <div class="form-text">
                      <?php echo __("Set Campaign end datetime (UTC)");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_budget"><?php echo __("Campaign Budget");?>
</label>
                    <div class="input-money <?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_dir'];?>
">
                      <span><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
                      <input type="text" class="form-control" placeholder="0.00" min="1.00" max="1000" name="campaign_budget">
                    </div>
                    <div class="form-text">
                      <?php echo __("Set a budget for your campaign, campaign will be paused if reached its limit");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_bidding"><?php echo __("Campaign Bidding");?>
</label>
                    <select class="form-select" name="campaign_bidding">
                      <option value="click"><?php echo __("Pay Per Click");?>
 (<?php echo print_money($_smarty_tpl->tpl_vars['system']->value['ads_cost_click']);?>
)</option>
                      <option value="view"><?php echo __("Pay Per View");?>
 (<?php echo print_money($_smarty_tpl->tpl_vars['system']->value['ads_cost_view']);?>
)</option>
                    </select>
                  </div>
                  <!-- campaign details -->

                  <!-- target audience -->
                  <div class="section-title mb20">
                    <i class="fa fa-crosshairs mr5"></i><?php echo __("Target Audience");?>

                  </div>
                  <div class="form-group">
                    <label class="form-label" for="audience_countries"><?php echo __("Audience Country");?>
</label>
                    <select class="form-select" multiple name="audience_countries[]" id="js_ads-audience-countries">
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['countries']->value, 'country');
$_smarty_tpl->tpl_vars['country']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['country']->value) {
$_smarty_tpl->tpl_vars['country']->do_else = false;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['country']->value['country_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['country']->value['country_name'];?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                  </div>
                  <div class="form-group <?php if ($_smarty_tpl->tpl_vars['system']->value['genders_disabled']) {?>x-hidden<?php }?>">
                    <label class="form-label" for="audience_gender"><?php echo __("Audience Gender");?>
</label>
                    <select class="form-select" name="audience_gender" id="js_ads-audience-gender">
                      <option value="all"><?php echo __("All");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['genders']->value, 'gender');
$_smarty_tpl->tpl_vars['gender']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['gender']->value) {
$_smarty_tpl->tpl_vars['gender']->do_else = false;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['gender']->value['gender_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['gender']->value['gender_name'];?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                  </div>
                  <?php if ($_smarty_tpl->tpl_vars['system']->value['relationship_info_enabled']) {?>
                    <div class="form-group">
                      <label class="form-label" for="audience_relationship"><?php echo __("Audience Relationship");?>
</label>
                      <select class="form-select" name="audience_relationship" id="js_ads-audience-relationship">
                        <option value="all"><?php echo __("All");?>
</option>
                        <option value="single"><?php echo __("Single");?>
</option>
                        <option value="relationship"><?php echo __("In a relationship");?>
</option>
                        <option value="married"><?php echo __("Married");?>
</option>
                        <option value="complicated"><?php echo __("It's complicated");?>
</option>
                        <option value="separated"><?php echo __("Separated");?>
</option>
                        <option value="divorced"><?php echo __("Divorced");?>
</option>
                        <option value="widowed"><?php echo __("Widowed");?>
</option>
                      </select>
                    </div>
                  <?php }?>
                  <div class="form-group">
                    <label class="form-label" for="potential_reach"><?php echo __("Potential Reach");?>
</label>
                    <div class="text-lg">
                      <div class="float-end x-hidden" id="js_ads-potential-reach-loader">
                        <div class="spinner-border text-info"></div>
                      </div>
                      <i class="fa fa-users"></i> <span class="badge rounded-pill badge-lg bg-danger" id="js_ads-potential-reach"><?php echo $_smarty_tpl->tpl_vars['potential_reach']->value;?>
</span> <?php echo __("People");?>

                    </div>
                  </div>
                  <!-- target audience -->
                </div>
                <!-- campaign details & target audience -->

                <!-- ads details -->
                <div class="col-sm-6">
                  <div class="section-title mb20">
                    <i class="fa fa-bullhorn mr5"></i><?php echo __("Ads Details");?>

                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_title"><?php echo __("Ads Title");?>
</label>
                    <input type="text" class="form-control" name="ads_title" id="ads_title">
                    <div class="form-text">
                      <?php echo __("Set a title for your ads");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_description"><?php echo __("Ads Description");?>
</label>
                    <textarea class="form-control" name="ads_description" rows="5"></textarea>
                    <div class="form-text">
                      <?php echo __("Set a description for your ads (maximum 200 characters)");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_type"><?php echo __("Advertise For");?>
</label>
                    <select class="form-select" name="ads_type" id="js_campaign-type">
                      <option value="url"><?php echo __("URL");?>
</option>
                      <option value="page"><?php echo __("Page");?>
</option>
                      <option value="group"><?php echo __("Group");?>
</option>
                      <option value="event"><?php echo __("Event");?>
</option>
                    </select>
                    <div class="form-text">
                      <?php echo __("You can advertise for a URL or one of your pages, groups or events");?>

                    </div>
                  </div>
                  <div class="form-group" id="js_campaign-type-url">
                    <label class="form-label" for="ads_url"><?php echo __("Target URL");?>
</label>
                    <input type="text" class="form-control" name="ads_url">
                    <div class="form-text">
                      <?php echo __("Enter your URL you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group x-hidden" id="js_campaign-type-page">
                    <label class="form-label" for="ads_page"><?php echo __("Target Page");?>
</label>
                    <select class="form-select" name="ads_page">
                      <option value="none"><?php echo __("Select Page");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
$_smarty_tpl->tpl_vars['page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->do_else = false;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><?php echo __($_smarty_tpl->tpl_vars['page']->value['page_title']);?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <div class="form-text">
                      <?php echo __("Select one of your pages you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group x-hidden" id="js_campaign-type-group">
                    <label class="form-label" for="ads_group"><?php echo __("Target Group");?>
</label>
                    <select class="form-select" name="ads_group">
                      <option value="none"><?php echo __("Select Group");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value, 'group');
$_smarty_tpl->tpl_vars['group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->do_else = false;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"><?php echo __($_smarty_tpl->tpl_vars['group']->value['group_title']);?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <div class="form-text">
                      <?php echo __("Select one of your groups you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group x-hidden" id="js_campaign-type-event">
                    <label class="form-label" for="ads_event"><?php echo __("Target Event");?>
</label>
                    <select class="form-select" name="ads_event">
                      <option value="none"><?php echo __("Select Event");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['events']->value, 'event');
$_smarty_tpl->tpl_vars['event']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['event']->value) {
$_smarty_tpl->tpl_vars['event']->do_else = false;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['event']->value['event_id'];?>
"><?php echo __($_smarty_tpl->tpl_vars['event']->value['event_title']);?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <div class="form-text">
                      <?php echo __("Select one of your events you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_placement"><?php echo __("Ads Placement");?>
</label>
                    <select class="form-select" name="ads_placement">
                      <option value="newsfeed"><?php echo __("Newsfeed");?>
</option>
                      <option value="sidebar"><?php echo __("Sidebar");?>
</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_image"><?php echo __("Ads Image");?>
</label>
                    <div class="x-image">
                      <button type="button" class="btn-close x-hidden js_x-image-remover" title='<?php echo __("Remove");?>
'>

                      </button>
                      <div class="x-image-loader">
                        <div class="progress x-progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <i class="fa fa-camera fa-lg js_x-uploader" data-handle="x-image"></i>
                      <input type="hidden" class="js_x-image-input" name="ads_image">
                    </div>
                    <div class="form-text">
                      <?php echo __("The image of your ads, supported formats (JPG, PNG, GIF)");?>

                    </div>
                  </div>
                </div>
                <!-- ads details -->
              </div>

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary">
                <?php echo __("Publish");?>

              </button>
            </div>
          </form>
        </div>
        <!-- new campaign -->

      <?php } elseif ($_smarty_tpl->tpl_vars['view']->value == "edit") {?>

        <!-- edit campaign -->
        <div class="card mt20">
          <div class="card-header with-icon">
            <div class="float-end">
              <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/ads" class="btn btn-md btn-light">
                <i class="fa fa-arrow-circle-left mr5"></i><?php echo __("Go Back");?>

              </a>
            </div>
            <?php echo __("Edit Campaign");?>

          </div>
          <form class="js_ajax-forms" data-url="ads/campaign.php?do=edit&id=<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_id'];?>
">
            <div class="card-body">
              <?php if ($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance'] == 0) {?>
                <div class="bs-callout bs-callout-danger mt0">
                  <?php echo __("Your current wallet credit is");?>
: <strong><?php echo print_money(smarty_modifier_number_format($_smarty_tpl->tpl_vars['user']->value->_data['user_wallet_balance'],2));?>
</strong> <?php echo __("You need to");?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet"><?php echo __("Replenish your wallet credit");?>
</a>
                </div>
              <?php }?>

              <?php if ($_smarty_tpl->tpl_vars['system']->value['ads_approval_enabled']) {?>
                <div class="bs-callout bs-callout-warning mt0">
                  <?php echo __("Your campaign will need to be approved by admin before publishing");?>

                </div>
              <?php }?>

              <div class="row">
                <!-- campaign details & target audience -->
                <div class="col-sm-6">
                  <!-- campaign details -->
                  <div class="section-title mb20">
                    <i class="fa fa-cog mr5"></i><?php echo __("Campaign Details");?>

                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_title"><?php echo __("Campaign Title");?>
</label>
                    <input type="text" class="form-control" name="campaign_title" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_title'];?>
">
                    <div class="form-text">
                      <?php echo __("Set a title for your campaign");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_start_date"><?php echo __("Campaign Start Date");?>
</label>
                    <input type="datetime-local" class="form-control" name="campaign_start_date" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_start_date'];?>
">
                    <div class="form-text">
                      <?php echo __("Set Campaign start datetime (UTC)");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_end_date"><?php echo __("Campaign End Date");?>
</label>
                    <input type="datetime-local" class="form-control" name="campaign_end_date" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_end_date'];?>
">
                    <div class="form-text">
                      <?php echo __("Set Campaign end datetime (UTC)");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_budget"><?php echo __("Campaign Budget");?>
</label>
                    <div class="input-money <?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_dir'];?>
">
                      <span><?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency_symbol'];?>
</span>
                      <input type="text" class="form-control" placeholder="0.00" min="1.00" max="1000" name="campaign_budget" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_budget'];?>
">
                    </div>
                    <div class="form-text">
                      <?php echo __("Set a budget for your campaign, campaign will be paused if reached its limit");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="campaign_bidding"><?php echo __("Campaign Bidding");?>
</label>
                    <select class="form-select" name="campaign_bidding">
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_bidding'] == "click") {?>selected<?php }?> value="click"><?php echo __("Pay Per Click");?>
 (<?php echo print_money($_smarty_tpl->tpl_vars['system']->value['ads_cost_click']);?>
)</option>
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['campaign_bidding'] == "view") {?>selected<?php }?> value="view"><?php echo __("Pay Per View");?>
 (<?php echo print_money($_smarty_tpl->tpl_vars['system']->value['ads_cost_view']);?>
)</option>
                    </select>
                  </div>
                  <!-- campaign details -->

                  <!-- target audience -->
                  <div class="section-title mb20">
                    <i class="fa fa-crosshairs mr5"></i><?php echo __("Target Audience");?>

                  </div>
                  <div class="form-group">
                    <label class="form-label" for="audience_countries"><?php echo __("Audience Country");?>
</label>
                    <select class="form-select" multiple name="audience_countries[]" id="js_ads-audience-countries">
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['countries']->value, 'country');
$_smarty_tpl->tpl_vars['country']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['country']->value) {
$_smarty_tpl->tpl_vars['country']->do_else = false;
?>
                        <option <?php if (in_array($_smarty_tpl->tpl_vars['country']->value['country_id'],$_smarty_tpl->tpl_vars['campaign']->value['audience_countries'])) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['country']->value['country_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['country']->value['country_name'];?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                  </div>
                  <div class="form-group <?php if ($_smarty_tpl->tpl_vars['system']->value['genders_disabled']) {?>x-hidden<?php }?>">
                    <label class="form-label" for="audience_gender"><?php echo __("Audience Gender");?>
</label>
                    <select class="form-select" name="audience_gender" id="js_ads-audience-gender">
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_gender'] == "all") {?>selected<?php }?> value="all"><?php echo __("All");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['genders']->value, 'gender');
$_smarty_tpl->tpl_vars['gender']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['gender']->value) {
$_smarty_tpl->tpl_vars['gender']->do_else = false;
?>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_gender'] == $_smarty_tpl->tpl_vars['gender']->value['gender_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['gender']->value['gender_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['gender']->value['gender_name'];?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                  </div>
                  <?php if ($_smarty_tpl->tpl_vars['system']->value['relationship_info_enabled']) {?>
                    <div class="form-group">
                      <label class="form-label" for="audience_relationship"><?php echo __("Audience Relationship");?>
</label>
                      <select class="form-select" name="audience_relationship" id="js_ads-audience-relationship">
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "all") {?>selected<?php }?> value="all"><?php echo __("All");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "single") {?>selected<?php }?> value="single"><?php echo __("Single");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "relationship") {?>selected<?php }?> value="relationship"><?php echo __("In a relationship");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "married") {?>selected<?php }?> value="married"><?php echo __("Married");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "complicated") {?>selected<?php }?> value="complicated"><?php echo __("It's complicated");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "separated") {?>selected<?php }?> value="separated"><?php echo __("Separated");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "divorced") {?>selected<?php }?> value="divorced"><?php echo __("Divorced");?>
</option>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['audience_relationship'] == "widowed") {?>selected<?php }?> value="widowed"><?php echo __("Widowed");?>
</option>
                      </select>
                    </div>
                  <?php }?>
                  <div class="form-group">
                    <label class="form-label" for="potential_reach"><?php echo __("Potential Reach");?>
</label>
                    <div class="text-lg">
                      <div class="float-end x-hidden" id="js_ads-potential-reach-loader">
                        <div class="spinner-border text-info"></div>
                      </div>
                      <i class="fa fa-users"></i> <span class="text-primary" id="js_ads-potential-reach"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_potential_reach'];?>
</span> <?php echo __("People");?>

                    </div>
                  </div>
                  <!-- target audience -->
                </div>
                <!-- campaign details & target audience -->

                <!-- ads details -->
                <div class="col-sm-6">
                  <div class="section-title mb20">
                    <i class="fa fa-bullhorn mr5"></i><?php echo __("Ads Details");?>

                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_title"><?php echo __("Ads Title");?>
</label>
                    <input type="text" class="form-control" name="ads_title" id="ads_title" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['ads_title'];?>
">
                    <div class="form-text">
                      <?php echo __("Set a title for your ads");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_description"><?php echo __("Ads Description");?>
</label>
                    <textarea class="form-control" name="ads_description" rows="5"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['ads_description'];?>
</textarea>
                    <div class="form-text">
                      <?php echo __("Set a description for your ads (maximum 200 characters)");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_type"><?php echo __("Advertise For");?>
</label>
                    <select class="form-select" name="ads_type" id="js_campaign-type">
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] == "url") {?>selected<?php }?> value="url"><?php echo __("URL");?>
</option>
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] == "page") {?>selected<?php }?> value="page"><?php echo __("Page");?>
</option>
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] == "group") {?>selected<?php }?> value="group"><?php echo __("Group");?>
</option>
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] == "event") {?>selected<?php }?> value="event"><?php echo __("Event");?>
</option>
                    </select>
                    <div class="form-text">
                      <?php echo __("You can advertise for a URL or one of your pages, groups or events");?>

                    </div>
                  </div>
                  <div class="form-group <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] != 'url') {?>x-hidden<?php }?>" id="js_campaign-type-url">
                    <label class="form-label" for="ads_url"><?php echo __("Target URL");?>
</label>
                    <input type="text" class="form-control" name="ads_url" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['ads_url'];?>
">
                    <div class="form-text">
                      <?php echo __("Enter your URL you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] != 'page') {?>x-hidden<?php }?>" id="js_campaign-type-page">
                    <label class="form-label" for="ads_page"><?php echo __("Target Page");?>
</label>
                    <select class="form-select" name="ads_page">
                      <option value="none"><?php echo __("Select Page");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
$_smarty_tpl->tpl_vars['page']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->do_else = false;
?>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_page'] == $_smarty_tpl->tpl_vars['page']->value['page_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><?php echo __($_smarty_tpl->tpl_vars['page']->value['page_title']);?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <div class="form-text">
                      <?php echo __("Select one of your pages you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] != 'group') {?>x-hidden<?php }?>" id="js_campaign-type-group">
                    <label class="form-label" for="ads_group"><?php echo __("Target Group");?>
</label>
                    <select class="form-select" name="ads_group">
                      <option value="none"><?php echo __("Select Group");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['groups']->value, 'group');
$_smarty_tpl->tpl_vars['group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->do_else = false;
?>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_group'] == $_smarty_tpl->tpl_vars['group']->value['group_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['group']->value['group_id'];?>
"><?php echo __($_smarty_tpl->tpl_vars['group']->value['group_title']);?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <div class="form-text">
                      <?php echo __("Select one of your groups you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_type'] != 'event') {?>x-hidden<?php }?>" id="js_campaign-type-event">
                    <label class="form-label" for="ads_event"><?php echo __("Target Event");?>
</label>
                    <select class="form-select" name="ads_event">
                      <option value="none"><?php echo __("Select Event");?>
</option>
                      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['events']->value, 'event');
$_smarty_tpl->tpl_vars['event']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['event']->value) {
$_smarty_tpl->tpl_vars['event']->do_else = false;
?>
                        <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_event'] == $_smarty_tpl->tpl_vars['event']->value['event_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['event']->value['event_id'];?>
"><?php echo __($_smarty_tpl->tpl_vars['event']->value['event_title']);?>
</option>
                      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </select>
                    <div class="form-text">
                      <?php echo __("Select one of your events you want to advertise for");?>

                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_placement"><?php echo __("Ads Placement");?>
</label>
                    <select class="form-select" name="ads_placement">
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_placement'] == "newsfeed") {?>selected<?php }?> value="newsfeed"><?php echo __("Newsfeed");?>
</option>
                      <option <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_placement'] == "sidebar") {?>selected<?php }?> value="sidebar"><?php echo __("Sidebar");?>
</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="ads_image"><?php echo __("Ads Image");?>
</label>
                    <?php if ($_smarty_tpl->tpl_vars['campaign']->value['ads_image'] == '') {?>
                      <div class="x-image">
                        <button type="button" class="btn-close x-hidden js_x-image-remover" title='<?php echo __("Remove");?>
'>

                        </button>
                        <div class="x-image-loader">
                          <div class="progress x-progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                        <i class="fa fa-camera fa-lg js_x-uploader" data-handle="x-image"></i>
                        <input type="hidden" class="js_x-image-input" name="ads_image">
                      </div>
                    <?php } else { ?>
                      <div class="x-image" style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['system']->value['system_uploads'];?>
/<?php echo $_smarty_tpl->tpl_vars['campaign']->value['ads_image'];?>
')">
                        <button type="button" class="btn-close js_x-image-remover" title='<?php echo __("Remove");?>
'>

                        </button>
                        <div class="x-image-loader">
                          <div class="progress x-progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                        <i class="fa fa-camera fa-lg js_x-uploader" data-handle="x-image"></i>
                        <input type="hidden" class="js_x-image-input" name="ads_image" value="<?php echo $_smarty_tpl->tpl_vars['campaign']->value['ads_image'];?>
">
                      </div>
                    <?php }?>
                    <div class="form-text">
                      <?php echo __("The image of your ads, supported formats (JPG, PNG, GIF)");?>

                    </div>
                  </div>
                </div>
                <!-- ads details -->
              </div>

              <!-- success -->
              <div class="alert alert-success mt15 mb0 x-hidden"></div>
              <!-- success -->

              <!-- error -->
              <div class="alert alert-danger mt15 mb0 x-hidden"></div>
              <!-- error -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Save Changes");?>
</button>
            </div>
          </form>
        </div>
        <!-- edit campaign -->

      <?php }?>
    </div>
    <!-- content panel -->

  </div>
</div>
<!-- page content -->

<?php $_smarty_tpl->_subTemplateRender('file:_footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
