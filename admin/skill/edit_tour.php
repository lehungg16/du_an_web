<?php
require_once '../../config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM tb_tours WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tour = $result->fetch_assoc();

if(isset($_POST['update'])) {

    $name = $_POST['nametour'];
    $region = $_POST['region'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $sql = "UPDATE tb_tours 
            SET nametour=?, region=?, location=?, price=?, duration=? 
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $name, $region, $location, $price, $duration, $id);

    if($stmt->execute()){
        header("Location: ../dashboard.php");
    } else {
        echo "Lỗi cập nhật!";
    }
}
?>

<form method="POST">
    <input type="text" name="nametour" value="<?= $tour['nametour'] ?>"><br>
    <input type="text" name="region" value="<?= $tour['region'] ?>"><br>
    <input type="text" name="location" value="<?= $tour['location'] ?>"><br>
    <input type="number" name="price" value="<?= $tour['price'] ?>"><br>
    <input type="text" name="duration" value="<?= $tour['duration'] ?>"><br>

    <button name="update">Cập nhật</button>
</form>