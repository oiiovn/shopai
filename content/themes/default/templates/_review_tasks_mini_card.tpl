<!-- review tasks -->
{if $available_tasks}
  <div class="card">
    <div class="card-header bg-transparent border-bottom-0">
      <strong class="text-muted">
        <i class="fa fa-map-marker-alt mr5"></i>
        {__("Nhiệm vụ đánh giá Google Maps")}
      </strong>
    </div>
    <div class="card-body" style="padding: 9px;">
      <div class="review-tasks-horizontal-scroll">
        {foreach $available_tasks as $task}
        <div class="review-task-item" style="height: 120px;">
          <div class="review-task-mini-card-horizontal" style="border: 1px solid #e9ecef; border-radius: 6px; padding: 16px 12px; background: #fff; height: 112px; display: flex; align-items: center; margin: 8px 0;">
            <span class="sponsored-badge">Được tài trợ</span>
            
            <div class="task-info">
              <div class="task-header">
                <div class="task-details">
                  <div class="task-avatar">
                    {if $task.user_picture}
                      <img src="{$system['system_uploads']}/{$task.user_picture}"
                           alt=""
                           width="32"
                           height="32"
                           style="width: 32px; height: 32px; object-fit: cover;"
                           class="rounded-circle">
                    {else}
                      {if $task.user_gender == '1'}
                        <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_profile_male.png"
                             alt=""
                             width="32"
                             height="32"
                             style="width: 32px; height: 32px; object-fit: cover;"
                             class="rounded-circle">
                      {elseif $task.user_gender == '2'}
                        <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_profile_female.png"
                             alt=""
                             width="32"
                             height="32"
                             style="width: 32px; height: 32px; object-fit: cover;"
                             class="rounded-circle">
                      {else}
                        <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/blank_profile.png"
                             alt=""
                             width="32"
                             height="32"
                             style="width: 32px; height: 32px; object-fit: cover;"
                             class="rounded-circle">
                      {/if}
                    {/if}
                  </div>
                  <div>
                    <small class="text-muted">
                      {if $task.user_firstname}
                        {$task.user_firstname}
                      {else}
                        {__("Người dùng")}
                      {/if}
                      {if $task.user_verified}
                        <span class="verified-badge d-inline-flex align-items-center ml-1"
                              data-bs-toggle="tooltip"
                              title='{__("Verified User")}'>
                          {include file='__svg_icons.tpl' icon="verified_badge" width="12px" height="12px"}
                        </span>
                      {/if}
                    </small>
                  </div>
                </div>
              </div>
              
              <div class="task-title">{$task.place_name}</div>
              <div class="task-address">
                <i class="fa fa-map-marker-alt mr5"></i>
                {$task.place_address|truncate:40}
              </div>
              <div class="task-expiry">
                <i class="fa fa-clock mr5"></i>
                Hết hạn: {$task.expires_at|date_format:"%d/%m/%Y"}
              </div>
            </div>
            
            <div class="task-actions">
              <div class="task-reward">
                {number_format($task.reward_amount, 0, ',', '.')} VND
              </div>
              <button class="btn btn-primary" onclick="showTaskModal({$task.sub_request_id}, '{$task.place_name|escape:javascript}', '{$task.place_address|escape:javascript}', '{$task.reward_amount}', '{$task.expires_at|date_format:"%d/%m/%Y"}')">
                {__("Nhận")}
              </button>
            </div>
          </div>
        </div>
        {/foreach}
      </div>
    </div>
  </div>
{/if}

<!-- Task Detail Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">
          <i class="fa fa-map-marker-alt mr5"></i>
          Chi tiết nhiệm vụ đánh giá
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6 class="text-muted mb-3">Thông tin địa điểm</h6>
            <div class="task-detail-info">
              <div class="detail-item mb-3">
                <strong>Tên địa điểm:</strong>
                <div class="mt-1" id="modalPlaceName"></div>
              </div>
              <div class="detail-item mb-3">
                <strong>Địa chỉ:</strong>
                <div class="mt-1" id="modalPlaceAddress"></div>
              </div>
              <div class="detail-item mb-3">
                <strong>Hết hạn:</strong>
                <div class="mt-1 text-warning" id="modalExpiry"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h6 class="text-muted mb-3">Thông tin thưởng</h6>
            <div class="reward-info text-center">
              <div class="reward-amount mb-3">
                <div class="h3 text-success" id="modalRewardAmount"></div>
                <small class="text-muted">Số tiền thưởng</small>
              </div>
              <div class="alert alert-info">
                <i class="fa fa-info-circle mr5"></i>
                <strong>Lưu ý:</strong> Bạn cần đánh giá 5 sao trên Google Maps để nhận thưởng
              </div>
            </div>
          </div>
        </div>
        
        <div class="task-requirements mt-4">
          <h6 class="text-muted mb-3">Yêu cầu thực hiện</h6>
          <div class="requirements-list">
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Tìm kiếm địa điểm trên Google Maps</span>
            </div>
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Đánh giá 5 sao cho địa điểm</span>
            </div>
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Viết đánh giá tích cực (tối thiểu 20 ký tự)</span>
            </div>
            <div class="requirement-item d-flex align-items-center mb-2">
              <i class="fa fa-check-circle text-success mr-3"></i>
              <span>Chụp ảnh màn hình đánh giá để xác minh</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times mr5"></i>
          Hủy
        </button>
        <button type="button" class="btn btn-primary" id="confirmAssignBtn">
          <i class="fa fa-hand-paper mr5"></i>
          Xác nhận nhận nhiệm vụ
        </button>
      </div>
    </div>
  </div>
</div>
<!-- review tasks -->

