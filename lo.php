<?php
include "config.php";

// lấy danh sách tour
$sql = "SELECT * FROM tb_tours ORDER BY id DESC LIMIT 9";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Travel Gia Lai</title>

<style>
body{font-family:Arial;margin:0;background:#f4f6f9}

/* HERO */
.hero{
    background:linear-gradient(120deg,#00b4db,#0083b0);
    color:white;
    padding:60px 20px;
    text-align:center;
}

.search-box{
    position:relative;
    width:300px;
    margin:20px auto;
}

.search-box input{
    width:100%;
    padding:10px;
    border:none;
    border-radius:5px;
}

#suggestions{
    position:absolute;
    background:white;
    width:100%;
    color:black;
    border-radius:5px;
}

#suggestions div{
    padding:8px;
    cursor:pointer;
}
#suggestions div:hover{background:#eee}

/* TOUR */
.tours{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    padding:20px;
}

.card{
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    transition:0.3s;
}
.card:hover{transform:translateY(-5px)}

.card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.content{padding:15px}

.price{color:red;font-weight:bold}

.rating{color:orange}

.btn{
    background:#007bff;
    color:white;
    padding:8px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
</style>

</head>

<body>

<!-- HERO -->
<div class="hero">
    <h1>Khám phá Gia Lai</h1>

    <div class="search-box">
        <input type="text" id="search" placeholder="Bạn muốn đi đâu ?">
        <div id="suggestions"></div>
    </div>
</div>

<!-- TOUR -->
<div class="tours">

<?php while($row = mysqli_fetch_assoc($result)): ?>

<?php
// lấy rating trung bình
$tour_id = $row['id'];

$sql_rating = "SELECT AVG(rating) as avg, COUNT(*) as total 
               FROM tb_reviews 
               WHERE tour_id = $tour_id AND status='Duyệt'";

$res_rating = mysqli_query($conn, $sql_rating);
$rating = mysqli_fetch_assoc($res_rating);

$avg = round($rating['avg'],1);
$total = $rating['total'];
?>

<div class="card">
    <a href="user/tour_detail.php?id=<?php echo $row['id']; ?>">
        <img src="data/image/<?php echo $row['image']; ?>"
             onerror="this.src='data/image/no-image.jpg'">
    </a>

    <div class="content">
        <h3><?php echo $row['nametour']; ?></h3>

        <p><?php echo substr($row['description'],0,50); ?>...</p>

        <div class="rating">
            ⭐ <?php echo $avg ? $avg : "Chưa có"; ?> 
            (<?php echo $total; ?>)
        </div>

        <div class="price">
            <?php echo number_format($row['price']); ?> VNĐ
        </div>

        <a href="user/tour_detail.php?id=<?php echo $row['id']; ?>">
            <button class="btn">Xem chi tiết</button>
        </a>
    </div>
</div>

<?php endwhile; ?>

</div>

<!-- SEARCH AJAX -->
<script>
document.getElementById("search").addEventListener("keyup", function(){
    let key = this.value;

    if(key.length == 0){
        document.getElementById("suggestions").innerHTML="";
        return;
    }

    fetch("search.php?key=" + key)
    .then(res => res.text())
    .then(data => {
        document.getElementById("suggestions").innerHTML = data;
    });
});

function selectTour(name){
    document.getElementById("search").value = name;
    document.getElementById("suggestions").innerHTML="";
}
</script>

</body>
</html>