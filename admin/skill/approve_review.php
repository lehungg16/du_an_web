<?php
require_once '../../config.php';

$id = intval($_GET['id']);
$sql = "UPDATE tb_reviews SET status='Đã Duyệt' WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: ../dashboard.php");
} else {
    echo "Duyệt thất bại!";
}