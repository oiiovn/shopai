{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="{if $system['fluid_design']}container-fluid{else}container{/if} mt20">
  <div class="row">

    <!-- google-maps-reviews sidebar (desktop only) -->
    <div class="col-md-4 col-lg-3 sg-offcanvas-sidebar js_sticky-sidebar shop-ai-sidebar d-none d-md-block">
      <div class="card main-side-nav-card">
        <div class="card-body with-nav">
          <ul class="main-side-nav">
            <li {if $view == 'dashboard'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/dashboard">
                <i class="fa fa-tachometer-alt main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Bảng điều khiển
              </a>
            </li>
            <li {if $view == 'my-requests'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/my-requests">
                <i class="fa fa-list main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Yêu cầu của tôi
              </a>
            </li>
            <li {if $view == 'available-tasks'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/available-tasks">
                <i class="fa fa-tasks main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Nhiệm vụ có sẵn
              </a>
            </li>
            <li {if $view == 'my-reviews'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/my-reviews">
                <i class="fa fa-star main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Đánh giá của tôi
              </a>
            </li>
            <li {if $view == 'create-request'}class="active" {/if}>
              <a href="{$system['system_url']}/google-maps-reviews/create-request">
                <i class="fa fa-plus main-icon mr-2" style="width: 24px; height: 24px; font-size: 18px;"></i>
                Tạo yêu cầu
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- google-maps-reviews sidebar -->

    <!-- content panel -->
    <div class="col-12 col-md-8 col-lg-9 sg-offcanvas-mainbar shop-ai-mainbar">

      <!-- tabs (mobile only) -->
      <div class="content-tabs rounded-sm shadow-sm clearfix d-block d-md-none">
        <ul>
          <li {if $view == 'dashboard'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/dashboard">
              Bảng điều khiển
            </a>
          </li>
          <li {if $view == 'my-requests'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/my-requests">
              Yêu cầu
            </a>
          </li>
          <li {if $view == 'available-tasks'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/available-tasks">
              Nhiệm vụ
            </a>
          </li>
          <li {if $view == 'my-reviews'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/my-reviews">
              Đánh giá
            </a>
          </li>
          <li {if $view == 'create-request'}class="active" {/if}>
            <a href="{$system['system_url']}/google-maps-reviews/create-request">
              Tạo mới
            </a>
          </li>
        </ul>
      </div>
      <!-- tabs -->

      <!-- content -->
      <div class="row">
        <!-- main content -->
        <div class="col-12">
          <div class="card">
            {if $view == 'dashboard'}
              <div class="card-header bg-transparent">
                <strong>Bảng điều khiển</strong>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="card bg-primary text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$user_requests|count}</h4>
                            <p class="mb-0">Yêu cầu của tôi</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-list fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-success text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$user_reviews|count}</h4>
                            <p class="mb-0">Đánh giá của tôi</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-star fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-warning text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$available_tasks|count}</h4>
                            <p class="mb-0">Nhiệm vụ có sẵn</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-tasks fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-info text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h4 class="mb-0">{$user_earnings|number_format:0}</h4>
                            <p class="mb-0">Tổng thu nhập (VND)</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fa fa-money-bill-wave fa-2x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            {/if}

            {if $view == 'my-requests'}
              <div class="card-header bg-transparent">
                <strong>Yêu cầu của tôi</strong>
              </div>
              <div class="card-body">
                {if $user_requests}
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tên địa điểm</th>
                          <th>Mục tiêu đánh giá</th>
                          <th>Đã hoàn thành</th>
                          <th>Số tiền thưởng</th>
                          <th>Tình trạng</th>
                          <th>Đã tạo</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        {foreach $user_requests as $request}
                          <tr>
                            <td>
                              <strong>{$request.place_name}</strong><br>
                              <small class="text-muted">{$request.place_address}</small>
                            </td>
                            <td>{$request.target_reviews}</td>
                            <td>{$request.completed_reviews}</td>
                            <td>{$request.reward_amount|number_format:0} VND</td>
                            <td>
                              <span class="badge badge-{if $request.status == 'active'}success{elseif $request.status == 'completed'}primary{else}secondary{/if}">
                                {if $request.status == 'active'}Kích hoạt{elseif $request.status == 'completed'}Hoàn thành{elseif $request.status == 'cancelled'}Đã hủy{else}Hết hạn{/if}
                              </span>
                            </td>
                            <td>{$request.created_at|date_format:"%d/%m/%Y"}</td>
                            <td>
                              <button class="btn btn-sm btn-info" onclick="viewRequestDetails({$request.request_id})">
                                <i class="fa fa-eye"></i>
                              </button>
                            </td>
                          </tr>
                        {/foreach}
                      </tbody>
                    </table>
                  </div>
                {else}
                  <div class="text-center py-4">
                    <i class="fa fa-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không tìm thấy yêu cầu nào</h5>
                    <p class="text-muted">Tạo yêu cầu đánh giá Google Maps đầu tiên của bạn</p>
                  </div>
                {/if}
              </div>
            {/if}

            {if $view == 'available-tasks'}
              <div class="card-header bg-transparent">
                <strong>Nhiệm vụ có sẵn</strong>
              </div>
              <div class="card-body">
                {if $available_tasks}
                  <div class="row">
                    {foreach $available_tasks as $task}
                      <div class="col-md-6 mb-3">
                        <div class="card">
                          <div class="card-body">
                            <h6 class="card-title">{$task.place_name}</h6>
                            <p class="card-text text-muted">{$task.place_address}</p>
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="badge badge-success">{$task.reward_amount|number_format:0} VND</span>
                              <button class="btn btn-sm btn-primary" onclick="assignTask({$task.sub_request_id})">
                                <i class="fa fa-hand-paper mr5"></i>
                                Nhận nhiệm vụ
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    {/foreach}
                  </div>
                {else}
                  <div class="text-center py-4">
                    <i class="fa fa-tasks fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không có nhiệm vụ nào</h5>
                    <p class="text-muted">Quay lại sau để xem nhiệm vụ đánh giá mới</p>
                  </div>
                {/if}
              </div>
            {/if}

            {if $view == 'my-reviews'}
              <div class="card-header bg-transparent">
                <strong>Đánh giá của tôi</strong>
              </div>
              <div class="card-body">
                {if $user_reviews}
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tên địa điểm</th>
                          <th>Đánh giá</th>
                          <th>Nội dung đánh giá</th>
                          <th>Tình trạng</th>
                          <th>Thưởng</th>
                          <th>Đã tạo</th>
                        </tr>
                      </thead>
                      <tbody>
                        {foreach $user_reviews as $review}
                          <tr>
                            <td>{$review.place_name}</td>
                            <td>
                              <div class="rating">
                                {for $i=1 to 5}
                                  <i class="fa fa-star {if $i <= $review.rating}text-warning{else}text-muted{/if}"></i>
                                {/for}
                              </div>
                            </td>
                            <td>{$review.review_text|truncate:50}</td>
                            <td>
                              <span class="badge badge-{if $review.verification_status == 'verified'}success{elseif $review.verification_status == 'rejected'}danger{else}warning{/if}">
                                {if $review.verification_status == 'verified'}Đã xác minh{elseif $review.verification_status == 'rejected'}Bị từ chối{elseif $review.verification_status == 'pending'}Đang chờ{else}Đang tranh chấp{/if}
                              </span>
                            </td>
                            <td>{$review.reward_paid|number_format:0} VND</td>
                            <td>{$review.created_at|date_format:"%d/%m/%Y"}</td>
                          </tr>
                        {/foreach}
                      </tbody>
                    </table>
                  </div>
                {else}
                  <div class="text-center py-4">
                    <i class="fa fa-star fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không tìm thấy đánh giá nào</h5>
                    <p class="text-muted">Bắt đầu nhận nhiệm vụ đánh giá để kiếm tiền</p>
                  </div>
                {/if}
              </div>
            {/if}

            {if $view == 'create-request'}
              <div class="card-header bg-transparent">
                <strong>Tạo yêu cầu đánh giá</strong>
              </div>
              <div class="card-body">
                <form id="createRequestForm">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="google_place_id">Google Place ID</label>
                        <input type="text" class="form-control" id="google_place_id" name="google_place_id" required>
                        <small class="form-text text-muted">Nhập Google Place ID của doanh nghiệp của bạn</small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="place_name">Tên địa điểm</label>
                        <input type="text" class="form-control" id="place_name" name="place_name" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="place_address">Địa chỉ</label>
                    <textarea class="form-control" id="place_address" name="place_address" rows="2" required></textarea>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="reward_amount">Số tiền thưởng (VND)</label>
                        <input type="number" class="form-control" id="reward_amount" name="reward_amount" min="1000" step="1000" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="target_reviews">Mục tiêu đánh giá</label>
                        <input type="number" class="form-control" id="target_reviews" name="target_reviews" min="1" max="100" value="1" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="expires_at">Hết hạn lúc</label>
                        <input type="datetime-local" class="form-control" id="expires_at" name="expires_at" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="place_url">URL địa điểm (Tùy chọn)</label>
                    <input type="url" class="form-control" id="place_url" name="place_url">
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-plus mr5"></i>
                      Tạo yêu cầu
                    </button>
                  </div>
                </form>
              </div>
            {/if}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Handle form submission
  $('#createRequestForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    formData.append('action', 'create_request');
    
    $.ajax({
      url: 'google-maps-reviews.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          alert('Tạo yêu cầu thành công!');
          location.reload();
        } else {
          alert('Lỗi: ' + response.error);
        }
      },
      error: function() {
        alert('Đã xảy ra lỗi. Vui lòng thử lại.');
      }
    });
  });
  
  // Set default expiry time (7 days from now)
  var now = new Date();
  now.setDate(now.getDate() + 7);
  var expiryTime = now.toISOString().slice(0, 16);
  $('#expires_at').val(expiryTime);
});

function assignTask(subRequestId) {
  if (confirm('Bạn có chắc chắn muốn nhận nhiệm vụ này?')) {
    $.ajax({
      url: 'google-maps-reviews.php',
      type: 'POST',
      data: {
        action: 'assign_task',
        sub_request_id: subRequestId
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

function viewRequestDetails(requestId) {
  // Implement view request details
  alert('Xem chi tiết yêu cầu ID: ' + requestId);
}
</script>

{include file='_footer.tpl'}