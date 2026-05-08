<?php
include "../config.php";
//xóa phiên làm việc
session_destroy();
//chuyển đến trang chủ
header("location:../index.php");
?>