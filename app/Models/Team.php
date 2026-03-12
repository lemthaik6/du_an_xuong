<?php

namespace App\Models;

class Team extends Model
{
    protected $table = 'teams';
    protected $fillable = ['name', 'description', 'leader_id', 'status', 'created_by'];

    public function getTeam($id)
    {
        $sql = "SELECT t.*, u.full_name as leader_name, COUNT(tm.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                LEFT JOIN team_members tm ON t.id = tm.team_id
                WHERE t.id = ?
                GROUP BY t.id";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getTeams()
    {
        $sql = "SELECT t.*, u.full_name as leader_name, COUNT(tm.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                LEFT JOIN team_members tm ON t.id = tm.team_id
                WHERE t.status = 'active'
                GROUP BY t.id
                ORDER BY t.name ASC";
        return $this->db->fetchAll($sql);
    }

    public function getAllTeams($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT t.*, u.full_name as leader_name, COUNT(tm.id) as member_count
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                LEFT JOIN team_members tm ON t.id = tm.team_id
                GROUP BY t.id
                ORDER BY t.name ASC
                LIMIT {$limit} OFFSET {$offset}";
        return $this->db->fetchAll($sql);
    }

    public function getTeamMembers($teamId)
    {
        $sql = "SELECT u.*, tm.id as team_member_id, tm.position, tm.joined_at FROM users u
                INNER JOIN team_members tm ON u.id = tm.user_id
                WHERE tm.team_id = ?
                ORDER BY u.full_name ASC";
        return $this->db->fetchAll($sql, [$teamId]);
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
}
