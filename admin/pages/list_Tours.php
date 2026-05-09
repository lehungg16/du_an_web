<?php require_once '../config.php'; 
    $sql = "SELECT * FROM tb_tours";
    $result = mysqli_query($conn, $sql);
?>
<!-- <link rel="stylesheet" href="../assets/css/admin/style.css">    -->
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
        <th>ID</th> <th>Mã Tour</th> <th>Hình Ảnh</th> <th>Tên Tour</th>
        <th>Du Lịch</th> <th>Địa Điểm</th> <th>Giá</th> <th>Thời gian</th>
        <th>Hành động</th>
    </tr>
    <?php while($tour = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $tour['id'] ?></td>
        <td><?= $tour['tour_id'] ?></td>
        <td><img src="../data/image/<?= $tour['image'] ?>" width="80"></td>
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
            <a href="actions/action_Tour.php?id=<?= $tour['id'] ?>" 
            onclick="return confirm('Bạn có chắc muốn xóa?')">
                <button class="action-btn delete">Xóa</button>
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
