<?php

namespace App\Models;

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

    public function getRecent($limit = 5)
    {
        $sql = "SELECT c.*, u.full_name, t.title as task_title
                FROM {$this->table} c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN tasks t ON c.task_id = t.id
                ORDER BY c.created_at DESC
                LIMIT {$limit}";
        return $this->db->fetchAll($sql);
    }
}
