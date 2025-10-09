<?php
/**
 * Cron Job: Xử lý timeout và tạo lại chiến dịch con Google Maps Reviews
 * 
 * Chức năng:
 * 1. Timeout khi assigned: Sau 30 phút vẫn ở trạng thái "assigned" → Chuyển thành "timeout" và tạo chiến dịch con mới
 * 2. Xác minh thất bại: Sau 30 phút từ khi completed mà bị expired (lỗi xác minh) → Tạo chiến dịch con mới và tách chiến dịch cũ
 * 
 * Chạy mỗi 5 phút: (crontab) every 5 minutes
 */

// Disable output buffering
if (ob_get_level()) ob_end_clean();

// Set timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/google_maps_timeout_handler.log');

echo "[" . date('Y-m-d H:i:s') . "] Starting Google Maps Timeout Handler Cron Job\n";

try {
    // Include bootloader
    require_once('bootloader.php');
    
    if (!isset($db)) {
        throw new Exception("Database connection not available");
    }
    
    echo "[" . date('Y-m-d H:i:s') . "] Database connected\n";
    
    // Debug: Check current database and $db object
    echo "DB Object class: " . get_class($db) . "\n";
    
    $db_check = $db->query("SELECT DATABASE() as current_db");
    if ($db_check) {
        $current_db = $db_check->fetch_assoc();
        echo "Current database: {$current_db['current_db']}\n";
    }
    
    // Debug: Check total assigned tasks
    $count_check = $db->query("SELECT COUNT(*) as total FROM google_maps_review_sub_requests WHERE status = 'assigned'");
    if ($count_check) {
        $count_result = $count_check->fetch_assoc();
        echo "Total assigned tasks in DB: {$count_result['total']}\n";
    }
    
    // Test simple assigned query without JOIN
    $simple_test = $db->query("SELECT sub_request_id, place_name FROM google_maps_review_sub_requests WHERE status = 'assigned' LIMIT 2");
    if ($simple_test) {
        echo "Simple test query results:\n";
        while ($row = $simple_test->fetch_assoc()) {
            echo "  - Task #{$row['sub_request_id']}: {$row['place_name']}\n";
        }
    }
    
    // Test with TIMESTAMPDIFF
    $timediff_test = $db->query("SELECT sub_request_id, TIMESTAMPDIFF(MINUTE, assigned_at, NOW()) as diff FROM google_maps_review_sub_requests WHERE status = 'assigned' AND assigned_at IS NOT NULL LIMIT 3");
    if ($timediff_test) {
        echo "TIMESTAMPDIFF test results:\n";
        $test_count = 0;
        while ($row = $timediff_test->fetch_assoc()) {
            $test_count++;
            echo "  - Task #{$row['sub_request_id']}: {$row['diff']} minutes\n";
        }
        echo "  Total fetched: {$test_count}\n";
    } else {
        echo "TIMESTAMPDIFF query failed: " . $db->error . "\n";
    }
    
    // ========================================
    // 1. XỬ LÝ TIMEOUT KHI ĐÃ NHẬN NHIỆM VỤ (ASSIGNED)
    // ========================================
    echo "\n[" . date('Y-m-d H:i:s') . "] Checking assigned tasks timeout...\n";
    
    // Tìm các sub-request đã nhận nhưng quá 30 phút chưa hoàn thành
    // Using simple query first, then check parent separately (workaround for JOIN issue)
    $query_sql = "
        SELECT 
            sub_request_id,
            parent_request_id,
            place_name,
            place_address,
            place_url,
            google_place_id,
            reward_amount,
            expires_at,
            assigned_user_id,
            assigned_at,
            status,
            generated_review_content,
            TIMESTAMPDIFF(MINUTE, assigned_at, CONVERT_TZ(NOW(), '+00:00', '+07:00')) as minutes_since_assigned
        FROM google_maps_review_sub_requests
        WHERE status = 'assigned'
        AND assigned_at IS NOT NULL
        AND parent_request_id IS NOT NULL
        AND TIMESTAMPDIFF(MINUTE, assigned_at, CONVERT_TZ(NOW(), '+00:00', '+07:00')) >= 30
    ";
    
    $timeout_assigned_query = $db->query($query_sql);
    
    if (!$timeout_assigned_query) {
        echo "Query failed: " . $db->error . "\n";
    } else {
        echo "Simple timeout query executed OK\n";
    }
    
    // Fetch and validate each task
    $timeout_tasks = [];
    $initial_fetch_count = 0;
    if ($timeout_assigned_query) {
        while ($row = $timeout_assigned_query->fetch_assoc()) {
            $initial_fetch_count++;
            echo "  Checking task #{$row['sub_request_id']} (parent: #{$row['parent_request_id']}, timeout: {$row['minutes_since_assigned']} min)\n";
            // Check parent campaign status separately
            $parent_check = $db->query("
                SELECT request_id, place_name, place_address, place_url, status, expires_at
                FROM google_maps_review_requests
                WHERE request_id = '{$row['parent_request_id']}'
                AND status = 'active'
                AND expires_at > NOW()
            ");
            
            if ($parent_check && $parent_check->num_rows > 0) {
                $parent = $parent_check->fetch_assoc();
                $row['parent_place_name'] = $parent['place_name'];
                $row['parent_place_address'] = $parent['place_address'];
                $row['parent_place_url'] = $parent['place_url'];
                $row['parent_status'] = $parent['status'];
                $timeout_tasks[] = $row;
            }
        }
    }
    
    echo "Initial fetch count: {$initial_fetch_count}, Valid tasks after parent check: " . count($timeout_tasks) . "\n";
    
    $timeout_assigned_count = count($timeout_tasks);
    echo "Found {$timeout_assigned_count} assigned tasks with timeout\n";
    
    if ($timeout_assigned_count > 0) {
        foreach ($timeout_tasks as $task) {
            echo "\nProcessing timeout assigned task #{$task['sub_request_id']}:\n";
            echo "  - Parent: #{$task['parent_request_id']}\n";
            echo "  - Place: {$task['place_name']}\n";
            echo "  - Assigned to user: {$task['assigned_user_id']}\n";
            echo "  - Minutes since assigned: {$task['minutes_since_assigned']}\n";
            
            // Start transaction
            $db->query("START TRANSACTION");
            
            try {
                // 1. Cập nhật sub-request cũ thành "timeout" và tách khỏi chiến dịch mẹ
                $update_old = $db->query("
                    UPDATE google_maps_review_sub_requests
                    SET 
                        status = 'timeout',
                        verification_notes = 'Không hoàn thành trong 30 phút - Timeout',
                        updated_at = NOW(),
                        parent_request_id = NULL
                    WHERE sub_request_id = '{$task['sub_request_id']}'
                ");
                
                if (!$update_old) {
                    throw new Exception("Failed to update old sub-request to timeout: " . $db->error);
                }
                
                if ($db->affected_rows == 0) {
                    throw new Exception("No rows affected when updating sub-request #{$task['sub_request_id']}");
                }
                
                echo "  ✓ Updated old task to timeout status\n";
                
                // 2. Tạo sub-request mới để thay thế (copy cả generated_review_content)
                $place_name_escaped = $db->real_escape_string($task['place_name']);
                $place_address_escaped = $db->real_escape_string($task['place_address']);
                $review_content_escaped = $task['generated_review_content'] ? $db->real_escape_string($task['generated_review_content']) : null;
                
                $insert_new = $db->query("
                    INSERT INTO google_maps_review_sub_requests (
                        parent_request_id,
                        google_place_id,
                        place_name,
                        place_address,
                        place_url,
                        reward_amount,
                        expires_at,
                        generated_review_content,
                        status,
                        created_at,
                        updated_at
                    ) VALUES (
                        '{$task['parent_request_id']}',
                        " . ($task['google_place_id'] ? "'{$task['google_place_id']}'" : "NULL") . ",
                        '{$place_name_escaped}',
                        '{$place_address_escaped}',
                        " . ($task['place_url'] ? "'{$task['place_url']}'" : "NULL") . ",
                        '{$task['reward_amount']}',
                        '{$task['expires_at']}',
                        " . ($review_content_escaped ? "'{$review_content_escaped}'" : "NULL") . ",
                        'available',
                        NOW(),
                        NOW()
                    )
                ");
                
                if (!$insert_new) {
                    throw new Exception("Failed to create new replacement sub-request");
                }
                
                $new_sub_request_id = $db->insert_id;
                echo "  ✓ Created new replacement task #{$new_sub_request_id}\n";
                
                // Commit transaction
                $db->query("COMMIT");
                echo "  ✓ Transaction committed successfully\n";
                
            } catch (Exception $e) {
                $db->query("ROLLBACK");
                echo "  ✗ Error: {$e->getMessage()}\n";
                error_log("Timeout assigned handler error: {$e->getMessage()}");
            }
        }
    }
    
    // ========================================
    // 2. XỬ LÝ XÁC MINH THẤT BẠI (EXPIRED/FAILED VERIFICATION)
    // ========================================
    echo "\n[" . date('Y-m-d H:i:s') . "] Checking failed verification tasks...\n";
    
    // Tìm các sub-request đã completed nhưng sau 30 phút vẫn chưa verified (hoặc đã bị expired)
    $failed_verification_query = $db->query("
        SELECT 
            sub_request_id,
            parent_request_id,
            place_name,
            place_address,
            place_url,
            google_place_id,
            reward_amount,
            expires_at,
            assigned_user_id,
            completed_at,
            status,
            verification_notes,
            generated_review_content,
            TIMESTAMPDIFF(MINUTE, completed_at, CONVERT_TZ(NOW(), '+00:00', '+07:00')) as minutes_since_completed
        FROM google_maps_review_sub_requests
        WHERE status IN ('completed', 'expired')
        AND completed_at IS NOT NULL
        AND verified_at IS NULL
        AND parent_request_id IS NOT NULL
        AND TIMESTAMPDIFF(MINUTE, completed_at, CONVERT_TZ(NOW(), '+00:00', '+07:00')) >= 30
        AND (
            verification_notes LIKE '%Sử dụng đánh giá của người khác%'
            OR status = 'expired'
        )
    ");
    
    // Fetch and validate
    $failed_tasks = [];
    if ($failed_verification_query) {
        while ($row = $failed_verification_query->fetch_assoc()) {
            // Check parent campaign status separately
            $parent_check = $db->query("
                SELECT request_id, place_name, place_address, place_url, status, expires_at
                FROM google_maps_review_requests
                WHERE request_id = '{$row['parent_request_id']}'
                AND status = 'active'
                AND expires_at > CONVERT_TZ(NOW(), '+00:00', '+07:00')
            ");
            
            if ($parent_check && $parent_check->num_rows > 0) {
                $parent = $parent_check->fetch_assoc();
                $row['parent_place_name'] = $parent['place_name'];
                $row['parent_place_address'] = $parent['place_address'];
                $row['parent_place_url'] = $parent['place_url'];
                $row['parent_status'] = $parent['status'];
                $failed_tasks[] = $row;
            }
        }
    }
    
    $failed_verification_count = count($failed_tasks);
    echo "Found {$failed_verification_count} failed verification tasks\n";
    
    if ($failed_verification_count > 0) {
        foreach ($failed_tasks as $task) {
            echo "\nProcessing failed verification task #{$task['sub_request_id']}:\n";
            echo "  - Parent: #{$task['parent_request_id']}\n";
            echo "  - Place: {$task['place_name']}\n";
            echo "  - Assigned to user: {$task['assigned_user_id']}\n";
            echo "  - Minutes since completed: {$task['minutes_since_completed']}\n";
            echo "  - Verification notes: {$task['verification_notes']}\n";
            
            // Start transaction
            $db->query("START TRANSACTION");
            
            try {
                // 1. Tách sub-request cũ khỏi chiến dịch mẹ và đánh dấu là "verification_failed"
                $update_old = $db->query("
                    UPDATE google_maps_review_sub_requests
                    SET 
                        status = 'verification_failed',
                        verification_notes = CONCAT(IFNULL(verification_notes, ''), ' - Tách khỏi chiến dịch mẹ và tạo nhiệm vụ thay thế'),
                        updated_at = NOW(),
                        parent_request_id = NULL
                    WHERE sub_request_id = '{$task['sub_request_id']}'
                ");
                
                if (!$update_old) {
                    throw new Exception("Failed to update old sub-request to verification_failed: " . $db->error);
                }
                
                if ($db->affected_rows == 0) {
                    throw new Exception("No rows affected when updating sub-request #{$task['sub_request_id']}");
                }
                
                echo "  ✓ Separated old task from parent campaign\n";
                
                // 2. Tạo sub-request mới để thay thế (copy cả generated_review_content)
                $place_name_escaped = $db->real_escape_string($task['place_name']);
                $place_address_escaped = $db->real_escape_string($task['place_address']);
                $review_content_escaped = $task['generated_review_content'] ? $db->real_escape_string($task['generated_review_content']) : null;
                
                $insert_new = $db->query("
                    INSERT INTO google_maps_review_sub_requests (
                        parent_request_id,
                        google_place_id,
                        place_name,
                        place_address,
                        place_url,
                        reward_amount,
                        expires_at,
                        generated_review_content,
                        status,
                        created_at,
                        updated_at
                    ) VALUES (
                        '{$task['parent_request_id']}',
                        " . ($task['google_place_id'] ? "'{$task['google_place_id']}'" : "NULL") . ",
                        '{$place_name_escaped}',
                        '{$place_address_escaped}',
                        " . ($task['place_url'] ? "'{$task['place_url']}'" : "NULL") . ",
                        '{$task['reward_amount']}',
                        '{$task['expires_at']}',
                        " . ($review_content_escaped ? "'{$review_content_escaped}'" : "NULL") . ",
                        'available',
                        NOW(),
                        NOW()
                    )
                ");
                
                if (!$insert_new) {
                    throw new Exception("Failed to create new replacement sub-request");
                }
                
                $new_sub_request_id = $db->insert_id;
                echo "  ✓ Created new replacement task #{$new_sub_request_id}\n";
                
                // Commit transaction
                $db->query("COMMIT");
                echo "  ✓ Transaction committed successfully\n";
                
            } catch (Exception $e) {
                $db->query("ROLLBACK");
                echo "  ✗ Error: {$e->getMessage()}\n";
                error_log("Failed verification handler error: {$e->getMessage()}");
            }
        }
    }
    
    // ========================================
    // 3. CẬP NHẬT TRẠNG THÁI CHIẾN DỊCH MẸ
    // ========================================
    echo "\n[" . date('Y-m-d H:i:s') . "] Updating parent campaign statuses...\n";
    
    // Tìm các chiến dịch mẹ cần cập nhật
    $parent_campaigns = $db->query("
        SELECT 
            gmr.request_id,
            gmr.target_reviews,
            COUNT(gmsr.sub_request_id) as total_sub_requests,
            SUM(CASE WHEN gmsr.status = 'verified' THEN 1 ELSE 0 END) as verified_count
        FROM google_maps_review_requests gmr
        LEFT JOIN google_maps_review_sub_requests gmsr ON gmr.request_id = gmsr.parent_request_id
        WHERE gmr.status = 'active'
        GROUP BY gmr.request_id
        HAVING verified_count >= gmr.target_reviews
    ");
    
    $completed_campaigns = 0;
    while ($campaign = $parent_campaigns->fetch_assoc()) {
        $db->query("
            UPDATE google_maps_review_requests
            SET status = 'completed', updated_at = NOW()
            WHERE request_id = '{$campaign['request_id']}'
        ");
        $completed_campaigns++;
        echo "  ✓ Campaign #{$campaign['request_id']} marked as completed\n";
    }
    
    echo "\nTotal campaigns completed: {$completed_campaigns}\n";
    
    // ========================================
    // SUMMARY
    // ========================================
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "SUMMARY:\n";
    echo "  - Timeout assigned tasks processed: {$timeout_assigned_count}\n";
    echo "  - Failed verification tasks processed: {$failed_verification_count}\n";
    echo "  - Parent campaigns completed: {$completed_campaigns}\n";
    echo str_repeat("=", 60) . "\n";
    
    echo "\n[" . date('Y-m-d H:i:s') . "] Cron job completed successfully\n";
    
} catch (Exception $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    error_log("Google Maps Timeout Handler Cron Error: " . $e->getMessage());
    exit(1);
}

exit(0);

