<!-- review task card -->
<div class="post review-task-card" data-id="{$task.id}">
  <div class="post-body">
    
    <!-- task header -->
    <div class="post-header">
      <div class="post-avatar">
        <div class="post-avatar-picture" style="background-image:url('{$system['system_url']}/content/themes/default/images/google-maps-icon.png');">
        </div>
      </div>
      <div class="post-meta">
        <div class="post-author">
          <i class="fa fa-map-marker-alt mr5"></i>
          {__("Nhiệm vụ đánh giá Google Maps")}
        </div>
        <div class="post-time">
          <span class="js_moment" data-time="{$task.created_at}">{$task.created_at}</span>
        </div>
      </div>
    </div>
    <!-- task header -->

    <!-- task content -->
    <div class="post-text">
      <h5 class="mb5">{$task.place_name}</h5>
      <p class="text-muted mb5">
        <i class="fa fa-map-marker-alt mr5"></i>
        {$task.place_address}
      </p>
      <p class="text-warning mb5">
        <i class="fa fa-clock mr5"></i>
        Hết hạn: {$task.expires_at|date_format:"%d/%m/%Y %H:%M"}
      </p>
      
      {if $task.place_url}
        <p class="mb5">
          <a href="{$task.place_url}" target="_blank" class="text-primary">
            <i class="fa fa-external-link-alt mr5"></i>
            {__("Xem trên Google Maps")}
          </a>
        </p>
      {/if}
    </div>
    <!-- task content -->

    <!-- task info -->
    <div class="post-media">
      <div class="row">
        <div class="col-6">
          <div class="text-center p5 bg-light rounded">
            <div class="h5 text-success mb0">
              {number_format($task.reward_amount, 0, ',', '.')} VND
            </div>
            <small class="text-muted">{__("Phần thưởng")}</small>
          </div>
        </div>
        <div class="col-6">
          <div class="text-center p5 bg-light rounded">
            <div class="text-muted">
              {$task.expires_at|date_format:"%d/%m/%Y"}
            </div>
            <small class="text-muted">{__("Hết hạn")}</small>
          </div>
        </div>
      </div>
    </div>
    <!-- task info -->

    <!-- task actions -->
    <div class="post-actions">
      <button class="action-btn text-primary" onclick="assignTask({$task.id})">
        <i class="fa fa-hand-paper mr5"></i>
        {__("Nhận nhiệm vụ")}
      </button>
      <button class="action-btn text-muted" onclick="viewTaskDetails({$task.id})">
        <i class="fa fa-info-circle mr5"></i>
        {__("Chi tiết")}
      </button>
    </div>
    <!-- task actions -->

  </div>
</div>
<!-- review task card -->

<style>
.review-task-card {
    height: 200px;
    overflow: hidden;
}

.review-task-card .post-header {
    padding: 8px 16px 0;
    margin-bottom: 5px;
}

.review-task-card .post-text {
    padding: 0 16px;
    margin-bottom: 8px;
}

.review-task-card .post-text h5 {
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-card .post-text p {
    font-size: 12px;
    line-height: 1.2;
    margin: 0 0 4px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.review-task-card .post-text .text-warning {
    font-size: 11px;
    color: #f39c12;
    font-weight: 600;
}

.review-task-card .post-media {
    margin: 8px 16px;
}

.review-task-card .post-media .p5 {
    padding: 4px !important;
}

.review-task-card .post-media .h5 {
    font-size: 13px;
    font-weight: 700;
}

.review-task-card .post-actions {
    padding: 4px 16px;
    margin-top: 8px;
}

.review-task-card .action-btn {
    font-size: 11px;
    padding: 4px 8px;
}
</style>

<script>
function assignTask(taskId) {
    if (confirm('Bạn có chắc chắn muốn nhận nhiệm vụ này?')) {
        $.ajax({
            url: '{$system['system_url']}/google-maps-reviews.php',
            type: 'POST',
            data: {
                action: 'assign_task',
                sub_request_id: taskId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Nhận nhiệm vụ thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.error);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        });
    }
}

function viewTaskDetails(taskId) {
    // TODO: Implement task details modal
    alert('Chi tiết nhiệm vụ #' + taskId);
}
</script>
