<?php include "../../config.php"; 

if(isset($_POST['add'])){

    $tour_id = $_POST['tour_id'];
    $name = $_POST['nametour'];
    $location = $_POST['location'];
    $des = $_POST['description'];
    $region = $_POST['region'];
    $price = $_POST['price'];
    $date = $_POST['duration'];

    // xử lý ảnh
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if($image != ""){
        move_uploaded_file($tmp, "../database/image/".$image);
    }

    $sql = "INSERT INTO tb_tours (tour_id, nametour, location, image ,description, region, price, duration)
            VALUES ('$tour_id','$name','$location','$image','$des','$region','$price','$date')";

    if(mysqli_query($conn, $sql)){
        echo "<script>
                alert('✅ Thêm tour thành công!');
                window.location='../dashboard.php';
              </script>";
    }else{
        echo "<script>alert('❌ Lỗi khi thêm!');</script>";
    }
}
?>
<head><title>Thêm TOUR</title><link rel="stylesheet" href="../../css/admin/add_tour.css"></head>
<body>
<form method="post" enctype="multipart/form-data" class="form-tour">//ảnh = e
    
    <label>Mã Tour(Số xxxx):</label>
    <input type="text" name="tour_id" required>

    <label>Tên tour:</label>
    <input type="text" name="nametour" required>

    <label>Địa Điểm:</label>
    <input type="text" name="location" required>

    <label>Mô tả:</label>
    <textarea name="description" required></textarea>

    <label>Phân vùng:</label>
    <select name="region">
        <option value="Núi">Núi</option>
        <option value="Biển">Biển</option>
        <option value="Sinh thái">Sinh thái</option>
    </select>

    <label>Giá:</label>
    <input type="number" name="price" required>

    <label>Thời gian:</label>
    <input type="text" name="duration" placeholder="VD: 3 ngày 2 đêm">

    <label>Ảnh:</label>
    <input type="file" name="image">

    <button type="submit" name="add">Thêm</button>

</form>