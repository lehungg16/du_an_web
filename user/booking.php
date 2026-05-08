<?php
include "../config.php";


// lấy id tour
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// lấy thông tin tour
$sql = "SELECT * FROM tb_tours WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $tour = mysqli_fetch_assoc($result);
}else{
    echo "Không tìm thấy tour!";
    exit;
}

// xử lý booking
if(isset($_POST['book'])){

    $user = $_SESSION['user'];

    $sql_user="SELECT id FROM tb_accounts WHERE username='$user'";
    $result_user=mysqli_query($conn,$sql_user);
    $row_user=mysqli_fetch_assoc($result_user);
    $user_id=$row_user['id'];

    $date = $_POST['date'];
    $quantity = $_POST['quantity'];
    $payment = $_POST['payment'];
    $note = $_POST['note'];

    $sql="INSERT INTO tb_bookings(user_id,tour_id,date_start,quantity,payment,note)
    VALUES('$user_id','$id','$date','$quantity','$payment','$note')";

    if(mysqli_query($conn,$sql)){
        echo "<script>alert('Đặt tour thành công');</script>";
    }else{
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tour</title>

    <!-- gọi css -->
    <link rel="stylesheet" href="../css/booking.css">
</head>
<body>

<div class="booking-container">

    <h2>Đăng ký tour</h2>

    <p class="tour-name">Tour: <?php echo $tour['nametour']; ?></p>

    <form method="post">

        <label>Ngày khởi hành:</label>
        <input type="date" name="date" required>

        <label>Số người (*)</label>
            <input type="number" name="quantity" min="1" required>

        <label>Thanh toán (*)</label>
            <select name="payment" required>
            <option value="Tiền mặt">Tiền mặt</option>
            <option value="Chuyển khoản">Chuyển khoản</option>
            </select>

        <label>Note (yêu cầu thêm)</label>
        <textarea name="note"></textarea>

        <button type="submit" name="book">Đăng ký tour</button>

    </form>

</div>

</body>
</html>