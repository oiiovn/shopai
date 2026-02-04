<?php
/* Smarty version 4.3.4, created on 2025-10-09 08:17:28
  from '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/admin.pages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68e76f98f0bf59_14256324',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4f0243ffb628edfc40e219e932fddb326d3ef55a' => 
    array (
      0 => '/home/sho73359/domains/shop-ai.vn/public_html/content/themes/default/templates/admin.pages.tpl',
      1 => 1758583937,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:__categories.recursive_options.tpl' => 3,
    'file:__svg_icons.tpl' => 2,
    'file:__custom_fields.tpl' => 1,
    'file:__categories.recursive_rows.tpl' => 1,
  ),
),false)) {
function content_68e76f98f0bf59_14256324 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'/home/sho73359/domains/shop-ai.vn/public_html/vendor/smarty/smarty/libs/plugins/modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
?>
<div class="card">
  <div class="card-header with-icon with-nav">
    <!-- panel title -->
    <div class="mb20">
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "find") {?>
        <div class="float-end">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left mr5"></i><?php echo __("Go Back");?>

          </a>
        </div>
      <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_page") {?>
        <div class="float-end">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left"></i><span class="ml5 d-none d-lg-inline-block"><?php echo __("Go Back");?>
</span>
          </a>
          <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/<?php echo $_smarty_tpl->tpl_vars['data']->value['page_name'];?>
" class="btn btn-md btn-info">
            <i class="fa fa-eye"></i><span class="ml5 d-none d-lg-inline-block"><?php echo __("View Page");?>
</span>
          </a>
        </div>
      <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "categories") {?>
        <div class="float-end">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/add_category" class="btn btn-md btn-primary">
            <i class="fa fa-plus"></i><span class="ml5 d-none d-lg-inline-block"><?php echo __("Add New Category");?>
</span>
          </a>
        </div>
      <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "add_category" || $_smarty_tpl->tpl_vars['sub_view']->value == "edit_category") {?>
        <div class="float-end">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/categories" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left"></i><span class="ml5 d-none d-lg-inline-block"><?php echo __("Go Back");?>
</span>
          </a>
        </div>
      <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "business_types") {?>
        <div class="float-end">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/add_business_type" class="btn btn-md btn-primary">
            <i class="fa fa-plus"></i><span class="ml5 d-none d-lg-inline-block">Thêm loại hình</span>
          </a>
        </div>
      <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "add_business_type" || $_smarty_tpl->tpl_vars['sub_view']->value == "edit_business_type") {?>
        <div class="float-end">
          <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/business_types" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left"></i><span class="ml5 d-none d-lg-inline-block">Quay lại</span>
          </a>
        </div>
      <?php }?>
      
      <i class="fa fa-flag mr10"></i><?php echo __("Pages");?>

      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "find") {?> &rsaquo; <?php echo __("Find");
}?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_page") {?> &rsaquo; <?php echo $_smarty_tpl->tpl_vars['data']->value['page_title'];
}?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "categories") {?> &rsaquo; <?php echo __("Categories");
}?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "add_category") {?> &rsaquo; <?php echo __("Categories");?>
 &rsaquo; <?php echo __("Add New Category");
}?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_category") {?> &rsaquo; <?php echo __("Categories");?>
 &rsaquo; <?php echo $_smarty_tpl->tpl_vars['data']->value['category_name'];
}?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "business_types") {?> &rsaquo; Loại hình kinh doanh<?php }?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "add_business_type") {?> &rsaquo; Loại hình kinh doanh &rsaquo; Thêm mới<?php }?>
      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_business_type") {?> &rsaquo; Loại hình kinh doanh &rsaquo; <?php echo $_smarty_tpl->tpl_vars['data']->value['type_name'];
}?>
    </div>
    <!-- panel title -->

    <!-- panel nav -->
    <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '' || $_smarty_tpl->tpl_vars['sub_view']->value == "find" || $_smarty_tpl->tpl_vars['sub_view']->value == "categories" || $_smarty_tpl->tpl_vars['sub_view']->value == "business_types") {?>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '' || $_smarty_tpl->tpl_vars['sub_view']->value == "find") {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages">
            <i class="fa fa-list fa-fw mr5"></i><strong><?php echo __("List Pages");?>
</strong>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "categories") {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/categories">
            <i class="fa fa-folder fa-fw mr5"></i><strong><?php echo __("Categories");?>
</strong>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == "business_types") {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/business_types">
            <i class="fa fa-store fa-fw mr5"></i><strong><?php echo __("Business Types");?>
</strong>
          </a>
        </li>
      </ul>
    <?php }?>
    <!-- panel nav -->
  </div>

  <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '' || $_smarty_tpl->tpl_vars['sub_view']->value == "find") {?>

    <div class="card-body">

      <?php if ($_smarty_tpl->tpl_vars['sub_view']->value == '') {?>
        <div class="row">
          <div class="col-sm-4">
            <div class="stat-panel bg-gradient-indigo">
              <div class="stat-cell narrow">
                <i class="fa fa-flag bg-icon"></i>
                <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['insights']->value['pages'];?>
</span><br>
                <span class="text-lg"><?php echo __("Pages");?>
</span><br>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="stat-panel bg-gradient-primary">
              <div class="stat-cell narrow">
                <i class="fa fa-check bg-icon"></i>
                <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['insights']->value['pages_verified'];?>
</span><br>
                <span class="text-lg"><?php echo __("Verified Pages");?>
</span><br>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="stat-panel bg-gradient-info">
              <div class="stat-cell narrow">
                <i class="fa fa-heart bg-icon"></i>
                <span class="text-xxlg"><?php echo $_smarty_tpl->tpl_vars['insights']->value['pages_likes'];?>
</span><br>
                <span class="text-lg"><?php echo __("Total Likes");?>
</span><br>
              </div>
            </div>
          </div>
        </div>
      <?php }?>

      <!-- search form -->
      <div class="mb20">
        <form class="d-flex flex-row align-items-center flex-wrap" action="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/find" method="get">
          <div class="form-group mb0">
            <div class="input-group">
              <input type="text" class="form-control" name="query">
              <button type="submit" class="btn btn-sm btn-light"><i class="fas fa-search mr5"></i><?php echo __("Search");?>
</button>
            </div>
          </div>
        </form>
        <div class="form-text small">
          <?php echo __('Search by Page Web Address or Title');?>

        </div>
      </div>
      <!-- search form -->

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th><?php echo __("ID");?>
</th>
              <th><?php echo __("Page");?>
</th>
              <th><?php echo __("Admin");?>
</th>
              <th><?php echo __("Likes");?>
</th>
              <th><?php echo __("Verified");?>
</th>
              <th><?php echo __("Actions");?>
</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                <tr>
                  <td>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/<?php echo $_smarty_tpl->tpl_vars['row']->value['page_name'];?>
" target="_blank">
                      <?php echo $_smarty_tpl->tpl_vars['row']->value['page_id'];?>

                    </a>
                  </td>
                  <td>
                    <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/<?php echo $_smarty_tpl->tpl_vars['row']->value['page_name'];?>
">
                      <img class="tbl-image" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['page_picture'];?>
">
                      <?php echo $_smarty_tpl->tpl_vars['row']->value['page_title'];?>

                    </a>
                  </td>
                  <td>
                    <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['user_name'];?>
">
                      <img class="tbl-image" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_picture'];?>
">
                      <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['row']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['row']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['user_lastname'];
}?>
                    </a>
                  </td>
                  <td><?php echo $_smarty_tpl->tpl_vars['row']->value['page_likes'];?>
</td>
                  <td>
                    <?php if ($_smarty_tpl->tpl_vars['row']->value['page_verified']) {?>
                      <span class="badge rounded-pill badge-lg bg-success"><?php echo __("Yes");?>
</span>
                    <?php } else { ?>
                      <span class="badge rounded-pill badge-lg bg-danger"><?php echo __("No");?>
</span>
                    <?php }?>
                  </td>
                  <td>
                    <a data-bs-toggle="tooltip" title='<?php echo __("Edit");?>
' href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/edit_page/<?php echo $_smarty_tpl->tpl_vars['row']->value['page_id'];?>
" class="btn btn-sm btn-icon btn-rounded btn-primary">
                      <i class="fa fa-pencil-alt"></i>
                    </a>
                    <button data-bs-toggle="tooltip" title='<?php echo __("Delete");?>
' class="btn btn-sm btn-icon btn-rounded btn-danger js_admin-deleter" data-handle="page" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['page_id'];?>
">
                      <i class="fa fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
              <tr>
                <td colspan="6" class="text-center">
                  <?php echo __("No data to show");?>

                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      <?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

    </div>

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_page") {?>

    <div class="card-body">
      <div class="row">
        <div class="col-12 col-md-2 text-center mb20">
          <img class="img-fluid img-thumbnail rounded-circle" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_picture'];?>
">
        </div>
        <div class="col-12 col-md-10 mb20">
          <ul class="list-group">
            <li class="list-group-item">
              <span class="float-end badge badge-lg rounded-pill bg-secondary"><?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
</span>
              <?php echo __("Page ID");?>

            </li>
            <li class="list-group-item">
              <span class="float-end badge badge-lg rounded-pill bg-secondary"><?php echo $_smarty_tpl->tpl_vars['data']->value['page_likes'];?>
</span>
              <?php echo __("Likes");?>

            </li>
          </ul>
        </div>
      </div>

      <!-- tabs nav -->
      <ul class="nav nav-tabs mb20">
        <li class="nav-item">
          <a class="nav-link active" href="#page_settings" data-bs-toggle="tab">
            <i class="fa fa-cog fa-fw mr5"></i><strong><?php echo __("Settings");?>
</strong>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#page_info" data-bs-toggle="tab">
            <i class="fa fa-info-circle fa-fw mr5"></i><strong><?php echo __("Info");?>
</strong>
          </a>
        </li>
        <?php if ($_smarty_tpl->tpl_vars['system']->value['monetization_enabled']) {?>
          <li class="nav-item">
            <a class="nav-link" href="#page_monetization" data-bs-toggle="tab">
              <i class="fa fa-coins fa-fw mr5"></i><strong><?php echo __("Monetization");?>
</strong>
            </a>
          </li>
        <?php }?>
      </ul>
      <!-- tabs nav -->

      <!-- tabs content -->
      <div class="tab-content">
        <!-- settings tab -->
        <div class="tab-pane active" id="page_settings">
          <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_page&edit=settings&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
">
            <div class="row form-group">
              <label class="col-md-3 form-label">
                <?php echo __("Created By");?>

              </label>
              <div class="col-md-9">
                <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['data']->value['user_name'];?>
">
                  <img class="tbl-image" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['user_picture'];?>
">
                  <?php if ($_smarty_tpl->tpl_vars['system']->value['show_usernames_enabled']) {
echo $_smarty_tpl->tpl_vars['data']->value['user_name'];
} else {
echo $_smarty_tpl->tpl_vars['data']->value['user_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['user_lastname'];
}?>
                </a>
                <a target="_blank" data-bs-toggle="tooltip" title='<?php echo __("Edit");?>
' href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/users/edit/<?php echo $_smarty_tpl->tpl_vars['data']->value['user_id'];?>
" class="btn btn-sm btn-light btn-icon btn-rounded ml10">
                  <i class="fa fa-pencil-alt"></i>
                </a>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                <?php echo __("Verification Status");?>

              </label>
              <div class="col-md-9">
                <select class="form-select" name="page_verification_level">
                  <option value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['page_verified'] == '0') {?>selected<?php }?>>
                    <i class="fa fa-circle-o mr-2"></i><?php echo __("No Verification");?>

                  </option>
                  <option value="2" <?php if ($_smarty_tpl->tpl_vars['data']->value['page_verified'] == '2') {?>selected<?php }?>>
                    <i class="fa fa-shield-alt mr-2"></i><?php echo __("Gray Badge - Business Verified");?>

                  </option>
                  <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['page_verified'] == '1') {?>selected<?php }?>>
                    <i class="fa fa-certificate mr-2"></i><?php echo __("Blue Badge - Premium Verified");?>

                  </option>
                </select>
                <div class="form-text">
                  <?php echo __("Set the verification level for this page");?>

                </div>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                Loại hình kinh doanh
              </label>
              <div class="col-md-9">
                <select class="form-select" name="page_business_type_id" id="page_business_type_id">
                  <option value="">Chọn loại hình kinh doanh</option>
                  <?php if ($_smarty_tpl->tpl_vars['business_types']->value) {?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['business_types']->value, 'type');
$_smarty_tpl->tpl_vars['type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->do_else = false;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['type']->value['business_type_id'];?>
" 
                              <?php if ($_smarty_tpl->tpl_vars['data']->value['page_business_type_id'] == $_smarty_tpl->tpl_vars['type']->value['business_type_id']) {?>selected<?php }?>
                              data-icon="<?php echo $_smarty_tpl->tpl_vars['type']->value['type_icon'];?>
" 
                              data-color="<?php echo $_smarty_tpl->tpl_vars['type']->value['type_color'];?>
">
                        <?php echo $_smarty_tpl->tpl_vars['type']->value['type_name'];?>

                      </option>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  <?php }?>
                </select>
                <div class="form-text">
                  Chọn loại hình kinh doanh cho page này. Điều này sẽ quyết định các tính năng có sẵn.
                  <?php if ($_smarty_tpl->tpl_vars['data']->value['page_business_type_id']) {?>
                    <br><small class="text-info">
                      <i class="fa fa-info-circle"></i> 
                      Loại hiện tại: <strong><?php echo $_smarty_tpl->tpl_vars['data']->value['current_business_type_name'];?>
</strong>
                      <?php if ($_smarty_tpl->tpl_vars['data']->value['business_type_approved_at']) {?>
                        <br>Được phê duyệt vào: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value['business_type_approved_at'],"%d/%m/%Y %H:%M");?>

                      <?php }?>
                    </small>
                  <?php }?>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                <?php echo __("Name Your Page");?>

              </label>
              <div class="col-md-9">
                <input class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_title'];?>
">
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                <?php echo __("Page Username");?>

              </label>
              <div class="col-md-9">
                <div class="input-group">
                  <span class="input-group-text d-none d-sm-block"><?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/pages/</span>
                  <input type="text" class="form-control" name="username" id="username" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_name'];?>
">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                <?php echo __("Category");?>

              </label>
              <div class="col-md-9">
                <select class="form-select" name="category">
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['categories'], 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('data_category'=>$_smarty_tpl->tpl_vars['data']->value['page_category']), 0, true);
?>
                  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </select>
              </div>
            </div>

            <?php if ($_smarty_tpl->tpl_vars['system']->value['tips_enabled']) {?>
              <div class="divider"></div>
              <div class="form-table-row">
                <div class="avatar">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"tip",'class'=>"main-icon",'width'=>"40px",'height'=>"40px"), 0, false);
?>
                </div>
                <div>
                  <div class="form-label h6"><?php echo __("Tips Enabled");?>
</div>
                  <div class="form-text d-none d-sm-block"><?php echo __("Allow the send tips button on your page");?>
</div>
                </div>
                <div class="text-end">
                  <label class="switch" for="page_tips_enabled">
                    <input type="checkbox" name="page_tips_enabled" id="page_tips_enabled" <?php if ($_smarty_tpl->tpl_vars['data']->value['page_tips_enabled']) {?>checked<?php }?>>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
            <?php }?>

            <!-- success -->
            <div class="alert alert-success mb0 mt20 x-hidden"></div>
            <!-- success -->

            <!-- error -->
            <div class="alert alert-danger mb0 mt20 x-hidden"></div>
            <!-- error -->

            <div class="card-footer-fake text-end">
              <button type="button" class="btn btn-danger js_admin-deleter" data-handle="page_posts" data-id="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
" data-delete-message="<?php echo __("Are you sure you want to delete all posts?");?>
">
                <i class="fa fa-trash-alt mr5"></i><?php echo __("Delete Posts");?>

              </button>
              <button type="button" class="btn btn-danger js_admin-deleter" data-handle="page" data-id="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
" data-redirect="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages">
                <i class="fa fa-trash-alt mr5"></i><?php echo __("Delete Page");?>

              </button>
              <button type="submit" class="btn btn-primary"><?php echo __("Save Changes");?>
</button>
            </div>
          </form>
        </div>
        <!-- settings tab -->

        <!-- info tab -->
        <div class="tab-pane" id="page_info">
          <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_page&edit=info&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
">
            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="company"><?php echo __("Company");?>
</label>
                <input type="text" class="form-control" name="company" id="company" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_company'];?>
">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label" for="phone"><?php echo __("Phone");?>
</label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_phone'];?>
">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="website"><?php echo __("Website");?>
</label>
                <input type="text" class="form-control" name="website" id="website" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_website'];?>
">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label" for="location"><?php echo __("Location");?>
</label>
                <input type="text" class="form-control js_geocomplete" name="location" id="location" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['page_location'];?>
">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="country"><?php echo __("Country");?>
</label>
              <select class="form-select" name="country">
                <option value="none"><?php echo __("Select Country");?>
</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['countries'], 'country');
$_smarty_tpl->tpl_vars['country']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['country']->value) {
$_smarty_tpl->tpl_vars['country']->do_else = false;
?>
                  <option value="<?php echo $_smarty_tpl->tpl_vars['country']->value['country_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['data']->value['page_country'] == $_smarty_tpl->tpl_vars['country']->value['country_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['country']->value['country_name'];?>
</option>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="description"><?php echo __("About");?>
</label>
              <textarea class="form-control" name="description" id="description"><?php echo $_smarty_tpl->tpl_vars['data']->value['page_description'];?>
</textarea>
            </div>

            <!-- custom fields -->
            <?php if ($_smarty_tpl->tpl_vars['custom_fields']->value['basic']) {?>
              <?php $_smarty_tpl->_subTemplateRender('file:__custom_fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_custom_fields'=>$_smarty_tpl->tpl_vars['custom_fields']->value['basic'],'_registration'=>false), 0, false);
?>
            <?php }?>
            <!-- custom fields -->

            <!-- success -->
            <div class="alert alert-success x-hidden"></div>
            <!-- success -->

            <!-- error -->
            <div class="alert alert-danger x-hidden"></div>
            <!-- error -->

            <div class="card-footer-fake text-end">
              <button type="submit" class="btn btn-primary"><?php echo __("Save Changes");?>
</button>
            </div>
          </form>
        </div>
        <!-- info tab -->

        <!-- monetization tab -->
        <div class="tab-pane" id="page_monetization">
          <?php if ($_smarty_tpl->tpl_vars['data']->value['can_monetize_content']) {?>
            <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_page&edit=monetization&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
">
              <div class="form-table-row">
                <div class="avatar">
                  <?php $_smarty_tpl->_subTemplateRender('file:__svg_icons.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('icon'=>"monetization",'class'=>"main-icon",'width'=>"40px",'height'=>"40px"), 0, true);
?>
                </div>
                <div>
                  <div class="form-label h6"><?php echo __("Content Monetization");?>
</div>
                  <div class="form-text d-none d-sm-block"><?php echo __("Enable or disable monetization for your content");?>
</div>
                </div>
                <div class="text-end">
                  <label class="switch" for="page_monetization_enabled">
                    <input type="checkbox" name="page_monetization_enabled" id="page_monetization_enabled" <?php if ($_smarty_tpl->tpl_vars['data']->value['page_monetization_enabled']) {?>checked<?php }?>>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>

              <div class="row form-group">
                <label class="col-md-3 form-label">
                  <?php echo __("Payment Plans");?>

                </label>
                <div class="col-md-9">
                  <div class="payment-plans">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['monetization_plans']->value, 'plan');
$_smarty_tpl->tpl_vars['plan']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['plan']->value) {
$_smarty_tpl->tpl_vars['plan']->do_else = false;
?>
                      <div class="payment-plan">
                        <div class="text-xxlg"><?php echo __($_smarty_tpl->tpl_vars['plan']->value['title']);?>
</div>
                        <div class="text-xlg"><?php echo print_money($_smarty_tpl->tpl_vars['plan']->value['price']);?>
 / <?php if ($_smarty_tpl->tpl_vars['plan']->value['period_num'] != '1') {
echo $_smarty_tpl->tpl_vars['plan']->value['period_num'];
}?> <?php echo __(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'ucfirst' ][ 0 ], array( $_smarty_tpl->tpl_vars['plan']->value['period'] )));?>
</div>
                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['plan']->value['custom_description'];
$_prefixVariable1 = ob_get_clean();
if ($_prefixVariable1) {?>
                          <div><?php echo $_smarty_tpl->tpl_vars['plan']->value['custom_description'];?>
</div>
                        <?php }?>
                        <div class="mt10">
                          <span class="text-link mr10 js_monetization-deleter" data-id="<?php echo $_smarty_tpl->tpl_vars['plan']->value['plan_id'];?>
">
                            <i class="fa fa-trash-alt mr5"></i><?php echo __("Delete");?>

                          </span>
                          |
                          <span data-toggle="modal" data-url="monetization/controller.php?do=edit&id=<?php echo $_smarty_tpl->tpl_vars['plan']->value['plan_id'];?>
" class="text-link ml10">
                            <i class="fa fa-pen mr5"></i><?php echo __("Edit");?>

                          </span>
                        </div>
                      </div>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <div data-toggle="modal" data-url="monetization/controller.php?do=add&node_id=<?php echo $_smarty_tpl->tpl_vars['data']->value['page_id'];?>
&node_type=page" class="payment-plan new"><?php echo __("Add new plan");?>
 </div>
                  </div>
                </div>
              </div>

              <!-- success -->
              <div class="alert alert-success x-hidden"></div>
              <!-- success -->

              <!-- error -->
              <div class="alert alert-danger x-hidden"></div>
              <!-- error -->

              <div class="card-footer-fake text-end">
                <button type="submit" class="btn btn-primary"><?php echo __("Save Changes");?>
</button>
              </div>
            </form>
          <?php } else { ?>
            <div class="alert alert-danger">
              <div class="icon">
                <i class="fa fa-minus-circle fa-2x"></i>
              </div>
              <div class="text pt5">
                <?php echo __("This page super admin is not eligible for monetization");?>

              </div>
            </div>
          <?php }?>
        </div>
        <!-- monetization tab -->
      </div>
      <!-- tabs content -->
    </div>

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "categories") {?>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover js_treegrid">
          <thead>
            <tr>
              <th><?php echo __("Title");?>
</th>
              <th><?php echo __("Description");?>
</th>
              <th><?php echo __("Order");?>
</th>
              <th><?php echo __("Actions");?>
</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($_smarty_tpl->tpl_vars['rows']->value) {?>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'row');
$_smarty_tpl->tpl_vars['row']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->do_else = false;
?>
                <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_rows.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_url'=>"pages",'_handle'=>"page_category"), 0, true);
?>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
              <tr>
                <td colspan="5" class="text-center">
                  <?php echo __("No data to show");?>

                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "add_category") {?>

    <form class="js_ajax-forms" data-url="admin/pages.php?do=add_category">
      <div class="card-body">
        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Name");?>

          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_name">
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Description");?>

          </label>
          <div class="col-md-9">
            <textarea class="form-control" name="category_description" rows="3"></textarea>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Parent Category");?>

          </label>
          <div class="col-md-9">
            <select class="form-select" name="category_parent_id">
              <option value="0"><?php echo __("Set as a Partent Category");?>
</option>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
                <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </select>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Order");?>

          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_order">
          </div>
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

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_category") {?>

    <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_category&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['category_id'];?>
">
      <div class="card-body">
        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Name");?>

          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_name" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['category_name'];?>
">
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Description");?>

          </label>
          <div class="col-md-9">
            <textarea class="form-control" name="category_description" rows="3"><?php echo $_smarty_tpl->tpl_vars['data']->value['category_description'];?>
</textarea>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Parent Category");?>

          </label>
          <div class="col-md-9">
            <select class="form-select" name="category_parent_id">
              <option value="0"><?php echo __("Set as a Partent Category");?>
</option>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value["categories"], 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
                <?php $_smarty_tpl->_subTemplateRender('file:__categories.recursive_options.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('data_category'=>$_smarty_tpl->tpl_vars['data']->value['category_parent_id']), 0, true);
?>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </select>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            <?php echo __("Order");?>

          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_order" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['category_order'];?>
">
          </div>
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

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "business_types") {?>

    <div class="card-body">
      <div class="row">
        <div class="col-sm-9">
          <h3>Quản lý loại hình kinh doanh</h3>
          <p class="text-muted">Tạo và quản lý các loại hình kinh doanh khác nhau cho pages, mỗi loại sẽ có bộ tính năng riêng</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>Icon</th>
              <th>Loại hình kinh doanh</th>
              <th>Slug</th>
              <th>Số pages</th>
              <th>Tính năng</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($_smarty_tpl->tpl_vars['business_types']->value) {?>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['business_types']->value, 'type');
$_smarty_tpl->tpl_vars['type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->do_else = false;
?>
                <tr>
                  <td class="text-center">
                    <i class="<?php echo $_smarty_tpl->tpl_vars['type']->value['type_icon'];?>
" style="color: <?php echo $_smarty_tpl->tpl_vars['type']->value['type_color'];?>
; font-size: 24px;"></i>
                  </td>
                  <td>
                    <div>
                      <strong><?php echo $_smarty_tpl->tpl_vars['type']->value['type_name'];?>
</strong>
                      <br><small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['type']->value['type_name_en'];?>
</small>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['type']->value['type_description']) {?>
                      <small class="text-muted d-block mt5"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['type']->value['type_description'],100);?>
</small>
                    <?php }?>
                  </td>
                  <td>
                    <code><?php echo $_smarty_tpl->tpl_vars['type']->value['type_slug'];?>
</code>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-success fs-6"><?php echo $_smarty_tpl->tpl_vars['type']->value['pages_count'];?>
</span>
                    <?php if ($_smarty_tpl->tpl_vars['type']->value['pages_count'] > 0) {?>
                      <br><a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages?business_type=<?php echo $_smarty_tpl->tpl_vars['type']->value['business_type_id'];?>
" class="btn btn-xs btn-outline-info mt5">
                        Xem pages
                      </a>
                    <?php }?>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-info fs-6"><?php echo $_smarty_tpl->tpl_vars['type']->value['features_count'];?>
</span>
                    <br><button class="btn btn-xs btn-outline-primary mt5" data-toggle="modal" data-url="#manage-features" data-id="<?php echo $_smarty_tpl->tpl_vars['type']->value['business_type_id'];?>
">
                      Quản lý
                    </button>
                  </td>
                  <td class="text-center">
                    <?php if ($_smarty_tpl->tpl_vars['type']->value['is_active'] == '1') {?>
                      <span class="badge bg-success">Hoạt động</span>
                    <?php } else { ?>
                      <span class="badge bg-secondary">Tạm dừng</span>
                    <?php }?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/edit_business_type/<?php echo $_smarty_tpl->tpl_vars['type']->value['business_type_id'];?>
" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Chỉnh sửa">
                        <i class="fa fa-edit"></i>
                      </a>
                      <button class="btn btn-sm btn-outline-info" onclick="manage_features(<?php echo $_smarty_tpl->tpl_vars['type']->value['business_type_id'];?>
)" data-bs-toggle="tooltip" title="Tính năng">
                        <i class="fa fa-cogs"></i>
                      </button>
                      <?php if ($_smarty_tpl->tpl_vars['type']->value['pages_count'] == 0) {?>
                        <button class="btn btn-sm btn-outline-danger js_admin-deleter" data-handle="business-type" data-id="<?php echo $_smarty_tpl->tpl_vars['type']->value['business_type_id'];?>
" data-bs-toggle="tooltip" title="Xóa">
                          <i class="fa fa-trash"></i>
                        </button>
                      <?php }?>
                    </div>
                  </td>
                </tr>
              <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
              <tr>
                <td colspan="7" class="text-center">
                  <div class="py-4">
                    <i class="fa fa-store fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có loại hình kinh doanh nào</h5>
                    <p class="text-muted">Bắt đầu bằng cách thêm loại hình kinh doanh đầu tiên</p>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['system']->value['system_url'];?>
/<?php echo $_smarty_tpl->tpl_vars['control_panel']->value['url'];?>
/pages/add_business_type" class="btn btn-primary">
                      <i class="fa fa-plus mr5"></i>Thêm loại hình kinh doanh
                    </a>
                  </div>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "add_business_type") {?>

    <div class="card-body">
      <form class="js_ajax-forms" data-url="admin/pages.php?do=add_business_type">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tên loại hình (Tiếng Việt)</label>
              <input type="text" class="form-control" name="type_name" required placeholder="Ẩm thực & Đồ uống">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tên loại hình (Tiếng Anh)</label>
              <input type="text" class="form-control" name="type_name_en" required placeholder="Food & Beverage">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Slug</label>
              <input type="text" class="form-control" name="type_slug" required placeholder="am-thuc-do-uong">
              <small class="form-text text-muted">Định danh thân thiện với URL</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Icon</label>
              <input type="text" class="form-control" name="type_icon" placeholder="fa-utensils" value="fa-store">
              <small class="form-text text-muted">Class icon FontAwesome</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Màu sắc</label>
              <input type="color" class="form-control" name="type_color" value="#007bff">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="type_description" rows="3" placeholder="Mô tả về loại hình kinh doanh này..."></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Thứ tự hiển thị</label>
          <input type="number" class="form-control" name="display_order" value="1" min="1">
        </div>

        <!-- success -->
        <div class="alert alert-success mt15 mb0 x-hidden"></div>
        <!-- success -->

        <!-- error -->
        <div class="alert alert-danger mt15 mb0 x-hidden"></div>
        <!-- error -->
      </div>
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
      </div>
    </form>

  <?php } elseif ($_smarty_tpl->tpl_vars['sub_view']->value == "edit_business_type") {?>

    <div class="card-body">
      <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_business_type&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['business_type_id'];?>
">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tên loại hình (Tiếng Việt)</label>
              <input type="text" class="form-control" name="type_name" required value="<?php echo $_smarty_tpl->tpl_vars['data']->value['type_name'];?>
">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tên loại hình (Tiếng Anh)</label>
              <input type="text" class="form-control" name="type_name_en" required value="<?php echo $_smarty_tpl->tpl_vars['data']->value['type_name_en'];?>
">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Slug</label>
              <input type="text" class="form-control" name="type_slug" required value="<?php echo $_smarty_tpl->tpl_vars['data']->value['type_slug'];?>
">
              <small class="form-text text-muted">Định danh thân thiện với URL</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Icon</label>
              <input type="text" class="form-control" name="type_icon" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['type_icon'];?>
">
              <small class="form-text text-muted">Class icon FontAwesome</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Màu sắc</label>
              <input type="color" class="form-control" name="type_color" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['type_color'];?>
">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="type_description" rows="3"><?php echo $_smarty_tpl->tpl_vars['data']->value['type_description'];?>
</textarea>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Thứ tự hiển thị</label>
              <input type="number" class="form-control" name="display_order" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['display_order'];?>
" min="1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Trạng thái</label>
              <select class="form-select" name="is_active">
                <option value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['is_active'] == '1') {?>selected<?php }?>>Hoạt động</option>
                <option value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['is_active'] == '0') {?>selected<?php }?>>Tạm dừng</option>
              </select>
            </div>
          </div>
        </div>

        <!-- success -->
        <div class="alert alert-success mt15 mb0 x-hidden"></div>
        <!-- success -->

        <!-- error -->
        <div class="alert alert-danger mt15 mb0 x-hidden"></div>
        <!-- error -->
      </div>
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
      </div>
    </form>

  <?php }?>

</div><?php }
}
