<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->auth->requireLogin();
        $this->auth->requireAdmin();
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $result = $this->userModel->paginate($page, 10);
        
        echo $this->render('users/index', [
            'users' => $result['data'],
            'total' => $result['total'],
            'pages' => $result['pages'],
            'current_page' => $result['current_page']
        ]);
    }

    public function show($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/users');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->setFlash('error', 'Người dùng không tồn tại');
            $this->redirect('/du_an_xuong/public/users');
        }

        echo $this->render('users/show', ['user' => $user]);
    }

    public function create()
    {
        echo $this->render('users/form');
    }

    public function store()
    {
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'full_name' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đủ thông tin hợp lệ');
            $this->redirect('/du_an_xuong/public/users/create');
            return;
        }

        // Check if email exists
        if ($this->userModel->exists(['email' => $post['email']])) {
            $this->setFlash('error', 'Email này đã được sử dụng');
            $this->redirect('/du_an_xuong/public/users/create');
            return;
        }

        $this->userModel->create([
            'username' => $post['email'],
            'email' => $post['email'],
            'password' => md5($post['password']),
            'full_name' => $post['full_name'],
            'phone' => !empty($post['phone']) ? $post['phone'] : null,
            'role' => $post['role'],
            'status' => 'active'
        ]);

        $this->setFlash('success', 'Tạo người dùng thành công');
        $this->redirect('/du_an_xuong/public/users');
    }

    public function edit($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/users');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->setFlash('error', 'Người dùng không tồn tại');
            $this->redirect('/du_an_xuong/public/users');
        }

        echo $this->render('users/form', ['user' => $user]);
    }

    public function update($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/users');
        }

        $post = $this->getPost();
        
        $this->userModel->update($id, [
            'full_name' => $post['full_name'],
            'phone' => !empty($post['phone']) ? $post['phone'] : null,
            'role' => $post['role'],
            'status' => $post['status']
        ]);

        $this->setFlash('success', 'Cập nhật người dùng thành công');
        $this->redirect('/du_an_xuong/public/users/' . $id);
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/users');
        }

        $this->userModel->delete($id);

        $this->setFlash('success', 'Xóa người dùng thành công');
        $this->redirect('/du_an_xuong/public/users');
    }
}
