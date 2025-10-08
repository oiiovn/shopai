{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20 sg-offcanvas">
  <div class="row">

    <!-- content panel -->
    <div class="col-12">
      
      <!-- Back button -->
      <div class="mb-3">
        <a href="{$system['system_url']}/google-maps-reviews/my-requests" class="btn btn-secondary">
          <i class="fa fa-arrow-left mr-1"></i>Quay lại danh sách chiến dịch
        </a>
      </div>

      <!-- Campaign Info Card -->
      <div class="card mb-3 shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="fa fa-map-marker-alt mr-2"></i>
            Thông tin chiến dịch
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="text-muted mb-3"><i class="fa fa-info-circle mr-2"></i>Thông tin địa điểm</h6>
              <div class="mb-3">
                <strong>Tên địa điểm:</strong>
                <div class="mt-1">{$campaign.place_name}</div>
              </div>
              <div class="mb-3">
                <strong>Địa chỉ:</strong>
                <div class="mt-1 text-muted">{$campaign.place_address}</div>
              </div>
              {if $campaign.place_url}
                <div class="mb-3">
                  <strong>Link Google Maps:</strong>
                  <div class="mt-1">
                    <a href="{$campaign.place_url}" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="fa fa-external-link-alt mr-1"></i>Xem trên Google Maps
                    </a>
                  </div>
                </div>
              {/if}
            </div>
            <div class="col-md-6">
              <h6 class="text-muted mb-3"><i class="fa fa-chart-line mr-2"></i>Thông tin chiến dịch</h6>
              <div class="mb-2">
                <strong>Mục tiêu:</strong>
                <span class="badge badge-info ml-2">{$campaign.target_reviews} đánh giá</span>
              </div>
              <div class="mb-2">
                <strong>Chi phí mỗi đánh giá:</strong>
                <span class="text-danger ml-2">{$campaign.reward_amount|number_format:0} VND</span>
              </div>
              <div class="mb-2">
                <strong>Tổng chi:</strong>
                <span class="text-danger font-weight-bold ml-2">{$campaign.total_budget|number_format:0} VND</span>
              </div>
              <div class="mb-2">
                <strong>Hết hạn:</strong>
                <span class="text-warning ml-2">{$campaign.expires_at|date_format:"%d/%m/%Y %H:%M"}</span>
              </div>
              <div class="mb-2">
                <strong>Trạng thái:</strong>
                <span class="badge badge-{if $campaign.status == 'active'}success{elseif $campaign.status == 'completed'}primary{else}secondary{/if} ml-2">
                  {if $campaign.status == 'active'}Kích hoạt{elseif $campaign.status == 'completed'}Hoàn thành{elseif $campaign.status == 'cancelled'}Đã hủy{else}Hết hạn{/if}
                </span>
              </div>
              <div class="mb-2">
                <strong>Ngày tạo:</strong>
                <span class="text-muted ml-2">{$campaign.created_at|date_format:"%d/%m/%Y %H:%M"}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sub-requests List -->
      <div class="card shadow-sm">
        <div class="card-header bg-transparent border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <i class="fa fa-tasks mr-2"></i>
              Danh sách nhiệm vụ con
            </h5>
            <span class="badge badge-primary badge-lg" style="font-size: 14px; padding: 8px 15px;">
              {$sub_requests|count}/{$campaign.target_reviews}
            </span>
          </div>
        </div>
        <div class="card-body">
          {if $sub_requests}
            <div class="table-responsive">
              <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                  <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="20%">Người nhận</th>
                    <th width="15%" class="text-center">Số sao</th>
                    <th width="35%">Nội dung đánh giá</th>
                    <th width="15%" class="text-center">Trạng thái</th>
                    <th width="10%" class="text-center">Thông tin</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach $sub_requests as $index => $sub}
                    <tr>
                      <td class="text-center"><strong class="text-primary">{$index + 1}</strong></td>
                      <td>
                        {if $sub.assigned_user_id}
                          <div class="d-flex align-items-center">
                            {if $sub.user_picture}
                              <img src="{$system['system_uploads']}/{$sub.user_picture}" 
                                   alt="" 
                                   class="rounded-circle mr-2" 
                                   style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                            {else}
                              {if $sub.user_gender == '1'}
                                <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_profile_male.png" 
                                     alt="" 
                                     class="rounded-circle mr-2" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                              {elseif $sub.user_gender == '2'}
                                <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_profile_female.png" 
                                     alt="" 
                                     class="rounded-circle mr-2" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                              {else}
                                <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_profile.png" 
                                     alt="" 
                                     class="rounded-circle mr-2" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                              {/if}
                            {/if}
                            <div>
                              <div>
                                <strong>{if $sub.user_firstname}{$sub.user_firstname} {$sub.user_lastname}{else}{$sub.user_name}{/if}</strong>
                                {if $sub.user_verified}
                                  <span class="verified-badge ml-1">
                                    {include file='__svg_icons.tpl' icon="verified_badge" width="14px" height="14px"}
                                  </span>
                                {/if}
                              </div>
                              <small class="text-muted">@{$sub.user_name}</small>
                            </div>
                          </div>
                        {else}
                          <span class="text-muted font-italic">
                            <i class="fa fa-user-slash mr-1"></i>Chưa có người nhận
                          </span>
                        {/if}
                      </td>
                      <td class="text-center">
                        {if $sub.gpt_rating_stars}
                          <div class="text-warning mb-1" style="font-size: 18px;">
                            {for $i=1 to $sub.gpt_rating_stars}
                              <i class="fa fa-star"></i>
                            {/for}
                            {if $sub.gpt_rating_stars < 5}
                              {for $i=$sub.gpt_rating_stars+1 to 5}
                                <i class="far fa-star"></i>
                              {/for}
                            {/if}
                          </div>
                        {else}
                          <span class="text-muted">-</span>
                        {/if}
                      </td>
                      <td>
                        {if $sub.gpt_review_content}
                          <div class="mb-1" style="max-height: 60px; overflow: hidden;">
                            <em>"{$sub.gpt_review_content|truncate:100:"...":true}"</em>
                          </div>
                          {if $sub.review_url}
                            <a href="{$sub.review_url}" target="_blank" class="text-primary small">
                              <i class="fa fa-external-link-alt mr-1"></i>Xem review trên Google
                            </a>
                          {/if}
                        {else}
                          <span class="text-muted font-italic">Chưa có nội dung</span>
                        {/if}
                      </td>
                      <td class="text-center">
                        {if $sub.status == 'available'}
                          <span class="badge badge-warning badge-status" style="background-color: #ffc107; color: #000; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-clock mr-1"></i>CHƯA NHẬN
                          </span>
                        {elseif $sub.status == 'assigned'}
                          <span class="badge badge-info badge-status" style="background-color: #17a2b8; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-hand-paper mr-1"></i>ĐÃ NHẬN
                          </span>
                        {elseif $sub.status == 'completed'}
                          <span class="badge badge-success badge-status" style="background-color: #28a745; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-check-circle mr-1"></i>HOÀN THÀNH
                          </span>
                        {elseif $sub.status == 'verified'}
                          <span class="badge badge-primary badge-status" style="background-color: #007bff; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-shield-alt mr-1"></i>ĐÃ XÁC MINH
                          </span>
                        {else}
                          <span class="badge badge-danger badge-status" style="background-color: #dc3545; color: #fff; font-size: 13px; padding: 8px 14px; font-weight: bold; letter-spacing: 0.5px;">
                            <i class="fa fa-times-circle mr-1"></i>HẾT HỊ̀N
                          </span>
                        {/if}
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary" 
                                onclick='showDetailsModal({$sub.sub_request_id}, "{$sub.user_firstname} {$sub.user_lastname}", "{$sub.gpt_rating_stars}", "{$sub.gpt_review_content|escape:'html'}", "{$sub.assigned_at}", "{$sub.completed_at}", "{$sub.reward_amount}")'
                                title="Xem chi tiết">
                          <i class="fa fa-eye"></i>
                        </button>
                      </td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
            </div>
            
            <!-- Summary Stats -->
            <div class="row mt-4">
              <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      {assign var="available_count" value=0}
                      {foreach $sub_requests as $sub}
                        {if $sub.status == 'available'}{assign var="available_count" value=$available_count+1}{/if}
                      {/foreach}
                      {$available_count}
                    </h3>
                    <p class="mb-0"><i class="fa fa-clock mr-1"></i>Chưa nhận</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="card bg-info text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      {assign var="assigned_count" value=0}
                      {foreach $sub_requests as $sub}
                        {if $sub.status == 'assigned'}{assign var="assigned_count" value=$assigned_count+1}{/if}
                      {/foreach}
                      {$assigned_count}
                    </h3>
                    <p class="mb-0"><i class="fa fa-hand-paper mr-1"></i>Đã nhận</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="card bg-success text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      {assign var="completed_count" value=0}
                      {foreach $sub_requests as $sub}
                        {if $sub.status == 'completed' || $sub.status == 'verified'}{assign var="completed_count" value=$completed_count+1}{/if}
                      {/foreach}
                      {$completed_count}
                    </h3>
                    <p class="mb-0"><i class="fa fa-check-circle mr-1"></i>Hoàn thành</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white shadow-sm">
                  <div class="card-body text-center py-3">
                    <h3 class="mb-1">
                      {assign var="expired_count" value=0}
                      {foreach $sub_requests as $sub}
                        {if $sub.status == 'expired'}{assign var="expired_count" value=$expired_count+1}{/if}
                      {/foreach}
                      {$expired_count}
                    </h3>
                    <p class="mb-0"><i class="fa fa-times-circle mr-1"></i>Hết hạn</p>
                  </div>
                </div>
              </div>
            </div>
            
          {else}
            <div class="text-center py-5">
              <i class="fa fa-tasks fa-4x text-muted mb-3"></i>
              <h5 class="text-muted">Chưa có nhiệm vụ con nào</h5>
              <p class="text-muted">Các nhiệm vụ con sẽ được tạo tự động khi bạn tạo chiến dịch.</p>
            </div>
          {/if}
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">
          <i class="fa fa-info-circle mr-2"></i>Chi tiết đánh giá
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6><i class="fa fa-user mr-2"></i>Người đánh giá</h6>
            <p id="modalUserName" class="text-muted">-</p>
          </div>
          <div class="col-md-6">
            <h6><i class="fa fa-star mr-2"></i>Đánh giá</h6>
            <div id="modalRating" class="text-warning">-</div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h6><i class="fa fa-comment mr-2"></i>Nội dung đánh giá</h6>
            <p id="modalReviewContent" class="text-muted">-</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <h6><i class="fa fa-calendar-alt mr-2"></i>Ngày nhận</h6>
            <p id="modalAssignedDate" class="text-muted">-</p>
          </div>
          <div class="col-md-6">
            <h6><i class="fa fa-check-circle mr-2"></i>Ngày hoàn thành</h6>
            <p id="modalCompletedDate" class="text-muted">-</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times mr-1"></i>Đóng
        </button>
      </div>
    </div>
  </div>
