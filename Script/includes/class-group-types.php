<?php

/**
 * Group Types Management Class
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

class GroupTypes {

    protected $db;
    protected $user;
    protected $system;

    public function __construct($db, $user, $system) {
        $this->db = $db;
        $this->user = $user;
        $this->system = $system;
    }

    /**
     * Get all group types
     * 
     * @param string $status
     * @return array
     */
    public function get_group_types($status = 'active') {
        $query = "SELECT * FROM groups_types WHERE type_status = " . secure($status) . " ORDER BY type_order ASC, type_name ASC";
        $result = $this->db->query($query);
        $types = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['type_features'] = json_decode($row['type_features'], true);
            $row['type_settings'] = json_decode($row['type_settings'], true);
            $row['type_permissions'] = json_decode($row['type_permissions'], true);
            $row['type_custom_fields'] = json_decode($row['type_custom_fields'], true);
            $types[] = $row;
        }
        
        return $types;
    }

    /**
     * Get group type by ID
     * 
     * @param int $type_id
     * @return array|false
     */
    public function get_group_type($type_id) {
        $query = "SELECT * FROM groups_types WHERE type_id = " . secure($type_id, 'int');
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $type = $result->fetch_assoc();
            $type['type_features'] = json_decode($type['type_features'], true);
            $type['type_settings'] = json_decode($type['type_settings'], true);
            $type['type_permissions'] = json_decode($type['type_permissions'], true);
            $type['type_custom_fields'] = json_decode($type['type_custom_fields'], true);
            
            // Get detailed features
            $type['features'] = $this->get_type_features($type_id);
            $type['settings'] = $this->get_type_settings($type_id);
            $type['permissions'] = $this->get_type_permissions($type_id);
            
            return $type;
        }
        
        return false;
    }

    /**
     * Get group type by key
     * 
     * @param string $type_key
     * @return array|false
     */
    public function get_group_type_by_key($type_key) {
        $query = "SELECT * FROM groups_types WHERE type_key = " . secure($type_key);
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $type = $result->fetch_assoc();
            $type['type_features'] = json_decode($type['type_features'], true);
            $type['type_settings'] = json_decode($type['type_settings'], true);
            $type['type_permissions'] = json_decode($type['type_permissions'], true);
            $type['type_custom_fields'] = json_decode($type['type_custom_fields'], true);
            
            return $type;
        }
        
        return false;
    }

    /**
     * Get type features
     * 
     * @param int $type_id
     * @return array
     */
    public function get_type_features($type_id) {
        $query = "SELECT * FROM groups_type_features WHERE type_id = " . secure($type_id, 'int') . " ORDER BY feature_order ASC";
        $result = $this->db->query($query);
        $features = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['feature_settings'] = json_decode($row['feature_settings'], true);
            $features[] = $row;
        }
        
        return $features;
    }

    /**
     * Get type settings
     * 
     * @param int $type_id
     * @return array
     */
    public function get_type_settings($type_id) {
        $query = "SELECT * FROM groups_type_settings WHERE type_id = " . secure($type_id, 'int');
        $result = $this->db->query($query);
        $settings = [];
        
        while ($row = $result->fetch_assoc()) {
            // Parse setting value based on type
            switch ($row['setting_type']) {
                case 'boolean':
                    $row['parsed_value'] = (bool) $row['setting_value'];
                    break;
                case 'integer':
                    $row['parsed_value'] = (int) $row['setting_value'];
                    break;
                case 'json':
                    $row['parsed_value'] = json_decode($row['setting_value'], true);
                    break;
                default:
                    $row['parsed_value'] = $row['setting_value'];
                    break;
            }
            $settings[$row['setting_key']] = $row;
        }
        
        return $settings;
    }

    /**
     * Get type permissions
     * 
     * @param int $type_id
     * @return array
     */
    public function get_type_permissions($type_id) {
        $query = "SELECT * FROM groups_type_permissions WHERE type_id = " . secure($type_id, 'int');
        $result = $this->db->query($query);
        $permissions = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['permissions'] = json_decode($row['permissions'], true);
            $permissions[$row['role']] = $row;
        }
        
        return $permissions;
    }

    /**
     * Apply group type to group
     * 
     * @param int $group_id
     * @param int $type_id
     * @return bool
     */
    public function apply_group_type($group_id, $type_id) {
        // Get group type
        $group_type = $this->get_group_type($type_id);
        if (!$group_type) {
            throw new Exception(__("Group type not found"));
        }
        
        // Update group with type settings
        $type_settings = json_encode($group_type['type_settings']);
        
        $query = "UPDATE groups SET 
                    group_type_id = " . secure($type_id, 'int') . ",
                    group_type_settings = " . secure($type_settings) . "
                  WHERE group_id = " . secure($group_id, 'int');
        
        if ($this->db->query($query)) {
            // Apply type-specific settings to group
            $this->apply_type_settings($group_id, $group_type);
            
            // Set up type-specific permissions
            $this->setup_type_permissions($group_id, $group_type);
            
            return true;
        }
        
        return false;
    }

    /**
     * Apply type settings to group
     * 
     * @param int $group_id
     * @param array $group_type
     */
    private function apply_type_settings($group_id, $group_type) {
        $settings = $group_type['type_settings'];
        
        // Update group settings based on type
        $update_fields = [];
        
        if (isset($settings['privacy'])) {
            $update_fields[] = "group_privacy = " . secure($settings['privacy']);
        }
        if (isset($settings['publish_approval'])) {
            $update_fields[] = "group_publish_approval_enabled = " . secure($settings['publish_approval']);
        }
        if (isset($settings['chatbox_enabled'])) {
            $update_fields[] = "chatbox_enabled = " . secure($settings['chatbox_enabled']);
        }
        if (isset($settings['monetization_enabled'])) {
            $update_fields[] = "group_monetization_enabled = " . secure($settings['monetization_enabled']);
        }
        if (isset($settings['analytics_enabled'])) {
            $update_fields[] = "group_analytics_enabled = " . secure($settings['analytics_enabled']);
        }
        if (isset($settings['events_enabled'])) {
            $update_fields[] = "group_events_enabled = " . secure($settings['events_enabled']);
        }
        if (isset($settings['polls_enabled'])) {
            $update_fields[] = "group_polls_enabled = " . secure($settings['polls_enabled']);
        }
        if (isset($settings['announcements_enabled'])) {
            $update_fields[] = "group_announcements_enabled = " . secure($settings['announcements_enabled']);
        }
        if (isset($settings['shopai_enabled'])) {
            $update_fields[] = "group_shopai_enabled = " . secure($settings['shopai_enabled']);
        }
        
        if (!empty($update_fields)) {
            $query = "UPDATE groups SET " . implode(', ', $update_fields) . " WHERE group_id = " . secure($group_id, 'int');
            $this->db->query($query);
        }
    }

    /**
     * Setup type permissions for group
     * 
     * @param int $group_id
     * @param array $group_type
     */
    private function setup_type_permissions($group_id, $group_type) {
        $type_permissions = $this->get_type_permissions($group_type['type_id']);
        
        // Clear existing permissions for this group
        $this->db->query("DELETE FROM groups_permissions WHERE group_id = " . secure($group_id, 'int'));
        
        // Apply default permissions for group admin
        $admin_permissions = $type_permissions['admin']['permissions'] ?? [];
        $this->set_user_permissions($group_id, $group_type['group_admin'], 'admin', $admin_permissions);
    }

    /**
     * Set user permissions for group
     * 
     * @param int $group_id
     * @param int $user_id
     * @param string $role
     * @param array $permissions
     * @return bool
     */
    public function set_user_permissions($group_id, $user_id, $role, $permissions) {
        $query = "INSERT INTO groups_permissions (group_id, user_id, role, permissions, granted_by) 
                  VALUES (" . secure($group_id, 'int') . ", " . secure($user_id, 'int') . ", " . secure($role) . ", " . secure(json_encode($permissions)) . ", " . secure($this->user->_data['user_id'], 'int') . ")";
        
        return $this->db->query($query);
    }

    /**
     * Check if user has specific permission in group
     * 
     * @param int $group_id
     * @param int $user_id
     * @param string $permission
     * @return bool
     */
    public function user_has_permission($group_id, $user_id, $permission) {
        // Check if user is group admin (super admin)
        $admin_query = "SELECT group_admin FROM groups WHERE group_id = " . secure($group_id, 'int');
        $admin_result = $this->db->query($admin_query);
        $admin_row = $admin_result->fetch_assoc();
        
        if ($admin_row && $admin_row['group_admin'] == $user_id) {
            return true; // Group admin has all permissions
        }
        
        // Check user permissions
        $query = "SELECT permissions FROM groups_permissions WHERE group_id = " . secure($group_id, 'int') . " AND user_id = " . secure($user_id, 'int');
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $permissions = json_decode($row['permissions'], true);
            
            // Check for all_permissions
            if (isset($permissions['all_permissions']) && $permissions['all_permissions']) {
                return true;
            }
            
            // Check specific permission
            return isset($permissions[$permission]) && $permissions[$permission];
        }
        
        return false;
    }

    /**
     * Get user role in group
     * 
     * @param int $group_id
     * @param int $user_id
     * @return string|null
     */
    public function get_user_role($group_id, $user_id) {
        // Check if user is group admin
        $admin_query = "SELECT group_admin FROM groups WHERE group_id = " . secure($group_id, 'int');
        $admin_result = $this->db->query($admin_query);
        $admin_row = $admin_result->fetch_assoc();
        
        if ($admin_row && $admin_row['group_admin'] == $user_id) {
            return 'admin';
        }
        
        // Check user permissions
        $query = "SELECT role FROM groups_permissions WHERE group_id = " . secure($group_id, 'int') . " AND user_id = " . secure($user_id, 'int');
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['role'];
        }
        
        return 'member';
    }

    /**
     * Get type-specific features for group
     * 
     * @param int $group_id
     * @return array
     */
    public function get_group_features($group_id) {
        // Get group type
        $query = "SELECT group_type_id FROM groups WHERE group_id = " . secure($group_id, 'int');
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $type_id = $row['group_type_id'];
            
            if ($type_id) {
                return $this->get_type_features($type_id);
            }
        }
        
        return [];
    }

    /**
     * Check if group has specific feature
     * 
     * @param int $group_id
     * @param string $feature_key
     * @return bool
     */
    public function group_has_feature($group_id, $feature_key) {
        $features = $this->get_group_features($group_id);
        
        foreach ($features as $feature) {
            if ($feature['feature_key'] == $feature_key && $feature['feature_enabled'] == '1') {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get type-specific settings for group
     * 
     * @param int $group_id
     * @return array
     */
    public function get_group_type_settings($group_id) {
        // Get group type settings
        $query = "SELECT group_type_settings FROM groups WHERE group_id = " . secure($group_id, 'int');
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $settings = json_decode($row['group_type_settings'], true);
            return $settings ?: [];
        }
        
        return [];
    }

    /**
     * Create new group type
     * 
     * @param array $type_data
     * @return int|false
     */
    public function create_group_type($type_data) {
        $query = "INSERT INTO groups_types (
                    type_name, type_key, type_description, type_icon, type_color,
                    type_features, type_settings, type_permissions, type_custom_fields,
                    type_status, type_order, created_by
                  ) VALUES (
                    " . secure($type_data['name']) . ",
                    " . secure($type_data['key']) . ",
                    " . secure($type_data['description']) . ",
                    " . secure($type_data['icon']) . ",
                    " . secure($type_data['color']) . ",
                    " . secure(json_encode($type_data['features'])) . ",
                    " . secure(json_encode($type_data['settings'])) . ",
                    " . secure(json_encode($type_data['permissions'])) . ",
                    " . secure(json_encode($type_data['custom_fields'])) . ",
                    " . secure($type_data['status']) . ",
                    " . secure($type_data['order'], 'int') . ",
                    " . secure($this->user->_data['user_id'], 'int') . "
                  )";
        
        if ($this->db->query($query)) {
            return $this->db->insert_id;
        }
        
        return false;
    }

    /**
     * Update group type
     * 
     * @param int $type_id
     * @param array $type_data
     * @return bool
     */
    public function update_group_type($type_id, $type_data) {
        $update_fields = [];
        
        if (isset($type_data['name'])) {
            $update_fields[] = "type_name = " . secure($type_data['name']);
        }
        if (isset($type_data['description'])) {
            $update_fields[] = "type_description = " . secure($type_data['description']);
        }
        if (isset($type_data['icon'])) {
            $update_fields[] = "type_icon = " . secure($type_data['icon']);
        }
        if (isset($type_data['color'])) {
            $update_fields[] = "type_color = " . secure($type_data['color']);
        }
        if (isset($type_data['features'])) {
            $update_fields[] = "type_features = " . secure(json_encode($type_data['features']));
        }
        if (isset($type_data['settings'])) {
            $update_fields[] = "type_settings = " . secure(json_encode($type_data['settings']));
        }
        if (isset($type_data['permissions'])) {
            $update_fields[] = "type_permissions = " . secure(json_encode($type_data['permissions']));
        }
        if (isset($type_data['custom_fields'])) {
            $update_fields[] = "type_custom_fields = " . secure(json_encode($type_data['custom_fields']));
        }
        if (isset($type_data['status'])) {
            $update_fields[] = "type_status = " . secure($type_data['status']);
        }
        if (isset($type_data['order'])) {
            $update_fields[] = "type_order = " . secure($type_data['order'], 'int');
        }
        
        if (!empty($update_fields)) {
            $query = "UPDATE groups_types SET " . implode(', ', $update_fields) . " WHERE type_id = " . secure($type_id, 'int');
            return $this->db->query($query);
        }
        
        return false;
    }

    /**
     * Delete group type
     * 
     * @param int $type_id
     * @return bool
     */
    public function delete_group_type($type_id) {
        // Check if any groups are using this type
        $check_query = "SELECT COUNT(*) as count FROM groups WHERE group_type_id = " . secure($type_id, 'int');
        $check_result = $this->db->query($check_query);
        $check_row = $check_result->fetch_assoc();
        
        if ($check_row['count'] > 0) {
            throw new Exception(__("Cannot delete group type that is being used by groups"));
        }
        
        // Delete group type (cascade will handle related records)
        $query = "DELETE FROM groups_types WHERE type_id = " . secure($type_id, 'int');
        return $this->db->query($query);
    }

    /**
     * Get groups by type
     * 
     * @param int $type_id
     * @param int $limit
     * @return array
     */
    public function get_groups_by_type($type_id, $limit = 20) {
        $query = "SELECT g.*, gt.type_name, gt.type_key, gt.type_icon, gt.type_color
                  FROM groups g
                  LEFT JOIN groups_types gt ON g.group_type_id = gt.type_id
                  WHERE g.group_type_id = " . secure($type_id, 'int') . "
                  ORDER BY g.group_date DESC
                  LIMIT " . secure($limit, 'int');
        
        $result = $this->db->query($query);
        $groups = [];
        
        while ($row = $result->fetch_assoc()) {
            $row['group_picture'] = get_picture($row['group_picture'], 'group');
            $groups[] = $row;
        }
        
        return $groups;
    }

    /**
     * Get type statistics
     * 
     * @return array
     */
    public function get_type_statistics() {
        $query = "SELECT 
                    gt.type_id,
                    gt.type_name,
                    gt.type_key,
                    gt.type_color,
                    COUNT(g.group_id) as groups_count,
                    SUM(g.group_members) as total_members
                  FROM groups_types gt
                  LEFT JOIN groups g ON gt.type_id = g.group_type_id
                  WHERE gt.type_status = 'active'
                  GROUP BY gt.type_id
                  ORDER BY gt.type_order ASC";
        
        $result = $this->db->query($query);
        $statistics = [];
        
        while ($row = $result->fetch_assoc()) {
            $statistics[] = $row;
        }
        
        return $statistics;
    }
}
