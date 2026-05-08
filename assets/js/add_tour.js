function showPopup(message){
    document.getElementById("popup-text").innerText = message;
    document.getElementById("popup").style.display = "block";
}

function closePopup(){
    //document.getElementById("popup").style.display = "none";

    // nếu muốn chuyển trang sau khi OK
    window.location.href = "../user/tour.php";
}