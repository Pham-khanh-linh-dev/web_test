<?php
include_once __DIR__ . '/../config/auth_check.php';
include_once __DIR__ . '/../config/constants.php';

// Kiểm tra đăng nhập và vai trò (đã được xử lý trong auth_check.php, nhưng thêm kiểm tra role)
if (isset($_SESSION['role']) && $_SESSION['role'] !== 'employee') {
    header('Location: ../views/auth/loginEmployee.php');
    exit();
}

// Lấy employee_id từ $userData (được gán trong auth_check.php)
$employee_id = $userData['id'] ?? null;
if (!$employee_id) {
    echo "Không tìm thấy ID nhân viên.";
    exit();
}

$employee_name = $_SESSION['user'] ?? 'Employee';
$profile_image = BASE_URL . 'assets/img/default-profile.png';
$pageTitle = 'Báo cáo';

$fromDate = $_GET['from_date'] ?? date('Y-m-d', strtotime('-6 days'));
$toDate = $_GET['to_date'] ?? date('Y-m-d');

require_once __DIR__ . '/../models/EmployeeReport.php';
$report = new EmployeeReport();
$summary = $report->getSummary($fromDate, $toDate, $employee_id);
$summary = fillEmptyDates($summary, $fromDate, $toDate);
$orders = $report->getOrders($fromDate, $toDate, $employee_id);

$orders = $orders ?? [];

include_once __DIR__ . '/../views/layout/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar-card p-3 mb-4 animate-fadein">
                <h5 class="text-center fw-bold mb-4" style="color: var(--primary-color);">CHỨC NĂNG</h5>
                <div class="row row-cols-1 g-3">
                    <div class="col">
                        <a href="index.php" class="text-decoration-none d-block text-center feature-link p-3 rounded active">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="fw-bold">Báo cáo</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="../Banhang.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                            <div class="feature-icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div class="fw-bold">Bán hàng</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="../Khachhang.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="fw-bold">Khách hàng</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="../sanpham.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                            <div class="feature-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="fw-bold">Sản phẩm</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h4 mb-4">Thống kê & Báo cáo bán hàng</h1>
                    <?php
                    $fromDateText = date('d/m/Y', strtotime($fromDate));
                    $toDateText = date('d/m/Y', strtotime($toDate));

                    $khoangNgay = ($fromDate === $toDate)
                        ? "Dữ liệu trong ngày: $fromDateText"
                        : "Dữ liệu từ $fromDateText đến $toDateText";
                    ?>
                    <div class="alert alert-info py-2 px-3 small rounded-pill d-inline-block mb-3">
                        <i class="bi bi-calendar3"></i> <?= $khoangNgay ?>
                    </div>

                    <?php
                    $tongDon = array_sum(array_column($summary, 'total_orders'));
                    $tongTien = array_sum(array_column($summary, 'total_revenue'));
                    $tongSP = array_sum(array_column($summary, 'total_products'));
                    ?>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="alert alert-success">Tổng đơn hàng: <strong><?= $tongDon ?></strong></div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning">Tổng sản phẩm bán ra: <strong><?= $tongSP ?></strong></div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-primary">Tổng doanh thu: <strong><?= number_format($tongTien) ?>₫</strong></div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <form method="GET" action="index.php" class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Mốc thời gian nhanh</label>
                                    <select class="form-select" onchange="setDateRange(this.value)">
                                        <option value="">-- Chọn --</option>
                                        <option value="today">Hôm nay</option>
                                        <option value="yesterday">Hôm qua</option>
                                        <option value="7days">7 ngày qua</option>
                                        <option value="thismonth">Tháng này</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Từ ngày</label>
                                    <input type="date" name="from_date" value="<?= $fromDate ?>" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Đến ngày</label>
                                    <input type="date" name="to_date" value="<?= $toDate ?>" class="form-control">
                                </div>
                                <div class="col-md-3 text-end">
                                    <button type="submit" class="btn btn-primary w-100">🔍 Xem báo cáo</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <canvas id="revenueChart" height="100"></canvas>

                    <h5 class="mt-5">Danh sách đơn hàng</h5>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Khách hàng</th>
                                <th>Ngày tạo</th>
                                <th>Tổng tiền</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($orders) > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr class="<?= $order['total_price'] > 20000000 ? 'table-warning' : '' ?>">
                                        <td>#<?= $order['id'] ?></td>
                                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                        <td><?= $order['created_at'] ?></td>
                                        <td><?= number_format($order['total_price']) ?>₫</td>
                                        <td>
                                            <a href="detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info">Chi tiết</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Không có đơn hàng nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function setDateRange(value) {
        const today = new Date();
        let from = '',
            to = today.toISOString().split('T')[0];

        if (value === 'today') {
            from = to;
        } else if (value === 'yesterday') {
            const y = new Date(today);
            y.setDate(today.getDate() - 1);
            from = to = y.toISOString().split('T')[0];
        } else if (value === '7days') {
            const d7 = new Date(today);
            d7.setDate(today.getDate() - 6);
            from = d7.toISOString().split('T')[0];
        } else if (value === 'thismonth') {
            from = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-01`;
        }
        const url = `index.php?from_date=${from}&to_date=${to}`;
        window.location.href = url;
    }

    window.addEventListener('load', function() {
        const chartData = <?= json_encode($summary) ?>;
        if (!chartData || chartData.length === 0) {
            console.warn("Không có dữ liệu để vẽ biểu đồ.");
            return;
        }
        const labels = chartData.map(item => item.day);
        const revenue = chartData.map(item => item.total_revenue);
        const orders = chartData.map(item => item.total_orders);
        const hasRevenue = revenue.some(val => val > 0);

        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            data: {
                labels: labels,
                datasets: [
                    ...(hasRevenue ? [{
                        type: 'bar',
                        label: 'Doanh thu (VNĐ)',
                        data: revenue,
                        yAxisID: 'y',
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }] : []),
                    {
                        type: 'line',
                        label: 'Số đơn hàng',
                        data: orders,
                        yAxisID: 'y1',
                        borderColor: 'green',
                        backgroundColor: 'green',
                        borderWidth: 2,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    ...(hasRevenue ? {
                        y: {
                            type: 'linear',
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Doanh thu (VNĐ)'
                            },
                            ticks: {
                                callback: function(val) {
                                    return val.toLocaleString('vi-VN') + '₫';
                                }
                            }
                        }
                    } : {}),
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Số đơn hàng'
                        },
                        grid: {
                            drawOnChartArea: hasRevenue
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>

<?php
include_once __DIR__ . '/../views/layout/footer.php';

function fillEmptyDates($summary, $fromDate, $toDate)
{
    $map = [];
    foreach ($summary as $item) {
        $map[$item['day']] = $item;
    }

    $from = new DateTime($fromDate);
    $to = new DateTime($toDate);
    $filled = [];

    while ($from <= $to) {
        $day = $from->format('Y-m-d');
        $filled[] = $map[$day] ?? [
            'day' => $day,
            'total_orders' => 0,
            'total_products' => 0,
            'total_revenue' => 0,
        ];
        $from->modify('+1 day');
    }

    return $filled;
}
?>