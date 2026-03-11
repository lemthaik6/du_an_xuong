<?php

namespace App\Models;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = ['task_id', 'file_name', 'file_path', 'file_size', 'file_type', 'uploaded_by'];

    public function getByTask($taskId)
    {
        $sql = "SELECT a.*, u.full_name as uploaded_by_name
                FROM {$this->table} a
                LEFT JOIN users u ON a.uploaded_by = u.id
                WHERE a.task_id = ?
                ORDER BY a.created_at DESC";
        return $this->db->fetchAll($sql, [$taskId]);
    }

    public function getRecent($limit = 5)
    {
        $sql = "SELECT a.*, u.full_name as uploaded_by_name, t.title as task_title
                FROM {$this->table} a
                LEFT JOIN users u ON a.uploaded_by = u.id
                LEFT JOIN tasks t ON a.task_id = t.id
                ORDER BY a.created_at DESC
                LIMIT {$limit}";
        return $this->db->fetchAll($sql);
    }

    public function deleteByPath($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
        $sql = "DELETE FROM {$this->table} WHERE file_path = ?";
        return $this->db->execute($sql, [$path]);
    }
}
