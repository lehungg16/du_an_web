<?php
include "config.php";

// Lấy danh sách tour kèm rating trong 1 query duy nhất (giống tours.php)
$sql = "SELECT 
            t.*, 
            ROUND(AVG(r.rating), 1) AS avg_rating,
            COUNT(r.id) AS total_review
        FROM tb_tours t
        LEFT JOIN tb_reviews r 
            ON t.tour_id = r.tour_id        
            AND r.status = 'Đã Duyệt'
        GROUP BY t.tour_id
        ORDER BY t.id DESC
        LIMIT 100";

$result = mysqli_query($conn, $sql);
?>

<body>

<!-- HERO -->
<div class="hero">
    <h1>Khám phá Gia Lai</h1>

    <div class="search-box">
        <input type="text" id="search" placeholder="Bạn muốn đi đâu ?">
        <div id="suggestions"></div>
    </div>
</div>

<!-- ABOUT -->
<section id="about" class="about fade">
<img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470">
<div>
<h2 data-vi="Về Gia Lai" data-en="About Gia Lai"></h2>
<p data-vi="Gia Lai nổi tiếng với thiên nhiên hoang sơ, rừng núi và văn hóa Tây Nguyên."
data-en="Gia Lai is famous for its wild nature and culture."></p>
</div>
</section>

<!-- TOUR -->
<div class="tours">

<?php while($row = mysqli_fetch_assoc($result)): ?>

<?php
// Lấy trực tiếp từ $row — không cần query thêm nữa
$avg   = $row['avg_rating'];   // đã ROUND sẵn
$total = $row['total_review'];
?>

<div class="card">
    <a href="user/tour_detail.php?id=<?php echo $row['id']; ?>">
        <img src="data/image/<?php echo $row['image']; ?>"
             onerror="this.src='data/image/index1.jpg'">
    </a>

    <div class="content">
        <h3><?php echo $row['nametour']; ?></h3>
        <div style="position:absolute;top:10px;right:10px;color:white;font-size:20px;">
            ❤️
        </div>

        <p><?php echo substr($row['description'], 0, 50); ?>...</p>

        <div class="rating">
            <?php if($avg): ?>
                ⭐ <?php echo $avg; ?>/5
                (<?php echo $total; ?> đánh giá)
            <?php else: ?>
                ⭐ Chưa có đánh giá
            <?php endif; ?>
        </div>

        <div class="price">
            <?php echo number_format($row['price']); ?> VNĐ
        </div>

        <a href="user/tour_detail.php?id=<?php echo $row['id']; ?>">
            <button class="btn">Xem chi tiết</button>
        </a>
    </div>
</div>

<?php endwhile; ?>

</div>

<!-- GALLERY -->
<section class="fade">
<h2 data-vi="Hình ảnh đẹp" data-en="Gallery"></h2>
<div class="gallery">
<img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470">
<img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e">
<img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb">
</div>
</section>

<!-- SEARCH AJAX -->
<script src="js/main.js"></script>

</body>