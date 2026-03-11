<?php

namespace App\Models;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['title', 'description', 'project_id', 'assigned_to', 'status', 'due_date', 'progress', 'created_by'];

    public function getTask($id)
    {
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name, cu.full_name as created_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                LEFT JOIN users cu ON t.created_by = cu.id
                WHERE t.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getByProject($projectId, $status = null)
    {
        if ($status) {
            $sql = "SELECT * FROM {$this->table} WHERE project_id = ? AND status = ? ORDER BY created_at DESC";
            return $this->db->fetchAll($sql, [$projectId, $status]);
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE project_id = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($sql, [$projectId]);
    }

    public function getAssigned($userId)
    {
        $sql = "SELECT t.*, p.name as project_name 
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                WHERE t.assigned_to = ? AND t.status != 'completed'
                ORDER BY t.due_date ASC";
        return $this->db->fetchAll($sql, [$userId]);
    }

    public function getOverdue()
    {
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.due_date < CURDATE() AND t.status IN ('todo', 'in_progress')
                ORDER BY t.due_date ASC";
        return $this->db->fetchAll($sql);
    }

    public function getUpcoming($days = 7)
    {
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL {$days} DAY)
                AND t.status IN ('todo', 'in_progress')
                ORDER BY t.due_date ASC";
        return $this->db->fetchAll($sql);
    }

    public function getStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'todo' THEN 1 ELSE 0 END) as todo,
                    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed
                FROM {$this->table}";
        return $this->db->fetchOne($sql);
    }
}
