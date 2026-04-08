<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    // ===== ADMIN MANAGEMENT =====
    public function index()
    {
        $this->auth->requireAdmin();
        
        $page = $_GET['page'] ?? 1;
        $products = $this->productModel->paginate($page, 10);

        echo $this->render('products/admin_index', [
            'products' => $products['data'],
            'total' => $products['total'],
            'pages' => $products['pages'],
            'current_page' => $page
        ]);
    }

    public function create()
    {
        $this->auth->requireAdmin();
        echo $this->render('products/admin_form', ['product' => null]);
    }

    public function store()
    {
        $this->auth->requireAdmin();
        
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đúng thông tin');
            $this->redirect('/du_an_xuong/public/products/create');
            return;
        }

        $data = [
            'name' => $post['name'],
            'description' => $post['description'],
            'price' => $post['price'],
            'stock' => $post['stock'],
            'category' => $post['category'] ?? null,
            'status' => $post['status'] ?? 'active'
        ];

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $imagePath = $this->uploadImage($_FILES['image']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
        }

        $productId = $this->productModel->create($data);

        if ($productId) {
            $this->setFlash('success', 'Tạo sản phẩm thành công');
            $this->redirect('/du_an_xuong/public/products');
        } else {
            $this->setFlash('error', 'Lỗi khi tạo sản phẩm');
            $this->redirect('/du_an_xuong/public/products/create');
        }
    }

    public function edit($id)
    {
        $this->auth->requireAdmin();
        
        $product = $this->productModel->find($id);
        
        if (!$product) {
            $this->setFlash('error', 'Sản phẩm không tồn tại');
            $this->redirect('/du_an_xuong/public/products');
            return;
        }

        echo $this->render('products/admin_form', ['product' => $product]);
    }

    public function update($id)
    {
        $this->auth->requireAdmin();
        
        $product = $this->productModel->find($id);
        
        if (!$product) {
            $this->setFlash('error', 'Sản phẩm không tồn tại');
            $this->redirect('/du_an_xuong/public/products');
            return;
        }

        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đúng thông tin');
            $this->redirect("/du_an_xuong/public/products/$id/edit");
            return;
        }

        $data = [
            'name' => $post['name'],
            'description' => $post['description'],
            'price' => $post['price'],
            'stock' => $post['stock'],
            'category' => $post['category'] ?? null,
            'status' => $post['status'] ?? 'active'
        ];

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            // Delete old image if exists
            if (!empty($product['image']) && file_exists(__DIR__ . '/../../' . $product['image'])) {
                unlink(__DIR__ . '/../../' . $product['image']);
            }
            
            $imagePath = $this->uploadImage($_FILES['image']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
        }

        $this->productModel->update($id, $data);
        
        $this->setFlash('success', 'Cập nhật sản phẩm thành công');
        $this->redirect('/du_an_xuong/public/products');
    }

    public function delete($id)
    {
        $this->auth->requireAdmin();
        
        $product = $this->productModel->find($id);
        
        if (!$product) {
            $this->setFlash('error', 'Sản phẩm không tồn tại');
            $this->redirect('/du_an_xuong/public/products');
            return;
        }

        $this->productModel->delete($id);
        
        $this->setFlash('success', 'Xóa sản phẩm thành công');
        $this->redirect('/du_an_xuong/public/products');
    }

    /**
     * Handle image upload for products
     * @param array $file File from $_FILES
     * @return string|null Image path or null if upload failed
     */
    private function uploadImage($file)
    {
        // Validate file
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = basename($file['name']);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            $this->setFlash('warning', 'Chỉ hỗ trợ file ảnh: JPG, PNG, GIF');
            return null;
        }
        
        if ($file['size'] > 5 * 1024 * 1024) {
            $this->setFlash('warning', 'Kích thước file tối đa là 5MB');
            return null;
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->setFlash('warning', 'Lỗi khi upload file');
            return null;
        }
        
        // Create upload directory in public/uploads/products
        $uploadDir = __DIR__ . '/../../public/uploads/products/';
        if (!is_dir($uploadDir)) {
            if (!@mkdir($uploadDir, 0777, true)) {
                $this->setFlash('warning', 'Không thể tạo thư mục upload');
                return null;
            }
        }
        
        $newFilename = 'product_' . time() . '_' . rand(10000, 99999) . '.' . $ext;
        $uploadPath = $uploadDir . $newFilename;
        
        if (@move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Return web-accessible path
            return '/uploads/products/' . $newFilename;
        } else {
            $this->setFlash('warning', 'Lỗi khi lưu file upload');
            return null;
        }
    }

    // ===== CUSTOMER SHOP =====
    public function shop()
    {
        $this->auth->requireLogin();
        
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';

        if (!empty($search)) {
            $products = $this->productModel->searchProducts($search, $page, 12);
        } else {
            $products = $this->productModel->getActiveProducts($page, 12);
        }

        $total = $this->productModel->getTotalActiveProducts();
        $pages = ceil($total / 12);

        echo $this->render('products/shop', [
            'products' => $products,
            'current_page' => $page,
            'pages' => $pages,
            'search' => $search,
            'total' => $total
        ]);
    }

    public function details($id)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            $this->redirect('/du_an_xuong/public/shop');
            return;
        }

        echo $this->render('products/details', [
            'product' => $product
        ]);
    }
}

