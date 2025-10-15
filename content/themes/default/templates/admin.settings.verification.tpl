<div class="card">
  <div class="card-header with-icon">
    <i class="fa fa-shield-alt mr10"></i>{__("Gray Verification Settings")}
    <div class="float-end">
      <small class="text-muted">Configure automatic gray badge verification criteria</small>
    </div>
  </div>
  
  <form class="js_ajax-forms" data-url="admin/settings.php?edit=gray_verification">
    <div class="card-body">
      
      {* Enable/Disable Gray Verification *}
      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-toggle-on fa-2x text-success"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Enable Gray Verification")}</div>
          <div class="form-text d-none d-sm-block">{__("Allow automatic gray badge verification for pages")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_enabled">
            <input type="checkbox" name="gray_verification_enabled" id="gray_verification_enabled" {if $system['gray_verification_enabled']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="divider dashed"></div>

      {* Basic Criteria Section *}
      <div class="form-group">
        <label class="form-label h6 mb-3">
          <i class="fa fa-chart-line mr5"></i>{__("Minimum Requirements")}
        </label>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-label">{__("Minimum Likes")}</label>
        <div class="col-md-9">
          <div class="input-group">
            <input type="number" class="form-control" name="gray_verification_min_likes" value="{$system['gray_verification_min_likes']}" min="0" max="10000">
            <span class="input-group-text">likes</span>
          </div>
          <div class="form-text">{__("Minimum number of page likes required for gray verification")}</div>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-label">{__("Minimum Posts")}</label>
        <div class="col-md-9">
          <div class="input-group">
            <input type="number" class="form-control" name="gray_verification_min_posts" value="{$system['gray_verification_min_posts']}" min="0" max="1000">
            <span class="input-group-text">posts</span>
          </div>
          <div class="form-text">{__("Minimum number of posts required on the page")}</div>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-md-3 form-label">{__("Active Days")}</label>
        <div class="col-md-9">
          <div class="input-group">
            <input type="number" class="form-control" name="gray_verification_min_active_days" value="{$system['gray_verification_min_active_days']}" min="1" max="365">
            <span class="input-group-text">days</span>
          </div>
          <div class="form-text">{__("Page must be active for this many days before eligible")}</div>
        </div>
      </div>

      <div class="divider dashed"></div>

      {* Required Information Section *}
      <div class="form-group">
        <label class="form-label h6 mb-3">
          <i class="fa fa-info-circle mr5"></i>{__("Required Information")}
        </label>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-building fa-lg text-primary"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Business Information")}</div>
          <div class="form-text d-none d-sm-block">{__("Require company name and phone number")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_require_business_info">
            <input type="checkbox" name="gray_verification_require_business_info" id="gray_verification_require_business_info" {if $system['gray_verification_require_business_info']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-image fa-lg text-primary"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Cover Photo")}</div>
          <div class="form-text d-none d-sm-block">{__("Require page to have a cover photo")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_require_cover_photo">
            <input type="checkbox" name="gray_verification_require_cover_photo" id="gray_verification_require_cover_photo" {if $system['gray_verification_require_cover_photo']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-align-left fa-lg text-primary"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Description")}</div>
          <div class="form-text d-none d-sm-block">{__("Require page to have a description")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_require_description">
            <input type="checkbox" name="gray_verification_require_description" id="gray_verification_require_description" {if $system['gray_verification_require_description']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-globe fa-lg text-info"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Website URL")}</div>
          <div class="form-text d-none d-sm-block">{__("Require page to have a website URL")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_require_website">
            <input type="checkbox" name="gray_verification_require_website" id="gray_verification_require_website" {if $system['gray_verification_require_website']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-map-marker-alt fa-lg text-info"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Location")}</div>
          <div class="form-text d-none d-sm-block">{__("Require page to have a location")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_require_location">
            <input type="checkbox" name="gray_verification_require_location" id="gray_verification_require_location" {if $system['gray_verification_require_location']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="divider dashed"></div>

      {* Approval Process Section *}
      <div class="form-group">
        <label class="form-label h6 mb-3">
          <i class="fa fa-cogs mr5"></i>{__("Approval Process")}
        </label>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-magic fa-lg text-success"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Auto Approval")}</div>
          <div class="form-text d-none d-sm-block">{__("Automatically grant gray verification when criteria are met")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_auto_approve">
            <input type="checkbox" name="gray_verification_auto_approve" id="gray_verification_auto_approve" {if $system['gray_verification_auto_approve']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-user-check fa-lg text-warning"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Manual Review")}</div>
          <div class="form-text d-none d-sm-block">{__("Require admin approval even when criteria are met")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_manual_review">
            <input type="checkbox" name="gray_verification_manual_review" id="gray_verification_manual_review" {if $system['gray_verification_manual_review']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="divider dashed"></div>

      {* Notification Settings *}
      <div class="form-group">
        <label class="form-label h6 mb-3">
          <i class="fa fa-bell mr5"></i>{__("Notification Settings")}
        </label>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-user-shield fa-lg text-info"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Notify Admins")}</div>
          <div class="form-text d-none d-sm-block">{__("Send notifications to admins for new gray verification requests")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_notify_admins">
            <input type="checkbox" name="gray_verification_notify_admins" id="gray_verification_notify_admins" {if $system['gray_verification_notify_admins']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

      <div class="form-table-row">
        <div class="avatar">
          <i class="fa fa-users fa-lg text-info"></i>
        </div>
        <div>
          <div class="form-label h6">{__("Notify Users")}</div>
          <div class="form-text d-none d-sm-block">{__("Send notifications to page owners about verification status")}</div>
        </div>
        <div class="text-end">
          <label class="switch" for="gray_verification_notify_users">
            <input type="checkbox" name="gray_verification_notify_users" id="gray_verification_notify_users" {if $system['gray_verification_notify_users']}checked{/if}>
            <span class="slider round"></span>
          </label>
        </div>
      </div>

    </div>
    <!-- card-body -->

    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <button type="button" class="btn btn-info" onclick="testGrayVerificationCriteria()">
            <i class="fa fa-flask mr5"></i>{__("Test Criteria")}
          </button>
          <button type="button" class="btn btn-warning" onclick="processAutoApprovals()">
            <i class="fa fa-play mr5"></i>{__("Process Auto Approvals")}
          </button>
        </div>
        <div class="col-md-6 text-end">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save mr5"></i>{__("Save Changes")}
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

{* Verification Statistics Card *}
<div class="card mt-3">
  <div class="card-header with-icon">
    <i class="fa fa-chart-bar mr10"></i>{__("Verification Statistics")}
  </div>
  <div class="card-body">
    <div class="row text-center">
      <div class="col-md-3">
        <div class="stat-panel">
          <div class="stat-cell">
            <i class="fa fa-pages fa-2x text-secondary mb-2"></i>
            <br>
            <span class="h4 text-secondary" id="unverified-count">-</span>
            <br>
            <span class="text-muted">{__("Unverified Pages")}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-panel">
          <div class="stat-cell">
            <i class="fa fa-shield-alt fa-2x text-muted mb-2"></i>
            <br>
            <span class="h4 text-muted" id="gray-count">-</span>
            <br>
            <span class="text-muted">{__("Gray Verified")}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-panel">
          <div class="stat-cell">
            <i class="fa fa-certificate fa-2x text-info mb-2"></i>
            <br>
            <span class="h4 text-info" id="blue-count">-</span>
            <br>
            <span class="text-muted">{__("Blue Verified")}</span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-panel">
          <div class="stat-cell">
            <i class="fa fa-clock fa-2x text-warning mb-2"></i>
            <br>
            <span class="h4 text-warning" id="pending-count">-</span>
            <br>
            <span class="text-muted">{__("Pending Requests")}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Load verification statistics
function loadVerificationStats() {
  $.post('admin/verification.php', {action: 'get_stats'}, function(data) {
    if (data.success) {
      $('#unverified-count').text(data.stats.unverified_pages || 0);
      $('#gray-count').text(data.stats.gray_verified_pages || 0);
      $('#blue-count').text(data.stats.blue_verified_pages || 0);
      $('#pending-count').text((data.stats.pending_gray || 0) + (data.stats.pending_blue || 0) + (data.stats.pending_upgrades || 0));
    }
  }, 'json');
}

// Test criteria against existing pages
function testGrayVerificationCriteria() {
  if (confirm('{__("This will test current criteria against existing unverified pages. Continue?")}')) {
    $.post('admin/verification.php', {action: 'test_criteria'}, function(data) {
      if (data.success) {
        alert('{__("Test Results")}: ' + data.message);
      } else {
        alert('{__("Error")}: ' + data.message);
      }
    }, 'json');
  }
}

// Process auto approvals manually
function processAutoApprovals() {
  if (confirm('{__("This will process auto-approvals for eligible pages. Continue?")}')) {
    $.post('admin/verification.php', {action: 'process_auto_approvals'}, function(data) {
      if (data.success) {
        alert('{__("Auto Approval Results")}: ' + data.message);
        loadVerificationStats();
      } else {
        alert('{__("Error")}: ' + data.message);
      }
    }, 'json');
  }
}

// Load stats on page load
$(document).ready(function() {
  loadVerificationStats();
  setInterval(loadVerificationStats, 30000); // Refresh every 30 seconds
});
</script>
