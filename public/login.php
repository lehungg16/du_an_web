<?php include "../config.php" ?>
<?php

if(isset($_POST['login'])){

$user=$_POST['username'];
$pass=$_POST['password'];

$sql="SELECT * FROM tb_accounts WHERE username='$user' AND password='$pass'";

$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){

$row=mysqli_fetch_assoc($result);

$_SESSION['user']=$row['username'];
$_SESSION['user_id']=$row['id'];
$_SESSION['role']=$row['role'];
var_dump($_SESSION);
header("location:../index.php");

}else{
echo "Sai tài khoản";
}

}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Travel</title>
    <link rel="stylesheet" href="../css/public/login.css">
</head>

<body>

<div class="login-container">

    <form method="post" class="login-form">
        <a href="../index.php" class="close-btn">✖</a>
        <h2>🌍 Đăng nhập</h2>

        <input type="text" name="username" placeholder="Tên đăng nhập" required>

        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button name="login">Đăng nhập</button>

        <p class="signup-link">Chưa có tài khoản? <a href="signup.php"> Đăng ký</a></p>
    </form>

</div>

</body>
</html>
