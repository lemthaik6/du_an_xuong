<?php

namespace App\Models;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'slug', 'icon', 'color', 'status', 'created_by'];

    public function getActive()
    {
        return $this->findAllBy('status', 'active');
    }

    public function getBySlug($slug)
    {
        return $this->findBy('slug', $slug);
    }
}

class Team extends Model
{
    protected $table = 'teams';
    protected $fillable = ['name', 'description', 'leader_id', 'status', 'created_by'];

    public function getTeam($id)
    {
        $sql = "SELECT t.*, u.full_name as leader_name
                FROM {$this->table} t
                LEFT JOIN users u ON t.leader_id = u.id
                WHERE t.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function getMembers($teamId)
    {
        $sql = "SELECT u.*, tm.position
                FROM team_members tm
                LEFT JOIN users u ON tm.user_id = u.id
                WHERE tm.team_id = ?";
        return $this->db->fetchAll($sql, [$teamId]);
    }

    public function addMember($teamId, $userId, $position = null)
    {
        return $this->db->insert('team_members', [
            'team_id' => $teamId,
            'user_id' => $userId,
            'position' => $position
        ]);
    }

    public function removeMember($teamId, $userId)
    {
        return $this->db->delete('team_members', ['team_id' => $teamId, 'user_id' => $userId]);
    }
}

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['task_id', 'user_id', 'content'];

    public function getByTask($taskId)
    {
        $sql = "SELECT c.*, u.full_name, u.avatar
                FROM {$this->table} c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.task_id = ?
                ORDER BY c.created_at DESC";
        return $this->db->fetchAll($sql, [$taskId]);
    }
}

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = ['task_id', 'project_id', 'file_name', 'file_path', 'file_size', 'uploaded_by'];

    public function getByTask($taskId)
    {
        $sql = "SELECT a.*, u.full_name
                FROM {$this->table} a
                LEFT JOIN users u ON a.uploaded_by = u.id
                WHERE a.task_id = ?
                ORDER BY a.created_at DESC";
        return $this->db->fetchAll($sql, [$taskId]);
    }

    public function getByProject($projectId)
    {
        $sql = "SELECT a.*, u.full_name
                FROM {$this->table} a
                LEFT JOIN users u ON a.uploaded_by = u.id
                WHERE a.project_id = ?
                ORDER BY a.created_at DESC";
        return $this->db->fetchAll($sql, [$projectId]);
    }
}

class Account extends Model
{
    protected $table = 'accounts';
    protected $fillable = ['user_id', 'subscription_type', 'subscription_status', 'subscription_start', 'subscription_end', 'balance', 'total_spent'];

    public function getByUser($userId)
    {
        return $this->findBy('user_id', $userId);
    }
}
