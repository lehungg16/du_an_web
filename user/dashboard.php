<?php
include "../config.php";

// ❌ Chưa login thì đá về login
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

// ❌ Không phải user (ví dụ admin vào) thì chặn
if($_SESSION['role'] != "0"){ // 0 = user, 1 = admin
    die("Bạn không có quyền truy cập trang này");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Travel Gia Lai</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f5f7fa;
}

/* HEADER */
header{
    display:flex;
    justify-content:space-between;
    padding:15px 40px;
    background:#0a9396;
    color:white;
}

header nav a{
    margin:0 10px;
    color:white;
    text-decoration:none;
}

/* HERO */
.hero{
    height:400px;
    background:url("https://images.unsplash.com/photo-1501785888041-af3ef285b470") center/cover;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:40px;
    font-weight:bold;
}

/* TOUR */
.tours{
    padding:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-10px);
}

.card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.card .content{
    padding:15px;
}

button{
    padding:10px;
    background:#0a9396;
    border:none;
    color:white;
    cursor:pointer;
}

/* MODAL */
.modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    display:none;
    justify-content:center;
    align-items:center;
}

.modal-content{
    background:white;
    padding:20px;
    width:300px;
}

/* HISTORY */
.history{
    padding:40px;
}

.item{
    background:white;
    margin:10px 0;
    padding:10px;
}
</style>
</head>

<body>

<header>
    <h2>Travel Gia Lai</h2>
    <nav>
        <a href="#">Trang chủ</a>
        <a href="#">Tour</a>
        <a href="#">Lịch sử</a>
    </nav>
</header>

<div class="hero">Khám phá Gia Lai</div>

<div class="tours" id="tourList"></div>

<h2 style="padding-left:40px">Lịch sử đặt tour</h2>
<div class="history" id="history"></div>

<!-- MODAL -->
<div class="modal" id="modal">
    <div class="modal-content">
        <h3>Đặt tour</h3>
        <input placeholder="Tên" id="name"><br><br>
        <input placeholder="SĐT" id="phone"><br><br>
        <input type="number" placeholder="Số người" id="people"><br><br>
        <input type="date" id="date"><br><br>
        <button onclick="submitBooking()">Xác nhận</button>
    </div>
</div>

<script>
let tours = [
    {name:"Biển Hồ", price:500000, img:"https://images.unsplash.com/photo-1507525428034-b723cf961d3e"},
    {name:"Thác Phú Cường", price:600000, img:"https://images.unsplash.com/photo-1506744038136-46273834b3fb"},
    {name:"Chư Đăng Ya", price:700000, img:"https://images.unsplash.com/photo-1501785888041-af3ef285b470"}
];

let selectedTour = "";

// load tours
function loadTours(){
    let html="";
    tours.forEach(t=>{
        html+=`
        <div class="card">
            <img src="${t.img}">
            <div class="content">
                <h3>${t.name}</h3>
                <p>${t.price} VNĐ</p>
                <button onclick="openModal('${t.name}')">Đặt tour</button>
            </div>
        </div>`;
    });
    document.getElementById("tourList").innerHTML=html;
}

function openModal(name){
    selectedTour=name;
    document.getElementById("modal").style.display="flex";
}

function submitBooking(){
    let data={
        name:document.getElementById("name").value,
        phone:document.getElementById("phone").value,
        people:document.getElementById("people").value,
        date:document.getElementById("date").value,
        tour:selectedTour,
        status:"Chờ xử lý"
    };

    let bookings=JSON.parse(localStorage.getItem("bookings"))||[];
    bookings.push(data);
    localStorage.setItem("bookings",JSON.stringify(bookings));

    alert("Đặt thành công!");
    location.reload();
}

// load history
function loadHistory(){
    let bookings=JSON.parse(localStorage.getItem("bookings"))||[];
    let html="";
    bookings.forEach(b=>{
        html+=`<div class="item">${b.name} - ${b.tour} - ${b.status}</div>`;
    });
    document.getElementById("history").innerHTML=html;
}

loadTours();
loadHistory();
</script>

</body>
</html>