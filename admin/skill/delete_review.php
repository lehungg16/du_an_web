<?php
require_once '../../config.php';

$id = intval($_GET['id']);
$sql = "DELETE FROM tb_reviews WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: ../dashboard.php");
} else {
    echo "Xóa thất bại!";
}