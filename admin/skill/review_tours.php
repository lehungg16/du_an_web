<?php 
include "../../config.php";

$id = $_GET['id']; // id của review

// Lấy review
$review = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM tb_reviews WHERE id='$id'")
);

// Nếu không có
if(!$review){
    echo "Không tìm thấy review!";
    exit;
}
?>
<?php
// Lấy tour
$tour = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM tb_tours WHERE tour_id='".$review['tour_id']."'")
);

// Lấy user
$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM tb_accounts WHERE id='".$review['user_id']."'")
);
?>
<link rel="stylesheet" href="../../css/admin/review_detail.css">
<div class="container">

    <h2>Chi tiết Review</h2>

    <!-- USER -->
    <div class="card user-info">
        <h3>👤 Người dùng</h3>
        <p><b>Tên:</b> <?= $user ? $user['fullname'] : 'Không tồn tại' ?></p>
        <p><b>Email:</b> <?= $user ? $user['email'] : 'Không có' ?></p>
    </div>

    <!-- TOUR -->
    <div class="card tour">
        <h3>🏝 Tour</h3>
        <p><b>Tên tour:</b> <?= $tour ? $tour['nametour'] : 'Không có' ?></p>
        <img src="../../data/image/<?= $tour['image'] ?>">
    </div>

    <!-- REVIEW -->
    <div class="card">
        <h3>⭐ Đánh giá</h3>

        <div class="review-box">
            <div class="rating">
                <?= $review['rating'] ?> ⭐
            </div>

            <p><?= $review['comment'] ?></p>

            <small>Ngày: <?= $review['created_at'] ?></small>
        </div>
    </div>

    <!-- BUTTON -->
    <div style="text-align:center;">
        <a href="../dashboard.php" class="btn btn-back">⬅ Quay lại</a>

        <a href="delete_review.php?id=<?= $review['id'] ?>" 
           class="btn btn-delete"
           onclick="return confirm('Xóa review này?')">
           🗑 Xóa
        </a>
    </div>

</div>