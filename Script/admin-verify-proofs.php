<?php
/**
 * Admin Page - Verify Google Maps Review Proofs
 * Trang admin để xác minh bằng chứng đánh giá
 */

// Include system files
require_once('bootloader.php');

// Check if user is admin
if (!$user->_logged_in || !$user->_is_admin) {
    http_response_code(403);
    echo "Access denied. Admin required.";
    exit;
}

// Handle AJAX verification request
if (isset($_POST['verify_proof'])) {
    $sub_request_id = (int)$_POST['sub_request_id'];
    
    // Call GPT verification
    $verify_url = $system['system_url'] . '/gpt-verify-proof.php';
    
    $post_data = ['sub_request_id' => $sub_request_id];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $verify_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    header('Content-Type: application/json');
    echo $response;
    exit;
}

// Get pending proofs for verification
$pending_proofs = array();

try {
    $proofs_query = $db->query("
        SELECT gmsr.*, gmr.place_name, gmr.place_address, gmr.reward_amount,
               u.user_name, u.user_firstname, u.user_lastname
        FROM google_maps_review_sub_requests gmsr
        LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
        LEFT JOIN users u ON gmsr.assigned_user_id = u.user_id
        WHERE gmsr.status = 'completed'
        ORDER BY gmsr.completed_at DESC
    ");
    
    if ($proofs_query->num_rows > 0) {
        while ($proof = $proofs_query->fetch_assoc()) {
            if (!empty($proof['proof_data'])) {
                $proof['proof_data_decoded'] = json_decode($proof['proof_data'], true);
            }
            $pending_proofs[] = $proof;
        }
    }
    
} catch (Exception $e) {
    error_log("Error getting pending proofs: " . $e->getMessage());
}

page_header("Admin - Verify Proofs");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fa fa-shield-alt mr-2"></i>
                        Xác Minh Bằng Chứng Đánh Giá Google Maps
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (empty($pending_proofs)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle mr-1"></i>
                            Không có bằng chứng nào cần xác minh.
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($pending_proofs as $proof): ?>
                                <div class="col-lg-6 mb-4">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-white">
                                            <h6 class="mb-0">
                                                <i class="fa fa-clock mr-1"></i>
                                                Chờ xác minh #<?php echo $proof['sub_request_id']; ?>
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6><i class="fa fa-map-marker-alt mr-1"></i> Thông tin nhiệm vụ:</h6>
                                                    <p class="mb-1"><strong>Địa điểm:</strong> <?php echo htmlspecialchars($proof['place_name']); ?></p>
                                                    <p class="mb-1"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($proof['place_address']); ?></p>
                                                    <p class="mb-1"><strong>Phần thưởng:</strong> <span class="text-success"><?php echo number_format($proof['reward_amount']); ?> VND</span></p>
                                                    
                                                    <h6 class="mt-3"><i class="fa fa-user mr-1"></i> Người thực hiện:</h6>
                                                    <p class="mb-1"><?php echo htmlspecialchars($proof['user_firstname'] . ' ' . $proof['user_lastname']); ?></p>
                                                    <p class="mb-0"><small class="text-muted">@<?php echo htmlspecialchars($proof['user_name']); ?></small></p>
                                                    
                                                    <h6 class="mt-3"><i class="fa fa-link mr-1"></i> Link đánh giá:</h6>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($proof['proof_data_decoded']['review_link']); ?>" readonly>
                                                        <div class="input-group-append">
                                                            <a href="<?php echo htmlspecialchars($proof['proof_data_decoded']['review_link']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="fa fa-external-link-alt"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <button class="btn btn-success btn-sm" onclick="verifyProof(<?php echo $proof['sub_request_id']; ?>)">
                                                            <i class="fa fa-robot mr-1"></i>
                                                            Xác minh bằng GPT
                                                        </button>
                                                        <button class="btn btn-info btn-sm ml-2" onclick="viewFullProof(<?php echo $proof['sub_request_id']; ?>)">
                                                            <i class="fa fa-eye mr-1"></i>
                                                            Xem chi tiết
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <h6><i class="fa fa-image mr-1"></i> Hình ảnh bằng chứng:</h6>
                                                    <?php if (!empty($proof['proof_data_decoded']['image_path']) && file_exists($proof['proof_data_decoded']['image_path'])): ?>
                                                        <img src="<?php echo $system['system_url']; ?>/<?php echo htmlspecialchars($proof['proof_data_decoded']['image_path']); ?>" 
                                                             class="img-fluid rounded border" 
                                                             alt="Proof Image"
                                                             style="max-height: 200px;">
                                                    <?php else: ?>
                                                        <div class="alert alert-warning">
                                                            <i class="fa fa-exclamation-triangle mr-1"></i>
                                                            Hình ảnh không tìm thấy
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            <i class="fa fa-clock mr-1"></i>
                                                            Gửi lúc: <?php echo date('d/m/Y H:i', strtotime($proof['completed_at'])); ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function verifyProof(subRequestId) {
    if (!confirm('Bạn có chắc muốn xác minh bằng chứng này bằng GPT?')) {
        return;
    }
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i>Đang xác minh...';
    
    fetch('<?php echo $system['system_url']; ?>/admin-verify-proofs.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'verify_proof=1&sub_request_id=' + subRequestId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Xác minh thành công!\n\nKết quả: ' + JSON.stringify(data.verification_result, null, 2));
            location.reload();
        } else {
            alert('Lỗi xác minh: ' + data.error);
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xác minh');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function viewFullProof(subRequestId) {
    window.open('<?php echo $system['system_url']; ?>/google-maps-reviews?action=view-proof&id=' + subRequestId, '_blank');
}
</script>

<?php
page_footer();
?>
