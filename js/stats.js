const pieGraph = document.querySelector('.pie-graph'),
tooltips = pieGraph.querySelectorAll(".tooltip"),
circles = pieGraph.querySelectorAll("circle");
let currentPercentage = 0;
var graphInterval = setInterval(updateGradient, 50);
function updateGradient() {
    if(currentPercentage<=100)currentPercentage = currentPercentage+5; // Incrementa el porcentaje (ajusta según sea necesario)
        for (let i = 0; i < circles.length; i++) {
            circles[i].style.strokeDasharray=`${(currentPercentage<circles[i].dataset.percentage)?currentPercentage:circles[i].dataset.percentage} var(--circumference)`;
        }
    if(currentPercentage==100)clearInterval(graphInterval);
}
const barsChart = document.querySelector(".chart"),
tooltips2 = barsChart.querySelectorAll(".tooltip");
barsChart.querySelectorAll("li .bar").forEach(bar => {
    var percentage = bar.dataset.percentage;
    setTimeout(() => {
        bar.style.height=percentage+'%';
    }, 1000);
});
document.addEventListener('DOMContentLoaded', function () {
    tooltips.forEach((NULL,index) => {
        document.addEventListener("mouseover",(e)=>{
            if(pieGraph.querySelectorAll("circle")[index].contains(e.target)){
                tooltips[index].style.left=e.clientX-pieGraph.getBoundingClientRect().left-115 + "px";
                tooltips[index].style.top=e.clientY+window.pageYOffset-260 + "px";
                tooltips[index].style.display="inline-block";
            }else tooltips[index].style.display="none";
        });
    });
    tooltips2.forEach((NULL,index) => {
        document.addEventListener('mouseover', function (e) {
            if(barsChart.querySelectorAll("li .bar")[index].contains(e.target)){
                tooltips2[index].style.left=e.clientX-document.querySelector(".sidebar").offsetWidth-40 + "px";
                if(document.querySelector(".sidebar").clientWidth=="0")tooltips2[index].style.left=e.clientX-barsChart.getBoundingClientRect().left-30 + "px";
                tooltips2[index].style.top=e.clientY+window.pageYOffset-40 + "px";
                tooltips2[index].style.display="inline-block";
            }else tooltips2[index].style.display="none";
        });
    });
});
