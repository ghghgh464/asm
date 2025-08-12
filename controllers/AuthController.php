<?php
// Models sẽ được autoload từ config.php

class AuthController {
    private $usersModel;

    public function __construct() {
        $this->usersModel = new Users();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ thông tin';
            } else {
                $user = $this->usersModel->authenticateUser($email, $password);
                if ($user) {
                    // Session đã được start trong index.php
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['fullname'] = $user['fullname'];
                    
                    // Chuyển hướng dựa trên role
                    if ($user['role'] === 'admin') {
                        header('Location: index.php?action=admin');
                    } else {
                        header('Location: index.php');
                    }
                    exit;
                } else {
                    $error = 'Email hoặc mật khẩu không đúng';
                }
            }
        }
        
        include 'views/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'])) {
                $error = 'Token bảo mật không hợp lệ. Vui lòng thử lại.';
            } else {
                $firstname = trim($_POST['firstname'] ?? '');
                $lastname = trim($_POST['lastname'] ?? '');
                $username = trim($_POST['username'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';
                $phone = trim($_POST['phone'] ?? '');
                $address = trim($_POST['address'] ?? '');
                
                // Kiểm tra dữ liệu
                if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
                    $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
                } elseif (strlen($firstname) < 2 || strlen($lastname) < 2) {
                    $error = 'Họ và tên phải có ít nhất 2 ký tự';
                } elseif (strlen($username) < 3 || strlen($username) > 20) {
                    $error = 'Tên đăng nhập phải từ 3-20 ký tự';
                } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                    $error = 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Email không hợp lệ';
                } elseif ($password !== $confirm_password) {
                    $error = 'Mật khẩu xác nhận không khớp';
                } elseif (strlen($password) < 8) {
                    $error = 'Mật khẩu phải có ít nhất 8 ký tự';
                } elseif ($phone && !preg_match('/^[0-9]{10,11}$/', $phone)) {
                    $error = 'Số điện thoại không hợp lệ';
                } else {
                    // Kiểm tra username và email đã tồn tại chưa
                    if ($this->usersModel->getUserByUsername($username)) {
                        $error = 'Tên đăng nhập đã tồn tại';
                    } elseif ($this->usersModel->getUserByEmail($email)) {
                        $error = 'Email đã được sử dụng';
                    } else {
                        // Tạo tài khoản mới
                        $userData = [
                            'username' => $username,
                            'email' => $email,
                            'password' => $password,
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'fullname' => $firstname . ' ' . $lastname,
                            'phone' => $phone,
                            'address' => $address,
                            'role' => 'user',
                            'status' => 'active'
                        ];
                        
                        $userId = $this->usersModel->addUser($userData);
                        if ($userId) {
                            $success = 'Đăng ký thành công! Vui lòng đăng nhập.';
                            // Reset form
                            $_POST = [];
                        } else {
                            $error = 'Có lỗi xảy ra, vui lòng thử lại';
                        }
                    }
                }
            }
        }
        
        include 'views/auth/register.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        $user = $this->usersModel->getUserById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'])) {
                $error = 'Token bảo mật không hợp lệ. Vui lòng thử lại.';
            } else {
                $firstname = trim($_POST['firstname'] ?? '');
                $lastname = trim($_POST['lastname'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $birthday = $_POST['birthday'] ?? '';
                $gender = $_POST['gender'] ?? '';
                
                // Validate input
                if (empty($firstname) || empty($lastname) || empty($email)) {
                    $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
                } elseif (strlen($firstname) < 2 || strlen($lastname) < 2) {
                    $error = 'Họ và tên phải có ít nhất 2 ký tự';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Email không hợp lệ';
                } elseif ($phone && !preg_match('/^[0-9]{10,11}$/', $phone)) {
                    $error = 'Số điện thoại không hợp lệ';
                } else {
                    $updateData = [
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'fullname' => $firstname . ' ' . $lastname,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $address,
                        'birthday' => $birthday,
                        'gender' => $gender
                    ];
                    
                    if ($this->usersModel->updateProfile($_SESSION['user_id'], $updateData)) {
                        $success = 'Cập nhật thông tin thành công!';
                        $user = $this->usersModel->getUserById($_SESSION['user_id']);
                    } else {
                        $error = 'Có lỗi xảy ra, vui lòng thử lại';
                    }
                }
            }
        }
        
        include 'views/auth/profile.php';
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        $user = $this->usersModel->getUserById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'])) {
                $error = 'Token bảo mật không hợp lệ. Vui lòng thử lại.';
            } else {
                $current_password = $_POST['current_password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';
                
                if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                    $error = 'Vui lòng nhập đầy đủ thông tin';
                } elseif ($new_password === $current_password) {
                    $error = 'Mật khẩu mới phải khác mật khẩu hiện tại';
                } elseif ($new_password !== $confirm_password) {
                    $error = 'Mật khẩu mới không khớp';
                } elseif (strlen($new_password) < 8) {
                    $error = 'Mật khẩu mới phải có ít nhất 8 ký tự';
                } else {
                    if (password_verify($current_password, $user['password'])) {
                        if ($this->usersModel->changePassword($_SESSION['user_id'], $new_password)) {
                            $success = 'Đổi mật khẩu thành công!';
                        } else {
                            $error = 'Có lỗi xảy ra, vui lòng thử lại';
                        }
                    } else {
                        $error = 'Mật khẩu hiện tại không đúng';
                    }
                }
            }
        }
        
        include 'views/auth/change-password.php';
    }
}
?>
