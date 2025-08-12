<?php
// Connect class sẽ được autoload từ config.php

class Comments extends Connect {
    public function __construct() {
        parent::__construct('comments');
    }

    public function getAllComments($limit = null, $offset = null) {
        $sql = "SELECT c.*, u.fullname as user_fullname, p.name as product_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN products p ON c.product_id = p.id 
                ORDER BY c.created_at DESC";
        
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

    public function getCommentById($id) {
        $sql = "SELECT c.*, u.fullname as user_fullname, p.name as product_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.id = :id";
        return $this->fetchOne($sql, ['id' => $id]);
    }

    public function getCommentsByProduct($product_id, $status = 'approved', $limit = null) {
        $status_condition = '';
        if ($status === 'approved') {
            $status_condition = 'AND c.status = 1';
        } elseif ($status === 'pending') {
            $status_condition = 'AND c.status = 0';
        }
        
        $sql = "SELECT c.*, u.fullname as user_fullname, u.avatar as user_avatar 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.product_id = :product_id {$status_condition}
                ORDER BY c.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $params = ['product_id' => $product_id];
        if ($limit) {
            $params['limit'] = $limit;
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function getCommentsByUser($user_id, $limit = null) {
        $sql = "SELECT c.*, p.name as product_name 
                FROM comments c 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = :user_id 
                ORDER BY c.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $params = ['user_id' => $user_id];
        if ($limit) {
            $params['limit'] = $limit;
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function addComment($data) {
        // created_at sẽ được tự động set bởi database
        return $this->insert($data);
    }

    public function updateComment($id, $data) {
        // updated_at sẽ được tự động set bởi database
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function deleteComment($id) {
        return $this->delete('id = :id', ['id' => $id]);
    }

    public function approveComment($id) {
        $data = ['status' => 1];
        // updated_at sẽ được tự động set bởi database
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function rejectComment($id) {
        $data = ['status' => 0];
        // updated_at sẽ được tự động set bởi database
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function getCommentCount() {
        $sql = "SELECT COUNT(*) as count FROM comments";
        $result = $this->fetchOne($sql);
        return $result ? $result['count'] : 0;
    }

    public function getCommentCountByProduct($product_id) {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE product_id = :product_id AND status = 1";
        $result = $this->fetchOne($sql, ['product_id' => $product_id]);
        return $result ? $result['count'] : 0;
    }

    public function getPendingComments() {
        $sql = "SELECT c.*, u.fullname as user_fullname, p.name as product_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.status = 0 
                ORDER BY c.created_at ASC";
        return $this->fetchAll($sql);
    }

    public function getCommentCountByStatus($status) {
        $status_value = ($status === 'approved') ? 1 : 0;
        $sql = "SELECT COUNT(*) as count FROM comments WHERE status = :status";
        $result = $this->fetchOne($sql, ['status' => $status_value]);
        return $result ? $result['count'] : 0;
    }
}
?>
