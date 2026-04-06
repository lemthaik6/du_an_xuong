<?php

namespace App\Models;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function getOrderItems($orderId)
    {
        $sql = "SELECT oi.*, p.name, p.price FROM {$this->table} oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?";
        return $this->db->fetchAll($sql, [$orderId]);
    }

    public function createOrderItem($orderId, $productId, $quantity, $price)
    {
        return $this->create([
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }
}
