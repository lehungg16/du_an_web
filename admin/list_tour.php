<?php include "../config.php"; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý Tour</title>
<link rel="stylesheet" href="../css/admin/list_tour.css">
</head>

<body>

<div class="header">
    <h2>Quản lý Tour Du Lịch</h2>
</div>

<div class="top-bar">
    <input type="text" placeholder="🔍 Tìm tour...">
    <a href="skill/add_tour.php" class="add-btn">+ Thêm Tour</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Mã Tour</th>
        <th>Hình Ảnh</th>
        <th>Tên Tour</th>
        <th>Du Lịch</th>
        <th>Địa Điểm</th>
        <th>Giá</th>
        <th>Thời gian</th>
        <th>Hành động</th>
    </tr>

<?php
$sql = "SELECT * FROM tb_tours";
$result = mysqli_query($conn, $sql);

while($tour = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?= $tour['id'] ?></td>
    <td><?= $tour['tour_id'] ?></td>
    <td>
        <img src="../data/image/<?= $tour['image'] ?>" width="80">
    </td>

    <td><?= $tour['nametour'] ?></td>
    <td><?= $tour['region'] ?></td>
    <td><?= $tour['location'] ?></td>
    <td><?= number_format($tour['price']) ?> VNĐ</td>
    <td><?= $tour['duration'] ?></td>

    <td>
         <!-- XEM -->
        <a href="skill/view_tour.php?id=<?= $tour['id'] ?>">
            <button class="action-btn view">Xem Chi Tiết</button>
        </a>

        <a href="skill/edit_tour.php?id=<?= $tour['id'] ?>">
            <button class="action-btn edit">Sửa</button>
        </a>

        <a href="skill/delete_tour.php?id=<?= $tour['id'] ?>" 
           onclick="return confirm('Bạn có chắc muốn xóa?')">
            <button class="action-btn delete">Xóa</button>
        </a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>