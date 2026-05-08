function loadPage(page){
    const content = document.getElementById("content");
  content.innerHTML = "⏳ Đang tải...";
  
  fetch(page)
    .then(res => res.text())
    .then(data => {
      const content = document.getElementById("content");
      content.innerHTML = data;

      // chạy script bên trong content
      content.querySelectorAll("script").forEach(oldScript => {
        const newScript = document.createElement("script");
        newScript.textContent = oldScript.textContent;
        document.body.appendChild(newScript);
      });
    })
    .catch(err => {
      document.getElementById("content").innerHTML = "❌ Lỗi load trang";
      console.error(err);
    });
}

// load mặc định
window.onload = function(){
  loadPage('dashboard_content.php');
}

const barCtx = document.getElementById('barChart');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['1','2','3','4','5','6','7','8','9','10','11','12'],
        datasets: [{
            label: 'Revenue',
            data: [1200,1900,3000,5000,2000,3000,4000,4500,3200,2800,3500,5000],
            backgroundColor: 'rgba(30,144,255,0.7)'
        }]
    }
});

const pieCtx = document.getElementById('pieChart');
new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: ['Biển','Núi','Sinh thái','Thành phố'],
        datasets: [{
            data: [40,20,25,15],
            backgroundColor: ['#1e90ff','#00bcd4','#4caf50','#ff9800']
        }]
    }
});

function toggleMenu(el){
    let submenu = el.nextElementSibling;

    if(submenu.style.display === "none"){
        submenu.style.display = "block";
        el.querySelector(".arrow").style.transform = "rotate(90deg)";
    }else{
        submenu.style.display = "none";
        el.querySelector(".arrow").style.transform = "rotate(0deg)";
    }
}