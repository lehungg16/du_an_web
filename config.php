<?php
// Kết nối dữ liệu phpMyAdmin (database)
$conn = mysqli_connect("localhost","root","","travel_web") or die("Kết nối thất bại");
//Gọi session
session_start();
?>