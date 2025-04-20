<?php
require_once __DIR__ . '/../../core/DbCore.php';

class EmployeeReport {
    private $db;

    public function __construct() {
        $dbCore = DbCore::getInstance();
        $this->db = $dbCore->getConnection();
    }

    public function getSummary($fromDate, $toDate, $employee_id) {
        $sql = "SELECT 
                    DATE(o.created_at) as day,
                    COUNT(DISTINCT o.id) as total_orders,
                    SUM(oi.quantity) as total_products,
                    SUM(o.total_price) as total_revenue
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                WHERE DATE(o.created_at) BETWEEN :fromDate AND :toDate AND o.employee_id = :employee_id
                GROUP BY DATE(o.created_at)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':fromDate' => $fromDate,
            ':toDate' => $toDate,
            ':employee_id' => $employee_id
        ]);
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getOrders($fromDate, $toDate, $employee_id) {
        $sql = "SELECT 
                    o.id, 
                    o.total_price, 
                    o.created_at, 
                    c.name as customer_name
                FROM orders o
                LEFT JOIN customers c ON o.customer_id = c.id
                WHERE DATE(o.created_at) BETWEEN :fromDate AND :toDate AND o.employee_id = :employee_id
                ORDER BY o.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':fromDate' => $fromDate,
            ':toDate' => $toDate,
            ':employee_id' => $employee_id
        ]);
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>