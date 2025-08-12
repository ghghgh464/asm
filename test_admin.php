<?php
session_start();

// Simulate admin login
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';
$_SESSION['fullname'] = 'Admin';

echo "<h2>Test AdminController</h2>";

try {
    // Load models
    require_once 'models/Connect.php';
    require_once 'models/Products.php';
    require_once 'models/Categories.php';
    require_once 'models/Users.php';
    
    echo "<p style='color: green;'>✓ Models loaded successfully!</p>";
    
    // Test model instantiation
    $productsModel = new Products();
    $categoriesModel = new Categories();
    $usersModel = new Users();
    
    echo "<p style='color: green;'>✓ Models instantiated successfully!</p>";
    
    // Test AdminController
    require_once 'controllers/AdminController.php';
    $adminController = new AdminController();
    
    echo "<p style='color: green;'>✓ AdminController created successfully!</p>";
    
    // Test dashboard
    echo "<p>Testing dashboard...</p>";
    $adminController->index();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Stack Trace:</strong><br><pre>" . $e->getTraceAsString() . "</pre></p>";
}
?>
