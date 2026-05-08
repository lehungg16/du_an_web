function togglePassword() {
    var pass = document.getElementById("password");
    var repass = document.getElementById("repassword");

    if (pass.type === "password") {
        pass.type = "text";
        repass.type = "text";
    } else {
        pass.type = "password";
        repass.type = "password";
    }
}

let popupType = ""; // lưu loại success / error
function showPopup(message, type) {
    let popup = document.getElementById("popup");
    let text = document.getElementById("popup-text");

    popup.classList.add("show", type);
    text.innerText = message;

    popupType = type; // lưu lại để xử lý khi bấm X
}

function handleClose() {
    if (popupType === "success") {
        window.location.href = "login.php"; // thành công → qua login
    } else {
        document.getElementById("popup").classList.remove("show"); // lỗi → đóng
    }
}

body {
    margin: 0;
    font-family: Arial, sans-serif;

    background: url('../database/image/nen1.jpg') no-repeat center center/cover;

    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* lớp phủ */
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

/* container */
.signup-container {
    position: relative;
    z-index: 1;
}

.signup-form {
    background: rgba(255,255,255,0.95);
	position: relative; /* bắt buộc để nút bám theo form */
    padding: 30px;
    border-radius: 12px;
    width: 320px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 12px;
    text-decoration: none;
    font-size: 18px;
    color: #888;
    font-weight: bold;
    transition: 0.2s;
}

/* hover cho xịn */
.close-btn:hover {
    color: red;
    transform: scale(1.2);
}

.signup-form h2 {
    margin-bottom: 20px;
    color: #ff5722;
}

.signup-form input {
    width: 74%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.signup-form button {
    width: 80%;
    padding: 10px;
    background: #ff5722;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.signup-form button:hover {
    background: #e64a19;
}

.login-link {
    margin-top: 10px;
    font-size: 14px;
}

.login-link a {
    color: #ff5722;
    text-decoration: none;
}

.email-box {
    position: relative;
    width: 100%;
}

.email-box input {
    width: 75%;
    padding-right: 80px; /* chừa chỗ cho @gmail.com */
}

.email-box span {
    position: absolute;
    right: 50px;
    top: 50%;
    transform: translateY(-50%);
    color: gray;
    pointer-events: none;
}

.show-pass {
    display: flex;
    justify-content: flex-end; /* đẩy sang phải */
    align-items: center;
    gap: 0px; /* khoảng cách chữ và ô */
    margin: -10px 0 -10px;
    font-size: 14px;
    cursor: pointer;
}

.show-pass input {
    width: 40%; /* tránh bị kéo dài */
}

.message {
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 6px;
    font-weight: bold;
}

.success {
    background: #d4edda;
    color: #155724;
}

.error {
    background: #f8d7da;
    color: #721c24;
}
.popup {
    display: none;
    position: fixed;
    top: 20px;
    right: -300px; /* ẩn ngoài */
    width: 245px;

    padding: 15px;
    border-radius: 10px;
    background: #fff;

    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transition: 0.4s;
    z-index: 9999;
}

/* hiện popup */
.popup.show {
    right: 20px;
}

/* header */
.popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    font-weight: bold;
    margin-bottom: 10px;
}

/* nội dung */
.popup p {
    text-align: center;
}

/* nút X */
.popup-close {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

.popup-close:hover {
    color: red;
    transform: scale(1.2);
}

/* màu */
.popup.success {
    border-left: 6px solid #28a745;
}

.popup.error {
    border-left: 6px solid #dc3545;
}

<?php include "config.php"; ?>

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

//tạo id ngẫu nhiên
function generateID() {
    $letter = chr(rand(65, 90)); // A-Z
    $number = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
    return $letter . "_" . $number;
}
// tạo id ko trùng
do {
    $id = generateID();
    $check = mysqli_query($conn, "SELECT id FROM tb_accounts WHERE id='$id'");
} while(mysqli_num_rows($check) > 0);

$sql="INSERT INTO tb_accounts(id,username,password,fullname, email, phone) VALUES('$id','$user','$pass','$fullname','$email','$phone')";
mysqli_query($conn,$sql);
    $_SESSION['msg'] = "✅ Đăng Ký Thành Công.Mời Bạn Đăng Nhập.";
    $_SESSION['type'] = "success";
    header("Location: signup.php"); 
    exit();
}
?>


<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Travel</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>

<div class="signup-container">

    <form method="post" class="signup-form">
        <a href="index.php" class="close-btn">✖</a>
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

<script src="js/signup.js"></script>
<script>
<?php if(isset($_SESSION['msg'])): ?>
    showPopup("<?php echo $_SESSION['msg']; ?>", "<?php echo $_SESSION['type']; ?>");
<?php 
unset($_SESSION['msg']);
unset($_SESSION['type']);
endif; 
?>
</script>

</body>
</html>
