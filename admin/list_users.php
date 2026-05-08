<?php
include "../config.php";

// THÊM USER
if(isset($_POST['add'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO tb_accounts(username, password) VALUES('$username','$password')";
    mysqli_query($conn, $sql);
}

// XÓA USER
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tb_accounts WHERE id=$id");
}

// SỬA USER
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn, "UPDATE tb_accounts SET username='$username', password='$password' WHERE id=$id");
}

// LẤY DANH SÁCH
$result = mysqli_query($conn, "
    SELECT u.*, 
    (SELECT COUNT(*) FROM tb_bookings b WHERE b.user_id = u.id) as total_booking
    FROM tb_accounts u
");
?>


<div class="container">
    <h2 class="title">Quản lý tài khoản Người</h2>
<div class="top-bar">
    <input type="text" placeholder=" 🔍 Tìm tên đăng nhập..." class="search"><button>Tìm</button>

    <a href="#" onclick="loadPage('add_user.php')"> Thêm tài khoản</a>
</div>

    <!-- TABLE -->
    <table>
        <tr>
            <th>ID</th>
            <th>Tài khoản</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số Điện Thoại</th>
            <th>Đặt tour</th>
            <th>Hành động</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <form method="post">
                <td><?= $row['id'] ?></td>

                <td><?= $row['username'] ?></td>
                <td><?= $row['fullname'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone']?></td>
                <td><?= $row['total_booking'] ?></td>

                <td>
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button name="view"> Xem Chi Tiêt</button>
                    <button name="update">Sửa</button>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirmDelete()">Xóa</a>
                </td>
            </form>
        </tr>
        <?php } ?>

    </table>
</div>

<script src="../js/users.js"></script>
