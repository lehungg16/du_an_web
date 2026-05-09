<?php require_once '../config.php';
    $sql = "SELECT 
                r.*, 
                a.fullname,
                t.nametour
            FROM tb_reviews r
            LEFT JOIN tb_accounts a ON r.user_id = a.id
            LEFT JOIN tb_tours t ON r.tour_id = t.tour_id
            ORDER BY r.id DESC";
    $result = mysqli_query($conn, $sql);
?>
<link rel="stylesheet" href="../assets/css/admin/style.css">

<body>

<h2>Quản lý đánh giá</h2>

<table>
    <tr>
        <th>ID</th><th>Khách</th><th>Tour</th>
        <th>Sao</th><th>Nội dung</th><th>Ngày Tạo</th>
        <th>Trạng thái</th><th>Hành động</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)):
        $status = $row['status'] ?: 'Chờ duyệt';
        $isDone = ($status === 'Đã Duyệt');
    ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['nametour']) ?></td>
        <td><?= $row['rating'] ?><i class="bi bi-star"></i></td>
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
            <a href="actions/action_Review.php?approve=<?= $row['id'] ?>">
                <button class="action-btn btn-approve">✔ Duyệt</button>
            </a>
            <?php endif; ?>

            <!-- Xem chi tiết -->
            <a href="skill/review_tours.php?id=<?= $row['id'] ?>">
                <button class="action-btn btn-view" title="Xem"><i class="bi bi-eye-fill"></i></button>
            </a>


            <!-- Nút xóa -->
            <a href="actions/action_Review.php?delete=<?= $row['id'] ?>" onclick="return confirm('Xác nhận xóa?')">
                <button class="action-btn btn-delete"><i class="bi bi-trash3-fill"></i></button>
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
