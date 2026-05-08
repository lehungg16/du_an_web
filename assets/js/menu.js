function toggleMenu() {
    var menu = document.getElementById("menu");

    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

function openMenu() {
    document.getElementById("sidebar").style.right = "0";
    document.getElementById("overlay").style.display = "block";
}

function closeMenu() {
    document.getElementById("sidebar").style.right = "-250px";
    document.getElementById("overlay").style.display = "none";
}