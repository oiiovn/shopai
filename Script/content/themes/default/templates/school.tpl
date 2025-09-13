{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} sg-offcanvas">
  <div class="row">

    <!-- side panel -->
    <div class="col-12 d-block d-md-none sg-offcanvas-sidebar mt20">
      {include file='_sidebar.tpl'}
    </div>
    <!-- side panel -->

    <!-- content panel -->
    <div class="col-12 sg-offcanvas-mainbar">
      <!-- profile-header -->
      <div class="profile-header">
        <!-- profile-cover -->
        <div class="profile-cover-wrapper">
          {if $school['school_cover_id']}
            <!-- full-cover -->
            <img class="js_position-cover-full x-hidden" src="{$school['school_cover_full']}">
            <!-- full-cover -->

            <!-- cropped-cover -->
            <img class="js_position-cover-cropped js_lightbox" data-init-position="{$school['school_cover_position']}" data-id="{$school['school_cover_id']}" data-image="{$school['school_cover_full']}" data-context="album" src="{$school['school_cover']}" alt="{$school['school_title']}">
            <!-- cropped-cover -->
          {/if}

          {if $school['i_admin']}
            <!-- buttons -->
            <div class="profile-cover-buttons">
              <div class="profile-cover-change">
                <i class="fa fa-camera" data-bs-toggle="dropdown" data-display="static"></i>
                <div class="dropdown-menu action-dropdown-menu">
                  <!-- upload -->
                  <div class="dropdown-item pointer js_x-uploader" data-handle="cover-school" data-id="{$school['school_id']}">
                    <div class="action">
                      {include file='__svg_icons.tpl' icon="camera" class="main-icon mr10" width="20px" height="20px"}
                      {__("Upload Photo")}
                    </div>
                    <div class="action-desc">{__("Upload a new photo")}</div>
                  </div>
                  <!-- upload -->
                  <!-- select -->
                  <div class="dropdown-item pointer" data-toggle="modal" data-url="users/photos.php?filter=cover&type=school&id={$school['school_id']}">
                    <div class="action">
                      {include file='__svg_icons.tpl' icon="photos" class="main-icon mr10" width="20px" height="20px"}
                      {__("Select Photo")}
                    </div>
                    <div class="action-desc">{__("Choose from your photos")}</div>
                  </div>
                  <!-- select -->
                  <!-- reposition -->
                  {if $school['school_cover']}
                    <div class="dropdown-item pointer js_position-cover" data-id="{$school['school_id']}">
                      <div class="action">
                        {include file='__svg_icons.tpl' icon="move" class="main-icon mr10" width="20px" height="20px"}
                        {__("Reposition")}
                      </div>
                      <div class="action-desc">{__("Reposition your cover photo")}</div>
                    </div>
                    <!-- reposition -->
                    <!-- delete -->
                    <div class="dropdown-item pointer js_delete-cover" data-id="{$school['school_id']}">
                      <div class="action">
                        {include file='__svg_icons.tpl' icon="delete" class="main-icon mr10" width="20px" height="20px"}
                        {__("Delete Photo")}
                      </div>
                      <div class="action-desc">{__("Remove your cover photo")}</div>
                    </div>
                    <!-- delete -->
                  {/if}
                </div>
              </div>
            </div>
            <!-- buttons -->
          {/if}
        </div>
        <!-- profile-cover -->

        <!-- profile-info -->
        <div class="profile-info-wrapper">
          <div class="profile-avatar">
            <img class="js_position-picture-full x-hidden" src="{$school['school_picture_full']}">
            <img class="js_position-picture-cropped js_lightbox" data-init-position="{$school['school_picture_position']}" data-id="{$school['school_picture_id']}" data-image="{$school['school_picture_full']}" data-context="album" src="{$school['school_picture']}" alt="{$school['school_title']}">
            {if $school['i_admin']}
              <div class="profile-avatar-change">
                <i class="fa fa-camera" data-bs-toggle="dropdown" data-display="static"></i>
                <div class="dropdown-menu action-dropdown-menu">
                  <!-- upload -->
                  <div class="dropdown-item pointer js_x-uploader" data-handle="picture-school" data-id="{$school['school_id']}">
                    <div class="action">
                      {include file='__svg_icons.tpl' icon="camera" class="main-icon mr10" width="20px" height="20px"}
                      {__("Upload Photo")}
                    </div>
                    <div class="action-desc">{__("Upload a new photo")}</div>
                  </div>
                  <!-- upload -->
                  <!-- select -->
                  <div class="dropdown-item pointer" data-toggle="modal" data-url="users/photos.php?filter=picture&type=school&id={$school['school_id']}">
                    <div class="action">
                      {include file='__svg_icons.tpl' icon="photos" class="main-icon mr10" width="20px" height="20px"}
                      {__("Select Photo")}
                    </div>
                    <div class="action-desc">{__("Choose from your photos")}</div>
                  </div>
                  <!-- select -->
                  <!-- reposition -->
                  {if $school['school_picture']}
                    <div class="dropdown-item pointer js_position-picture" data-id="{$school['school_id']}">
                      <div class="action">
                        {include file='__svg_icons.tpl' icon="move" class="main-icon mr10" width="20px" height="20px"}
                        {__("Reposition")}
                      </div>
                      <div class="action-desc">{__("Reposition your profile picture")}</div>
                    </div>
                    <!-- reposition -->
                    <!-- delete -->
                    <div class="dropdown-item pointer js_delete-picture" data-id="{$school['school_id']}">
                      <div class="action">
                        {include file='__svg_icons.tpl' icon="delete" class="main-icon mr10" width="20px" height="20px"}
                        {__("Delete Photo")}
                      </div>
                      <div class="action-desc">{__("Remove your profile picture")}</div>
                    </div>
                    <!-- delete -->
                  {/if}
                </div>
              </div>
            {/if}
          </div>

          <div class="profile-info">
            <div class="profile-name">
              <h2>{$school['school_title']}</h2>
              {if $school['school_category_name'] != 'N/A'}
                <div class="profile-category">
                  <i class="fa fa-graduation-cap mr5"></i>{__($school['school_category_name'])}
                </div>
              {/if}
            </div>

            <div class="profile-meta">
              <div class="profile-meta-item">
                <div class="profile-meta-icon">
                  <i class="fa fa-users"></i>
                </div>
                <div class="profile-meta-info">
                  <div class="profile-meta-number">{$school['school_members']}</div>
                  <div class="profile-meta-text">{__("Members")}</div>
                </div>
              </div>
              <div class="profile-meta-item">
                <div class="profile-meta-icon">
                  <i class="fa fa-file-text"></i>
                </div>
                <div class="profile-meta-info">
                  <div class="profile-meta-number">{$school['posts_count']}</div>
                  <div class="profile-meta-text">{__("Posts")}</div>
                </div>
              </div>
              <div class="profile-meta-item">
                <div class="profile-meta-icon">
                  <i class="fa fa-image"></i>
                </div>
                <div class="profile-meta-info">
                  <div class="profile-meta-number">{$school['photos_count']}</div>
                  <div class="profile-meta-text">{__("Photos")}</div>
                </div>
              </div>
              {if $system['videos_enabled']}
                <div class="profile-meta-item">
                  <div class="profile-meta-icon">
                    <i class="fa fa-video"></i>
                  </div>
                  <div class="profile-meta-info">
                    <div class="profile-meta-number">{$school['videos_count']}</div>
                    <div class="profile-meta-text">{__("Videos")}</div>
                  </div>
                </div>
              {/if}
            </div>

            <div class="profile-actions">
              {if $school['i_joined'] == "approved"}
                <button type="button" class="btn btn-success btn-delete js_leave-school" data-id="{$school['school_id']}" data-privacy="{$school['school_privacy']}">
                  <i class="fa fa-check mr5"></i>{__("Joined")}
                </button>
              {elseif $school['i_joined'] == "pending"}
                <button type="button" class="btn btn-warning js_leave-school" data-id="{$school['school_id']}" data-privacy="{$school['school_privacy']}">
                  <i class="fa fa-clock mr5"></i>{__("Pending")}
                </button>
              {else}
                <button type="button" class="btn btn-success js_join-school" data-id="{$school['school_id']}" data-privacy="{$school['school_privacy']}">
                  <i class="fa fa-user-plus mr5"></i>{__("Join School")}
                </button>
              {/if}
              {if $school['i_admin']}
                <a href="{$system['system_url']}/schools/{$school['school_name']}/settings" class="btn btn-primary">
                  <i class="fa fa-cog mr5"></i>{__("Settings")}
                </a>
              {/if}
            </div>
          </div>
        </div>
        <!-- profile-info -->
      </div>
      <!-- profile-header -->

      <!-- profile-content -->
      <div class="profile-content">
        <div class="row">
          <!-- left panel -->
          <div class="col-lg-3">
            <!-- profile-tabs -->
            <div class="profile-tabs">
              <ul>
                <li {if $view == ""}class="active"{/if}>
                  <a href="{$system['system_url']}/schools/{$school['school_name']}">
                    <i class="fa fa-newspaper mr5"></i>{__("Timeline")}
                  </a>
                </li>
                <li {if $view == "members"}class="active"{/if}>
                  <a href="{$system['system_url']}/schools/{$school['school_name']}/members">
                    <i class="fa fa-users mr5"></i>{__("Members")}
                    <span class="badge badge-pill badge-light">{$school['school_members']}</span>
                  </a>
                </li>
                <li {if $view == "photos"}class="active"{/if}>
                  <a href="{$system['system_url']}/schools/{$school['school_name']}/photos">
                    <i class="fa fa-image mr5"></i>{__("Photos")}
                    <span class="badge badge-pill badge-light">{$school['photos_count']}</span>
                  </a>
                </li>
                {if $system['videos_enabled']}
                  <li {if $view == "videos"}class="active"{/if}>
                    <a href="{$system['system_url']}/schools/{$school['school_name']}/videos">
                      <i class="fa fa-video mr5"></i>{__("Videos")}
                      <span class="badge badge-pill badge-light">{$school['videos_count']}</span>
                    </a>
                  </li>
                {/if}
              </ul>
            </div>
            <!-- profile-tabs -->

            <!-- profile-sidebar -->
            <div class="profile-sidebar">
              <!-- about -->
              <div class="card">
                <div class="card-header bg-transparent">
                  <strong>{__("About")}</strong>
                </div>
                <div class="card-body">
                  <div class="about-bio">
                    <div class="js_readmore" data-char="120">
                      {$school['school_description']|nl2br}
                    </div>
                  </div>
                </div>
              </div>
              <!-- about -->

              <!-- custom fields -->
              {if $custom_fields}
                <div class="card">
                  <div class="card-header bg-transparent">
                    <strong>{__("Info")}</strong>
                  </div>
                  <div class="card-body">
                    {foreach $custom_fields as $custom_field}
                      <div class="about-item">
                        <strong>{$custom_field['label']}:</strong>
                        <span>{$custom_field['value']}</span>
                      </div>
                    {/foreach}
                  </div>
                </div>
              {/if}
              <!-- custom fields -->
            </div>
            <!-- profile-sidebar -->
          </div>
          <!-- left panel -->

          <!-- right panel -->
          <div class="col-lg-9">
            {if $view == ""}
              <!-- timeline -->
              {include file='_posts.tpl'}
              <!-- timeline -->
            {elseif $view == "members"}
              <!-- members -->
              <div class="card">
                <div class="card-header bg-transparent">
                  <div class="float-end">
                    <small class="text-muted">{$school['school_members']} {__("Members")}</small>
                  </div>
                  <strong>{__("Members")}</strong>
                </div>
                <div class="card-body">
                  {if $members}
                    <div class="row">
                      {foreach $members as $_member}
                        <div class="col-md-6 col-lg-4">
                          <div class="ui-box">
                            <div class="img">
                              <a href="{$system['system_url']}/{$_member['user_name']}">
                                <img src="{$_member['user_picture']}" alt="{$_member['user_firstname']} {$_member['user_lastname']}">
                              </a>
                            </div>
                            <div class="mt10">
                              <a class="h6" href="{$system['system_url']}/{$_member['user_name']}">{$_member['user_firstname']} {$_member['user_lastname']}</a>
                              <div class="text-muted">{$_member['status']|ucfirst}</div>
                            </div>
                          </div>
                        </div>
                      {/foreach}
                    </div>
                  {else}
                    <div class="text-center text-muted">
                      <div class="big-icon">
                        <i class="fa fa-users"></i>
                      </div>
                      <div class="inner">
                        <span class="inner-title">{__("No members to show")}</span>
                      </div>
                    </div>
                  {/if}
                </div>
              </div>
              <!-- members -->
            {elseif $view == "photos"}
              <!-- photos -->
              {include file='_photos.tpl'}
              <!-- photos -->
            {elseif $view == "videos"}
              <!-- videos -->
              {include file='_videos.tpl'}
              <!-- videos -->
            {/if}
          </div>
          <!-- right panel -->
        </div>
      </div>
      <!-- profile-content -->
    </div>
    <!-- content panel -->
  </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
