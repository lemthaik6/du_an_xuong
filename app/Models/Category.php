<?php

namespace App\Models;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'status'];

    public function getCategories()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY name ASC";
        return $this->db->fetchAll($sql);
    }

    public function getCategoryWithCount($id)
    {
        $sql = "SELECT c.*, COUNT(p.id) as project_count
                FROM {$this->table} c
                LEFT JOIN projects p ON c.id = p.category_id
                WHERE c.id = ?
                GROUP BY c.id";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getAllCategories($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT c.*, COUNT(p.id) as project_count
                FROM {$this->table} c
                LEFT JOIN projects p ON c.id = p.category_id
                GROUP BY c.id
                ORDER BY c.name ASC
                LIMIT {$limit} OFFSET {$offset}";
        return $this->db->fetchAll($sql);
    }
}
