<?php require_once '../../config.php'; 

if(isset($_POST['add'])){
    $u = $_POST['username'];
    $p = $_POST['password'];

    echo "Đã bấm submit <br>"; // TEST

    $sql="INSERT INTO tb_accounts(username,password) VALUES('$u','$p')";

    if(mysqli_query($conn,$sql)){
        echo "Thêm OK";
    }else{
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<h2>Thêm tài khoản</h2>
<div class ="container">
<form method="post" action="add_user.php">
    <input type="text" name="username" placeholder="Tên đăng nhập"><br><br>
    <input type="text" name="password" placeholder="Mật khẩu"><br><br>
    <button type="submit" name="add">Thêm Tài Khoản</button>
</form>
</div>


