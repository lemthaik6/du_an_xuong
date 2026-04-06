<?php

namespace App\Models;

class Team extends Model
{
    protected $table = 'teams';
    protected $fillable = ['name', 'description', 'leader_id', 'status', 'created_by'];

    public function getTeam($id)
    {
        $sql = "SELECT t.*, u.full_name as leader_name,
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                WHERE t.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getTeams()
    {
        $sql = "SELECT t.*, u.full_name as leader_name,
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                WHERE t.status = 'active'
                ORDER BY t.name ASC";
        return $this->db->fetchAll($sql);
    }

    public function getAllTeamsForAdmin()
    {
        $sql = "SELECT t.*, u.full_name as leader_name,
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                ORDER BY t.name ASC";
        return $this->db->fetchAll($sql);
    }

    public function getAllTeams($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT t.*, u.full_name as leader_name,
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                ORDER BY t.name ASC
                LIMIT {$limit} OFFSET {$offset}";
        return $this->db->fetchAll($sql);
    }

    public function getTeamMembers($teamId)
    {
        $sql = "SELECT u.id, u.username, u.email, u.full_name, u.phone, u.role, u.status,
                tm.id as team_member_id, tm.position, tm.joined_at 
                FROM users u
                INNER JOIN team_members tm ON u.id = tm.user_id
                WHERE tm.team_id = ?
                ORDER BY u.full_name ASC";
        $result = $this->db->fetchAll($sql, [$teamId]);
        return is_array($result) ? $result : [];
    }

    public function addMember($teamId, $userId, $position = null)
    {
        $sql = "INSERT INTO team_members (team_id, user_id, position, joined_at) VALUES (?, ?, ?, NOW())";
        return $this->db->execute($sql, [$teamId, $userId, $position]);
    }

    public function removeMember($teamId, $userId)
    {
        $sql = "DELETE FROM team_members WHERE team_id = ? AND user_id = ?";
        return $this->db->execute($sql, [$teamId, $userId]);
    }

    public function isUserMember($teamId, $userId)
    {
        $sql = "SELECT COUNT(*) as count FROM team_members WHERE team_id = ? AND user_id = ?";
        $result = $this->db->fetchOne($sql, [$teamId, $userId]);
        return $result['count'] > 0;
    }

    public function getTeamsWithMembershipStatus($userId)
    {
        $sql = "SELECT t.*, u.full_name as leader_name,
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count,
                (CASE WHEN EXISTS(SELECT 1 FROM team_members WHERE team_id = t.id AND user_id = ?) THEN 1 ELSE 0 END) as is_member
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                ORDER BY t.name ASC";
        return $this->db->fetchAll($sql, [$userId]);
    }

    // ==================== TASK ASSIGNMENT FOR TEAM ====================
    
    public function getProjectsForTeam($teamId)
    {
        $sql = "SELECT p.* FROM projects p
                INNER JOIN project_teams pt ON p.id = pt.project_id
                WHERE pt.team_id = ?
                ORDER BY p.name ASC";
        return $this->db->fetchAll($sql, [$teamId]);
    }

    public function getTasksForTeam($teamId)
    {
        $sql = "SELECT t.*, p.name as project_name, u.full_name as assigned_name
                FROM tasks t
                INNER JOIN projects p ON t.project_id = p.id
                INNER JOIN project_teams pt ON p.id = pt.project_id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE pt.team_id = ?
                ORDER BY t.title ASC";
        return $this->db->fetchAll($sql, [$teamId]);
    }
}
