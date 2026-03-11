<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->auth->requireLogin();
        $this->auth->requireAdmin();
    }

    public function index()
    {
        $categories = $this->categoryModel->all();
        
        echo $this->render('categories/index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        echo $this->render('categories/form');
    }

    public function store()
    {
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền tên danh mục');
            $this->redirect('/du_an_xuong/public/categories/create');
            return;
        }

        $this->categoryModel->create([
            'name' => $post['name'],
            'description' => $post['description'],
            'slug' => $this->generateSlug($post['name']),
            'icon' => $post['icon'],
            'color' => $post['color'],
            'status' => 'active',
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo danh mục thành công');
        $this->redirect('/du_an_xuong/public/categories');
    }

    public function edit($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/categories');
        }

        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            $this->setFlash('error', 'Danh mục không tồn tại');
            $this->redirect('/du_an_xuong/public/categories');
        }

        echo $this->render('categories/form', ['category' => $category]);
    }

    public function update($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/categories');
        }

        $post = $this->getPost();
        
        $this->categoryModel->update($id, [
            'name' => $post['name'],
            'description' => $post['description'],
            'icon' => $post['icon'],
            'color' => $post['color'],
            'status' => $post['status']
        ]);

        $this->setFlash('success', 'Cập nhật danh mục thành công');
        $this->redirect('/du_an_xuong/public/categories');
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/categories');
        }

        $this->categoryModel->delete($id);

        $this->setFlash('success', 'Xóa danh mục thành công');
        $this->redirect('/du_an_xuong/public/categories');
    }

    private function generateSlug($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
