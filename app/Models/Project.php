<?php

namespace App\Models;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['name', 'description', 'slug', 'category_id', 'status', 'start_date', 'end_date', 'budget', 'progress', 'assigned_to', 'created_by'];

    public function getProject($id)
    {
        $sql = "SELECT p.*, c.name as category_name, u.full_name as assigned_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.assigned_to = u.id
                WHERE p.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getByCategory($categoryId, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT p.*, c.name as category_name, u.full_name as assigned_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.assigned_to = u.id
                WHERE p.category_id = ? AND p.status != 'cancelled'
                ORDER BY p.created_at DESC
                LIMIT {$limit} OFFSET {$offset}";
        
        return $this->db->fetchAll($sql, [$categoryId]);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT p.*, c.name as category_name, u.full_name as assigned_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.assigned_to = u.id
                WHERE p.assigned_to = ? OR p.created_by = ? 
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql, [$userId, $userId]);
    }

    public function getActive()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status IN ('planning', 'in_progress') ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    public function updateProgress($id)
    {
        $sql = "UPDATE {$this->table} 
                SET progress = (
                    SELECT ROUND(AVG(progress), 0)
                    FROM tasks
                    WHERE project_id = {$id} AND status != 'completed'
                )
                WHERE id = {$id}";
        return $this->db->query($sql);
    }

    public function getStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'planning' THEN 1 ELSE 0 END) as planning,
                    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed
                FROM {$this->table}";
        return $this->db->fetchOne($sql);
    }
}