</div>

<script>
function showDetailsModal(subRequestId, userName, rating, reviewContent, assignedDate, completedDate, rewardAmount) {
  try {
    // Set user name
    document.getElementById('modalUserName').textContent = userName || 'Chưa có người nhận';
    
    // Set rating
    var ratingElement = document.getElementById('modalRating');
    if (rating && rating > 0) {
      var stars = '';
      for (var i = 1; i <= 5; i++) {
        if (i <= rating) {
          stars += '<i class="fa fa-star"></i> ';
        } else {
          stars += '<i class="fa fa-star-o"></i> ';
        }
      }
      ratingElement.innerHTML = stars;
    } else {
      ratingElement.textContent = 'Chưa có đánh giá';
    }
    
    // Set review content
    document.getElementById('modalReviewContent').textContent = reviewContent || 'Chưa có nội dung đánh giá';
    
    // Set assigned date
    document.getElementById('modalAssignedDate').textContent = assignedDate || 'Chưa được giao';
    
    // Set completed date
    document.getElementById('modalCompletedDate').textContent = completedDate || 'Chưa hoàn thành';
    
    // Show modal
    var modalElement = document.getElementById('detailsModal');
    if (modalElement) {
      var modal = new bootstrap.Modal(modalElement);
      modal.show();
    }
    
  } catch (e) {
    console.error('❌ Error showing details modal:', e);
    alert('Lỗi hiển thị chi tiết: ' + e.message);
  }
}
</script>

{include file='_footer.tpl'}
