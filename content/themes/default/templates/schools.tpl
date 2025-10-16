{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page header -->
<div class="page-header">
  <img class="floating-img d-none d-md-block" src="{$system['system_url']}/content/themes/{$system['theme']}/images/headers/undraw_community_re_cyrm.svg">
  <div class="circle-2"></div>
  <div class="circle-3"></div>
  <div class="{if $system['fluid_design']}container-fluid{else}container{/if}">
    <h2>{__("Schools")}</h2>
    <p class="text-xlg">{__($system['system_description_schools'])}</p>
    <div class="row mt20">
      <div class="col-sm-9 col-lg-6 mx-sm-auto">
        <form class="js_search-form" data-filter="schools">
          <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder='{__("Search for schools")}'>
            <button type="submit" class="btn btn-light">{__("Search")}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- page header -->

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} sg-offcanvas" style="margin-top: -25px;">

  <div class="position-relative">
    <!-- tabs -->
    <div class="content-tabs rounded-sm shadow-sm clearfix">
      <ul>
        <li {if $view == ""}class="active" {/if}>
          <a href="{$system['system_url']}/schools">{__("Discover")}</a>
        </li>
        {if $user->_logged_in}
          <li {if $view == "joined"}class="active" {/if}>
            <a href="{$system['system_url']}/schools/joined">{__("Joined Schools")}</a>
          </li>
          <li {if $view == "manage"}class="active" {/if}>
            <a href="{$system['system_url']}/schools/manage">{__("My Schools")}</a>
          </li>
        {/if}
      </ul>
      {if $user->_data['can_create_schools']}
        <div class="mt10 float-end">
          <button class="btn btn-md btn-primary d-none d-lg-block" data-toggle="modal" data-url="modules/add.php?type=school">
            <i class="fa fa-plus-circle mr5"></i>{__("Create School")}
          </button>
          <button class="btn btn-sm btn-icon btn-primary d-block d-lg-none" data-toggle="modal" data-url="modules/add.php?type=school">
            <i class="fa fa-plus-circle"></i>
          </button>
        </div>
      {/if}
    </div>
    <!-- tabs -->

    <div class="row">
      <!-- left panel -->
      <div class="col-lg-3">
        <!-- categories -->
        {if $categories}
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="float-end">
                <small class="text-muted">{count($categories)}</small>
              </div>
              <strong>{__("Categories")}</strong>
            </div>
            <div class="card-body">
              <ul class="side-nav">
                {foreach $categories as $category}
                  <li {if $current_category && $current_category['category_id'] == $category['category_id']}class="active"{/if}>
                    <a href="{$system['system_url']}/schools/category/{$category['category_id']}/{$category['category_url']}">
                      <span class="side-nav-icon">
                        <i class="fa fa-graduation-cap"></i>
                      </span>
                      {__($category['category_name'])}
                      <span class="side-nav-counter">{$category['schools_count']}</span>
                    </a>
                  </li>
                {/foreach}
              </ul>
            </div>
          </div>
        {/if}
        <!-- categories -->
      </div>
      <!-- left panel -->

      <!-- right panel -->
      <div class="col-lg-9">
        <!-- schools -->
        {if $schools}
          <div class="row">
            {foreach $schools as $school}
              {assign var="_school" value=$school}
              {include file='__feeds_school.tpl'}
            {/foreach}
          </div>

          <!-- see-more -->
          <div class="text-center">
            <button class="btn btn-light js_see-more" data-get="{$get}">
              <span class="loading {if $schools|count < $system['max_results']}d-none{/if}">
                <span class="spinner-border spinner-border-sm mr5"></span>{__("Loading")}
              </span>
              <span class="text {if $schools|count < $system['max_results']}d-none{/if}">
                <i class="fa fa-arrow-circle-down mr5"></i>{__("Load More")}
              </span>
            </button>
          </div>
          <!-- see-more -->
        {else}
          <!-- no schools -->
          <div class="text-center text-muted">
            <div class="big-icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <div class="inner">
              <span class="inner-title">{__("No schools to show")}</span>
              <div class="inner-details">{__("Be the first to create a school")}</div>
            </div>
          </div>
          <!-- no schools -->
        {/if}
        <!-- schools -->
      </div>
      <!-- right panel -->
    </div>
  </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
