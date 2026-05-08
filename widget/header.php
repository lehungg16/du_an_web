<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>✈ Travel Gia Lai</title>
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/public/main_con.css">
</head>

<body>

<header>
    <h2>✈ Travel Gia Lai</h2>
    <nav>
        <a href="index.php" data-vi="Trang chủ" data-en="Home"></a>
        <a href="user/tours.php" data-vi="Tour" data-en="Tours"></a>
        <a href="#about" data-vi="Giới thiệu" data-en="About"></a>
        <a href="#contact" data-vi="Liên hệ" data-en="Contact"></a>
        <?php
        if(isset($_SESSION['user'])){
            echo '<a href="public/logout.php">Logout</a>';

	        if($_SESSION['role']=="1"){
	    	    header("location:admin/dashboard.php");
	        }
        }else{
                echo '<a href="public/login.php" data-vi="Đăng Nhập" data-en="Contact"></a>';
                echo '<a href="public/signup.php" data-vi="Đăng Ký" data-en="Contact"></a>';
            }        
        ?>
    </nav>
    <button class="lang-btn" onclick="toggleLang()">EN</button>
</header>