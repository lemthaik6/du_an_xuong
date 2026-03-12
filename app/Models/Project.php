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

    public function search($keyword, $filters = [], $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT p.*, c.name as category_name, u.full_name as assigned_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.assigned_to = u.id
                WHERE (p.name LIKE ? OR p.description LIKE ?)";
        
        $params[] = "%{$keyword}%";
        $params[] = "%{$keyword}%";
        
        // Filter by category
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
        }
        
        // Filter by status
        if (!empty($filters['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filters['status'];
        }
        
        // Filter by assigned user
        if (!empty($filters['assigned_to'])) {
            $sql .= " AND p.assigned_to = ?";
            $params[] = $filters['assigned_to'];
        }
        
        // Filter by budget range
        if (!empty($filters['budget_min'])) {
            $sql .= " AND p.budget >= ?";
            $params[] = $filters['budget_min'];
        }
        if (!empty($filters['budget_max'])) {
            $sql .= " AND p.budget <= ?";
            $params[] = $filters['budget_max'];
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT {$limit} OFFSET {$offset}";
        
        return $this->db->fetchAll($sql, $params);
    }

    public function searchByUser($userId, $keyword, $filters = [], $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT p.*, c.name as category_name, u.full_name as assigned_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.assigned_to = u.id
                WHERE (p.assigned_to = ? OR p.created_by = ?)
                AND (p.name LIKE ? OR p.description LIKE ?)";
        
        $params[] = $userId;
        $params[] = $userId;
        $params[] = "%{$keyword}%";
        $params[] = "%{$keyword}%";
        
        // Filter by category
        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
        }
        
        // Filter by status
        if (!empty($filters['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT {$limit} OFFSET {$offset}";
        
        return $this->db->fetchAll($sql, $params);
    }
}
