<?php

/**
 * Gray Verification System
 * 
 * @package Sngine
 * @author TCSN Team
 */

class GrayVerification
{
    private $db;
    private $system;

    public function __construct($database, $system_config)
    {
        $this->db = $database;
        $this->system = $system_config;
    }

    /**
     * Check if Gray Verification is enabled
     */
    public function isEnabled()
    {
        return (bool) $this->system['gray_verification_enabled'];
    }

    /**
     * Check if a page meets Gray Verification criteria
     */
    public function checkEligibility($page_id)
    {
        if (!$this->isEnabled()) {
            return [
                'eligible' => false,
                'reason' => 'Gray verification is disabled'
            ];
        }

        // Get page data
        $get_page = $this->db->query(sprintf("
            SELECT p.*, 
                   COUNT(posts.post_id) as post_count,
                   DATEDIFF(NOW(), p.page_date) as active_days
            FROM pages p
            LEFT JOIN posts ON (posts.in_page = 1 AND posts.page_id = p.page_id)
            WHERE p.page_id = %s
            GROUP BY p.page_id
        ", secure($page_id, 'int')));

        if ($get_page->num_rows == 0) {
            return [
                'eligible' => false,
                'reason' => 'Page not found'
            ];
        }

        $page = $get_page->fetch_assoc();

        // Check if already verified
        if ($page['page_verified'] != '0') {
            return [
                'eligible' => false,
                'reason' => 'Page already verified'
            ];
        }

        $criteria_checks = [];

        // Check minimum likes
        $min_likes = (int) $this->system['gray_verification_min_likes'];
        $criteria_checks['likes'] = [
            'required' => $min_likes,
            'current' => (int) $page['page_likes'],
            'passed' => $page['page_likes'] >= $min_likes
        ];

        // Check minimum posts
        $min_posts = (int) $this->system['gray_verification_min_posts'];
        $criteria_checks['posts'] = [
            'required' => $min_posts,
            'current' => (int) $page['post_count'],
            'passed' => $page['post_count'] >= $min_posts
        ];

        // Check active days
        $min_active_days = (int) $this->system['gray_verification_min_active_days'];
        $criteria_checks['active_days'] = [
            'required' => $min_active_days,
            'current' => (int) $page['active_days'],
            'passed' => $page['active_days'] >= $min_active_days
        ];

        // Check business information
        if ($this->system['gray_verification_require_business_info']) {
            $has_business_info = !empty($page['page_company']) && !empty($page['page_phone']);
            $criteria_checks['business_info'] = [
                'required' => true,
                'current' => $has_business_info,
                'passed' => $has_business_info
            ];
        }

        // Check cover photo
        if ($this->system['gray_verification_require_cover_photo']) {
            $has_cover = !empty($page['page_cover']);
            $criteria_checks['cover_photo'] = [
                'required' => true,
                'current' => $has_cover,
                'passed' => $has_cover
            ];
        }

        // Check description
        if ($this->system['gray_verification_require_description']) {
            $has_description = !empty($page['page_description']);
            $criteria_checks['description'] = [
                'required' => true,
                'current' => $has_description,
                'passed' => $has_description
            ];
        }

        // Check website
        if ($this->system['gray_verification_require_website']) {
            $has_website = !empty($page['page_website']);
            $criteria_checks['website'] = [
                'required' => true,
                'current' => $has_website,
                'passed' => $has_website
            ];
        }

        // Check location
        if ($this->system['gray_verification_require_location']) {
            $has_location = !empty($page['page_location']);
            $criteria_checks['location'] = [
                'required' => true,
                'current' => $has_location,
                'passed' => $has_location
            ];
        }

        // Determine overall eligibility
        $all_passed = true;
        $failed_criteria = [];

        foreach ($criteria_checks as $criterion => $check) {
            if (!$check['passed']) {
                $all_passed = false;
                $failed_criteria[] = $criterion;
            }
        }

        return [
            'eligible' => $all_passed,
            'criteria' => $criteria_checks,
            'failed_criteria' => $failed_criteria,
            'page_data' => $page
        ];
    }

    /**
     * Create Gray Verification request
     */
    public function createRequest($page_id, $message = '', $documents = [])
    {
        global $date;

        // Check if page exists and user has permission
        $get_page = $this->db->query(sprintf("
            SELECT page_id, page_admin, page_title 
            FROM pages 
            WHERE page_id = %s
        ", secure($page_id, 'int')));

        if ($get_page->num_rows == 0) {
            throw new Exception("Page not found");
        }

        $page = $get_page->fetch_assoc();

        // Check for existing pending request
        $existing_request = $this->db->query(sprintf("
            SELECT request_id 
            FROM verification_requests 
            WHERE node_id = %s 
            AND node_type = 'page' 
            AND verification_level = 'gray'
            AND status = '0'
        ", secure($page_id, 'int')));

        if ($existing_request->num_rows > 0) {
            throw new Exception("Pending gray verification request already exists");
        }

        // Insert verification request
        $query = $this->db->query(sprintf("
            INSERT INTO verification_requests 
            (node_id, node_type, verification_level, source_verification, photo, passport, message, time, status) 
            VALUES (%s, 'page', 'gray', '0', %s, %s, %s, %s, '0')
        ", 
            secure($page_id, 'int'),
            secure($documents['photo'] ?? ''),
            secure($documents['passport'] ?? ''),
            secure($message),
            secure($date)
        ));

        if (!$query) {
            throw new Exception("Failed to create verification request");
        }

        return $this->db->insert_id;
    }

    /**
     * Create Blue Verification upgrade request
     */
    public function createUpgradeRequest($page_id, $message = '', $documents = [])
    {
        global $date;

        // Check if page has gray verification
        $get_page = $this->db->query(sprintf("
            SELECT page_id, page_admin, page_title, page_verified 
            FROM pages 
            WHERE page_id = %s
        ", secure($page_id, 'int')));

        if ($get_page->num_rows == 0) {
            throw new Exception("Page not found");
        }

        $page = $get_page->fetch_assoc();

        if ($page['page_verified'] != '2') {
            throw new Exception("Page must have gray verification to upgrade");
        }

        // Check for existing pending upgrade request
        $existing_request = $this->db->query(sprintf("
            SELECT request_id 
            FROM verification_requests 
            WHERE node_id = %s 
            AND node_type = 'page' 
            AND verification_level = 'blue'
            AND source_verification = '2'
            AND status = '0'
        ", secure($page_id, 'int')));

        if ($existing_request->num_rows > 0) {
            throw new Exception("Pending blue verification upgrade request already exists");
        }

        // Insert upgrade request
        $query = $this->db->query(sprintf("
            INSERT INTO verification_requests 
            (node_id, node_type, verification_level, source_verification, photo, passport, message, time, status) 
            VALUES (%s, 'page', 'blue', '2', %s, %s, %s, %s, '0')
        ", 
            secure($page_id, 'int'),
            secure($documents['business_registration'] ?? ''),
            secure($documents['tax_document'] ?? ''),
            secure($message),
            secure($date)
        ));

        if (!$query) {
            throw new Exception("Failed to create upgrade request");
        }

        return $this->db->insert_id;
    }

    /**
     * Approve Gray Verification
     */
    public function approveGrayVerification($page_id, $request_id = null)
    {
        // Update page verification status
        $update_page = $this->db->query(sprintf("
            UPDATE pages 
            SET page_verified = '2',
                page_verification_type = 'manual_gray',
                page_verification_date = NOW()
            WHERE page_id = %s
        ", secure($page_id, 'int')));

        if (!$update_page) {
            throw new Exception("Failed to update page verification status");
        }

        // Update verification history
        $this->updateVerificationHistory($page_id, 'gray', 'manual_approval');

        // Mark request as approved
        if ($request_id) {
            $this->db->query(sprintf("
                UPDATE verification_requests 
                SET status = '1' 
                WHERE request_id = %s
            ", secure($request_id, 'int')));
        }

        return true;
    }

    /**
     * Approve Blue Verification (including upgrades)
     */
    public function approveBlueVerification($page_id, $request_id = null, $is_upgrade = false)
    {
        $verification_type = $is_upgrade ? 'upgrade_blue' : 'manual_blue';

        // Update page verification status
        $update_page = $this->db->query(sprintf("
            UPDATE pages 
            SET page_verified = '1',
                page_verification_type = %s,
                page_verification_date = NOW()
            WHERE page_id = %s
        ", secure($verification_type), secure($page_id, 'int')));

        if (!$update_page) {
            throw new Exception("Failed to update page verification status");
        }

        // Update verification history
        $this->updateVerificationHistory($page_id, 'blue', $verification_type);

        // Mark request as approved
        if ($request_id) {
            $this->db->query(sprintf("
                UPDATE verification_requests 
                SET status = '1' 
                WHERE request_id = %s
            ", secure($request_id, 'int')));
        }

        return true;
    }

    /**
     * Update verification history
     */
    private function updateVerificationHistory($page_id, $level, $type)
    {
        $history_entry = json_encode([
            'level' => $level,
            'type' => $type,
            'date' => date('Y-m-d H:i:s'),
            'timestamp' => time()
        ]);

        $this->db->query(sprintf("
            UPDATE pages 
            SET page_verification_history = COALESCE(
                JSON_ARRAY_APPEND(page_verification_history, '$', %s),
                JSON_ARRAY(%s)
            )
            WHERE page_id = %s
        ", secure($history_entry), secure($history_entry), secure($page_id, 'int')));
    }

    /**
     * Get verification statistics
     */
    public function getStatistics()
    {
        $stats = $this->db->query("
            SELECT 
                COUNT(CASE WHEN page_verified = '0' THEN 1 END) as unverified_pages,
                COUNT(CASE WHEN page_verified = '2' THEN 1 END) as gray_verified_pages,
                COUNT(CASE WHEN page_verified = '1' THEN 1 END) as blue_verified_pages,
                COUNT(CASE WHEN page_verification_type = 'auto_gray' THEN 1 END) as auto_gray_count,
                COUNT(CASE WHEN page_verification_type = 'manual_gray' THEN 1 END) as manual_gray_count,
                COUNT(CASE WHEN page_verification_type = 'upgrade_blue' THEN 1 END) as upgrade_blue_count
            FROM pages
        ")->fetch_assoc();

        $pending_requests = $this->db->query("
            SELECT 
                COUNT(CASE WHEN verification_level = 'gray' THEN 1 END) as pending_gray,
                COUNT(CASE WHEN verification_level = 'blue' AND source_verification = '0' THEN 1 END) as pending_blue,
                COUNT(CASE WHEN verification_level = 'blue' AND source_verification = '2' THEN 1 END) as pending_upgrades
            FROM verification_requests 
            WHERE node_type = 'page' AND status = '0'
        ")->fetch_assoc();

        return array_merge($stats, $pending_requests);
    }

    /**
     * Get verification requests with filters
     */
    public function getRequests($filters = [])
    {
        $where_conditions = ["vr.node_type = 'page'", "vr.status = '0'"];
        $params = [];

        if (!empty($filters['verification_level'])) {
            $where_conditions[] = "vr.verification_level = ?";
            $params[] = $filters['verification_level'];
        }

        if (!empty($filters['source_verification'])) {
            $where_conditions[] = "vr.source_verification = ?";
            $params[] = $filters['source_verification'];
        }

        $where_clause = implode(" AND ", $where_conditions);
        $order_clause = "ORDER BY vr.verification_level ASC, vr.time DESC";

        if (!empty($filters['limit'])) {
            $order_clause .= " LIMIT " . intval($filters['limit']);
        }

        $query = "
            SELECT vr.*, 
                   p.page_title as node_name,
                   p.page_picture as node_picture,
                   p.page_verified as current_verification,
                   u.user_name as admin_name
            FROM verification_requests vr
            LEFT JOIN pages p ON vr.node_id = p.page_id
            LEFT JOIN users u ON p.page_admin = u.user_id
            WHERE {$where_clause}
            {$order_clause}
        ";

        if (empty($params)) {
            return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
        } else {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }

    /**
     * Process auto-approval for eligible pages
     */
    public function processAutoApprovals()
    {
        if (!$this->system['gray_verification_auto_approve']) {
            return ['processed' => 0, 'message' => 'Auto-approval is disabled'];
        }

        // Get unverified pages
        $get_pages = $this->db->query("
            SELECT page_id 
            FROM pages 
            WHERE page_verified = '0'
            ORDER BY page_date DESC
            LIMIT 100
        ");

        $processed = 0;
        $approved = 0;

        while ($page = $get_pages->fetch_assoc()) {
            $processed++;
            
            $eligibility = $this->checkEligibility($page['page_id']);
            
            if ($eligibility['eligible']) {
                try {
                    // Auto-approve gray verification
                    $this->db->query(sprintf("
                        UPDATE pages 
                        SET page_verified = '2',
                            page_verification_type = 'auto_gray',
                            page_verification_date = NOW()
                        WHERE page_id = %s
                    ", secure($page['page_id'], 'int')));

                    $this->updateVerificationHistory($page['page_id'], 'gray', 'auto_approval');
                    $approved++;

                } catch (Exception $e) {
                    error_log("Auto-approval failed for page {$page['page_id']}: " . $e->getMessage());
                }
            }
        }

        return [
            'processed' => $processed,
            'approved' => $approved,
            'message' => "Processed {$processed} pages, approved {$approved} for gray verification"
        ];
    }
}
