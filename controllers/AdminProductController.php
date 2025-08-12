<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tf/models/Products.php';

class AdminProductController {
    public function index() {
        $products = Products::all();
        include $_SERVER['DOCUMENT_ROOT'] . '/tf/views/admin/products.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/tf/uploads/' . $image);
            }
            Products::create($name, $price, $category, $image);
            header('Location: index.php?action=admin-products');
            exit;
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/tf/views/admin/add_product.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $product = Products::find($id);
        if (!$product) {
            header('Location: index.php?action=admin-products');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $image = $product['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/tf/uploads/' . $image);
            }
            Products::updateProductStatic($id, $name, $price, $category, $image);
            header('Location: index.php?action=admin-products');
            exit;
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/tf/views/admin/edit_product.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        Products::deleteProductStatic($id);
        header('Location: index.php?action=admin-products');
        exit;
    }
}
