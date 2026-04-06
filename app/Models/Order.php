<?php

namespace App\Models;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['customer_id', 'total_amount', 'status', 'shipping_address', 'notes'];

    public function getCustomerOrders($customerId, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM {$this->table} WHERE customer_id = ? ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        return $this->db->fetchAll($sql, [$customerId]);
    }

    public function getOrderDetails($orderId)
    {
        $sql = "SELECT o.*, od.* FROM {$this->table} o
                LEFT JOIN order_items od ON o.id = od.order_id
                WHERE o.id = ?";
        return $this->db->fetchAll($sql, [$orderId]);
    }

    public function getOrderById($orderId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetchOne($sql, [$orderId]);
    }

    public function createOrder($customerId, $totalAmount, $shippingAddress, $notes = null)
    {
        return $this->create([
            'customer_id' => $customerId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'notes' => $notes
        ]);
    }

    public function updateOrderStatus($orderId, $status)
    {
        return $this->update($orderId, ['status' => $status]);
    }
}
