<?php
require_once '../../config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM tb_tours WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();
?>

<h2>Chi tiết tour</h2>

<img src="../../data/image/<?= $tour['image'] ?>" width="200"><br>

<p><b>Tên tour:</b> <?= $tour['nametour'] ?></p>
<p><b>Khu vực:</b> <?= $tour['region'] ?></p>
<p><b>Địa điểm:</b> <?= $tour['location'] ?></p>
<p><b>Giá:</b> <?= number_format($tour['price']) ?> VNĐ</p>
<p><b>Thời gian:</b> <?= $tour['duration'] ?></p>

<a href="../dashboard.php">Quay lại</a>