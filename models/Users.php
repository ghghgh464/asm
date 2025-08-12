<?php
// Connect class sẽ được autoload từ config.php

class Users extends Connect {
    public function __construct() {
        parent::__construct('users');
    }

    public function getAllUsers($limit = null, $offset = null) {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            if ($offset) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = [];
        if ($limit) {
            $params['limit'] = $limit;
            if ($offset) {
                $params['offset'] = $offset;
            }
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->fetchOne($sql, ['id' => $id]);
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        return $this->fetchOne($sql, ['email' => $email]);
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        return $this->fetchOne($sql, ['username' => $username]);
    }

    public function authenticateUser($email, $password) {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function addUser($data) {
        // Hash password trước khi lưu
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        // created_at sẽ được tự động set bởi database
        return $this->insert($data);
    }

    public function updateUser($id, $data) {
        // Hash password nếu có cập nhật
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']); // Không cập nhật password nếu trống
        }
        
        // updated_at sẽ được tự động set bởi database
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function deleteUser($id) {
        return $this->delete('id = :id', ['id' => $id]);
    }

    public function updateProfile($id, $data) {
        $allowed_fields = ['firstname', 'lastname', 'fullname', 'email', 'phone', 'address', 'birthday', 'gender', 'avatar'];
        $update_data = array_intersect_key($data, array_flip($allowed_fields));
        
        if (!empty($update_data)) {
            // updated_at sẽ được tự động set bởi database
            return $this->update($update_data, 'id = :id', ['id' => $id]);
        }
        return false;
    }

    public function changePassword($id, $new_password) {
        $data = [
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
            // updated_at sẽ được tự động set bởi database
        ];
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function getUserCount() {
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = $this->fetchOne($sql);
        return $result ? $result['count'] : 0;
    }

    public function getUsersByRole($role, $limit = null) {
        $sql = "SELECT * FROM users WHERE role = :role ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $params = ['role' => $role];
        if ($limit) {
            $params['limit'] = $limit;
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function searchUsers($keyword, $limit = null, $offset = null) {
        $sql = "SELECT * FROM users WHERE 
                username LIKE :keyword OR 
                email LIKE :keyword OR 
                fullname LIKE :keyword OR 
                firstname LIKE :keyword OR 
                lastname LIKE :keyword
                ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            if ($offset) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = ['keyword' => '%' . $keyword . '%'];
        if ($limit) {
            $params['limit'] = $limit;
            if ($offset) {
                $params['offset'] = $offset;
            }
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function countSearchResults($keyword) {
        $sql = "SELECT COUNT(*) as count FROM users WHERE 
                username LIKE :keyword OR 
                email LIKE :keyword OR 
                fullname LIKE :keyword OR 
                firstname LIKE :keyword OR 
                lastname LIKE :keyword";
        
        $result = $this->fetchOne($sql, ['keyword' => '%' . $keyword . '%']);
        return $result ? $result['count'] : 0;
    }
}
?>
