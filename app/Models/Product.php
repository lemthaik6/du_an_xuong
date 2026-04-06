<?php

namespace App\Models;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'stock', 'category', 'image', 'status'];

    public function getActiveProducts($page = 1, $limit = 12)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND stock > 0 ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        return $this->db->fetchAll($sql);
    }

    public function searchProducts($keyword, $page = 1, $limit = 12)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND stock > 0 AND (name LIKE ? OR description LIKE ?) ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $params = ["%{$keyword}%", "%{$keyword}%"];
        return $this->db->fetchAll($sql, $params);
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ? AND status = 'active'";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getTotalActiveProducts()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'active' AND stock > 0";
        $result = $this->db->fetchOne($sql);
        return $result['count'] ?? 0;
    }

    public function updateStock($id, $quantity)
    {
        $sql = "UPDATE {$this->table} SET stock = stock - ? WHERE id = ? AND stock >= ?";
        return $this->db->execute($sql, [$quantity, $id, $quantity]);
    }
}
