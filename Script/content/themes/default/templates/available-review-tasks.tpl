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
        <div class="col-lg-12">

          <!-- page header -->
          <div class="page-header mini rounded mb10">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
            <div class="inner">
              <h2>{__("Nhiệm vụ đánh giá có sẵn")}</h2>
              <p class="text-lg">{__("Nhận nhiệm vụ đánh giá Google Maps và kiếm tiền")}</p>
            </div>
          </div>
          <!-- page header -->

          {if $available_tasks}
            <!-- tasks -->
            <div class="row">
              {foreach $available_tasks as $task}
                <div class="col-md-6 col-lg-4 mb20">
                  <div class="card">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">
                        <i class="fa fa-map-marker-alt mr5"></i>
                        {__("Nhiệm vụ đánh giá")}
                      </h6>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">{$task.place_name}</h5>
                      <p class="card-text text-muted">
                        <i class="fa fa-map-marker-alt mr5"></i>
                        {$task.place_address}
                      </p>
                      
                      {if $task.place_url}
                        <p class="card-text">
                          <a href="{$task.place_url}" target="_blank" class="text-primary">
                            <i class="fa fa-external-link-alt mr5"></i>
                            {__("Xem trên Google Maps")}
                          </a>
                        </p>
                      {/if}
                      
                      <div class="row mb-3">
                        <div class="col-6">
                          <small class="text-muted">{__("Phần thưởng")}</small>
                          <div class="h5 text-success mb-0">
                            {number_format($task.reward_amount, 0, ',', '.')} VND
                          </div>
                        </div>
                        <div class="col-6">
                          <small class="text-muted">{__("Hết hạn")}</small>
                          <div class="text-muted">
                            {$task.expires_at|date_format:"%d/%m/%Y %H:%M"}
                          </div>
                        </div>
                      </div>
                      
                      <button class="btn btn-primary btn-block" onclick="assignTask({$task.id})">
                        <i class="fa fa-hand-paper mr5"></i>
                        {__("Nhận nhiệm vụ")}
                      </button>
                    </div>
                  </div>
                </div>
              {/foreach}
            </div>
            <!-- tasks -->
          {else}
            <!-- no data -->
            <div class="card">
              <div class="card-body text-center">
                <div class="empty-state">
                  <div class="empty-state-icon">
                    <i class="fa fa-map-marker-alt"></i>
                  </div>
                  <div class="empty-state-text">
                    <h5>{__("Không có nhiệm vụ nào")}</h5>
                    <p class="text-muted">{__("Hiện tại không có nhiệm vụ đánh giá nào có sẵn")}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- no data -->
          {/if}

        </div>
        <!-- center panel -->
      </div>
    </div>
    <!-- content panel -->

  </div>
</div>

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
</script>

{include file='_footer.tpl'}
