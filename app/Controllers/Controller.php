<?php

namespace App\Controllers;

use Src\Auth;

class Controller
{
    protected $auth;
    protected $viewPath = __DIR__ . '/../../views/';

    public function __construct()
    {
        $this->auth = new Auth();
    }

    protected function render($view, $data = [])
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
        include $this->viewPath . 'layout.php';
        $html = ob_get_clean();
        
        return $html;
    }

    protected function response($success = true, $message = '', $data = [])
    {
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function setFlash($type, $message)
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function getFlash()
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            if ($rule === 'required' && empty($data[$field] ?? null)) {
                $errors[$field] = "Trường này không được để trống";
            } elseif (strpos($rule, 'email') !== false && !filter_var($data[$field] ?? '', FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "Email không hợp lệ";
            } elseif (strpos($rule, 'min:') !== false) {
                $min = (int) str_replace('min:', '', $rule);
                if (strlen($data[$field] ?? '') < $min) {
                    $errors[$field] = "Tối thiểu {$min} ký tự";
                }
            }
        }

        return $errors;
    }

    protected function getPost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return [];
        }
        return $_POST;
    }

    protected function getGet()
    {
        return $_GET;
    }
}
