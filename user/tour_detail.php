<?php 
include "../config.php"; 
require '../site.php';

$id = $_GET['id'];

// lấy dữ liệu tour
$sql = "SELECT * FROM tb_tours WHERE id = $id";
$result = $conn->query($sql);

if($result->num_rows == 0){
    echo "Không tìm thấy tour!";
    exit;
}

$row = $result->fetch_assoc();

// Lấy tour_id thực (ví dụ: 220457)
$tour_id_real = $row['tour_id'];

// Tính rating trung bình + tổng số review đã duyệt
$sql_rating = "SELECT 
                    AVG(rating) AS avg_rating, 
                    COUNT(*) AS total_review
               FROM tb_reviews
               WHERE tour_id = '$tour_id_real'
               AND status = 'Đã Duyệt'";

$result_rating = mysqli_query($conn, $sql_rating);
$data_rating = mysqli_fetch_assoc($result_rating);

$avg = round($data_rating['avg_rating'], 1);
$total = $data_rating['total_review'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết tour</title>
<link rel="stylesheet" href="../css/user/tour_detail.css">
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div><b>Travel Gia Lai</b></div>
    <div>
        <a href="../index.php">Trang chủ</a>
        <a href="tours.php">Tour</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <!-- LEFT -->
    <div class="left">
        <img src="../data/image/<?php echo $row['image']; ?>">

        <div class="content">

            <div class="title">
                <?php echo $row['nametour']; ?>
            </div>

            <div class="rating">
                ⭐ <?php echo $avg ? $avg : "Mới"; ?>/5 
                (<?php echo $total; ?> đánh giá)
            </div>

            <div class="desc">
                <?php echo $row['description']; ?>
            </div>

            <div class="price">
                <?php echo number_format($row['price']); ?> VNĐ
            </div>

        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="booking-card">

            <!--
                SỬA: Dùng method="GET" action="check_out.php"
                để check_out.php nhận được $_GET['tour_id'] và $_GET['quantity']
            -->
            <form method="GET" action="check_out.php">

                <!-- Truyền tour_id thực (220457) thay vì id (4) -->
                <input type="hidden" name="tour_id" value="<?php echo $row['tour_id']; ?>">

                <h3>Thanh toán tour</h3>

                <!-- Số người -->
                <label>Số người</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1">

                <!-- Giá tour -->
                <div class="price-box">
                    Giá tour: <b id="price"><?php echo number_format($row['price']); ?></b> VNĐ
                </div>

                <!-- Tổng tiền (hiển thị để user thấy, tính thực ở check_out.php) -->
                <div class="total-box">
                    Tổng tiền: <b id="total"></b> VNĐ
                </div>

                <button type="submit">Đặt tour</button>

            </form>
        </div>
    </div>

</div>

<!-- REVIEW SECTION -->
<?php
$sql = "SELECT r.*, a.fullname, t.nametour
        FROM tb_reviews r
        JOIN tb_accounts a ON r.user_id = a.id
        JOIN tb_tours t ON r.tour_id = t.tour_id
        WHERE r.tour_id = '$tour_id_real'
          AND r.status = 'Đã Duyệt'
        ORDER BY r.created_at DESC";
$reviews = mysqli_query($conn, $sql);
?>
<div class="review-section">

    <h2>Đánh giá khách hàng</h2>

    <?php if(mysqli_num_rows($reviews) > 0): ?>
        
        <?php while($r = mysqli_fetch_assoc($reviews)): ?>
            <div class="review-item">

                <div class="review-top">
                    <b>Tên: <?php echo $r['fullname']; ?></b>
                    <span>
                        <?php for($i=0;$i<$r['rating'];$i++) echo "⭐"; ?>
                    </span>
                </div>

                <p><?php echo htmlspecialchars($r['comment']); ?></p>

                <small><?php echo $r['created_at']; ?></small>

            </div>
        <?php endwhile; ?>

    <?php else: ?>
        <p>Chưa có đánh giá nào.</p>
    <?php endif; ?>

</div>

<script>
let price = <?php echo $row['price']; ?>;

function formatMoney(n){
    return n.toLocaleString('vi-VN');
}

function updateTotal(){
    let quantity = document.getElementById("quantity").value;
    let total = price * quantity;
    document.getElementById("total").innerText = formatMoney(total);
    document.getElementById("price").innerText = formatMoney(price);
}

updateTotal();

document.getElementById("quantity").addEventListener("input", updateTotal);
</script>

<?php load_footer(); ?>