<?php
include "config.php";

$tour_id = $_GET['id'];
?>

<?php
if(isset($_POST['review'])){
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $user = $_SESSION['user'];

    // lấy user_id
    $getUser = mysqli_query($conn, "SELECT id FROM tb_accounts WHERE username='$user'");
    $u = mysqli_fetch_assoc($getUser);
    $user_id = $u['id'];

    // insert review
    mysqli_query($conn, "INSERT INTO tb_reviews(user_id, tour_id, rating, comment)
                        VALUES('$user_id','$tour_id','$rating','$comment')");

    echo "<script>alert('Đánh giá thành công');</script>";
}
?>

<h3>Đánh giá tour ⭐</h3>

<form method="post">
    <label>Số sao:</label>
    <select name="rating">
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
    </select>
    <br><br>

    <textarea name="comment" placeholder="Nhận xét..." required></textarea>
    <br><br>

    <button name="review" type="submit">Gửi đánh giá</button>
</form>