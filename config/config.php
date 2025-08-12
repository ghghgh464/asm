<?php
// PolyShop Configuration File

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'polyshop');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'PolyShop');
define('APP_URL', 'http://localhost/tf');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // development, production

// File Upload Configuration
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Session Configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_NAME', 'polyshop_session');

// Security Configuration
define('HASH_COST', 12); // Password hashing cost
define('CSRF_TOKEN_NAME', 'csrf_token');
define('CSRF_TOKEN_LENGTH', 32);

// Pagination Configuration
define('ITEMS_PER_PAGE', 12);
define('MAX_PAGES_DISPLAY', 5);

// Email Configuration (for future use)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_FROM', 'noreply@polyshop.com');
define('SMTP_FROM_NAME', 'PolyShop');

// Error Reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Start session with custom configuration (only if session not already started)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
    ini_set('session.cookie_lifetime', SESSION_LIFETIME);
    session_name(SESSION_NAME);
}

// Helper Functions
function asset($path) {
    return APP_URL . '/assets/' . ltrim($path, '/');
}

function url($path = '') {
    return APP_URL . '/' . ltrim($path, '/');
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

function old($key, $default = '') {
    return $_POST[$key] ?? $_GET[$key] ?? $default;
}

function csrf_token() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function verify_csrf_token($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

function format_price($price) {
    return number_format($price, 0, ',', '.') . 'đ';
}

function format_date($date, $format = 'd/m/Y H:i') {
    return date($format, strtotime($date));
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        redirect('login');
    }
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        redirect('index.php');
    }
}

// Autoloader for classes
spl_autoload_register(function ($class_name) {
    $paths = [
        'models/',
        'controllers/',
        'config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Error Handler
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    if (APP_ENV === 'development') {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
        echo "<strong>Error:</strong> $errstr<br>";
        echo "<strong>File:</strong> $errfile<br>";
        echo "<strong>Line:</strong> $errline";
        echo "</div>";
    }
    
    // Log error to file in production
    if (APP_ENV === 'production') {
        error_log("Error [$errno]: $errstr in $errfile on line $errline");
    }
    
    return true;
}

set_error_handler('custom_error_handler');

// Exception Handler
function custom_exception_handler($exception) {
    if (APP_ENV === 'development') {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
        echo "<strong>Exception:</strong> " . $exception->getMessage() . "<br>";
        echo "<strong>File:</strong> " . $exception->getFile() . "<br>";
        echo "<strong>Line:</strong> " . $exception->getLine() . "<br>";
        echo "<strong>Stack Trace:</strong><br><pre>" . $exception->getTraceAsString() . "</pre>";
        echo "</div>";
    } else {
        // Log exception and show generic error page
        error_log("Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
        // Show generic error message instead of including non-existent file
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
        echo "<strong>Đã xảy ra lỗi!</strong><br>";
        echo "Vui lòng thử lại sau hoặc liên hệ quản trị viên.";
        echo "</div>";
    }
}

set_exception_handler('custom_exception_handler');
?>
