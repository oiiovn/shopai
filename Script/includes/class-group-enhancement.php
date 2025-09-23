<?php

/**
 * Group Enhancement Class
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

class GroupEnhancement {

    protected $db;
    protected $user;
    protected $system;

    public function __construct($db, $user, $system) {
        $this->db = $db;
        $this->user = $user;
        $this->system = $system;
    }

    /**
     * Get group analytics data
     * 
     * @param int $group_id
     * @param string $period (daily, weekly, monthly, yearly)
     * @param int $limit
     * @return array
     */
    public function get_group_analytics($group_id, $period = 'daily', $limit = 30) {
        $date_format = $this->get_date_format($period);
        
        $query = "SELECT 
                    DATE_FORMAT(date, '{$date_format}') as period,
                    SUM(new_members) as total_new_members,
                    SUM(posts_count) as total_posts,
                    SUM(interactions_count) as total_interactions,
                    SUM(views_count) as total_views,
                    SUM(unique_visitors) as total_unique_visitors,
                    AVG(engagement_rate) as avg_engagement_rate
                  FROM groups_analytics 
                  WHERE group_id = " . secure($group_id, 'int') . "
                  GROUP BY DATE_FORMAT(date, '{$date_format}')
                  ORDER BY period DESC 
                  LIMIT " . secure($limit, 'int');
        
        $result = $this->db->query($query);
        $analytics = [];
        
        while ($row = $result->fetch_assoc()) {
            $analytics[] = $row;
        }
        
        return array_reverse($analytics);
    }

    /**
     * Update group analytics for today
     * 
     * @param int $group_id
     * @param array $data
     */
    public function update_group_analytics($group_id, $data = []) {
        $today = date('Y-m-d');
        
        // Check if record exists for today
        $check_query = "SELECT id FROM groups_analytics WHERE group_id = " . secure($group_id, 'int') . " AND date = '{$today}'";
        $check_result = $this->db->query($check_query);
        
        if ($check_result->num_rows > 0) {
            // Update existing record
            $update_fields = [];
            foreach ($data as $field => $value) {
                if (in_array($field, ['new_members', 'posts_count', 'interactions_count', 'views_count', 'unique_visitors', 'engagement_rate'])) {
                    $update_fields[] = "{$field} = {$field} + " . secure($value, 'float');
                }
            }
            
            if (!empty($update_fields)) {
                $query = "UPDATE groups_analytics SET " . implode(', ', $update_fields) . " WHERE group_id = " . secure($group_id, 'int') . " AND date = '{$today}'";
                $this->db->query($query);
            }
        } else {
            // Insert new record
            $fields = ['group_id', 'date'];
            $values = [secure($group_id, 'int'), "'{$today}'"];
            
            foreach ($data as $field => $value) {
                if (in_array($field, ['new_members', 'posts_count', 'interactions_count', 'views_count', 'unique_visitors', 'engagement_rate'])) {
                    $fields[] = $field;
                    $values[] = secure($value, 'float');
                }
            }
            
            $query = "INSERT INTO groups_analytics (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
            $this->db->query($query);
        }
    }

    /**
     * Create group event
     * 
     * @param int $group_id
     * @param int $user_id
     * @param array $event_data
     * @return int|false
     */
    public function create_group_event($group_id, $user_id, $event_data) {
        // Check if user has permission to create events
        if (!$this->can_create_events($group_id, $user_id)) {
            throw new Exception(__("You don't have permission to create events"));
        }
        
        $query = "INSERT INTO groups_events (
                    group_id, user_id, event_title, event_description, event_date, 
                    event_end_date, event_location, event_type, event_link, 
                    max_attendees, event_fee, event_currency, event_status, 
                    event_image, event_cover
                  ) VALUES (
                    " . secure($group_id, 'int') . ",
                    " . secure($user_id, 'int') . ",
                    " . secure($event_data['title']) . ",
                    " . secure($event_data['description']) . ",
                    " . secure($event_data['date']) . ",
                    " . secure($event_data['end_date']) . ",
                    " . secure($event_data['location']) . ",
                    " . secure($event_data['type']) . ",
                    " . secure($event_data['link']) . ",
                    " . secure($event_data['max_attendees'], 'int') . ",
                    " . secure($event_data['fee'], 'float') . ",
                    " . secure($event_data['currency']) . ",
                    " . secure($event_data['status']) . ",
                    " . secure($event_data['image']) . ",
                    " . secure($event_data['cover']) . "
                  )";
        
        if ($this->db->query($query)) {
            return $this->db->insert_id;
        }
        
        return false;
    }

    /**
     * Get group events
     * 
     * @param int $group_id
     * @param string $status
     * @param int $limit
     * @return array
     */
    public function get_group_events($group_id, $status = 'published', $limit = 20) {
        $query = "SELECT ge.*, u.user_name, u.user_firstname, u.user_lastname, u.user_picture
                  FROM groups_events ge
                  LEFT JOIN users u ON ge.user_id = u.user_id
                  WHERE ge.group_id = " . secure($group_id, 'int');
        
        if ($status) {
            $query .= " AND ge.event_status = " . secure($status);
        }
        
        $query .= " ORDER BY ge.event_date ASC LIMIT " . secure($limit, 'int');
        
        $result = $this->db->query($query);
        $events = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['user_picture'] = get_picture($row['user_picture'], 'user');
            $row['attendees_count'] = $this->get_event_attendees_count($row['event_id']);
            $events[] = $row;
        }
        
        return $events;
    }

    /**
     * Register for event
     * 
     * @param int $event_id
     * @param int $user_id
     * @param string $status
     * @return bool
     */
    public function register_for_event($event_id, $user_id, $status = 'attending') {
        // Check if user is already registered
        $check_query = "SELECT id FROM groups_event_attendees WHERE event_id = " . secure($event_id, 'int') . " AND user_id = " . secure($user_id, 'int');
        $check_result = $this->db->query($check_query);
        
        if ($check_result->num_rows > 0) {
            // Update existing registration
            $query = "UPDATE groups_event_attendees SET status = " . secure($status) . " WHERE event_id = " . secure($event_id, 'int') . " AND user_id = " . secure($user_id, 'int');
        } else {
            // Insert new registration
            $query = "INSERT INTO groups_event_attendees (event_id, user_id, status) VALUES (" . secure($event_id, 'int') . ", " . secure($user_id, 'int') . ", " . secure($status) . ")";
        }
        
        return $this->db->query($query);
    }

    /**
     * Create group poll
     * 
     * @param int $group_id
     * @param int $user_id
     * @param array $poll_data
     * @return int|false
     */
    public function create_group_poll($group_id, $user_id, $poll_data) {
        // Check if user has permission to create polls
        if (!$this->can_create_polls($group_id, $user_id)) {
            throw new Exception(__("You don't have permission to create polls"));
        }
        
        $query = "INSERT INTO groups_polls (
                    group_id, user_id, poll_question, poll_options, poll_type,
                    poll_end_date, poll_status, poll_results_visible, poll_anonymous
                  ) VALUES (
                    " . secure($group_id, 'int') . ",
                    " . secure($user_id, 'int') . ",
                    " . secure($poll_data['question']) . ",
                    " . secure(json_encode($poll_data['options'])) . ",
                    " . secure($poll_data['type']) . ",
                    " . secure($poll_data['end_date']) . ",
                    " . secure($poll_data['status']) . ",
                    " . secure($poll_data['results_visible']) . ",
                    " . secure($poll_data['anonymous']) . "
                  )";
        
        if ($this->db->query($query)) {
            return $this->db->insert_id;
        }
        
        return false;
    }

    /**
     * Get group polls
     * 
     * @param int $group_id
     * @param string $status
     * @param int $limit
     * @return array
     */
    public function get_group_polls($group_id, $status = 'active', $limit = 20) {
        $query = "SELECT gp.*, u.user_name, u.user_firstname, u.user_lastname, u.user_picture
                  FROM groups_polls gp
                  LEFT JOIN users u ON gp.user_id = u.user_id
                  WHERE gp.group_id = " . secure($group_id, 'int');
        
        if ($status) {
            $query .= " AND gp.poll_status = " . secure($status);
        }
        
        $query .= " ORDER BY gp.created_at DESC LIMIT " . secure($limit, 'int');
        
        $result = $this->db->query($query);
        $polls = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['user_picture'] = get_picture($row['user_picture'], 'user');
            $row['poll_options'] = json_decode($row['poll_options'], true);
            $row['votes_count'] = $this->get_poll_votes_count($row['poll_id']);
            $row['user_has_voted'] = $this->user_has_voted($row['poll_id'], $this->user->_data['user_id']);
            $polls[] = $row;
        }
        
        return $polls;
    }

    /**
     * Vote in poll
     * 
     * @param int $poll_id
     * @param int $user_id
     * @param array $selected_options
     * @return bool
     */
    public function vote_in_poll($poll_id, $user_id, $selected_options) {
        // Check if user has already voted
        if ($this->user_has_voted($poll_id, $user_id)) {
            throw new Exception(__("You have already voted in this poll"));
        }
        
        // Check if poll is still active
        $poll_query = "SELECT poll_status, poll_end_date FROM groups_polls WHERE poll_id = " . secure($poll_id, 'int');
        $poll_result = $this->db->query($poll_query);
        $poll = $poll_result->fetch_assoc();
        
        if ($poll['poll_status'] != 'active') {
            throw new Exception(__("This poll is no longer active"));
        }
        
        if ($poll['poll_end_date'] && strtotime($poll['poll_end_date']) < time()) {
            throw new Exception(__("This poll has ended"));
        }
        
        $query = "INSERT INTO groups_poll_votes (poll_id, user_id, selected_options) VALUES (" . secure($poll_id, 'int') . ", " . secure($user_id, 'int') . ", " . secure(json_encode($selected_options)) . ")";
        
        return $this->db->query($query);
    }

    /**
     * Create group announcement
     * 
     * @param int $group_id
     * @param int $user_id
     * @param array $announcement_data
     * @return int|false
     */
    public function create_group_announcement($group_id, $user_id, $announcement_data) {
        // Check if user has permission to create announcements
        if (!$this->can_create_announcements($group_id, $user_id)) {
            throw new Exception(__("You don't have permission to create announcements"));
        }
        
        $query = "INSERT INTO groups_announcements (
                    group_id, user_id, announcement_title, announcement_content,
                    announcement_type, announcement_priority, announcement_status,
                    expires_at
                  ) VALUES (
                    " . secure($group_id, 'int') . ",
                    " . secure($user_id, 'int') . ",
                    " . secure($announcement_data['title']) . ",
                    " . secure($announcement_data['content']) . ",
                    " . secure($announcement_data['type']) . ",
                    " . secure($announcement_data['priority']) . ",
                    " . secure($announcement_data['status']) . ",
                    " . secure($announcement_data['expires_at']) . "
                  )";
        
        if ($this->db->query($query)) {
            return $this->db->insert_id;
        }
        
        return false;
    }

    /**
     * Get group announcements
     * 
     * @param int $group_id
     * @param string $status
     * @param int $limit
     * @return array
     */
    public function get_group_announcements($group_id, $status = 'published', $limit = 10) {
        $query = "SELECT ga.*, u.user_name, u.user_firstname, u.user_lastname, u.user_picture
                  FROM groups_announcements ga
                  LEFT JOIN users u ON ga.user_id = u.user_id
                  WHERE ga.group_id = " . secure($group_id, 'int');
        
        if ($status) {
            $query .= " AND ga.announcement_status = " . secure($status);
        }
        
        $query .= " AND (ga.expires_at IS NULL OR ga.expires_at > NOW())";
        $query .= " ORDER BY ga.announcement_priority DESC, ga.created_at DESC LIMIT " . secure($limit, 'int');
        
        $result = $this->db->query($query);
        $announcements = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['user_picture'] = get_picture($row['user_picture'], 'user');
            $row['user_has_viewed'] = $this->user_has_viewed_announcement($row['announcement_id'], $this->user->_data['user_id']);
            $announcements[] = $row;
        }
        
        return $announcements;
    }

    /**
     * Mark announcement as viewed
     * 
     * @param int $announcement_id
     * @param int $user_id
     * @return bool
     */
    public function mark_announcement_viewed($announcement_id, $user_id) {
        $query = "INSERT IGNORE INTO groups_announcement_views (announcement_id, user_id) VALUES (" . secure($announcement_id, 'int') . ", " . secure($user_id, 'int') . ")";
        return $this->db->query($query);
    }

    /**
     * Get group templates
     * 
     * @param string $category
     * @return array
     */
    public function get_group_templates($category = null) {
        $query = "SELECT * FROM groups_templates WHERE template_status = 'active'";
        
        if ($category) {
            $query .= " AND template_category = " . secure($category);
        }
        
        $query .= " ORDER BY template_name ASC";
        
        $result = $this->db->query($query);
        $templates = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['template_settings'] = json_decode($row['template_settings'], true);
            $row['template_permissions'] = json_decode($row['template_permissions'], true);
            $templates[] = $row;
        }
        
        return $templates;
    }

    /**
     * Create group with template
     * 
     * @param int $user_id
     * @param int $template_id
     * @param array $group_data
     * @return int|false
     */
    public function create_group_with_template($user_id, $template_id, $group_data) {
        // Get template settings
        $template_query = "SELECT * FROM groups_templates WHERE template_id = " . secure($template_id, 'int');
        $template_result = $this->db->query($template_query);
        $template = $template_result->fetch_assoc();
        
        if (!$template) {
            throw new Exception(__("Template not found"));
        }
        
        $template_settings = json_decode($template['template_settings'], true);
        
        // Merge template settings with user data
        $final_data = array_merge($template_settings, $group_data);
        $final_data['group_template_id'] = $template_id;
        
        // Create group (this would need to be integrated with existing group creation logic)
        // For now, return the prepared data
        return $final_data;
    }

    /**
     * Setup Shop-AI integration for group
     * 
     * @param int $group_id
     * @param string $integration_type
     * @param array $settings
     * @return bool
     */
    public function setup_shopai_integration($group_id, $integration_type, $settings) {
        $query = "INSERT INTO groups_shopai_integration (
                    group_id, integration_type, shopai_settings,
                    product_categories, commission_rate, payment_methods,
                    auto_approval, integration_status
                  ) VALUES (
                    " . secure($group_id, 'int') . ",
                    " . secure($integration_type) . ",
                    " . secure(json_encode($settings)) . ",
                    " . secure(json_encode($settings['product_categories'])) . ",
                    " . secure($settings['commission_rate'], 'float') . ",
                    " . secure(json_encode($settings['payment_methods'])) . ",
                    " . secure($settings['auto_approval']) . ",
                    'active'
                  )";
        
        return $this->db->query($query);
    }

    /**
     * Get Shop-AI integration settings
     * 
     * @param int $group_id
     * @return array|false
     */
    public function get_shopai_integration($group_id) {
        $query = "SELECT * FROM groups_shopai_integration WHERE group_id = " . secure($group_id, 'int');
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $integration = $result->fetch_assoc();
            $integration['shopai_settings'] = json_decode($integration['shopai_settings'], true);
            $integration['product_categories'] = json_decode($integration['product_categories'], true);
            $integration['payment_methods'] = json_decode($integration['payment_methods'], true);
            return $integration;
        }
        
        return false;
    }

    // Helper methods

    private function get_date_format($period) {
        switch ($period) {
            case 'daily': return '%Y-%m-%d';
            case 'weekly': return '%Y-%u';
            case 'monthly': return '%Y-%m';
            case 'yearly': return '%Y';
            default: return '%Y-%m-%d';
        }
    }

    private function can_create_events($group_id, $user_id) {
        // Check if user is group admin or has permission
        $query = "SELECT COUNT(*) as count FROM groups_permissions 
                  WHERE group_id = " . secure($group_id, 'int') . " 
                  AND user_id = " . secure($user_id, 'int') . " 
                  AND role IN ('admin', 'moderator')";
        
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }

    private function can_create_polls($group_id, $user_id) {
        // Check if user is group admin or has permission
        $query = "SELECT COUNT(*) as count FROM groups_permissions 
                  WHERE group_id = " . secure($group_id, 'int') . " 
                  AND user_id = " . secure($user_id, 'int') . " 
                  AND role IN ('admin', 'moderator', 'editor')";
        
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }

    private function can_create_announcements($group_id, $user_id) {
        // Check if user is group admin or has permission
        $query = "SELECT COUNT(*) as count FROM groups_permissions 
                  WHERE group_id = " . secure($group_id, 'int') . " 
                  AND user_id = " . secure($user_id, 'int') . " 
                  AND role IN ('admin', 'moderator')";
        
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }

    private function get_event_attendees_count($event_id) {
        $query = "SELECT COUNT(*) as count FROM groups_event_attendees WHERE event_id = " . secure($event_id, 'int') . " AND status = 'attending'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    private function get_poll_votes_count($poll_id) {
        $query = "SELECT COUNT(*) as count FROM groups_poll_votes WHERE poll_id = " . secure($poll_id, 'int');
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    private function user_has_voted($poll_id, $user_id) {
        $query = "SELECT COUNT(*) as count FROM groups_poll_votes WHERE poll_id = " . secure($poll_id, 'int') . " AND user_id = " . secure($user_id, 'int');
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    private function user_has_viewed_announcement($announcement_id, $user_id) {
        $query = "SELECT COUNT(*) as count FROM groups_announcement_views WHERE announcement_id = " . secure($announcement_id, 'int') . " AND user_id = " . secure($user_id, 'int');
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
