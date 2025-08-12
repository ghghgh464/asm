<?php
// Connect class sẽ được autoload từ config.php

class Products extends Connect {
    public static function all() {
        $instance = new self();
        return $instance->getAllProducts();
    }
    public static function find($id) {
        $instance = new self();
        return $instance->getProductById($id);
    }
    public static function create($name, $price, $category, $image) {
        $data = [
            'name' => $name,
            'price' => $price,
            'category' => $category,
            'image' => $image,
            'status' => 1
        ];
        $instance = new self();
        return $instance->addProduct($data);
    }
    public static function updateProductStatic($id, $name, $price, $category, $image) {
        $data = [
            'name' => $name,
            'price' => $price,
            'category' => $category,
            'image' => $image
        ];
        $instance = new self();
        return $instance->updateProduct($id, $data);
    }
    public static function deleteProductStatic($id) {
        $instance = new self();
        return $instance->deleteProduct($id);
    }
    public function __construct() {
        parent::__construct('products');
    }

    public function getAllProducts($limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 1
                ORDER BY p.created_at DESC";
        
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

    public function getProductById($id) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        return $this->fetchOne($sql, ['id' => $id]);
    }

    public function getProductsByCategory($category_id, $limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id AND p.status = 1 
                ORDER BY p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            if ($offset) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = ['category_id' => $category_id];
        if ($limit) {
            $params['limit'] = $limit;
            if ($offset) {
                $params['offset'] = $offset;
            }
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function getFeaturedProducts($limit = 8) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.featured = 1 AND p.status = 1 
                ORDER BY p.created_at DESC 
                LIMIT :limit";
        return $this->fetchAll($sql, ['limit' => $limit]);
    }

    public function searchProducts($keyword, $limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE (p.name LIKE :keyword OR p.description LIKE :keyword) 
                AND p.status = 1 
                ORDER BY p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            if ($offset) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = ['keyword' => "%{$keyword}%"];
        if ($limit) {
            $params['limit'] = $limit;
            if ($offset) {
                $params['offset'] = $offset;
            }
        }
        
        return $this->fetchAll($sql, $params);
    }

    public function addProduct($data) {
        // created_at sẽ được tự động set bởi database
        return $this->insert($data);
    }

    public function updateProduct($id, $data) {
        // updated_at sẽ được tự động set bởi database
        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function deleteProduct($id) {
        return $this->delete('id = :id', ['id' => $id]);
    }

    public function getProductCount() {
        $sql = "SELECT COUNT(*) as count FROM products";
        $result = $this->fetchOne($sql);
        return $result ? $result['count'] : 0;
    }

    public function getProductCountByCategory($category_id) {
        $sql = "SELECT COUNT(*) as count FROM products WHERE category_id = :category_id";
        $result = $this->fetchOne($sql, ['category_id' => $category_id]);
        return $result ? $result['count'] : 0;
    }

    public function countAllProducts() {
        $sql = "SELECT COUNT(*) as count FROM products WHERE status = 1";
        $result = $this->fetchOne($sql);
        return $result ? $result['count'] : 0;
    }

    public function countProductsByCategory($category_id) {
        $sql = "SELECT COUNT(*) as count FROM products WHERE category_id = :category_id AND status = 1";
        $result = $this->fetchOne($sql, ['category_id' => $category_id]);
        return $result ? $result['count'] : 0;
    }

    public function countSearchResults($keyword) {
        $sql = "SELECT COUNT(*) as count FROM products 
                WHERE (name LIKE :keyword OR description LIKE :keyword) AND status = 1";
        $result = $this->fetchOne($sql, ['keyword' => "%{$keyword}%"]);
        return $result ? $result['count'] : 0;
    }
}
?>
