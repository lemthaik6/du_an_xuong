<?php

namespace Src;

class Auth
{
    private $db;
    private $sessionTimeout = 3600; // 1 hour

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function login($email, $password)
    {
        try {
            $user = $this->db->fetchOne(
                "SELECT id, username, email, full_name, role, status FROM users WHERE email = ? AND password = ?",
                [$email, md5($password)]
            );

            if (!$user) {
                return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
            }

            if ($user['status'] !== 'active') {
                return ['success' => false, 'message' => 'Tài khoản không được kích hoạt'];
            }

            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = time();

            // Log activity
            $this->logActivity($user['id'], 'LOGIN', 'USER', $user['id']);

            return ['success' => true, 'message' => 'Đăng nhập thành công', 'user' => $user];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user_id'])) {
            $this->logActivity($_SESSION['user_id'], 'LOGOUT', 'USER', $_SESSION['user_id']);
        }
        
        session_destroy();
        return ['success' => true, 'message' => 'Đã đăng xuất'];
    }

    public function register($data)
    {
        try {
            // Validate
            if (empty($data['email']) || empty($data['password']) || empty($data['full_name'])) {
                return ['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin'];
            }

            // Check if email exists
            $existing = $this->db->fetchOne(
                "SELECT id FROM users WHERE email = ?",
                [$data['email']]
            );

            if ($existing) {
                return ['success' => false, 'message' => 'Email đã được đăng ký'];
            }

            // Insert user
            $userId = $this->db->insert('users', [
                'username' => $data['email'],
                'email' => $data['email'],
                'password' => md5($data['password']),
                'full_name' => $data['full_name'],
                'phone' => $data['phone'] ?? null,
                'role' => 'user',
                'status' => 'active'
            ]);

            // Create account
            $this->db->insert('accounts', [
                'user_id' => $userId,
                'subscription_type' => 'free',
                'subscription_status' => 'active'
            ]);

            return ['success' => true, 'message' => 'Đăng ký thành công', 'user_id' => $userId];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function getId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function getRole()
    {
        return $_SESSION['role'] ?? null;
    }

    public function getUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'],
            'full_name' => $_SESSION['full_name'],
            'role' => $_SESSION['role']
        ];
    }

    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header('Location: /du_an_xuong/public/login');
            exit;
        }
    }

    public function requireAdmin()
    {
        if (!$this->isAdmin()) {
            header('Location: /du_an_xuong/public/403');
            exit;
        }
    }

    public function changePassword($userId, $oldPassword, $newPassword)
    {
        try {
            $user = $this->db->fetchOne(
                "SELECT password FROM users WHERE id = ?",
                [$userId]
            );

            if (!$user || $user['password'] !== md5($oldPassword)) {
                return ['success' => false, 'message' => 'Mật khẩu cũ không đúng'];
            }

            $this->db->update('users', 
                ['password' => md5($newPassword)],
                ['id' => $userId]
            );

            $this->logActivity($userId, 'CHANGE_PASSWORD', 'USER', $userId);

            return ['success' => true, 'message' => 'Đổi mật khẩu thành công'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function logActivity($userId, $action, $entityType, $entityId, $oldValue = null, $newValue = null)
    {
        try {
            $this->db->insert('activity_logs', [
                'user_id' => $userId,
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'old_value' => $oldValue ? json_encode($oldValue) : null,
                'new_value' => $newValue ? json_encode($newValue) : null
            ]);
        } catch (\Exception $e) {
            // Log errors silently
        }
    }
}
