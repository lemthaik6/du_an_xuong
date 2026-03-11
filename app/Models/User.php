<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'full_name', 'phone', 'avatar', 'role', 'status'];
    protected $hidden = ['password'];

    public function getProfile($id)
    {
        $sql = "SELECT u.*, a.subscription_type, a.subscription_status, a.balance 
                FROM {$this->table} u 
                LEFT JOIN accounts a ON u.id = a.user_id 
                WHERE u.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getByEmail($email)
    {
        return $this->findBy('email', $email);
    }

    public function updateProfile($id, $data)
    {
        $allowedFields = ['full_name', 'phone', 'avatar'];
        $validData = array_intersect_key($data, array_flip($allowedFields));
        return $this->update($id, $validData);
    }

    public function getAllUsers($page = 1, $limit = 10)
    {
        return $this->paginate($page, $limit);
    }

    public function getAdmins()
    {
        return $this->findAllBy('role', 'admin');
    }

    public function getRegularUsers()
    {
        return $this->findAllBy('role', 'user');
    }
}
