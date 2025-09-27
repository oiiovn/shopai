<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Debugging dashboard...\n";

// Include the main file
try {
    // Simulate $_GET parameters
    $_GET['view'] = 'dashboard';
    
    echo "GET view: " . $_GET['view'] . "\n";
    
    // Test the view logic
    $view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
    echo "View variable: " . $view . "\n";
    
    // Test dashboard stats
    $dashboard_stats = array(
        'total_requests' => 0,
        'total_reviews' => 0,
        'total_earnings' => 0,
        'available_tasks' => 0,
        'assigned_tasks' => 0,
        'completed_tasks' => 0,
        'pending_tasks' => 0
    );
    
    echo "Dashboard stats initialized: " . print_r($dashboard_stats, true) . "\n";
    
    // Test template condition
    if ($view == 'dashboard') {
        echo "Dashboard view condition passed!\n";
    } else {
        echo "Dashboard view condition failed!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "Debug completed!\n";
?>
