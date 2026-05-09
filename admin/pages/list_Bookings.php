<?php require_once '../config.php'; 
$sql = "SELECT 
            tb_bookings.*, 
            tb_bookings.created_at,
            tb_accounts.fullname,
            tb_accounts.phone,
            tb_tours.nametour,
            tb_tours.region, tb_tours.duration, tb_tours.price

        FROM tb_bookings

        LEFT JOIN tb_accounts /*sẽ lấy hàng bên trái có thể hiện null nếu dùng inner join thì có dủ thuộc ttính mới hiẹn */
        ON tb_bookings.user_id = tb_accounts.id

        LEFT JOIN tb_tours 
        ON tb_bookings.tour_id = tb_tours.tour_id

        ORDER BY tb_bookings.id DESC";

$result = mysqli_query($conn, $sql);
?>
<link rel="stylesheet" href="../assets/css/admin/style.css">

<h2>Danh sách đơn đặt tour</h2>

<table>
    <tr>
        <th>ID</th><th>Khách</th><th>SĐT</th><th>Loại Hình Du Lịch</th>
        <th>Tour</th><th>Số người</th><th>Số Ngày </th><th>Ngày đi</th>
        <th>Loại Thanh Toán</th><th>Giá Tiền</th><th>Ngày Tạo</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['fullname'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td><?= $row['region'] ?></td>
        <td><?= $row['nametour'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['duration'] ?></td>
        <td><?= $row['date_start'] ?></td>
        <td><?= $row['payment'] ?></td>
        <td><?= $row['total_price'] ?>VNĐ</td>  
        <td><?= $row['created_at'] ?></td>  
    </tr>

    <?php } ?>
</table>
