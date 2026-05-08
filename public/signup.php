<?php include "../config.php"; ?>

<?php
if(isset($_POST['signup'])){

$user = $_POST['username'];
$pass = $_POST['password'];
$repass = $_POST['repassword'];
$fullname = $_POST['fullname'];
$email = $_POST['email']."@gmail.com";
$phone = $_POST['phone'];

// kiểm tra password nhập lại
if($pass != $repass){
    $_SESSION['msg'] = "❌ Mật khẩu không khớp";
    $_SESSION['type'] = "error"; // báo thuộc tính lỗi
    header("Location: signup.php"); //load lại trang nếu pas!=repas
    exit();
}

// kiểm tra trùng user trong database 
$checkUser = mysqli_query($conn, "SELECT * FROM tb_accounts WHERE username='$user'");
// Xử lý chống trùng user với database
if(mysqli_num_rows($checkUser) > 0){
    $_SESSION['msg'] = "❌ Username đã tồn tại!";
    $_SESSION['type'] = "error";
    header("Location: signup.php");
    exit();
}


$sql="INSERT INTO tb_accounts(id,username,password,fullname, email, phone) VALUES('$id','$user','$pass','$fullname','$email','$phone')";
mysqli_query($conn,$sql);
    $_SESSION['msg'] = "✅ Đăng Ký Thành Công.Mời Bạn Đăng Nhập.";
    $_SESSION['type'] = "success";
    
    exit();
}
?>


<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Travel</title>
    <link rel="stylesheet" href="../css/public/signup.css">
</head>
<body>

<div class="signup-container">

    <form method="post" class="signup-form">
        <a href="../index.php" class="close-btn">✖</a>
        <h2>✈️ Đăng ký</h2>

        <input type="text" name="username" placeholder="Tên đăng nhập" required>

        <input type="password" id="password" name="password" placeholder="Mật khẩu" required>

        <input type="password" id="repassword" name="repassword" placeholder="Nhập Lại Mật khẩu" required>
        
        <label class="show-pass" >Hiện mật khẩu<input type="checkbox" onclick="togglePassword()"></label>
        
        <input type="text" name="fullname" placeholder="Fullname" required>
        
        <div class="email-box"><input type="text" name="email" placeholder="Nhập Email" required><span>@gmail.com</span></div>

        <input type="text" name="phone" placeholder="Phone" required>

        <button name="signup">Đăng ký</button>

        <p class="login-link">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </form>

    <div id="popup" class="popup">
    
      <div class="popup-header">
          <span>Thông báo</span>
           <button class="popup-close" onclick="handleClose()">✖</button>
     </div>

    <p id="popup-text"></p>

</div>


</div>

<script>
<?php if(isset($_SESSION['msg'])): ?>
window.onload = function() {
    showPopup("<?php echo $_SESSION['msg']; ?>", "<?php echo $_SESSION['type']; ?>");
};
<?php 
unset($_SESSION['msg']);
unset($_SESSION['type']);
endif; 
?>
</script>
</script>

</body>
</html>
