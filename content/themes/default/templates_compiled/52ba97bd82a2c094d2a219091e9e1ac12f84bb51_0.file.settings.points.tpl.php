<?php
/* Smarty version 4.3.4, created on 2026-01-15 14:55:29
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/settings.points.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_6968ffe10dee81_67955882',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52ba97bd82a2c094d2a219091e9e1ac12f84bb51' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/settings.points.tpl',
      1 => 1685364572,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__svg_icons.tpl' => 1,
    'file:_no_transactions.tpl' => 1,
  ),
),false)) {
function content_6968ffe10dee81_67955882 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
?>
<div class="card-header with-icon">
  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"points",'class'=>"main-icon mr15",'width'=>"24px",'height'=>"24px"), 0, false);
?>
  <?php echo __("Points");?>

</div>
<div class="card-body">
  <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '') {?>
    <div class="alert alert-info">
      <div class="text">
        <strong><?php echo __("Points System");?>
</strong><br>
        <?php echo __("Each");?>
 <strong><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_currency'];?>
</strong> <?php echo __("points equal");?>
 <strong><?php echo print_money("1");?>
</strong>.
        <br>
        <?php echo __("Your daily points limit is");?>
 <strong><span class="badge rounded-pill bg-warning"><?php if ($_smarty_tpl->tpl_vars['system']->value['packages_enabled'] && $_smarty_tpl->tpl_vars['user']->value->_data['user_subscribed']) {
echo $_smarty_tpl->tpl_vars['system']->value['points_limit_pro'];
} else {
echo $_smarty_tpl->tpl_vars['system']->value['points_limit_user'];
}?></span></strong> <?php echo __("Points");?>
, <?php echo __("You have");?>
 <strong><span class="badge rounded-pill bg-danger"><?php echo $_smarty_tpl->tpl_vars['remaining_points']->value;?>
</span></strong> <?php echo __("remaining points");?>

        <br>
        <?php echo __("Your daily points limit will be reset after 24 hours from your last valid earned action");?>

        <br>
        <?php if ($_smarty_tpl->tpl_vars['system']->value['points_money_withdraw_enabled']) {?>
          <?php echo __("You can withdraw your money");?>

        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['system']->value['points_money_transfer_enabled']) {?>
          <?php if ($_smarty_tpl->tpl_vars['system']->value['points_money_withdraw_enabled']) {
echo __("or");?>
 <?php }?>
          <?php echo __("You can transfer your money to your");?>
 <a class="alert-link" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/wallet" target="_blank"><i class="fa fa-wallet"></i> <?php echo __("wallet");?>
</a>
        <?php }?>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="stat-panel border">
          <div class="stat-cell">
            <i class="fa fa-newspaper icon bg-gradient-success"></i>
            <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_post'];?>
</span><br>
            <span class="text-lg"><?php echo __("Points");?>
</span><br>
            <span><?php echo __("For creating a new post");?>
</span>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="stat-panel border">
          <div class="stat-cell">
            <i class="fa fa-eye icon bg-gradient-success"></i>
            <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_post_view'];?>
</span><br>
            <span class="text-lg"><?php echo __("Points");?>
</span><br>
            <span><?php echo __("For each post view");?>
</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="stat-panel border">
          <div class="stat-cell">
            <i class="fa fa-comments icon bg-gradient-primary"></i>
            <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_comment'];?>
</span><br>
            <span class="text-lg"><?php echo __("Points");?>
</span><br>
            <span><?php echo __("For commenting any post");?>
</span>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="stat-panel border">
          <div class="stat-cell">
            <i class="fa fa-smile icon bg-gradient-danger"></i>
            <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_reaction'];?>
</span><br>
            <span class="text-lg"><?php echo __("Points");?>
</span><br>
            <span><?php echo __("For reacting on any post");?>
</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="stat-panel border">
          <div class="stat-cell">
            <i class="fa fa-users icon bg-gradient-warning"></i>
            <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_follow'];?>
</span><br>
            <span class="text-lg"><?php echo __("Points");?>
</span><br>
            <span><?php echo __("For each follower you got");?>
</span>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="stat-panel border">
          <div class="stat-cell">
            <i class="fa fa-exchange-alt icon bg-gradient-purple"></i>
            <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['system']->value['points_per_referred'];?>
</span><br>
            <span class="text-lg"><?php echo __("Points");?>
</span><br>
            <span><?php echo __("For referring user");?>
</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- points balance -->
      <div class="col-sm-6">
        <div class="section-title mb20">
          <?php echo __("Points Balance");?>

        </div>
        <div class="stat-panel bg-info">
          <div class="stat-cell">
            <i class="fa fa-piggy-bank bg-icon"></i>
            <div class="h3 mtb10">
              <?php echo $_smarty_tpl->tpl_vars['user']->value->_data['user_points'];?>
 <?php echo __("Points");?>

            </div>
          </div>
        </div>
      </div>
      <!-- points balance -->

      <!-- money balance -->
      <div class="col-sm-6">
        <div class="section-title mb20">
          <?php echo __("Points Money Balance");?>

        </div>
        <div class="stat-panel bg-primary">
          <div class="stat-cell">
            <i class="fa fas fa-donate bg-icon"></i>
            <div class="h3 mtb10">
              <?php echo print_money(smarty_modifier_number_format(((1/$_smarty_tpl->tpl_vars['system']->value['points_per_currency'])*$_smarty_tpl->tpl_vars['user']->value->_data['user_points']),2));?>

            </div>
          </div>
        </div>
      </div>
      <!-- money balance -->
    </div>
  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "payments") {?>
    <div class="heading-small mb20">
      <?php echo __("Withdrawal Request");?>

    </div>
    <div class="pl-md-4">
      <form class="js_ajax-forms" data-url="users/withdraw.php?type=points">
        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Your Balance");?>

          </label>
          <div class="col-md-9">
            <h6>
              <span class="badge badge-lg bg-info">
                <?php echo print_money(smarty_modifier_number_format(((1/$_smarty_tpl->tpl_vars['system']->value['points_per_currency'])*$_smarty_tpl->tpl_vars['user']->value->_data['user_points']),2));?>

              </span>
            </h6>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Amount");?>
 (<?php echo $_smarty_tpl->tpl_vars['system']->value['system_currency'];?>
)
          </label>
          <div class="col-md-9">
            <input type="text" class="form-control" name="amount">
            <div class="form-text">
              <?php echo __("The minimum withdrawal request amount is");?>
 <?php echo print_money($_smarty_tpl->tpl_vars['system']->value['points_min_withdrawal']);?>

            </div>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Payment Method");?>

          </label>
          <div class="col-md-9">
            <?php if (in_array("paypal",$_smarty_tpl->tpl_vars['system']->value['points_payment_method_array'])) {?>
              <div class="form-check form-check-inline">
                <input type="radio" name="method" id="method_paypal" value="paypal" class="form-check-input">
                <label class="form-check-label" for="method_paypal"><?php echo __("PayPal");?>
</label>
              </div>
            <?php }?>
            <?php if (in_array("skrill",$_smarty_tpl->tpl_vars['system']->value['points_payment_method_array'])) {?>
              <div class="form-check form-check-inline">
                <input type="radio" name="method" id="method_skrill" value="skrill" class="form-check-input">
                <label class="form-check-label" for="method_skrill"><?php echo __("Skrill");?>
</label>
              </div>
            <?php }?>
            <?php if (in_array("moneypoolscash",$_smarty_tpl->tpl_vars['system']->value['points_payment_method_array'])) {?>
              <div class="form-check form-check-inline">
                <input type="radio" name="method" id="method_moneypoolscash" value="moneypoolscash" class="form-check-input">
                <label class="form-check-label" for="method_moneypoolscash"><?php echo __("MoneyPoolsCash");?>
</label>
              </div>
            <?php }?>
            <?php if (in_array("bank",$_smarty_tpl->tpl_vars['system']->value['points_payment_method_array'])) {?>
              <div class="form-check form-check-inline">
                <input type="radio" name="method" id="method_bank" value="bank" class="form-check-input">
                <label class="form-check-label" for="method_bank"><?php echo __("Bank Transfer");?>
</label>
              </div>
            <?php }?>
            <?php if (in_array("custom",$_smarty_tpl->tpl_vars['system']->value['points_payment_method_array'])) {?>
              <div class="form-check form-check-inline">
                <input type="radio" name="method" id="method_custom" value="custom" class="form-check-input">
                <label class="form-check-label" for="method_custom"><?php echo __($_smarty_tpl->tpl_vars['system']->value['points_payment_method_custom']);?>
</label>
              </div>
            <?php }?>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Transfer To");?>

          </label>
          <div class="col-md-9">
            <input type="text" class="form-control" name="method_value">
          </div>
        </div>

        <div class="row">
          <div class="col-md-9 offset-md-3">
            <button type="submit" class="btn btn-primary"><?php echo __("Make a withdrawal");?>
</button>
          </div>
        </div>

        <!-- success -->
        <div class="alert alert-success mt15 mb0 x-hidden"></div>
        <!-- success -->

        <!-- error -->
        <div class="alert alert-danger mt15 mb0 x-hidden"></div>
        <!-- error -->
      </form>
    </div>

    <div class="divider"></div>

    <div class="heading-small mb20">
      <?php echo __("Withdrawal History");?>

    </div>
    <div class="pl-md-4">
      <?php if ($_smarty_tpl->tpl_vars['payments']->value) {?>
        <div class="table-responsive mt20">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th><?php echo __("ID");?>
</th>
                <th><?php echo __("Amount");?>
</th>
                <th><?php echo __("Method");?>
</th>
                <th><?php echo __("Transfer To");?>
</th>
                <th><?php echo __("Time");?>
</th>
                <th><?php echo __("Status");?>
</th>
              </tr>
            </thead>
            <tbody>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payments']->value, 'payment');
$_smarty_tpl->tpl_vars['payment']->iteration = 0;
$_smarty_tpl->tpl_vars['payment']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['payment']->value) {
$_smarty_tpl->tpl_vars['payment']->do_else = false;
$_smarty_tpl->tpl_vars['payment']->iteration++;
$__foreach_payment_0_saved = $_smarty_tpl->tpl_vars['payment'];
?>
                <tr>
                  <td><?php echo $_smarty_tpl->tpl_vars['payment']->iteration;?>
</td>
                  <td><?php echo print_money(smarty_modifier_number_format($_smarty_tpl->tpl_vars['payment']->value['amount'],2));?>
</td>
                  <td>
                    <?php if ($_smarty_tpl->tpl_vars['payment']->value['method'] == "custom") {?>
                      <?php echo $_smarty_tpl->tpl_vars['system']->value['points_payment_method_custom'];?>

                    <?php } else { ?>
                      <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'ucfirst' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['method'] ));?>

                    <?php }?>
                  </td>
                  <td><?php echo $_smarty_tpl->tpl_vars['payment']->value['method_value'];?>
</td>
                  <td>
                    <span class="js_moment" data-time="<?php echo $_smarty_tpl->tpl_vars['payment']->value['time'];?>
"><?php echo $_smarty_tpl->tpl_vars['payment']->value['time'];?>
</span>
                  </td>
                  <td>
                    <?php if ($_smarty_tpl->tpl_vars['payment']->value['status'] == '0') {?>
                      <span class="badge rounded-pill badge-lg bg-warning"><?php echo __("Pending");?>
</span>
                    <?php } elseif ($_smarty_tpl->tpl_vars['payment']->value['status'] == '1') {?>
                      <span class="badge rounded-pill badge-lg bg-success"><?php echo __("Approved");?>
</span>
                    <?php } else { ?>
                      <span class="badge rounded-pill badge-lg bg-danger"><?php echo __("Declined");?>
</span>
                    <?php }?>
                  </td>
                </tr>
              <?php
$_smarty_tpl->tpl_vars['payment'] = $__foreach_payment_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </tbody>
          </table>
        </div>
      <?php } else { ?>
        <?php $_smarty_tpl->_subTemplateRender('file:_no_transactions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php }?>
    </div>
  <?php }?>
</div><?php }
}
