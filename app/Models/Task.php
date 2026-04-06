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
            $sql = "SELECT t.*, u.full_name as assigned_name 
                    FROM {$this->table} t
                    LEFT JOIN users u ON t.assigned_to = u.id
                    WHERE t.project_id = ? AND t.status = ? 
                    ORDER BY t.created_at DESC";
            return $this->db->fetchAll($sql, [$projectId, $status]);
        }
        
        $sql = "SELECT t.*, u.full_name as assigned_name 
                FROM {$this->table} t
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.project_id = ? 
                ORDER BY t.created_at DESC";
        return $this->db->fetchAll($sql, [$projectId]);
    }

    public function getAssigned($userId)
    {
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name, cu.full_name as created_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                LEFT JOIN users cu ON t.created_by = cu.id
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

    public function search($keyword, $filters = [], $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE (t.title LIKE ? OR t.description LIKE ?)";
        
        $params[] = "%{$keyword}%";
        $params[] = "%{$keyword}%";
        
        // Filter by status
        if (!empty($filters['status'])) {
            $sql .= " AND t.status = ?";
            $params[] = $filters['status'];
        }
        
        // Filter by project
        if (!empty($filters['project_id'])) {
            $sql .= " AND t.project_id = ?";
            $params[] = $filters['project_id'];
        }
        
        // Filter by assigned user
        if (!empty($filters['assigned_to'])) {
            $sql .= " AND t.assigned_to = ?";
            $params[] = $filters['assigned_to'];
        }
        
        $sql .= " ORDER BY t.due_date ASC LIMIT {$limit} OFFSET {$offset}";
        
        return $this->db->fetchAll($sql, $params);
    }

    public function searchAssigned($userId, $keyword, $filters = [], $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.assigned_to = ?
                AND (t.title LIKE ? OR t.description LIKE ?)";
        
        $params[] = $userId;
        $params[] = "%{$keyword}%";
        $params[] = "%{$keyword}%";
        
        // Filter by status
        if (!empty($filters['status'])) {
            $sql .= " AND t.status = ?";
            $params[] = $filters['status'];
        }
        
        // Filter by project
        if (!empty($filters['project_id'])) {
            $sql .= " AND t.project_id = ?";
            $params[] = $filters['project_id'];
        }
        
        $sql .= " ORDER BY t.due_date ASC LIMIT {$limit} OFFSET {$offset}";
        
        return $this->db->fetchAll($sql, $params);
    }

    // ==================== TASK MEMBER ASSIGNMENT ====================
    
    public function getAssignedMembers($taskId)
    {
        $sql = "SELECT u.* 
                FROM users u
                INNER JOIN task_members tm ON u.id = tm.user_id
                WHERE tm.task_id = ?
                ORDER BY u.full_name ASC";
        return $this->db->fetchAll($sql, [$taskId]);
    }

    public function assignMembers($taskId, $userIds = [])
    {
        // Clear existing assignments
        $deleteSql = "DELETE FROM task_members WHERE task_id = ?";
        $this->db->execute($deleteSql, [$taskId]);
        
        // Add new assignments
        if (!empty($userIds) && is_array($userIds)) {
            $userIds = array_filter($userIds); // Remove empty values
            
            foreach ($userIds as $userId) {
                $insertSql = "INSERT INTO task_members (task_id, user_id) VALUES (?, ?)";
                $this->db->execute($insertSql, [$taskId, $userId]);
            }
        }
        
        return true;
    }

    public function isMemberAssigned($taskId, $userId)
    {
        $sql = "SELECT id FROM task_members WHERE task_id = ? AND user_id = ?";
        $result = $this->db->fetchOne($sql, [$taskId, $userId]);
        return !empty($result);
    }

    public function unassignMember($taskId, $userId)
    {
        $sql = "DELETE FROM task_members WHERE task_id = ? AND user_id = ?";
        return $this->db->execute($sql, [$taskId, $userId]);
    }
}
