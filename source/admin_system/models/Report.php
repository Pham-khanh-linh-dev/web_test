<?php
require_once __DIR__ . '/../../core/DbCore.php';

class Report {
    private $db;

    public function __construct() {
        $this->db = DbCore::getInstance()->getConnection();
    }

    // Lấy tổng hợp doanh thu, số đơn, số sản phẩm và lợi nhuận theo ngày
    public function getSummary($fromDate, $toDate) {
        $stmt = $this->db->prepare("
            SELECT 
                DATE(o.created_at) as day,
                COUNT(DISTINCT o.id) as total_orders,
                SUM(oi.quantity) as total_products,
                SUM(o.total_price) as total_revenue,
                SUM((oi.price - p.purchase_price) * oi.quantity) as total_profit
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.created_at BETWEEN :fromDate AND :toDate
            GROUP BY DATE(o.created_at)
            ORDER BY day ASC
        ");
        $stmt->execute([
            ':fromDate' => $fromDate . ' 00:00:00',
            ':toDate'   => $toDate . ' 23:59:59'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách đơn hàng với tên khách hàng
    public function getOrders($fromDate, $toDate) {
        $stmt = $this->db->prepare("
            SELECT 
                o.*, 
                c.name as customer_name,
                SUM((oi.price - p.purchase_price) * oi.quantity) as profit
            FROM orders o
            JOIN customers c ON o.customer_id = c.id
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            WHERE o.created_at BETWEEN :from AND :to
            GROUP BY o.id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([
            ':from' => $fromDate . ' 00:00:00',
            ':to'   => $toDate . ' 23:59:59'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy chi tiết một đơn hàng
    public function getOrderDetail($orderId) {
        $stmt = $this->db->prepare("
            SELECT p.name, oi.quantity, oi.price 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :orderId
        ");
        $stmt->execute([':orderId' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
