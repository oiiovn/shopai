<?php

/**
 * ajax -> groups -> enhanced
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access();

// check demo account
if ($user->_data['user_demo']) {
    modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// include group enhancement class
require_once('../../../includes/class-group-enhancement.php');
$group_enhancement = new GroupEnhancement($db, $user, $system);

// handle enhanced group features
try {

    switch ($_GET['do']) {
        
        case 'get_analytics':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            $period = secure($_GET['period']) ?: 'daily';
            $limit = secure($_GET['limit'], 'int') ?: 30;
            
            // Check if user has permission to view analytics
            if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
                _error(403);
            }
            
            $analytics = $group_enhancement->get_group_analytics($group_id, $period, $limit);
            
            /* return */
            return_json(array('success' => true, 'analytics' => $analytics));
            break;

        case 'create_event':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            
            // Check required fields
            if (is_empty($_POST['title'])) {
                throw new Exception(__("Please enter event title"));
            }
            if (is_empty($_POST['date'])) {
                throw new Exception(__("Please select event date"));
            }
            
            $event_data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'date' => $_POST['date'],
                'end_date' => $_POST['end_date'],
                'location' => $_POST['location'],
                'type' => $_POST['type'],
                'link' => $_POST['link'],
                'max_attendees' => $_POST['max_attendees'],
                'fee' => $_POST['fee'],
                'currency' => $_POST['currency'] ?: 'VND',
                'status' => $_POST['status'] ?: 'draft',
                'image' => $_POST['image'],
                'cover' => $_POST['cover']
            ];
            
            $event_id = $group_enhancement->create_group_event($group_id, $user->_data['user_id'], $event_data);
            
            if ($event_id) {
                /* return */
                return_json(array('success' => true, 'message' => __("Event created successfully"), 'event_id' => $event_id));
            } else {
                throw new Exception(__("Failed to create event"));
            }
            break;

        case 'get_events':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            $status = secure($_GET['status']) ?: 'published';
            $limit = secure($_GET['limit'], 'int') ?: 20;
            
            $events = $group_enhancement->get_group_events($group_id, $status, $limit);
            
            /* return */
            return_json(array('success' => true, 'events' => $events));
            break;

        case 'register_event':
            /* valid inputs */
            if (!isset($_GET['event_id']) || !is_numeric($_GET['event_id'])) {
                _error(400);
            }
            
            $event_id = secure($_GET['event_id'], 'int');
            $status = secure($_POST['status']) ?: 'attending';
            
            $success = $group_enhancement->register_for_event($event_id, $user->_data['user_id'], $status);
            
            if ($success) {
                /* return */
                return_json(array('success' => true, 'message' => __("Registration updated successfully")));
            } else {
                throw new Exception(__("Failed to update registration"));
            }
            break;

        case 'create_poll':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            
            // Check required fields
            if (is_empty($_POST['question'])) {
                throw new Exception(__("Please enter poll question"));
            }
            if (is_empty($_POST['options']) || !is_array($_POST['options'])) {
                throw new Exception(__("Please add at least 2 options"));
            }
            
            $poll_data = [
                'question' => $_POST['question'],
                'options' => $_POST['options'],
                'type' => $_POST['type'] ?: 'single',
                'end_date' => $_POST['end_date'],
                'status' => $_POST['status'] ?: 'active',
                'results_visible' => $_POST['results_visible'] ?: 'immediate',
                'anonymous' => $_POST['anonymous'] ?: '0'
            ];
            
            $poll_id = $group_enhancement->create_group_poll($group_id, $user->_data['user_id'], $poll_data);
            
            if ($poll_id) {
                /* return */
                return_json(array('success' => true, 'message' => __("Poll created successfully"), 'poll_id' => $poll_id));
            } else {
                throw new Exception(__("Failed to create poll"));
            }
            break;

        case 'get_polls':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            $status = secure($_GET['status']) ?: 'active';
            $limit = secure($_GET['limit'], 'int') ?: 20;
            
            $polls = $group_enhancement->get_group_polls($group_id, $status, $limit);
            
            /* return */
            return_json(array('success' => true, 'polls' => $polls));
            break;

        case 'vote_poll':
            /* valid inputs */
            if (!isset($_GET['poll_id']) || !is_numeric($_GET['poll_id'])) {
                _error(400);
            }
            
            $poll_id = secure($_GET['poll_id'], 'int');
            
            if (is_empty($_POST['selected_options']) || !is_array($_POST['selected_options'])) {
                throw new Exception(__("Please select at least one option"));
            }
            
            $success = $group_enhancement->vote_in_poll($poll_id, $user->_data['user_id'], $_POST['selected_options']);
            
            if ($success) {
                /* return */
                return_json(array('success' => true, 'message' => __("Vote recorded successfully")));
            } else {
                throw new Exception(__("Failed to record vote"));
            }
            break;

        case 'create_announcement':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            
            // Check required fields
            if (is_empty($_POST['title'])) {
                throw new Exception(__("Please enter announcement title"));
            }
            if (is_empty($_POST['content'])) {
                throw new Exception(__("Please enter announcement content"));
            }
            
            $announcement_data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'type' => $_POST['type'] ?: 'info',
                'priority' => $_POST['priority'] ?: 'normal',
                'status' => $_POST['status'] ?: 'draft',
                'expires_at' => $_POST['expires_at']
            ];
            
            $announcement_id = $group_enhancement->create_group_announcement($group_id, $user->_data['user_id'], $announcement_data);
            
            if ($announcement_id) {
                /* return */
                return_json(array('success' => true, 'message' => __("Announcement created successfully"), 'announcement_id' => $announcement_id));
            } else {
                throw new Exception(__("Failed to create announcement"));
            }
            break;

        case 'get_announcements':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            $status = secure($_GET['status']) ?: 'published';
            $limit = secure($_GET['limit'], 'int') ?: 10;
            
            $announcements = $group_enhancement->get_group_announcements($group_id, $status, $limit);
            
            /* return */
            return_json(array('success' => true, 'announcements' => $announcements));
            break;

        case 'mark_announcement_viewed':
            /* valid inputs */
            if (!isset($_GET['announcement_id']) || !is_numeric($_GET['announcement_id'])) {
                _error(400);
            }
            
            $announcement_id = secure($_GET['announcement_id'], 'int');
            
            $success = $group_enhancement->mark_announcement_viewed($announcement_id, $user->_data['user_id']);
            
            if ($success) {
                /* return */
                return_json(array('success' => true, 'message' => __("Announcement marked as viewed")));
            } else {
                throw new Exception(__("Failed to mark announcement as viewed"));
            }
            break;

        case 'get_templates':
            $category = secure($_GET['category']);
            
            $templates = $group_enhancement->get_group_templates($category);
            
            /* return */
            return_json(array('success' => true, 'templates' => $templates));
            break;

        case 'setup_shopai_integration':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            
            // Check if user is group admin
            if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
                _error(403);
            }
            
            $integration_type = secure($_POST['integration_type']);
            $settings = [
                'product_categories' => $_POST['product_categories'],
                'commission_rate' => $_POST['commission_rate'],
                'payment_methods' => $_POST['payment_methods'],
                'auto_approval' => $_POST['auto_approval']
            ];
            
            $success = $group_enhancement->setup_shopai_integration($group_id, $integration_type, $settings);
            
            if ($success) {
                /* return */
                return_json(array('success' => true, 'message' => __("Shop-AI integration setup successfully")));
            } else {
                throw new Exception(__("Failed to setup Shop-AI integration"));
            }
            break;

        case 'get_shopai_integration':
            /* valid inputs */
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                _error(400);
            }
            
            $group_id = secure($_GET['id'], 'int');
            
            // Check if user is group admin
            if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
                _error(403);
            }
            
            $integration = $group_enhancement->get_shopai_integration($group_id);
            
            /* return */
            return_json(array('success' => true, 'integration' => $integration));
            break;

        default:
            _error(400);
            break;
    }

} catch (Exception $e) {
    return_json(array('error' => true, 'message' => $e->getMessage()));
}
