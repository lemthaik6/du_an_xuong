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

