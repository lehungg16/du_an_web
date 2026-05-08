<?php include "../../config.php"; ?>

<?php
// lấy id từ URL
$id = $_GET['id'];

// lấy dữ liệu tour
$sql = "SELECT * FROM tb_tours WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$tour = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết tour</title>
    <!-- <link rel="stylesheet" href="../../css/review_detail.css"> -->
     <style>
        body {
    font-family: Arial;
    margin: 0;
    padding: 20px;
    background: #f5f5f5;
}

h2 {
    margin-bottom: 20px;
}

.list-tour {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.tour {
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
}

.tour h3 {
    padding: 10px;
    margin: 0;
}

.tour img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.tour p {
    margin: 5px 10px;
}

.tour a {
    margin: 10px;
    padding: 8px;
    background: #007bff;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
}

.tour a:hover {
    background: #0056b3;
}
</style>
</head>

<body>

<div class="container">

    <!-- Ảnh lớn -->
    <div class="left">
        <img src="../database/image/<?php echo $tour['image']; ?>"
             onerror="this.src='../data/image/default.jpg'">
    </div>

    <!-- Thông tin -->
    <div class="right">
        <h2><?php echo $tour['nametour']; ?></h2>

        <p class="desc"><?php echo $tour['description']; ?></p>

        <p><b>Giá:</b> <?php echo $tour['price']; ?> $</p>
        <p><b>Thời gian:</b> <?php echo $tour['duration']; ?></p>

        <a class="btn" href="booking.php?id=<?php echo $tour['id']; ?>">
            Đặt tour
        </a>
    </div>

</div>

<!-- Review giả -->
<div class="review-section">
    <h3>Đánh giá</h3>

    <div class="review">
        <b>Nguyễn Văn A</b>
        <p>Tour rất đẹp, đáng tiền 👍</p>
    </div>

    <div class="review">
        <b>Trần Thị B</b>
        <p>Hướng dẫn viên nhiệt tình, sẽ đi lại!</p>
    </div>

</div>

</body>
</html>