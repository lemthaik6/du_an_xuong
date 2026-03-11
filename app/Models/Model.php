<?php

namespace App\Models;

use Src\Database;

class Model
{
    protected $db;
    protected $table;
    protected $fillable = [];
    protected $hidden = ['password'];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all($orderBy = 'id', $order = 'DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy} {$order}";
        return $this->db->fetchAll($sql);
    }

    public function paginate($page = 1, $limit = 10, $orderBy = 'id')
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy} DESC LIMIT {$limit} OFFSET {$offset}";
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table}";
        $countResult = $this->db->fetchOne($countSql);
        
        $data = $this->db->fetchAll($sql);
        
        return [
            'data' => $data,
            'total' => $countResult['total'],
            'pages' => ceil($countResult['total'] / $limit),
            'current_page' => $page,
            'per_page' => $limit
        ];
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function findBy($column, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        return $this->db->fetchOne($sql, [$value]);
    }

    public function findAllBy($column, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ? ORDER BY id DESC";
        return $this->db->fetchAll($sql, [$value]);
    }

    public function create($data)
    {
        $validData = array_intersect_key($data, array_flip($this->fillable));
        return $this->db->insert($this->table, $validData);
    }

    public function update($id, $data)
    {
        $validData = array_intersect_key($data, array_flip($this->fillable));
        return $this->db->update($this->table, $validData, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function where($conditions, $orderBy = 'id')
    {
        $whereClause = '';
        $params = [];
        
        foreach ($conditions as $key => $value) {
            $whereClause .= "{$key} = ? AND ";
            $params[] = $value;
        }
        
        $whereClause = rtrim($whereClause, ' AND ');
        
        $sql = "SELECT * FROM {$this->table} WHERE {$whereClause} ORDER BY {$orderBy} DESC";
        return $this->db->fetchAll($sql, $params);
    }

    public function count($conditions = [])
    {
        if (empty($conditions)) {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $result = $this->db->fetchOne($sql);
        } else {
            $whereClause = '';
            $params = [];
            
            foreach ($conditions as $key => $value) {
                $whereClause .= "{$key} = ? AND ";
                $params[] = $value;
            }
            
            $whereClause = rtrim($whereClause, ' AND ');
            
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE {$whereClause}";
            $result = $this->db->fetchOne($sql, $params);
        }
        
        return $result['total'] ?? 0;
    }

    public function exists($conditions)
    {
        return $this->count($conditions) > 0;
    }
}
