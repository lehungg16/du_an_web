<?php require_once '../config.php'; 
if($_SESSION['role']!="admin"){die("Ồ no. Bạn Không có quyền =))");}
 
/* Trang dashboard chính của admin, hiển thị các thống kê cơ bản và liên kết đến các trang quản lý khác
 * URL: /dashboard
 * Phân quyền: Chỉ admin (role=1) mới được truy cập
 * Các tab: dashboard (thống kê), list_Users, list_Tours, list_Bookings, list_Reviews, chat
 Mỗi tab sẽ load nội dung tương ứng qua AJAX vào div#content
*/
$tab =$_GET['tab'] ?? 'dashboard';

$allowed_tabs = ['dashboard', 'list_Users', 'list_Tours', 'list_Bookings', 'list_Reviews', 'chat', 'back'];
if(!in_array($tab, $allowed_tabs)) $tab = 'dashboard';



/* Lấy các thống kê cơ bản để hiển thị trên dashboard
 * Tổng tour, tổng user, tổng đơn hàng, tổng doanh thu
 */
if($tab === 'dashboard') {
// Tổng tour
$tour_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_tours"))['total'];
// Tổng user
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_accounts"))['total'];
// Tổng đơn
$booking_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_bookings"))['total'];
// Tổng doanh thu (dùng total_price)
$revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as total FROM tb_bookings"))['total'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> ⚙️ Admin</title>
  <link rel="stylesheet" href="../assets/css/admin/dashboard.css">
  <!-- <link rel="stylesheet" href="../assets/css/admin/add_tour.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
  <!-- NAVBAR_ADMIN -->
  <div class="navbar-admin">
  </div>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
    <span class="logo-icon">📘</span>
    <span class="logo-text">Travel Admin</span>
  </div>
  <ul>
    <li class="menu-parent" onclick="toggleMenu(this)">
      DASHBOARD <span class="arrow">></span>
    </li>
    <ul class="submenu">
      <li><a href="?tab=dashboard" class="<?= $tab==='dashboard' ? 'active' : '' ?>">
        <span>Dashboard</span>
      </a>
      <li><a href="#" onclick="loadPage('dashboard_content.php')">📊 Thống kê</a></li>
    </ul>
    <!-- MENU CHA -->
    <li class="menu-parent" onclick="toggleMenu(this)">
        QUẢN LÝ TOUR <span class="arrow">></span>
    </li>
    <!-- MENU CON -->
    <ul class="submenu">
        <li><a href="?tab=list_Users">👤 Quản lý user</a></li>
        <li><a href="?tab=list_Tours">🧳 Danh sách tour</a></li>
        <li><a href="?tab=add_tour" onclick="loadPage('skill/add_tour.php')">➕ Thêm tour</a></li>
    </ul>
    <!-- MENU CHA -->
    <li class="menu-parent" onclick="toggleMenu(this)">
        VẬN HÀNH <span class="arrow">></span>
    </li>

    <!-- MENU CON -->
    <ul class="submenu">
        <li><a href="?tab=list_Bookings">📦 Đơn hàng</a></li>
        <li><a href="?tab=list_Reviews">⭐ Đánh giá</a></li>
    </ul>
    <li class="menu-parent" onclick="toggleMenu(this)">
        KHÁC <span class="arrow">></span>
    </li>
    <ul class="submenu">
      <li><a href="?tab=chat">💬 Tin nhắn</a></li>
      <li><a href="?tab=back">Xem website</a></li>
    </ul>
    <li><a href="../logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i>  Đăng xuất</a></li>
  </ul>
 
</div>
<!-- TAB: DASHBOARD -->

  <!-- Main -->
  <div class="main">
    <?php
    include "pages/{$tab}.php";

    ?>
  </div>

<script src="../assets/js/admin/dashboard.js"></script>

</body>
</html>
