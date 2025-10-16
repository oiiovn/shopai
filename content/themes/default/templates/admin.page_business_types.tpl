<div class="card">
  <div class="card-header with-icon with-nav">
    <!-- panel title -->
    <div class="mb20">
      <i class="fa fa-store mr10"></i>{__("Page Business Types Management")}
    </div>
    <!-- panel title -->

    <!-- panel nav -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link {if $sub_view == "" || $sub_view == "types"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/page_business_types">
          <i class="fa fa-list fa-fw mr5"></i><strong>{__("Business Types")}</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $sub_view == "features"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/page_business_types/features">
          <i class="fa fa-cogs fa-fw mr5"></i><strong>{__("Features")}</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $sub_view == "requests"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/page_business_types/requests">
          <i class="fa fa-clock fa-fw mr5"></i><strong>{__("Pending Requests")}</strong>
          {if $pending_requests_count > 0}
            <span class="badge bg-danger ml5">{$pending_requests_count}</span>
          {/if}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {if $sub_view == "pages"}active{/if}" href="{$system['system_url']}/{$control_panel['url']}/page_business_types/pages">
          <i class="fa fa-users fa-fw mr5"></i><strong>{__("Pages by Type")}</strong>
        </a>
      </li>
    </ul>
    <!-- panel nav -->
  </div>

  {if $sub_view == "" || $sub_view == "types"}
    <!-- Business Types Management -->
    <div class="card-body">
      <div class="row">
        <div class="col-sm-9">
          <h3>{__("Manage Business Types")}</h3>
          <p class="text-muted">{__("Create and manage different business categories for pages")}</p>
        </div>
        <div class="col-sm-3 text-end">
          <button class="btn btn-md btn-primary" data-toggle="modal" data-url="#add-business-type">
            <i class="fa fa-plus mr5"></i>{__("Add New Type")}
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>{__("Icon")}</th>
              <th>{__("Business Type")}</th>
              <th>{__("Slug")}</th>
              <th>{__("Features")}</th>
              <th>{__("Pages")}</th>
              <th>{__("Status")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
            {foreach $business_types as $type}
              <tr>
                <td>
                  <i class="{$type.type_icon}" style="color: {$type.type_color}; font-size: 20px;"></i>
                </td>
                <td>
                  <strong>{$type.type_name}</strong>
                  <br><small class="text-muted">{$type.type_name_en}</small>
                  {if $type.type_description}
                    <br><small class="text-muted">{$type.type_description}</small>
                  {/if}
                </td>
                <td>
                  <code>{$type.type_slug}</code>
                </td>
                <td>
                  <span class="badge bg-info">{$type.features_count} {__("features")}</span>
                </td>
                <td>
                  <span class="badge bg-success">{$type.pages_count} {__("pages")}</span>
                </td>
                <td>
                  {if $type.is_active == '1'}
                    <span class="badge bg-success">{__("Active")}</span>
                  {else}
                    <span class="badge bg-secondary">{__("Inactive")}</span>
                  {/if}
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-url="#edit-business-type" data-id="{$type.business_type_id}">
                    <i class="fa fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-url="#manage-features" data-id="{$type.business_type_id}">
                    <i class="fa fa-cogs"></i>
                  </button>
                  {if $type.pages_count == 0}
                    <button class="btn btn-sm btn-outline-danger js_admin-deleter" data-handle="business-type" data-id="{$type.business_type_id}">
                      <i class="fa fa-trash"></i>
                    </button>
                  {/if}
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>

  {elseif $sub_view == "requests"}
    <!-- Pending Requests -->
    <div class="card-body">
      <div class="row">
        <div class="col-sm-9">
          <h3>{__("Business Type Requests")}</h3>
          <p class="text-muted">{__("Review and approve page business type requests from users")}</p>
        </div>
        <div class="col-sm-3 text-end">
          <div class="btn-group" role="group">
            <button class="btn btn-outline-secondary {if !$filter || $filter == 'all'}active{/if}" 
                    onclick="window.location.href='{$system['system_url']}/{$control_panel['url']}/page_business_types/requests'">
              {__("All")} ({$requests_stats.total})
            </button>
            <button class="btn btn-outline-warning {if $filter == 'pending'}active{/if}"
                    onclick="window.location.href='{$system['system_url']}/{$control_panel['url']}/page_business_types/requests?filter=pending'">
              {__("Pending")} ({$requests_stats.pending})
            </button>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>{__("Page")}</th>
              <th>{__("Current Type")}</th>
              <th>{__("Requested Type")}</th>
              <th>{__("Reason")}</th>
              <th>{__("Documents")}</th>
              <th>{__("Status")}</th>
              <th>{__("Date")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
            {foreach $business_requests as $request}
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{$request.page_picture}" class="rounded-circle mr10" width="32" height="32">
                    <div>
                      <strong>{$request.page_title}</strong>
                      <br><small class="text-muted">@{$request.page_name}</small>
                    </div>
                  </div>
                </td>
                <td>
                  {if $request.current_type_name}
                    <i class="{$request.current_type_icon}" style="color: {$request.current_type_color}"></i>
                    {$request.current_type_name}
                  {else}
                    <span class="text-muted">{__("Unassigned")}</span>
                  {/if}
                </td>
                <td>
                  <i class="{$request.requested_type_icon}" style="color: {$request.requested_type_color}"></i>
                  <strong>{$request.requested_type_name}</strong>
                </td>
                <td>
                  {if $request.request_reason}
                    <small>{$request.request_reason|truncate:100}</small>
                  {else}
                    <span class="text-muted">{__("No reason provided")}</span>
                  {/if}
                </td>
                <td>
                  {if $request.business_documents}
                    <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-url="#view-documents" data-id="{$request.request_id}">
                      <i class="fa fa-file"></i> {__("View")}
                    </button>
                  {else}
                    <span class="text-muted">{__("No documents")}</span>
                  {/if}
                </td>
                <td>
                  {if $request.status == 'pending'}
                    <span class="badge bg-warning">{__("Pending")}</span>
                  {elseif $request.status == 'approved'}
                    <span class="badge bg-success">{__("Approved")}</span>
                  {else}
                    <span class="badge bg-danger">{__("Rejected")}</span>
                  {/if}
                </td>
                <td>
                  <small>{$request.created_at|date_format:"%d/%m/%Y %H:%M"}</small>
                </td>
                <td>
                  {if $request.status == 'pending'}
                    <div class="btn-group" role="group">
                      <button class="btn btn-sm btn-success js_approve-business-type" 
                              data-id="{$request.request_id}" 
                              data-bs-toggle="tooltip" 
                              title="{__('Approve Request')}">
                        <i class="fa fa-check"></i>
                      </button>
                      <button class="btn btn-sm btn-danger js_reject-business-type" 
                              data-id="{$request.request_id}"
                              data-bs-toggle="tooltip"
                              title="{__('Reject Request')}">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  {else}
                    <small class="text-muted">
                      {__("By")} {$request.reviewed_by_name}<br>
                      {$request.reviewed_at|date_format:"%d/%m/%Y"}
                    </small>
                  {/if}
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>

      {if !$business_requests}
        <div class="text-center mt50">
          <i class="fa fa-inbox fa-3x text-muted mb20"></i>
          <h4 class="text-muted">{__("No requests found")}</h4>
          <p class="text-muted">{__("There are no business type requests at the moment")}</p>
        </div>
      {/if}
    </div>

  {elseif $sub_view == "pages"}
    <!-- Pages by Business Type -->
    <div class="card-body">
      <div class="row">
        <div class="col-sm-9">
          <h3>{__("Pages by Business Type")}</h3>
          <p class="text-muted">{__("Overview of all pages categorized by business types")}</p>
        </div>
      </div>

      <div class="row">
        {foreach $business_types as $type}
          <div class="col-lg-6 col-xl-4 mb20">
            <div class="card">
              <div class="card-header" style="background-color: {$type.type_color}; color: white;">
                <div class="d-flex align-items-center">
                  <i class="{$type.type_icon} fa-2x mr15"></i>
                  <div>
                    <h6 class="mb0">{$type.type_name}</h6>
                    <small>{$type.pages_count} {__("pages")}</small>
                  </div>
                </div>
              </div>
              <div class="card-body">
                {if $type.sample_pages}
                  <div class="mb10">
                    {foreach $type.sample_pages as $page}
                      <div class="d-flex align-items-center mb10">
                        <img src="{$page.page_picture}" class="rounded-circle mr10" width="24" height="24">
                        <div class="flex-grow-1">
                          <a href="{$system['system_url']}/pages/{$page.page_name}" class="text-decoration-none">
                            <small><strong>{$page.page_title}</strong></small>
                          </a>
                        </div>
                        <small class="text-muted">{$page.page_likes} {__("likes")}</small>
                      </div>
                    {/foreach}
                    {if $type.pages_count > 3}
                      <small class="text-muted">+ {$type.pages_count - 3} {__("more pages")}</small>
                    {/if}
                  </div>
                {else}
                  <p class="text-muted text-center">{__("No pages in this category yet")}</p>
                {/if}
                
                <div class="text-center">
                  <a href="{$system['system_url']}/{$control_panel['url']}/pages?business_type={$type.business_type_id}" 
                     class="btn btn-sm btn-outline-primary">
                    {__("View All Pages")}
                  </a>
                </div>
              </div>
            </div>
          </div>
        {/foreach}
      </div>
    </div>
  {/if}
</div>

<!-- Add Business Type Modal -->
<div class="modal fade" id="add-business-type" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{__("Add New Business Type")}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form class="js_ajax-forms" data-url="admin/page_business_types.php?do=add">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{__("Type Name (Vietnamese)")}</label>
                <input type="text" class="form-control" name="type_name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{__("Type Name (English)")}</label>
                <input type="text" class="form-control" name="type_name_en" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{__("Slug")}</label>
                <input type="text" class="form-control" name="type_slug" required>
                <small class="form-text text-muted">{__("URL-friendly identifier")}</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{__("Color")}</label>
                <input type="color" class="form-control" name="type_color" value="#007bff">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">{__("Icon")}</label>
            <input type="text" class="form-control" name="type_icon" placeholder="fa-store">
            <small class="form-text text-muted">{__("FontAwesome icon class")}</small>
          </div>

          <div class="form-group">
            <label class="form-label">{__("Description")}</label>
            <textarea class="form-control" name="type_description" rows="3"></textarea>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="approval_required" id="approval_required" checked>
            <label class="form-check-label" for="approval_required">
              {__("Require admin approval for this business type")}
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{__("Cancel")}</button>
          <button type="submit" class="btn btn-primary">{__("Add Business Type")}</button>
        </div>
      </form>
    </div>
  </div>
</div>
