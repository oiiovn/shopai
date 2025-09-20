<div class="card">
  <div class="card-header with-icon with-nav">
    <!-- panel title -->
    <div class="mb20">
      {if $sub_view == "find"}
        <div class="float-end">
          <a href="{$system['system_url']}/{$control_panel['url']}/pages" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left mr5"></i>{__("Go Back")}
          </a>
        </div>
      {elseif $sub_view == "edit_page"}
        <div class="float-end">
          <a href="{$system['system_url']}/{$control_panel['url']}/pages" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left"></i><span class="ml5 d-none d-lg-inline-block">{__("Go Back")}</span>
          </a>
          <a target="_blank" href="{$system['system_url']}/pages/{$data['page_name']}" class="btn btn-md btn-info">
            <i class="fa fa-eye"></i><span class="ml5 d-none d-lg-inline-block">{__("View Page")}</span>
          </a>
        </div>
      {elseif $sub_view == "categories"}
        <div class="float-end">
          <a href="{$system['system_url']}/{$control_panel['url']}/pages/add_category" class="btn btn-md btn-primary">
            <i class="fa fa-plus"></i><span class="ml5 d-none d-lg-inline-block">{__("Add New Category")}</span>
          </a>
        </div>
      {elseif $sub_view == "add_category" || $sub_view == "edit_category"}
        <div class="float-end">
          <a href="{$system['system_url']}/{$control_panel['url']}/pages/categories" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left"></i><span class="ml5 d-none d-lg-inline-block">{__("Go Back")}</span>
          </a>
        </div>
      {elseif $sub_view == "business_types"}
        <div class="float-end">
          <a href="{$system['system_url']}/{$control_panel['url']}/pages/add_business_type" class="btn btn-md btn-primary">
            <i class="fa fa-plus"></i><span class="ml5 d-none d-lg-inline-block">Thêm loại hình</span>
          </a>
        </div>
      {elseif $sub_view == "add_business_type" || $sub_view == "edit_business_type"}
        <div class="float-end">
          <a href="{$system['system_url']}/{$control_panel['url']}/pages/business_types" class="btn btn-md btn-light">
            <i class="fa fa-arrow-circle-left"></i><span class="ml5 d-none d-lg-inline-block">Quay lại</span>
          </a>
        </div>
      {/if}
      
      <i class="fa fa-flag mr10"></i>{__("Pages")}
      {if $sub_view == "find"} &rsaquo; {__("Find")}{/if}
      {if $sub_view == "edit_page"} &rsaquo; {$data['page_title']}{/if}
      {if $sub_view == "categories"} &rsaquo; {__("Categories")}{/if}
      {if $sub_view == "add_category"} &rsaquo; {__("Categories")} &rsaquo; {__("Add New Category")}{/if}
      {if $sub_view == "edit_category"} &rsaquo; {__("Categories")} &rsaquo; {$data['category_name']}{/if}
      {if $sub_view == "business_types"} &rsaquo; Loại hình kinh doanh{/if}
      {if $sub_view == "add_business_type"} &rsaquo; Loại hình kinh doanh &rsaquo; Thêm mới{/if}
      {if $sub_view == "edit_business_type"} &rsaquo; Loại hình kinh doanh &rsaquo; {$data['type_name']}{/if}
    </div>
    <!-- panel title -->

    <!-- panel nav -->
    {if $sub_view == "" || $sub_view == "find" || $sub_view == "categories" || $sub_view == "business_types"}
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link {if $sub_view == "" || $sub_view == "find"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/pages">
            <i class="fa fa-list fa-fw mr5"></i><strong>{__("List Pages")}</strong>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {if $sub_view == "categories"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/pages/categories">
            <i class="fa fa-folder fa-fw mr5"></i><strong>{__("Categories")}</strong>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {if $sub_view == "business_types"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/pages/business_types">
            <i class="fa fa-store fa-fw mr5"></i><strong>{__("Business Types")}</strong>
          </a>
        </li>
      </ul>
    {/if}
    <!-- panel nav -->
  </div>

  {if $sub_view == "" || $sub_view == "find"}

    <div class="card-body">

      {if $sub_view == ""}
        <div class="row">
          <div class="col-sm-4">
            <div class="stat-panel bg-gradient-indigo">
              <div class="stat-cell narrow">
                <i class="fa fa-flag bg-icon"></i>
                <span class="text-xxlg">{$insights['pages']}</span><br>
                <span class="text-lg">{__("Pages")}</span><br>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="stat-panel bg-gradient-primary">
              <div class="stat-cell narrow">
                <i class="fa fa-check bg-icon"></i>
                <span class="text-xxlg">{$insights['pages_verified']}</span><br>
                <span class="text-lg">{__("Verified Pages")}</span><br>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="stat-panel bg-gradient-info">
              <div class="stat-cell narrow">
                <i class="fa fa-heart bg-icon"></i>
                <span class="text-xxlg">{$insights['pages_likes']}</span><br>
                <span class="text-lg">{__("Total Likes")}</span><br>
              </div>
            </div>
          </div>
        </div>
      {/if}

      <!-- search form -->
      <div class="mb20">
        <form class="d-flex flex-row align-items-center flex-wrap" action="{$system['system_url']}/{$control_panel['url']}/pages/find" method="get">
          <div class="form-group mb0">
            <div class="input-group">
              <input type="text" class="form-control" name="query">
              <button type="submit" class="btn btn-sm btn-light"><i class="fas fa-search mr5"></i>{__("Search")}</button>
            </div>
          </div>
        </form>
        <div class="form-text small">
          {__('Search by Page Web Address or Title')}
        </div>
      </div>
      <!-- search form -->

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>{__("ID")}</th>
              <th>{__("Page")}</th>
              <th>{__("Admin")}</th>
              <th>{__("Likes")}</th>
              <th>{__("Verified")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
            {if $rows}
              {foreach $rows as $row}
                <tr>
                  <td>
                    <a href="{$system['system_url']}/pages/{$row['page_name']}" target="_blank">
                      {$row['page_id']}
                    </a>
                  </td>
                  <td>
                    <a target="_blank" href="{$system['system_url']}/pages/{$row['page_name']}">
                      <img class="tbl-image" src="{$row['page_picture']}">
                      {$row['page_title']}
                    </a>
                  </td>
                  <td>
                    <a target="_blank" href="{$system['system_url']}/{$row['user_name']}">
                      <img class="tbl-image" src="{$row['user_picture']}">
                      {if $system['show_usernames_enabled']}{$row['user_name']}{else}{$row['user_firstname']} {$row['user_lastname']}{/if}
                    </a>
                  </td>
                  <td>{$row['page_likes']}</td>
                  <td>
                    {if $row['page_verified']}
                      <span class="badge rounded-pill badge-lg bg-success">{__("Yes")}</span>
                    {else}
                      <span class="badge rounded-pill badge-lg bg-danger">{__("No")}</span>
                    {/if}
                  </td>
                  <td>
                    <a data-bs-toggle="tooltip" title='{__("Edit")}' href="{$system['system_url']}/{$control_panel['url']}/pages/edit_page/{$row['page_id']}" class="btn btn-sm btn-icon btn-rounded btn-primary">
                      <i class="fa fa-pencil-alt"></i>
                    </a>
                    <button data-bs-toggle="tooltip" title='{__("Delete")}' class="btn btn-sm btn-icon btn-rounded btn-danger js_admin-deleter" data-handle="page" data-id="{$row['page_id']}">
                      <i class="fa fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
              {/foreach}
            {else}
              <tr>
                <td colspan="6" class="text-center">
                  {__("No data to show")}
                </td>
              </tr>
            {/if}
          </tbody>
        </table>
      </div>
      {$pager}
    </div>

  {elseif $sub_view == "edit_page"}

    <div class="card-body">
      <div class="row">
        <div class="col-12 col-md-2 text-center mb20">
          <img class="img-fluid img-thumbnail rounded-circle" src="{$data['page_picture']}">
        </div>
        <div class="col-12 col-md-10 mb20">
          <ul class="list-group">
            <li class="list-group-item">
              <span class="float-end badge badge-lg rounded-pill bg-secondary">{$data['page_id']}</span>
              {__("Page ID")}
            </li>
            <li class="list-group-item">
              <span class="float-end badge badge-lg rounded-pill bg-secondary">{$data['page_likes']}</span>
              {__("Likes")}
            </li>
          </ul>
        </div>
      </div>

      <!-- tabs nav -->
      <ul class="nav nav-tabs mb20">
        <li class="nav-item">
          <a class="nav-link active" href="#page_settings" data-bs-toggle="tab">
            <i class="fa fa-cog fa-fw mr5"></i><strong>{__("Settings")}</strong>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#page_info" data-bs-toggle="tab">
            <i class="fa fa-info-circle fa-fw mr5"></i><strong>{__("Info")}</strong>
          </a>
        </li>
        {if $system['monetization_enabled']}
          <li class="nav-item">
            <a class="nav-link" href="#page_monetization" data-bs-toggle="tab">
              <i class="fa fa-coins fa-fw mr5"></i><strong>{__("Monetization")}</strong>
            </a>
          </li>
        {/if}
      </ul>
      <!-- tabs nav -->

      <!-- tabs content -->
      <div class="tab-content">
        <!-- settings tab -->
        <div class="tab-pane active" id="page_settings">
          <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_page&edit=settings&id={$data['page_id']}">
            <div class="row form-group">
              <label class="col-md-3 form-label">
                {__("Created By")}
              </label>
              <div class="col-md-9">
                <a target="_blank" href="{$system['system_url']}/{$data['user_name']}">
                  <img class="tbl-image" src="{$data['user_picture']}">
                  {if $system['show_usernames_enabled']}{$data['user_name']}{else}{$data['user_firstname']} {$data['user_lastname']}{/if}
                </a>
                <a target="_blank" data-bs-toggle="tooltip" title='{__("Edit")}' href="{$system['system_url']}/{$control_panel['url']}/users/edit/{$data['user_id']}" class="btn btn-sm btn-light btn-icon btn-rounded ml10">
                  <i class="fa fa-pencil-alt"></i>
                </a>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                {__("Verification Status")}
              </label>
              <div class="col-md-9">
                <select class="form-select" name="page_verification_level">
                  <option value="0" {if $data['page_verified'] == '0'}selected{/if}>
                    <i class="fa fa-circle-o mr-2"></i>{__("No Verification")}
                  </option>
                  <option value="2" {if $data['page_verified'] == '2'}selected{/if}>
                    <i class="fa fa-shield-alt mr-2"></i>{__("Gray Badge - Business Verified")}
                  </option>
                  <option value="1" {if $data['page_verified'] == '1'}selected{/if}>
                    <i class="fa fa-certificate mr-2"></i>{__("Blue Badge - Premium Verified")}
                  </option>
                </select>
                <div class="form-text">
                  {__("Set the verification level for this page")}
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
                  {if $business_types}
                    {foreach $business_types as $type}
                      <option value="{$type.business_type_id}" 
                              {if $data['page_business_type_id'] == $type.business_type_id}selected{/if}
                              data-icon="{$type.type_icon}" 
                              data-color="{$type.type_color}">
                        {$type.type_name}
                      </option>
                    {/foreach}
                  {/if}
                </select>
                <div class="form-text">
                  Chọn loại hình kinh doanh cho page này. Điều này sẽ quyết định các tính năng có sẵn.
                  {if $data['page_business_type_id']}
                    <br><small class="text-info">
                      <i class="fa fa-info-circle"></i> 
                      Loại hiện tại: <strong>{$data['current_business_type_name']}</strong>
                      {if $data['business_type_approved_at']}
                        <br>Được phê duyệt vào: {$data['business_type_approved_at']|date_format:"%d/%m/%Y %H:%M"}
                      {/if}
                    </small>
                  {/if}
                </div>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                {__("Name Your Page")}
              </label>
              <div class="col-md-9">
                <input class="form-control" name="title" value="{$data['page_title']}">
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                {__("Page Username")}
              </label>
              <div class="col-md-9">
                <div class="input-group">
                  <span class="input-group-text d-none d-sm-block">{$system['system_url']}/pages/</span>
                  <input type="text" class="form-control" name="username" id="username" value="{$data['page_name']}">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-md-3 form-label">
                {__("Category")}
              </label>
              <div class="col-md-9">
                <select class="form-select" name="category">
                  {foreach $data['categories'] as $category}
                    {include file='__categories.recursive_options.tpl' data_category=$data['page_category']}
                  {/foreach}
                </select>
              </div>
            </div>

            {if $system['tips_enabled']}
              <div class="divider"></div>
              <div class="form-table-row">
                <div class="avatar">
                  {include file='__svg_icons.tpl' icon="tip" class="main-icon" width="40px" height="40px"}
                </div>
                <div>
                  <div class="form-label h6">{__("Tips Enabled")}</div>
                  <div class="form-text d-none d-sm-block">{__("Allow the send tips button on your page")}</div>
                </div>
                <div class="text-end">
                  <label class="switch" for="page_tips_enabled">
                    <input type="checkbox" name="page_tips_enabled" id="page_tips_enabled" {if $data['page_tips_enabled']}checked{/if}>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
            {/if}

            <!-- success -->
            <div class="alert alert-success mb0 mt20 x-hidden"></div>
            <!-- success -->

            <!-- error -->
            <div class="alert alert-danger mb0 mt20 x-hidden"></div>
            <!-- error -->

            <div class="card-footer-fake text-end">
              <button type="button" class="btn btn-danger js_admin-deleter" data-handle="page_posts" data-id="{$data['page_id']}" data-delete-message="{__("Are you sure you want to delete all posts?")}">
                <i class="fa fa-trash-alt mr5"></i>{__("Delete Posts")}
              </button>
              <button type="button" class="btn btn-danger js_admin-deleter" data-handle="page" data-id="{$data['page_id']}" data-redirect="{$system['system_url']}/{$control_panel['url']}/pages">
                <i class="fa fa-trash-alt mr5"></i>{__("Delete Page")}
              </button>
              <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
            </div>
          </form>
        </div>
        <!-- settings tab -->

        <!-- info tab -->
        <div class="tab-pane" id="page_info">
          <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_page&edit=info&id={$data['page_id']}">
            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="company">{__("Company")}</label>
                <input type="text" class="form-control" name="company" id="company" value="{$data['page_company']}">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label" for="phone">{__("Phone")}</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{$data['page_phone']}">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="website">{__("Website")}</label>
                <input type="text" class="form-control" name="website" id="website" value="{$data['page_website']}">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label" for="location">{__("Location")}</label>
                <input type="text" class="form-control js_geocomplete" name="location" id="location" value="{$data['page_location']}">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="country">{__("Country")}</label>
              <select class="form-select" name="country">
                <option value="none">{__("Select Country")}</option>
                {foreach $data['countries'] as $country}
                  <option value="{$country['country_id']}" {if $data['page_country'] == $country['country_id']}selected{/if}>{$country['country_name']}</option>
                {/foreach}
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="description">{__("About")}</label>
              <textarea class="form-control" name="description" id="description">{$data['page_description']}</textarea>
            </div>

            <!-- custom fields -->
            {if $custom_fields['basic']}
              {include file='__custom_fields.tpl' _custom_fields=$custom_fields['basic'] _registration=false}
            {/if}
            <!-- custom fields -->

            <!-- success -->
            <div class="alert alert-success x-hidden"></div>
            <!-- success -->

            <!-- error -->
            <div class="alert alert-danger x-hidden"></div>
            <!-- error -->

            <div class="card-footer-fake text-end">
              <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
            </div>
          </form>
        </div>
        <!-- info tab -->

        <!-- monetization tab -->
        <div class="tab-pane" id="page_monetization">
          {if $data['can_monetize_content']}
            <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_page&edit=monetization&id={$data['page_id']}">
              <div class="form-table-row">
                <div class="avatar">
                  {include file='__svg_icons.tpl' icon="monetization" class="main-icon" width="40px" height="40px"}
                </div>
                <div>
                  <div class="form-label h6">{__("Content Monetization")}</div>
                  <div class="form-text d-none d-sm-block">{__("Enable or disable monetization for your content")}</div>
                </div>
                <div class="text-end">
                  <label class="switch" for="page_monetization_enabled">
                    <input type="checkbox" name="page_monetization_enabled" id="page_monetization_enabled" {if $data['page_monetization_enabled']}checked{/if}>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>

              <div class="row form-group">
                <label class="col-md-3 form-label">
                  {__("Payment Plans")}
                </label>
                <div class="col-md-9">
                  <div class="payment-plans">
                    {foreach $monetization_plans as $plan}
                      <div class="payment-plan">
                        <div class="text-xxlg">{__($plan['title'])}</div>
                        <div class="text-xlg">{print_money($plan['price'])} / {if $plan['period_num'] != '1'}{$plan['period_num']}{/if} {__($plan['period']|ucfirst)}</div>
                        {if {$plan['custom_description']}}
                          <div>{$plan['custom_description']}</div>
                        {/if}
                        <div class="mt10">
                          <span class="text-link mr10 js_monetization-deleter" data-id="{$plan['plan_id']}">
                            <i class="fa fa-trash-alt mr5"></i>{__("Delete")}
                          </span>
                          |
                          <span data-toggle="modal" data-url="monetization/controller.php?do=edit&id={$plan['plan_id']}" class="text-link ml10">
                            <i class="fa fa-pen mr5"></i>{__("Edit")}
                          </span>
                        </div>
                      </div>
                    {/foreach}
                    <div data-toggle="modal" data-url="monetization/controller.php?do=add&node_id={$data['page_id']}&node_type=page" class="payment-plan new">{__("Add new plan")} </div>
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
                <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
              </div>
            </form>
          {else}
            <div class="alert alert-danger">
              <div class="icon">
                <i class="fa fa-minus-circle fa-2x"></i>
              </div>
              <div class="text pt5">
                {__("This page super admin is not eligible for monetization")}
              </div>
            </div>
          {/if}
        </div>
        <!-- monetization tab -->
      </div>
      <!-- tabs content -->
    </div>

  {elseif $sub_view == "categories"}

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover js_treegrid">
          <thead>
            <tr>
              <th>{__("Title")}</th>
              <th>{__("Description")}</th>
              <th>{__("Order")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
            {if $rows}
              {foreach $rows as $row}
                {include file='__categories.recursive_rows.tpl' _url="pages" _handle="page_category"}
              {/foreach}
            {else}
              <tr>
                <td colspan="5" class="text-center">
                  {__("No data to show")}
                </td>
              </tr>
            {/if}
          </tbody>
        </table>
      </div>
    </div>

  {elseif $sub_view == "add_category"}

    <form class="js_ajax-forms" data-url="admin/pages.php?do=add_category">
      <div class="card-body">
        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Name")}
          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_name">
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Description")}
          </label>
          <div class="col-md-9">
            <textarea class="form-control" name="category_description" rows="3"></textarea>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Parent Category")}
          </label>
          <div class="col-md-9">
            <select class="form-select" name="category_parent_id">
              <option value="0">{__("Set as a Partent Category")}</option>
              {foreach $categories as $category}
                {include file='__categories.recursive_options.tpl'}
              {/foreach}
            </select>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Order")}
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
        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
      </div>
    </form>

  {elseif $sub_view == "edit_category"}

    <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_category&id={$data['category_id']}">
      <div class="card-body">
        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Name")}
          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_name" value="{$data['category_name']}">
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Description")}
          </label>
          <div class="col-md-9">
            <textarea class="form-control" name="category_description" rows="3">{$data['category_description']}</textarea>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Parent Category")}
          </label>
          <div class="col-md-9">
            <select class="form-select" name="category_parent_id">
              <option value="0">{__("Set as a Partent Category")}</option>
              {foreach $data["categories"] as $category}
                {include file='__categories.recursive_options.tpl' data_category=$data['category_parent_id']}
              {/foreach}
            </select>
          </div>
        </div>

        <div class="row form-group">
          <label class="col-md-3 form-label">
            {__("Order")}
          </label>
          <div class="col-md-9">
            <input class="form-control" name="category_order" value="{$data['category_order']}">
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
        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
      </div>
    </form>

  {elseif $sub_view == "business_types"}

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
            {if $business_types}
              {foreach $business_types as $type}
                <tr>
                  <td class="text-center">
                    <i class="{$type.type_icon}" style="color: {$type.type_color}; font-size: 24px;"></i>
                  </td>
                  <td>
                    <div>
                      <strong>{$type.type_name}</strong>
                      <br><small class="text-muted">{$type.type_name_en}</small>
                    </div>
                    {if $type.type_description}
                      <small class="text-muted d-block mt5">{$type.type_description|truncate:100}</small>
                    {/if}
                  </td>
                  <td>
                    <code>{$type.type_slug}</code>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-success fs-6">{$type.pages_count}</span>
                    {if $type.pages_count > 0}
                      <br><a href="{$system['system_url']}/{$control_panel['url']}/pages?business_type={$type.business_type_id}" class="btn btn-xs btn-outline-info mt5">
                        Xem pages
                      </a>
                    {/if}
                  </td>
                  <td class="text-center">
                    <span class="badge bg-info fs-6">{$type.features_count}</span>
                    <br><button class="btn btn-xs btn-outline-primary mt5" data-toggle="modal" data-url="#manage-features" data-id="{$type.business_type_id}">
                      Quản lý
                    </button>
                  </td>
                  <td class="text-center">
                    {if $type.is_active == '1'}
                      <span class="badge bg-success">Hoạt động</span>
                    {else}
                      <span class="badge bg-secondary">Tạm dừng</span>
                    {/if}
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="{$system['system_url']}/{$control_panel['url']}/pages/edit_business_type/{$type.business_type_id}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Chỉnh sửa">
                        <i class="fa fa-edit"></i>
                      </a>
                      <button class="btn btn-sm btn-outline-info" onclick="manage_features({$type.business_type_id})" data-bs-toggle="tooltip" title="Tính năng">
                        <i class="fa fa-cogs"></i>
                      </button>
                      {if $type.pages_count == 0}
                        <button class="btn btn-sm btn-outline-danger js_admin-deleter" data-handle="business-type" data-id="{$type.business_type_id}" data-bs-toggle="tooltip" title="Xóa">
                          <i class="fa fa-trash"></i>
                        </button>
                      {/if}
                    </div>
                  </td>
                </tr>
              {/foreach}
            {else}
              <tr>
                <td colspan="7" class="text-center">
                  <div class="py-4">
                    <i class="fa fa-store fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có loại hình kinh doanh nào</h5>
                    <p class="text-muted">Bắt đầu bằng cách thêm loại hình kinh doanh đầu tiên</p>
                    <a href="{$system['system_url']}/{$control_panel['url']}/pages/add_business_type" class="btn btn-primary">
                      <i class="fa fa-plus mr5"></i>Thêm loại hình kinh doanh
                    </a>
                  </div>
                </td>
              </tr>
            {/if}
          </tbody>
        </table>
      </div>
    </div>

  {elseif $sub_view == "add_business_type"}

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

  {elseif $sub_view == "edit_business_type"}

    <div class="card-body">
      <form class="js_ajax-forms" data-url="admin/pages.php?do=edit_business_type&id={$data['business_type_id']}">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tên loại hình (Tiếng Việt)</label>
              <input type="text" class="form-control" name="type_name" required value="{$data['type_name']}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Tên loại hình (Tiếng Anh)</label>
              <input type="text" class="form-control" name="type_name_en" required value="{$data['type_name_en']}">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Slug</label>
              <input type="text" class="form-control" name="type_slug" required value="{$data['type_slug']}">
              <small class="form-text text-muted">Định danh thân thiện với URL</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Icon</label>
              <input type="text" class="form-control" name="type_icon" value="{$data['type_icon']}">
              <small class="form-text text-muted">Class icon FontAwesome</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Màu sắc</label>
              <input type="color" class="form-control" name="type_color" value="{$data['type_color']}">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="type_description" rows="3">{$data['type_description']}</textarea>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Thứ tự hiển thị</label>
              <input type="number" class="form-control" name="display_order" value="{$data['display_order']}" min="1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label">Trạng thái</label>
              <select class="form-select" name="is_active">
                <option value="1" {if $data['is_active'] == '1'}selected{/if}>Hoạt động</option>
                <option value="0" {if $data['is_active'] == '0'}selected{/if}>Tạm dừng</option>
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

  {/if}

</div>