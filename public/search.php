<?php
include "config.php";

header('Content-Type: application/json');

if(isset($_GET['keyword'])) {

    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);

    $sql = "SELECT nametour, price, image 
            FROM tb_tours 
            WHERE nametour LIKE '%$keyword%' 
            OR location LIKE '%$keyword%'
            LIMIT 5";

    $result = mysqli_query($conn, $sql);

    $data = [];

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; // trả cả object luôn
    }

    echo json_encode($data);
}
?>