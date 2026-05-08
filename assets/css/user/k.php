<head><link rel="stylesheet" href="tour_detail1.css"></head>
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
            <form method="POST">

                <input type="hidden" name="tour_id" value="<?php echo $row['id']; ?>">

                <h3>Đặt tour</h3>

                <input type="text" name="fullname" placeholder="Họ tên" required>

                <input type="text" name="phone" placeholder="SĐT" required>

                <input type="number" name="quantity" value="1">

                <select name="payment">
                    <option>Tiền mặt</option>
                    <option>Chuyển khoản</option>
                </select>

                <button name="book_tour">Đặt ngay</button>

            </form>
        </div>
    </div>

</div>