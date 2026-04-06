<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    protected function renderAuth($view, $data = [])
    {
        extract($data);
        $baseUrl = defined('APP_BASE_URL') ? APP_BASE_URL : '/du_an_xuong/public';
        
        $file = $this->viewPath . $view . '.php';
        
        if (!file_exists($file)) {
            die("View not found: {$file}");
        }

        ob_start();
        include $file;
        $content = ob_get_clean();
        
        // Get flash messages if any
        $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        if (isset($_SESSION['flash'])) {
            unset($_SESSION['flash']);
        }
        
        ob_start();
        include $this->viewPath . 'layouts/auth-layout.php';
        $html = ob_get_clean();
        
        return $html;
    }

    public function loginPage()
    {
        if ($this->auth->isLoggedIn()) {
            $this->redirect('/du_an_xuong/public/dashboard');
        }
        
        $flash = $this->getFlash();
        echo $this->renderAuth('auth/login', ['flash' => $flash]);
    }

    public function register()
    {
        if ($this->auth->isLoggedIn()) {
            $this->redirect('/du_an_xuong/public/dashboard');
        }
        
        $flash = $this->getFlash();
        echo $this->renderAuth('auth/register', ['flash' => $flash]);
    }

    public function handleLogin()
    {
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đủ thông tin');
            $this->redirect('/du_an_xuong/public/login');
            return;
        }

        $result = $this->auth->login($post['email'], $post['password']);

        if ($result['success']) {
            $this->setFlash('success', 'Đăng nhập thành công');
            $this->redirect('/du_an_xuong/public/dashboard');
        } else {
            $this->setFlash('error', $result['message']);
            $this->redirect('/du_an_xuong/public/login');
        }
    }

    public function handleRegister()
    {
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'full_name' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đủ thông tin hợp lệ');
            $this->redirect('/du_an_xuong/public/register');
            return;
        }

        $result = $this->auth->register($post);

        if ($result['success']) {
            $this->setFlash('success', 'Đăng ký thành công, vui lòng đăng nhập');
            $this->redirect('/du_an_xuong/public/login');
        } else {
            $this->setFlash('error', $result['message']);
            $this->redirect('/du_an_xuong/public/register');
        }
    }

    public function logout()
    {
        $this->auth->logout();
        $this->setFlash('success', 'Đã đăng xuất');
        $this->redirect('/du_an_xuong/public/login');
    }

    public function profile()
    {
        $this->auth->requireLogin();
        
        $user = $this->userModel->getProfile($this->auth->getId());
        echo $this->render('auth/profile', ['user' => $user]);
    }

    public function editProfile()
    {
        $this->auth->requireLogin();
        
        $user = $this->userModel->find($this->auth->getId());
        echo $this->render('auth/edit_profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        $this->auth->requireLogin();
        
        $post = $this->getPost();
        
        $this->userModel->updateProfile($this->auth->getId(), [
            'full_name' => $post['full_name'],
            'phone' => $post['phone']
        ]);

        $this->setFlash('success', 'Cập nhật hồ sơ thành công');
        $this->redirect('/du_an_xuong/public/profile');
    }

    public function changePassword()
    {
        $this->auth->requireLogin();
        echo $this->render('auth/change_password');
    }

    public function updatePassword()
    {
        $this->auth->requireLogin();
        
        $post = $this->getPost();
        
        // Validate that new password and confirm password match
        if ($post['new_password'] !== $post['confirm_password']) {
            $this->setFlash('error', 'Mật khẩu mới và xác nhận không trùng khớp');
            $this->redirect('/du_an_xuong/public/profile/change-password');
            return;
        }
        
        $result = $this->auth->changePassword(
            $this->auth->getId(),
            $post['old_password'],
            $post['new_password']
        );

        if ($result['success']) {
            $this->setFlash('success', 'Đổi mật khẩu thành công');
        } else {
            $this->setFlash('error', $result['message']);
        }

        $this->redirect('/du_an_xuong/public/profile');
    }
}
