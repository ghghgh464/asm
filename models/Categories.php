<?php
// Connect class sẽ được autoload từ config.php

class Categories extends Connect {
    public function __construct() {
        parent::__construct('categories');
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->fetchAll($sql);
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        return $this->fetchOne($sql, ['id' => $id]);
    }

    public function getActiveCategories() {
        $sql = "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC";
        return $this->fetchAll($sql);
    }

    public function addCategory($name, $description = '', $status = 1) {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
            // created_at sẽ được tự động set bởi database
        ];
        return $this->insert($data);
    }

    public function updateCategory($id, $name, $description = '', $status = 1) {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status
            // updated_at sẽ được tự động set bởi database
        ];
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function deleteCategory($id) {
        return $this->delete('id = :id', ['id' => $id]);
    }

    public function getCategoryCount() {
        $sql = "SELECT COUNT(*) as count FROM categories";
        $result = $this->fetchOne($sql);
        return $result ? $result['count'] : 0;
    }
}
?>
