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
<head><title>Thêm TOUR</title><link rel="stylesheet" href="../../assets/css/admin/add_tour.css"></head>
<body>
<form method="post" enctype="multipart/form-data" class="form-tour">
    
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
    <label>Hoặc dán URL ảnh:</label><input type="text" name="image_url"placeholder="https:// ...">
    <!-- Xem trước ảnh -->
<div style="margin-top:10px;">
    <img id="preview"
         src=""
         style="max-width:300px;
                display:none;
                border-radius:10px;
                border:1px solid #ccc;">
</div>

    <button type="submit" name="add">Thêm</button>

</form>
<script>
const imageUrl = document.getElementById("imageUrl");
const preview = document.getElementById("preview");
const imageFile = document.getElementById("imageFile");

// Preview khi nhập URL
imageUrl.addEventListener("input", function () {
    const url = this.value.trim();

    if(url !== ""){
        preview.src = url;
        preview.style.display = "block";
    }else{
        preview.style.display = "none";
    }
});

// Preview khi chọn file từ máy
imageFile.addEventListener("change", function () {
    const file = this.files[0];

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});
</script>