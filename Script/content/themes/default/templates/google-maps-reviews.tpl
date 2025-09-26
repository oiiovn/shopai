<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3 d-none d-md-block">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt mr10"></i>
                        {__("Google Maps Reviews")}
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="main-side-nav">
                        <li {if $view == 'dashboard'}class="active"{/if}>
                            <a href="{$system['system_url']}/google-maps-reviews/dashboard">
                                <i class="fas fa-tachometer-alt main-icon mr10" style="width: 24px; height: 24px; font-size: 18px;"></i>
                                {__("Dashboard")}
                            </a>
                        </li>
                        <li {if $view == 'my-requests'}class="active"{/if}>
                            <a href="{$system['system_url']}/google-maps-reviews/my-requests">
                                <i class="fas fa-list main-icon mr10" style="width: 24px; height: 24px; font-size: 18px;"></i>
                                {__("My Requests")}
                            </a>
                        </li>
                        <li {if $view == 'available-tasks'}class="active"{/if}>
                            <a href="{$system['system_url']}/google-maps-reviews/available-tasks">
                                <i class="fas fa-tasks main-icon mr10" style="width: 24px; height: 24px; font-size: 18px;"></i>
                                {__("Available Tasks")}
                            </a>
                        </li>
                        <li {if $view == 'my-reviews'}class="active"{/if}>
                            <a href="{$system['system_url']}/google-maps-reviews/my-reviews">
                                <i class="fas fa-star main-icon mr10" style="width: 24px; height: 24px; font-size: 18px;"></i>
                                {__("My Reviews")}
                            </a>
                        </li>
                        <li {if $view == 'create-request'}class="active"{/if}>
                            <a href="{$system['system_url']}/google-maps-reviews/create-request">
                                <i class="fas fa-plus main-icon mr10" style="width: 24px; height: 24px; font-size: 18px;"></i>
                                {__("Create Request")}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-8 col-lg-9">
            <div class="tab-content">
                <!-- Dashboard Tab -->
                <div class="tab-pane {if $view == 'dashboard'}active{/if}" id="dashboard">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tachometer-alt mr10"></i>
                                {__("Dashboard")}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h4 class="mb-0">{$user_requests|count}</h4>
                                                    <p class="mb-0">{__("My Requests")}</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-list fa-2x"></i>
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
                                                    <p class="mb-0">{__("My Reviews")}</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-star fa-2x"></i>
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
                                                    <p class="mb-0">{__("Available Tasks")}</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-tasks fa-2x"></i>
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
                                                    <p class="mb-0">{__("Total Earnings")} (VND)</p>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- My Requests Tab -->
                <div class="tab-pane {if $view == 'my-requests'}active{/if}" id="my-requests">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list mr10"></i>
                                {__("My Requests")}
                            </h5>
                        </div>
                        <div class="card-body">
                            {if $user_requests}
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{__("Place Name")}</th>
                                                <th>{__("Target Reviews")}</th>
                                                <th>{__("Completed")}</th>
                                                <th>{__("Reward Amount")}</th>
                                                <th>{__("Status")}</th>
                                                <th>{__("Created")}</th>
                                                <th>{__("Actions")}</th>
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
                                                            {__($request.status|ucfirst)}
                                                        </span>
                                                    </td>
                                                    <td>{$request.created_at|date_format:"%d/%m/%Y"}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info" onclick="viewRequestDetails({$request.request_id})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            {else}
                                <div class="text-center py-4">
                                    <i class="fas fa-list fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{__("No requests found")}</h5>
                                    <p class="text-muted">{__("Create your first Google Maps review request")}</p>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                
                <!-- Available Tasks Tab -->
                <div class="tab-pane {if $view == 'available-tasks'}active{/if}" id="available-tasks">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tasks mr10"></i>
                                {__("Available Tasks")}
                            </h5>
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
                                                            <i class="fas fa-hand-paper mr5"></i>
                                                            {__("Take Task")}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                            {else}
                                <div class="text-center py-4">
                                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{__("No available tasks")}</h5>
                                    <p class="text-muted">{__("Check back later for new review tasks")}</p>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                
                <!-- My Reviews Tab -->
                <div class="tab-pane {if $view == 'my-reviews'}active{/if}" id="my-reviews">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-star mr10"></i>
                                {__("My Reviews")}
                            </h5>
                        </div>
                        <div class="card-body">
                            {if $user_reviews}
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{__("Place Name")}</th>
                                                <th>{__("Rating")}</th>
                                                <th>{__("Review Text")}</th>
                                                <th>{__("Status")}</th>
                                                <th>{__("Reward")}</th>
                                                <th>{__("Created")}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {foreach $user_reviews as $review}
                                                <tr>
                                                    <td>{$review.place_name}</td>
                                                    <td>
                                                        <div class="rating">
                                                            {for $i=1 to 5}
                                                                <i class="fas fa-star {if $i <= $review.rating}text-warning{else}text-muted{/if}"></i>
                                                            {/for}
                                                        </div>
                                                    </td>
                                                    <td>{$review.review_text|truncate:50}</td>
                                                    <td>
                                                        <span class="badge badge-{if $review.verification_status == 'verified'}success{elseif $review.verification_status == 'rejected'}danger{else}warning{/if}">
                                                            {__($review.verification_status|ucfirst)}
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
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{__("No reviews found")}</h5>
                                    <p class="text-muted">{__("Start taking review tasks to earn money")}</p>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                
                <!-- Create Request Tab -->
                <div class="tab-pane {if $view == 'create-request'}active{/if}" id="create-request">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-plus mr10"></i>
                                {__("Create Review Request")}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="createRequestForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="google_place_id">{__("Google Place ID")}</label>
                                            <input type="text" class="form-control" id="google_place_id" name="google_place_id" required>
                                            <small class="form-text text-muted">{__("Enter the Google Place ID of your business")}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="place_name">{__("Place Name")}</label>
                                            <input type="text" class="form-control" id="place_name" name="place_name" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="place_address">{__("Place Address")}</label>
                                    <textarea class="form-control" id="place_address" name="place_address" rows="2" required></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="reward_amount">{__("Reward Amount")} (VND)</label>
                                            <input type="number" class="form-control" id="reward_amount" name="reward_amount" min="1000" step="1000" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="target_reviews">{__("Target Reviews")}</label>
                                            <input type="number" class="form-control" id="target_reviews" name="target_reviews" min="1" max="100" value="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="expires_at">{__("Expires At")}</label>
                                            <input type="datetime-local" class="form-control" id="expires_at" name="expires_at" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="place_url">{__("Place URL")} ({__("Optional")})</label>
                                    <input type="url" class="form-control" id="place_url" name="place_url">
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus mr5"></i>
                                        {__("Create Request")}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation -->
<div class="d-md-none">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#dashboard" data-toggle="tab">
                        <i class="fas fa-tachometer-alt"></i>
                        <small>{__("Dashboard")}</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#my-requests" data-toggle="tab">
                        <i class="fas fa-list"></i>
                        <small>{__("Requests")}</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#available-tasks" data-toggle="tab">
                        <i class="fas fa-tasks"></i>
                        <small>{__("Tasks")}</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#my-reviews" data-toggle="tab">
                        <i class="fas fa-star"></i>
                        <small>{__("Reviews")}</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#create-request" data-toggle="tab">
                        <i class="fas fa-plus"></i>
                        <small>{__("Create")}</small>
                    </a>
                </li>
            </ul>
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
                    alert('Request created successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
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
    if (confirm('Are you sure you want to take this task?')) {
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
                    alert('Task assigned successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    }
}

function viewRequestDetails(requestId) {
    // Implement view request details
    alert('View request details for ID: ' + requestId);
}
</script>
