<div class="card">
  <div class="card-header with-icon">
    <i class="fa fa-check-circle mr10"></i>{__("Verification")}
    {if $sub_view == ""} &rsaquo; {__("Requests")}{/if}
    {if $sub_view == "users"} &rsaquo; {__("Verified Users")}{/if}
    {if $sub_view == "pages"} &rsaquo; {__("Verified Pages")}{/if}
  </div>

  {if $sub_view == ""}

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover js_dataTable">
          <thead>
            <tr>
              <th>{__("ID")}</th>
              <th>{__("User/Page")}</th>
              <th>{__("Type")}</th>
              <th>{__("Level")}</th>
              <th>{__("Current")}</th>
              <th>{__("Time")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
            {foreach $rows as $row}
              <tr>
                <td>{$row['request_id']}</td>
                <td>
                  {if $row['node_type'] == "user"}
                    <a target="_blank" href="{$system['system_url']}/{$row['user_name']}">
                      <img class="tbl-image" src="{$row['user_picture']}">
                      {if $system['show_usernames_enabled']}{$row['user_name']}{else}{$row['user_firstname']} {$row['user_lastname']}{/if}
                    </a>
                  {elseif $row['node_type'] == "page"}
                    <a target="_blank" href="{$system['system_url']}/pages/{$row['page_name']}">
                      <img class="tbl-image" src="{$row['page_picture']}">
                      {$row['page_title']}
                    </a>
                  {/if}
                </td>
                <td>
                  <span class="badge rounded-pill badge-lg bg-{$row['color']}">{$row['node_type']|capitalize}</span>
                </td>
                <td>
                  {if $row['verification_level'] == 'gray'}
                    <span class="badge rounded-pill badge-lg bg-secondary">
                      <i class="fa fa-shield-alt mr5"></i>Gray Badge
                    </span>
                  {else}
                    <span class="badge rounded-pill badge-lg bg-info">
                      <i class="fa fa-certificate mr5"></i>Blue Badge
                    </span>
                  {/if}
                </td>
                <td>
                  {if $row['current_verification'] == '0'}
                    <span class="badge rounded-pill badge-sm bg-light text-dark">None</span>
                  {elseif $row['current_verification'] == '2'}
                    <span class="badge rounded-pill badge-sm bg-secondary">Gray</span>
                  {elseif $row['current_verification'] == '1'}
                    <span class="badge rounded-pill badge-sm bg-info">Blue</span>
                  {/if}
                </td>
                <td>{$row['time']|date_format:"%e %B %Y"}</td>
                <td>
                  <button data-bs-toggle="tooltip" title='{__("View Verification Documents")}' class="btn btn-sm btn-icon btn-rounded btn-info js_admin-verification-documents" data-photo="{$system['system_uploads']}/{$row['photo']}" data-passport="{$system['system_uploads']}/{$row['passport']}" data-message="{$row['message']}" {if $row['node_type'] == 'page'} data-business-website="{$row['business_website']}" data-business-address="{$row['business_address']}" {/if} data-handle="{$row['node_type']}" data-node-id="{$row['node_id']}" data-request-id="{$row['request_id']}">
                    <i class="fa fa-paperclip"></i>
                  </button>
                  
                  {if $row['node_type'] == 'page'}
                    {* Page verification with level options *}
                    {if $row['verification_level'] == 'gray'}
                      <button data-bs-toggle="tooltip" title='{__("Approve Gray Badge")}' class="btn btn-sm btn-icon btn-rounded btn-secondary js_admin-verify-gray" data-handle="{$row['node_type']}" data-id="{$row['node_id']}" data-level="gray" data-request-id="{$row['request_id']}">
                        <i class="fa fa-shield-alt"></i>
                      </button>
                    {else}
                      <button data-bs-toggle="tooltip" title='{__("Approve Blue Badge")}' class="btn btn-sm btn-icon btn-rounded btn-info js_admin-verify-blue" data-handle="{$row['node_type']}" data-id="{$row['node_id']}" data-level="blue" data-request-id="{$row['request_id']}">
                        <i class="fa fa-certificate"></i>
                      </button>
                    {/if}
                    
                    {* Option to approve different level *}
                    {if $row['verification_level'] == 'blue'}
                      <button data-bs-toggle="tooltip" title='{__("Approve as Gray Badge Instead")}' class="btn btn-sm btn-icon btn-rounded btn-secondary js_admin-verify-gray" data-handle="{$row['node_type']}" data-id="{$row['node_id']}" data-level="gray" data-request-id="{$row['request_id']}">
                        <i class="fa fa-shield-alt"></i>
                      </button>
                    {elseif $row['verification_level'] == 'gray'}
                      <button data-bs-toggle="tooltip" title='{__("Upgrade to Blue Badge")}' class="btn btn-sm btn-icon btn-rounded btn-info js_admin-verify-blue" data-handle="{$row['node_type']}" data-id="{$row['node_id']}" data-level="blue" data-request-id="{$row['request_id']}">
                        <i class="fa fa-certificate"></i>
                      </button>
                    {/if}
                  {else}
                    {* User verification (unchanged) *}
                    <button data-bs-toggle="tooltip" title='{__("Verify")}' class="btn btn-sm btn-icon btn-rounded btn-success js_admin-verify" data-handle="{$row['node_type']}" data-id="{$row['node_id']}">
                      <i class="fa fa-check"></i>
                    </button>
                  {/if}
                  
                  <button data-bs-toggle="tooltip" title='{__("Decline")}' class="btn btn-sm btn-icon btn-rounded btn-danger js_admin-unverify" data-id="{$row['request_id']}">
                    <i class="fa fa-times"></i>
                  </button>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>

  {elseif $sub_view == "users"}

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover js_dataTable">
          <thead>
            <tr>
              <th>{__("ID")}</th>
              <th>{__("Name")}</th>
              <th>{__("Username")}</th>
              <th>{__("Joined")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
            {foreach $rows as $row}
              <tr>
                <td><a href="{$system['system_url']}/{$row['user_name']}" target="_blank">{$row['user_id']}</a></td>
                <td>
                  <a target="_blank" href="{$system['system_url']}/{$row['user_name']}">
                    <img class="tbl-image" src="{$row['user_picture']}">
                    {$row['user_firstname']} {$row['user_lastname']}
                  </a>
                </td>
                <td>
                  <a href="{$system['system_url']}/{$row['user_name']}" target="_blank">
                    {$row['user_name']}
                  </a>
                </td>
                <td>{$row['user_registered']|date_format:"%e %B %Y"}</td>
                <td>
                  <a data-bs-toggle="tooltip" title='{__("Edit")}' href="{$system['system_url']}/{$control_panel['url']}/users/edit/{$row['user_id']}" class="btn btn-sm btn-icon btn-rounded btn-primary">
                    <i class="fa fa-pencil-alt"></i>
                  </a>
                  <button data-bs-toggle="tooltip" title='{__("Delete")}' class="btn btn-sm btn-icon btn-rounded btn-danger js_admin-deleter" data-handle="user" data-id="{$row['user_id']}">
                    <i class="fa fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>

  {elseif $sub_view == "pages"}

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover js_dataTable">
          <thead>
            <tr>
              <th>{__("ID")}</th>
              <th>{__("Page")}</th>
              <th>{__("Likes")}</th>
              <th>{__("Actions")}</th>
            </tr>
          </thead>
          <tbody>
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
                <td>{$row['page_likes']}</td>
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
          </tbody>
        </table>
      </div>
    </div>

  {/if}
</div>