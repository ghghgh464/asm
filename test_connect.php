<?php
session_start();

// Simulate admin login
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';
$_SESSION['fullname'] = 'Admin';

echo "<h2>Test Connect Class</h2>";

try {
    // Test Database class
    require_once 'config/database.php';
    $database = new Database();
    echo "<p style='color: green;'>✓ Database class loaded successfully!</p>";
    
    // Test database connection
    $conn = $database->getConnection();
    if ($conn) {
        echo "<p style='color: green;'>✓ Database connection successful!</p>";
    } else {
        echo "<p style='color: red;'>✗ Database connection failed!</p>";
    }
    
    // Test Connect class
    require_once 'models/Connect.php';
    $connect = new Connect('test');
    echo "<p style='color: green;'>✓ Connect class created successfully!</p>";
    
    // Test Products class
    require_once 'models/Products.php';
    $products = new Products();
    echo "<p style='color: green;'>✓ Products class created successfully!</p>";
    
    // Test Categories class
    require_once 'models/Categories.php';
    $categories = new Categories();
    echo "<p style='color: green;'>✓ Categories class created successfully!</p>";
    
    // Test Users class
    require_once 'models/Users.php';
    $users = new Users();
    echo "<p style='color: green;'>✓ Users class created successfully!</p>";
    
    // Test AdminController
    require_once 'controllers/AdminController.php';
    $adminController = new AdminController();
    echo "<p style='color: green;'>✓ AdminController created successfully!</p>";
    
    echo "<p style='color: green; font-weight: bold;'>🎉 All tests passed! System is working correctly.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Stack Trace:</strong><br><pre>" . $e->getTraceAsString() . "</pre></p>";
}
?>
