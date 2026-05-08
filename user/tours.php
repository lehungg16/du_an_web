<?php include "../config.php" ; 
    require '../site.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách tour</title>
<link rel="stylesheet" href="../css/user/tours.css">
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div><b>Travel Gia Lai</b></div>
    <div>
        <a href="../index.php">Trang chủ</a>
        <a href="tours.php">Tour</a>
        <a href="#">Liên hệ</a>
    </div>
</div>

<!-- TITLE -->
<div class="title">Danh sách tour</div>

<!-- TOUR LIST -->
<div class="tour-list">

<?php
// Chỉ dùng 1 query duy nhất, có JOIN để lấy avg_rating và total_review
$sql = "SELECT 
            t.*, 
            ROUND(AVG(r.rating), 1) AS avg_rating,
            COUNT(r.id) AS total_review
        FROM tb_tours t
        LEFT JOIN tb_reviews r 
            ON t.tour_id = r.tour_id 
            AND r.status = 'Đã Duyệt'
        GROUP BY t.tour_id
        ORDER BY t.tour_id DESC";
 
$result = $conn->query($sql);
 
while($row = $result->fetch_assoc()) {
    $avg_rating = $row['avg_rating']; // lấy từ $row, không phải biến ngoài
    $total_review = $row['total_review'];
?>
    <a href="../user/tour_detail.php?id=<?php echo $row['id']; ?>" class="tour-link">
        <div class="tour-card">
            <img src="../data/image/<?php echo $row['image']; ?>">
            <div class="tour-content">
                <div class="tour-name"><?php echo $row['nametour']; ?></div>
 
                <div class="tour-rating">
                    <?php if($avg_rating): ?>
                        <?php for($i = 0; $i < round($avg_rating); $i++) echo "⭐"; ?>
                        <?php echo $avg_rating; ?>/5
                        (<?php echo $total_review; ?> đánh giá)
                    <?php else: ?>
                        Mới
                    <?php endif; ?>
                </div>
 
                <div class="tour-desc"><?php echo $row['description']; ?></div>
                <div class="tour-price">
                    <?php echo number_format($row['price']); ?> VNĐ
                </div>
 
                <div class="btn">Đặt tour</div>
            </div>
        </div>
    </a>
 
<?php } ?>
 
</div>



<!-- FOOTER -->
<div>
<?php load_footer(); ?>
</div>


