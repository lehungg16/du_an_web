<?php
session_start();
include "../config.php";

// Kiểm tra login
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

// Lấy username
$username = $_SESSION['user'];

// Lấy dữ liệu booking của user
$sql = "SELECT tb_bookings.*, tb_tours.nametour 
        FROM tb_bookings
        JOIN tb_tours ON tb_bookings.tour_id = tb_tours.id
        JOIN tb_accounts ON tb_bookings.user_id = tb_accounts.id
        WHERE tb_accounts.username = '$username'
        ORDER BY tb_bookings.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử đặt tour</title>

    <link rel="stylesheet" href="../css/user.css">
</head>

<body>

<div class="container">
    <h2>Lịch sử đặt tour 📖</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Ngày đặt</th>
            <th>Số người</th>
            <th>Trạng thái</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nametour']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php } ?>

    </table>

    <br>
    <a href="dashboard.php">← Quay lại</a>
</div>

</body>
</html>