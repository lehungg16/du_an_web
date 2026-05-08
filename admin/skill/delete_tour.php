<?php
require_once '../../config.php';

$id = $_GET['id'];

$sql = "DELETE FROM tb_tours WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: ../dashboard.php");
} else {
    echo "Xóa thất bại!";
}