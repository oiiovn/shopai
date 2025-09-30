{include file='_head.tpl'}
{include file='_header.tpl'}

<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">

    <!-- side panel -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar">
      {include file='_sidebar.tpl'}
    </div>
    <!-- side panel -->

    <!-- content panel -->
    <div class="col-md-8 col-lg-9 sg-offcanvas-mainbar">
      <div class="row">
        <!-- center panel -->
        <div class="col-lg-8">

          <!-- announcments -->
          {include file='_announcements.tpl'}
          <!-- announcments -->

          {if $view == ""}

            {if $user->_logged_in}
              <!-- stories -->
              {if $user->_data['can_add_stories'] || ($system['stories_enabled'] && !empty($stories['array']))}
                <div class="card">
                  <div class="card-header bg-transparent border-bottom-0">
                    <strong class="text-muted">{__("Stories")}</strong>
                    {if $has_story}
                      <div class="float-end">
                        <button data-bs-toggle="tooltip" title='{__("Delete Your Story")}' class="btn btn-sm btn-icon btn-rounded btn-danger js_story-deleter">
                          <i class="fa fa-trash-alt"></i>
                        </button>
                      </div>
                    {/if}
                  </div>
                  <div class="card-body pt5 stories-wrapper">
                    <div id="stories" data-json='{htmlspecialchars($stories["json"], ENT_QUOTES, 'UTF-8')}'>
                      {if $user->_data['can_add_stories']}
                        <div class="add-story" data-toggle="modal" data-url="posts/story.php?do=create">
                          <div class="img" style="background-image:url({$user->_data['user_picture']});">
                          </div>
                          <div class="add">
                            {include file='__svg_icons.tpl' icon="add" class="main-icon" width="18px" height="18px"}
                          </div>
                        </div>
                      {/if}
                    </div>
                  </div>
                </div>
              {/if}
              <!-- stories -->

              <!-- publisher -->
              {include file='_publisher.tpl' _handle="me" _node_can_monetize_content=$user->_data['can_monetize_content'] _node_monetization_enabled=$user->_data['user_monetization_enabled'] _node_monetization_plans=$user->_data['user_monetization_plans'] _privacy=true}
              <!-- publisher -->

              <!-- pro users -->
              {if $pro_members}
                <div class="d-block d-lg-none">
                  <div class="card bg-indigo border-0">
                    <div class="card-header ptb20 bg-transparent border-bottom-0">
                      {if $system['packages_enabled'] && !$user->_data['user_subscribed']}
                        <div class="float-end">
                          <small><a class="text-white text-underline" href="{$system['system_url']}/packages">{__("Upgrade")}</a></small>
                        </div>
                      {/if}
                      <h6 class="pb0">
                        {include file='__svg_icons.tpl' icon="pro" class="mr5" width="20px" height="20px" style="fill: #fff;"}
                        {__("Pro Users")}
                      </h6>
                    </div>
                    <div class="card-body pt0 plr5">
                      <div class="pro-box-wrapper {if count($pro_members) > 3}js_slick{else}full-opacity{/if}">
                        {foreach $pro_members as $_member}
                          <a class="user-box text-white" href="{$system['system_url']}/{$_member['user_name']}">
                            <img alt="" src="{$_member['user_picture']}" />
                            <div class="name">
                              {if $system['show_usernames_enabled']}
                                {$_member['user_name']}
                              {else}
                                {$_member['user_firstname']} {$_member['user_lastname']}
                              {/if}
                            </div>
                          </a>
                        {/foreach}
                      </div>
                    </div>
                  </div>
                </div>
              {/if}
              <!-- pro users -->

              <!-- pro pages -->
              {if $promoted_pages}
                <div class="d-block d-lg-none">
                  <div class="card bg-teal border-0">
                    <div class="card-header ptb20 bg-transparent border-bottom-0">
                      {if $system['packages_enabled'] && !$user->_data['user_subscribed']}
                        <div class="float-end">
                          <small><a class="text-white text-underline" href="{$system['system_url']}/packages">{__("Upgrade")}</a></small>
                        </div>
                      {/if}
                      <h6 class="pb0">
                        {include file='__svg_icons.tpl' icon="pro" class="mr5" width="20px" height="20px" style="fill: #fff;"}
                        {__("Pro Pages")}
                      </h6>
                    </div>
                    <div class="card-body pt0 plr5">
                      <div class="pro-box-wrapper {if count($promoted_pages) > 3}js_slick{else}full-opacity{/if}">
                        {foreach $promoted_pages as $_page}
                          <a class="user-box text-white" href="{$system['system_url']}/pages/{$_page['page_name']}">
                            <img alt="{$_page['page_title']}" src="{$_page['page_picture']}" />
                            <div class="name" title="{$_page['page_title']}">
                              {$_page['page_title']}
                            </div>
                          </a>
                        {/foreach}
                      </div>
                    </div>
                  </div>
                </div>
              {/if}
              <!-- pro pages -->
            {/if}

            <!-- boosted post -->
            {if $boosted_post}
              {include file='_boosted_post.tpl' post=$boosted_post}
            {/if}
            <!-- boosted post -->

            <!-- review tasks -->
            {include file='_review_tasks_mini_card.tpl'}
            <!-- review tasks -->

            <!-- posts -->
            {include file='_posts.tpl' _get="newsfeed"}
            <!-- posts -->

          {elseif $view == "popular"}
            <!-- popular posts -->
            {include file='_posts.tpl' _get="popular" _title=__("Popular Posts")}
            <!-- popular posts -->

          {elseif $view == "discover"}
            <!-- discover posts -->
            {include file='_posts.tpl' _get="discover" _title=__("Discover Posts")}
            <!-- discover posts -->

          {elseif $view == "saved"}
            <!-- saved posts -->
            {include file='_posts.tpl' _get="saved" _title=__("Saved Posts")}
            <!-- saved posts -->

          {elseif $view == "memories"}
            <!-- page header -->
            <div class="page-header mini rounded mb10">
              <div class="circle-1"></div>
              <div class="circle-2"></div>
              <div class="inner">
                <h2>{__("Memories")}</h2>
                <p class="text-lg">{__("Enjoy looking back on your memories")}</p>
              </div>
            </div>
            <!-- page header -->

            <!-- memories posts -->
            {include file='_posts.tpl' _get="memories" _title=__("ON THIS DAY") _filter="all"}
            <!-- memories posts -->

          {elseif $view == "articles"}
            <!-- articles posts -->
            {include file='_posts.tpl' _get="posts_profile" _id=$user->_data['user_id'] _filter="article" _title=__("My Articles")}
            <!-- articles posts -->

          {elseif $view == "products"}
            <!-- products posts -->
            {include file='_posts.tpl' _get="posts_profile" _id=$user->_data['user_id'] _filter="product" _title=__("My Products")}
            <!-- products posts -->

          {elseif $view == "funding_requests"}
            <!-- funding posts -->
            {include file='_posts.tpl' _get="posts_profile" _id=$user->_data['user_id'] _filter="funding" _title=__("My Funding Requests")}
            <!-- funding posts -->

          {elseif $view == "boosted_posts"}
            {if $user->_is_admin || $user->_data['user_subscribed']}
              <!-- boosted posts -->
              {include file='_posts.tpl' _get="boosted" _title=__("My Boosted Posts")}
              <!-- boosted posts -->
            {else}
              <!-- upgrade -->
              <div class="alert alert-warning">
                <div class="icon">
                  <i class="fa fa-id-card fa-2x"></i>
                </div>
                <div class="text">
                  <strong>{__("Membership")}</strong><br>
                  {__("Choose the Plan That's Right for You")}, {__("Check the package from")} <a href="{$system['system_url']}/packages">{__("Here")}</a>
                </div>
              </div>
              <div class="text-center">
                <a href="{$system['system_url']}/packages" class="btn btn-primary"><i class="fa fa-rocket mr5"></i>{__("Upgrade to Pro")}</a>
              </div>
              <!-- upgrade -->
            {/if}

          {elseif $view == "boosted_pages"}
            {if $user->_is_admin || $user->_data['user_subscribed']}
              <div class="card">
                <div class="card-header">
                  <strong>{__("My Boosted Pages")}</strong>
                </div>
                <div class="card-body">
                  {if $boosted_pages}
                    <ul>
                      {foreach $boosted_pages as $_page}
                        {include file='__feeds_page.tpl' _tpl="list"}
                      {/foreach}
                    </ul>

                    {if count($boosted_pages) >= $system['max_results_even']}
                      <!-- see-more -->
                      <div class="alert alert-info see-more js_see-more" data-get="boosted_pages">
                        <span>{__("See More")}</span>
                        <div class="loader loader_small x-hidden"></div>
                      </div>
                      <!-- see-more -->
                    {/if}
                  {else}
                    {include file='_no_data.tpl'}
                  {/if}
                </div>
              </div>
            {else}
              <!-- upgrade -->
              <div class="alert alert-warning">
                <div class="icon">
                  <i class="fa fa-id-card fa-2x"></i>
                </div>
                <div class="text">
                  <strong>{__("Membership")}</strong><br>
                  {__("Choose the Plan That's Right for You")}, {__("Check the package from")} <a href="{$system['system_url']}/packages">{__("Here")}</a>
                </div>
              </div>
              <div class="text-center">
                <a href="{$system['system_url']}/packages" class="btn btn-primary"><i class="fa fa-rocket mr5"></i>{__("Upgrade to Pro")}</a>
              </div>
              <!-- upgrade -->
            {/if}

          {elseif $view == "watch"}
            <!-- videos posts -->
            {include file='_posts.tpl' _get="discover" _filter="video" _title=__("Watch")}
            <!-- videos posts -->

          {/if}
        </div>
        <!-- center panel -->

        <!-- right panel -->
        <div class="col-lg-4 js_sticky-sidebar">

          <!-- pro users -->
          {if $pro_members}
            <div class="d-none d-lg-block">
              <div class="card bg-indigo border-0">
                <div class="card-header ptb20 bg-transparent border-bottom-0">
                  {if $system['packages_enabled'] && !$user->_data['user_subscribed']}
                    <div class="float-end">
                      <small><a class="text-white text-underline" href="{$system['system_url']}/packages">{__("Upgrade")}</a></small>
                    </div>
                  {/if}
                  <h6 class="pb0">
                    {include file='__svg_icons.tpl' icon="pro" class="mr5" width="20px" height="20px" style="fill: #fff;"}
                    {__("Pro Users")}
                  </h6>
                </div>
                <div class="card-body pt0 plr5">
                  <div class="pro-box-wrapper {if count($pro_members) > 3}js_slick{else}full-opacity{/if}">
                    {foreach $pro_members as $_member}
                      <a class="user-box text-white" href="{$system['system_url']}/{$_member['user_name']}">
                        <img alt="" src="{$_member['user_picture']}" />
                        <div class="name">
                          {if $system['show_usernames_enabled']}
                            {$_member['user_name']}
                          {else}
                            {$_member['user_firstname']} {$_member['user_lastname']}
                          {/if}
                        </div>
                      </a>
                    {/foreach}
                  </div>
                </div>
              </div>
            </div>
          {/if}
          <!-- pro users -->

          <!-- pro pages -->
          {if $promoted_pages}
            <div class="d-none d-lg-block">
              <div class="card bg-teal border-0">
                <div class="card-header ptb20 bg-transparent border-bottom-0">
                  {if $system['packages_enabled'] && !$user->_data['user_subscribed']}
                    <div class="float-end">
                      <small><a class="text-white text-underline" href="{$system['system_url']}/packages">{__("Upgrade")}</a></small>
                    </div>
                  {/if}
                  <h6 class="pb0">
                    {include file='__svg_icons.tpl' icon="pro" class="mr5" width="20px" height="20px" style="fill: #fff;"}
                    {__("Pro Pages")}
                  </h6>
                </div>
                <div class="card-body pt0 plr5">
                  <div class="pro-box-wrapper {if count($promoted_pages) > 3}js_slick{else}full-opacity{/if}">
                    {foreach $promoted_pages as $_page}
                      <a class="user-box text-white" href="{$system['system_url']}/pages/{$_page['page_name']}">
                        <img alt="{$_page['page_title']}" src="{$_page['page_picture']}" />
                        <div class="name" title="{$_page['page_title']}">
                          {$_page['page_title']}
                        </div>
                      </a>
                    {/foreach}
                  </div>
                </div>
              </div>
            </div>
          {/if}
          <!-- pro pages -->

          <!-- trending -->
          {if $trending_hashtags}
            <div class="card bg-red border-0">
              <div class="card-header pt20 pb10 bg-transparent border-bottom-0">
                <h6 class="mb0">
                  {include file='__svg_icons.tpl' icon="trend" class="mr5" width="20px" height="20px" style="fill: #fff;"}
                  {__("Trending")}
                </h6>
              </div>
              <div class="card-body pt0">
                {foreach $trending_hashtags as $hashtag}
                  <a class="trending-item" href="{$system['system_url']}/search/hashtag/{$hashtag['hashtag']}">
                    <span class="hash">
                      #{$hashtag['hashtag']}
                    </span>
                    <span class="frequency">
                      {$hashtag['frequency']} {__("Posts")}
                    </span>
                  </a>
                {/foreach}
              </div>
            </div>
          {/if}
          <!-- trending -->

          {include file='_ads.tpl'}
          {include file='_ads_campaigns.tpl'}
          {include file='_widget.tpl'}

          <!-- friend suggestions -->
          {if $new_people}
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="{$system['system_url']}/people">{__("See All")}</a></small>
                </div>
                {__("Friend Suggestions")}
              </div>
              <div class="card-body with-list">
                <ul>
                  {foreach $new_people as $_user}
                    {include file='__feeds_user.tpl' _tpl="list" _connection="add"}
                  {/foreach}
                </ul>
              </div>
            </div>
          {/if}
          <!-- friend suggestions -->

          <!-- suggested pages -->
          {if $new_pages}
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="{$system['system_url']}/pages">{__("See All")}</a></small>
                </div>
                {__("Suggested Pages")}
              </div>
              <div class="card-body with-list">
                <ul>
                  {foreach $new_pages as $_page}
                    {include file='__feeds_page.tpl' _tpl="list"}
                  {/foreach}
                </ul>
              </div>
            </div>
          {/if}
          <!-- suggested pages -->

          <!-- suggested groups -->
          {if $new_groups}
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="{$system['system_url']}/groups">{__("See All")}</a></small>
                </div>
                {__("Suggested Groups")}
              </div>
              <div class="card-body with-list">
                <ul>
                  {foreach $new_groups as $_group}
                    {include file='__feeds_group.tpl' _tpl="list"}
                  {/foreach}
                </ul>
              </div>
            </div>
          {/if}
          <!-- suggested groups -->

          <!-- suggested events -->
          {if $new_events}
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="float-end">
                  <small><a href="{$system['system_url']}/events">{__("See All")}</a></small>
                </div>
                {__("Suggested Events")}
              </div>
              <div class="card-body with-list">
                <ul>
                  {foreach $new_events as $_event}
                    {include file='__feeds_event.tpl' _tpl="list" _small=true}
                  {/foreach}
                </ul>
              </div>
            </div>
          {/if}
          <!-- suggested events -->

          <!-- invitation widget -->
          {if $user->_data['can_invite_users']}
            <div class="card">
              <div class="card-body text-center">
                <div class="mb10">
                  {include file='__svg_icons.tpl' icon="invitation" class="main-icon" width="60px" height="60px"}
                </div>
                <a class="btn btn-sm btn-primary rounded-pill" href="{$system['system_url']}/settings/invitations">{__("Invite Your Friends")}</a>
              </div>
            </div>
          {/if}
          <!-- invitation widget -->

          <!-- mini footer -->
          {include file='_footer_mini.tpl'}
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
    padding: 12px;
    background: #fff;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    position: relative;
    min-height: 80px;
    width: 100%;
    box-sizing: border-box;
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
    margin-bottom: 8px;
}

.review-task-mini-card-horizontal .task-details {
    display: flex;
    align-items: center;
    gap: 4px;
}

.review-task-mini-card-horizontal .task-avatar {
    margin-right: 8px;
}

.review-task-mini-card-horizontal .task-avatar img {
    width: 32px;
    height: 32px;
    border: 1px solid #e9ecef;
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
}

.review-task-mini-card-horizontal .badge-warning {
    background-color: #ffc107;
    color: #000;
    font-weight: 600;
    font-size: 9px;
    padding: 2px 6px;
    position: absolute;
    top: 8px;
    right: 8px;
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
    padding: 10px 0;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
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
}

</style>

<script>
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
    
    fetch('{$system['system_url']}/google-maps-reviews.php', {
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
                window.location.href = '{$system['system_url']}/google-maps-reviews/my-reviews';
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
</script>

{include file='_footer.tpl'}