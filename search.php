<?php
include "config.php";

$key = $_GET['key'];

$sql = "SELECT * FROM tb_tours 
        WHERE nametour LIKE '%$key%' 
        LIMIT 5";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
    echo "<div onclick=\"window.location='user/tour_detail.php?id=".$row['id']."'\">";
    echo $row['nametour'];
    echo "</div>";
}