<?php 
include "../config.php";

// Tổng tour
$tour_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM tb_tours
"))['total'];

// Tổng user
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM tb_accounts
"))['total'];

// Tổng đơn
$booking_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM tb_bookings
"))['total'];

// Tổng doanh thu (dùng total_price)
$revenue = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(total_price) as total FROM tb_bookings
"))['total'];
?>
<!-- Header -->
    <div class="header">
      <h2>Dashboard</h2>
      <div class="right">🔔<div class="avatar">ư</div>
      </div>
    </div>

    <!-- Cards -->
    <div class="cards">
      <div class="card"><h3>Tổng tour</h3><p><?=$tour_count ?></p></div>
      <div class="card"><h3>Người dùng</h3><p><?=$user_count?></p></div>
      <div class="card"><h3>Đơn đặt</h3><p><?=$booking_count?></p></div>
      <div class="card"><h3>Doanh thu</h3><p><?=number_format($revenue ?? 0)?>VNĐ</p></div>
    </div>

    <!-- Charts -->
    <div class="charts">
      <div class="chart-box">
        <canvas id="barChart"></canvas>
      </div>
      <div class="chart-box">
        <canvas id="pieChart"></canvas>
      </div>
    </div>

    <!-- Table -->
    <table>
      <thead>
        <tr>
          <th>Khách hàng</th>
          <th>Tour</th>
          <th>Ngày</th>
          <th>Trạng thái</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Nguyễn A</td><td>Biển</td><td>01/04</td><td>Đã thanh toán</td></tr>
        <tr><td>Trần B</td><td>Núi</td><td>02/04</td><td>Chờ xử lý</td></tr>
        <tr><td>Lê C</td><td>Thành phố</td><td>03/04</td><td>Đã hủy</td></tr>
      </tbody>
    </table>


<script>
new Chart(document.getElementById('barChart'), {
  type: 'bar',
  data: {
    labels: ['1','2','3','4','5','6','7','8','9','10','11','12'],
    datasets: [{
      label: 'Doanh thu',
      data: [1200,1900,3000,5000,2000,3000,4000,3500,4200,4800,5200,6000],
      backgroundColor: 'rgba(13,110,253,0.7)'
    }]
  }
});

new Chart(document.getElementById('pieChart'), {
  type: 'pie',
  data: {
    labels: ['Biển','Núi','Sinh thái','Thành phố'],
    datasets: [{
      data: [30,25,20,25],
      backgroundColor: ['#0d6efd','#20c997','#ffc107','#dc3545']
    }]
  }
});
</script>