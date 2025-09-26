<!-- review tasks -->
{if $available_tasks}
  <div class="card">
    <div class="card-header bg-transparent border-bottom-0">
      <strong class="text-muted">
        <i class="fa fa-map-marker-alt mr5"></i>
        {__("Nhiệm vụ đánh giá Google Maps")}
      </strong>
    </div>
    <div class="card-body">
      <div class="review-tasks-horizontal-scroll">
        {foreach $available_tasks as $task}
        <div class="review-task-item">
          <div class="review-task-mini-card-horizontal">
            <span class="badge badge-warning">ADS</span>
            
            <div class="task-info">
              <div class="task-header">
                <div class="task-details">
                  <div class="task-avatar">
                    <img src="{$system['system_url']}/content/uploads/{$task.user_picture}"
                         alt=""
                         class="rounded-circle">
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
              <button class="btn btn-primary" onclick="assignTask({$task.sub_request_id})">
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
<!-- review tasks -->
