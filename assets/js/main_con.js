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