<?php

namespace App\Models;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['name', 'description', 'slug', 'category_id', 'status', 'start_date', 'end_date', 'budget', 'progress', 'team_id', 'created_by'];

    public function getProject($id)
    {
        $sql = "SELECT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
                WHERE p.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getByCategory($categoryId, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
                WHERE p.category_id = ? AND p.status != 'cancelled'
                ORDER BY p.created_at DESC
                LIMIT {$limit} OFFSET {$offset}";
        
        return $this->db->fetchAll($sql, [$categoryId]);
    }

    public function getByTeam($teamId)
    {
        $sql = "SELECT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
                WHERE p.team_id = ?
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql, [$teamId]);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT DISTINCT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
                LEFT JOIN team_members tm ON p.team_id = tm.team_id
                WHERE tm.user_id = ? OR p.created_by = ?
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql, [$userId, $userId]);
    }

    public function getByUserTeams($userId)
    {
        $sql = "SELECT DISTINCT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
                INNER JOIN team_members tm ON p.team_id = tm.team_id
                WHERE tm.user_id = ? OR p.created_by = ?
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
        
        $sql = "SELECT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
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
        
        // Filter by team
        if (!empty($filters['team_id'])) {
            $sql .= " AND p.team_id = ?";
            $params[] = $filters['team_id'];
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
        
        $sql = "SELECT DISTINCT p.*, c.name as category_name, t.name as team_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN teams t ON p.team_id = t.id
                INNER JOIN team_members tm ON p.team_id = tm.team_id
                WHERE (tm.user_id = ? OR p.created_by = ?)
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

    // ===== TEAMS MANAGEMENT =====
    
    /**
     * Lấy danh sách tất cả đội nhóm được phân công cho dự án
     */
    public function getAssignedTeams($projectId)
    {
        $sql = "SELECT t.* 
                FROM teams t
                INNER JOIN project_teams pt ON t.id = pt.team_id
                WHERE pt.project_id = ?
                ORDER BY t.name ASC";
        return $this->db->fetchAll($sql, [$projectId]);
    }

    /**
     * Phân công multiple teams cho dự án
     */
    public function assignTeams($projectId, $teamIds = [])
    {
        // Xóa các team cũ
        $this->db->delete('project_teams', ['project_id' => $projectId]);
        
        // Thêm các team mới
        if (!empty($teamIds) && is_array($teamIds)) {
            foreach ($teamIds as $teamId) {
                $this->db->insert('project_teams', [
                    'project_id' => $projectId,
                    'team_id' => $teamId
                ]);
            }
        }
        
        return true;
    }

    /**
     * Kiểm tra team có được phân công cho dự án không
     */
    public function isTeamAssigned($projectId, $teamId)
    {
        $sql = "SELECT id FROM project_teams WHERE project_id = ? AND team_id = ?";
        $result = $this->db->fetchOne($sql, [$projectId, $teamId]);
        return !empty($result);
    }

    /**
     * Hủy phân công team cho dự án
     */
    public function unassignTeam($projectId, $teamId)
    {
        return $this->db->delete('project_teams', [
            'project_id' => $projectId,
            'team_id' => $teamId
        ]);
    }
}
