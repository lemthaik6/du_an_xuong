<?php

namespace Src;

class Database
{
    private $connection;
    private static $instance = null;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect()
    {
        try {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $user = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? '';
            $database = $_ENV['DB_NAME'] ?? 'du_an_xuong';

            $this->connection = new \mysqli($host, $user, $password, $database);

            if ($this->connection->connect_error) {
                throw new \Exception("Kết nối thất bại: " . $this->connection->connect_error);
            }

            $this->connection->set_charset("utf8mb4");
        } catch (\Exception $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);
        if (!$result) {
            throw new \Exception("Query Error: " . $this->connection->error);
        }
        return $result;
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            throw new \Exception("Prepare Error: " . $this->connection->error);
        }

        if (!empty($params)) {
            $types = '';
            $values = [];
            
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
                $values[] = $param;
            }

            $stmt->bind_param($types, ...$values);
        }

        if (!$stmt->execute()) {
            throw new \Exception("Execute Error: " . $stmt->error);
        }

        return $stmt;
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        $stmt = $this->connection->prepare($sql);
        
        $types = '';
        $params = [];
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $params[] = $value;
        }

        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) {
            throw new \Exception("Insert Error: " . $stmt->error);
        }

        $lastId = $this->connection->insert_id;
        $stmt->close();
        return $lastId;
    }

    public function update($table, $data, $where)
    {
        $set = '';
        $params = [];
        
        foreach ($data as $key => $value) {
            $set .= "{$key} = ?, ";
            $params[] = $value;
        }
        
        $set = rtrim($set, ', ');
        
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "{$key} = ? AND ";
            $params[] = $value;
        }
        
        $whereClause = rtrim($whereClause, ' AND ');
        
        $sql = "UPDATE {$table} SET {$set} WHERE {$whereClause}";
        $stmt = $this->connection->prepare($sql);
        
        $types = '';
        foreach ($params as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) {
            throw new \Exception("Update Error: " . $stmt->error);
        }

        $rowsAffected = $stmt->affected_rows;
        $stmt->close();
        return $rowsAffected;
    }

    public function delete($table, $where)
    {
        $whereClause = '';
        $params = [];
        
        foreach ($where as $key => $value) {
            $whereClause .= "{$key} = ? AND ";
            $params[] = $value;
        }
        
        $whereClause = rtrim($whereClause, ' AND ');
        
        $sql = "DELETE FROM {$table} WHERE {$whereClause}";
        $stmt = $this->connection->prepare($sql);
        
        $types = '';
        foreach ($params as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } else {
                $types .= 's';
            }
        }

        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) {
            throw new \Exception("Delete Error: " . $stmt->error);
        }

        $rowsAffected = $stmt->affected_rows;
        $stmt->close();
        return $rowsAffected;
    }

    public function lastInsertId()
    {
        return $this->connection->insert_id;
    }

    public function close()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
