<?php 
include "../config.php";

// Xử lý duyệt
if(isset($_GET['approve'])){
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE tb_reviews SET status='Đã Duyệt' WHERE id=$id");
    // Không dùng header() nữa!
    echo "<script>
        if(window.parent && window.parent.loadPage){
            window.parent.loadPage('review.php');
        } else {
            window.location.href = 'review.php';
        }
    </script>";
    exit();
}

// Xử lý xóa
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM tb_reviews WHERE id=$id");
    echo "<script>
        if(window.parent && window.parent.loadPage){
            window.parent.loadPage('review.php');
        } else {
            window.location.href = 'review.php';
        }
    </script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý đánh giá</title>
<style>
body { font-family: Arial; background: #f4f6f9; }

h2 { text-align: center; margin: 20px 0; }

table {
    width: 95%;
    margin: auto;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px 10px;
    border: 1px solid #ddd;
    text-align: center;
}

th { background: #007bff; color: white; }

tr:hover { background: #f1f7ff; }

.action-btn {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: white;
    margin: 2px;
}

.btn-approve { background: green; }
.btn-view    { background: #17a2b8; }
.btn-delete  { background: red; }

.status {
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 12px;
    display: inline-block;
}

.pending { background: #fff3cd; color: #856404; }   /* vàng */
.done    { background: #d4edda; color: #155724; }   /* xanh */
</style>
</head>

<body>

<h2>Quản lý đánh giá</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Khách</th>
        <th>Tour</th>
        <th>Sao</th>
        <th>Nội dung</th>
        <th>Ngày Tạo</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

    <?php
    $sql = "SELECT 
                r.*, 
                a.fullname,
                t.nametour
            FROM tb_reviews r
            LEFT JOIN tb_accounts a ON r.user_id = a.id
            LEFT JOIN tb_tours t ON r.tour_id = t.tour_id
            ORDER BY r.id DESC";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)):
        $status = $row['status'] ?: 'Chờ duyệt';
        $isDone = ($status === 'Đã Duyệt');
    ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['nametour']) ?></td>
        <td><?= $row['rating'] ?>⭐</td>
        <td><?= htmlspecialchars(substr($row['comment'], 0, 30)) ?>...</td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>

        <td>
            <span class="status <?= $isDone ? 'done' : 'pending' ?>">
                <?= $status ?>
            </span>
        </td>

        <td>
            <!-- Nút duyệt: chỉ hiện khi chưa duyệt -->
            
            <!-- Nút duyệt -->
            <?php if(!$isDone): ?>
            <a href="skill/approve_review.php?id=<?= $row['id'] ?>">
                <button class="action-btn btn-approve">✔ Duyệt</button>
            </a>
            <?php endif; ?>

            <!-- Xem chi tiết -->
            <a href="skill/review_tours.php?id=<?= $row['id'] ?>">
                <button class="action-btn btn-view" title="Xem">👁</button>
            </a>


            <!-- Nút xóa -->
            <a href="skill/delete_review.php?id=<?= $row['id'] ?>" onclick="return confirm('Xác nhận xóa?')">
                <button class="action-btn btn-delete">🗑</button>
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>