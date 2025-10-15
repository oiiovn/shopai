{include file='_head.tpl'}

<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fa fa-eye mr-2"></i>
                        Xem Bằng Chứng Đánh Giá
                    </h4>
                </div>
                <div class="card-body">
                    {if $task}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6><i class="fa fa-map-marker-alt mr-1"></i> Thông tin nhiệm vụ:</h6>
                                    <p class="mb-1"><strong>Tên địa điểm:</strong> {$task.place_name}</p>
                                    <p class="mb-1"><strong>Địa chỉ:</strong> {$task.place_address}</p>
                                    <p class="mb-1"><strong>Phần thưởng:</strong> <span class="text-success font-weight-bold">{number_format($task.reward_amount)} VND</span></p>
                                    <p class="mb-0"><strong>Trạng thái:</strong> 
                                        {if $task.status == 'completed'}
                                            <span class="badge badge-warning">Đang chờ xác minh</span>
                                        {elseif $task.status == 'verified'}
                                            <span class="badge badge-success">Đã xác minh</span>
                                        {elseif $task.status == 'failed'}
                                            <span class="badge badge-danger">Xác minh thất bại</span>
                                        {else}
                                            <span class="badge badge-secondary">{$task.status}</span>
                                        {/if}
                                    </p>
                                </div>
                                
                                <div class="form-group">
                                    <label><i class="fa fa-link mr-1"></i> Link đánh giá:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{$proof_data.review_link}" readonly>
                                        <div class="input-group-append">
                                            <a href="{$proof_data.review_link}" target="_blank" class="btn btn-outline-primary">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                {if $task.verification_notes}
                                    <div class="form-group">
                                        <label><i class="fa fa-comment mr-1"></i> Ghi chú xác minh:</label>
                                        <div class="alert alert-info">
                                            {$task.verification_notes}
                                        </div>
                                    </div>
                                {/if}
                                
                                {if $task.gpt_response}
                                    <div class="form-group">
                                        <label><i class="fa fa-robot mr-1"></i> Kết quả AI phân tích:</label>
                                        <div class="alert alert-light">
                                            <pre class="mb-0" style="white-space: pre-wrap; font-size: 0.9rem;">{$task.gpt_response}</pre>
                                        </div>
                                    </div>
                                {/if}
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-image mr-1"></i> Hình ảnh bằng chứng:</label>
                                    <div class="text-center">
                                        {if $proof_data.image_path && file_exists($proof_data.image_path)}
                                            <img src="{$system['system_url']}/{$proof_data.image_path}" 
                                                 class="img-fluid rounded border" 
                                                 alt="Proof Image"
                                                 style="max-height: 400px;">
                                        {else}
                                            <div class="alert alert-warning">
                                                <i class="fa fa-exclamation-triangle mr-1"></i>
                                                Hình ảnh không tìm thấy hoặc đã bị xóa
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="fa fa-history mr-1"></i> Lịch sử nhiệm vụ</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline">
                                            {if $task.assigned_at}
                                                <div class="timeline-item">
                                                    <div class="timeline-marker bg-info"></div>
                                                    <div class="timeline-content">
                                                        <h6 class="timeline-title">Nhận nhiệm vụ</h6>
                                                        <p class="timeline-text">{$task.assigned_at|date_format:"%d/%m/%Y %H:%M"}</p>
                                                    </div>
                                                </div>
                                            {/if}
                                            
                                            {if $task.completed_at}
                                                <div class="timeline-item">
                                                    <div class="timeline-marker bg-warning"></div>
                                                    <div class="timeline-content">
                                                        <h6 class="timeline-title">Gửi bằng chứng</h6>
                                                        <p class="timeline-text">{$task.completed_at|date_format:"%d/%m/%Y %H:%M"}</p>
                                                    </div>
                                                </div>
                                            {/if}
                                            
                                            {if $task.verified_at}
                                                <div class="timeline-item">
                                                    <div class="timeline-marker {if $task.status == 'verified'}bg-success{else}bg-danger{/if}"></div>
                                                    <div class="timeline-content">
                                                        <h6 class="timeline-title">
                                                            {if $task.status == 'verified'}Xác minh thành công{else}Xác minh thất bại{/if}
                                                        </h6>
                                                        <p class="timeline-text">{$task.verified_at|date_format:"%d/%m/%Y %H:%M"}</p>
                                                        {if $task.verified_by}
                                                            <small class="text-muted">Bởi: Admin #{task.verified_by}</small>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{$system['system_url']}/google-maps-reviews/my-reviews" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-2"></i>
                                Quay Lại Danh Sách
                            </a>
                        </div>
                    {else}
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle mr-1"></i>
                            Không tìm thấy nhiệm vụ hoặc bạn không có quyền xem bằng chứng này.
                        </div>
                        <div class="text-center">
                            <a href="{$system['system_url']}/google-maps-reviews/my-reviews" class="btn btn-primary">
                                <i class="fa fa-arrow-left mr-2"></i>
                                Quay Lại Danh Sách
                            </a>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: 600;
    color: #495057;
}

.timeline-text {
    margin-bottom: 0;
    color: #6c757d;
}
</style>

{include file='_footer.tpl'}
