// LANGUAGE
let lang="vi";
function toggleLang(){
lang=(lang==="vi")?"en":"vi";
document.querySelectorAll("[data-vi]").forEach(el=>{
el.innerText=el.getAttribute("data-"+lang);
});
document.querySelector(".lang-btn").innerText=lang==="vi"?"EN":"VI";
}
toggleLang();toggleLang();

// ANIMATION
window.addEventListener("scroll",()=>{
document.querySelectorAll(".fade").forEach(el=>{
if(el.getBoundingClientRect().top < window.innerHeight-100){
el.classList.add("show");
}
});
});

// BOOKING
let currentTour="",currentPrice=0;

function openBooking(name,price){
currentTour=name;
currentPrice=price;
document.getElementById("tourName").innerText="Đặt tour: "+name;
document.getElementById("tourText").innerText=name;
document.getElementById("priceText").innerText=price+" VNĐ";
document.getElementById("bookingModal").style.display="flex";
}

function closeBooking(){
document.getElementById("bookingModal").style.display="none";
}

function submitBooking(){
let data={
name:document.getElementById("name").value,
phone:document.getElementById("phone").value,
people:document.getElementById("people").value,
date:document.getElementById("date").value,
tour:currentTour,
price:currentPrice,
status:"Chờ xử lý"
};

let bookings=JSON.parse(localStorage.getItem("bookings"))||[];
bookings.push(data);
localStorage.setItem("bookings",JSON.stringify(bookings));

alert("✅ Đặt tour thành công!");
closeBooking();
}

//sreach
const input = document.getElementById("search");
const box = document.getElementById("suggestions");

input.addEventListener("keyup", function() {

    let keyword = this.value.trim(); // ✅ nằm trong đây

    if(keyword.length < 1){
        box.innerHTML = "";
        return;
    }

    fetch("search.php?keyword=" + encodeURIComponent(keyword)) // ✅ dùng ở đây
    .then(res => res.json())
    .then(data => {

        box.innerHTML = "";

        data.forEach(item => {
            let div = document.createElement("div");

            div.innerHTML = `
                <b>${item.nametour}</b><br>
                <small>${item.price} VNĐ</small>
            `;

            div.onclick = () => {
                input.value = item.nametour;
                box.innerHTML = "";
            };

            box.appendChild(div);
        });

    });
});