//Right Arrow & Left Arrow
let rightArrow = document.querySelector("#wrapper-carousel .right.carousel-control");
let leftArrow = document.querySelector("#wrapper-carousel .left.carousel-control");
//List of all of the screens in carousel
let screenStore = document.querySelectorAll("#wrapper-carousel .carousel-inner .item");
let numOfScreens = screenStore.length;
//Autogenerate highLighCircles
var circleGroup = document.querySelector("#wrapper-carousel .carousel-indicators");
for(let i = 0; i < numOfScreens; i++) {
    let printCircles = document.createElement('li');
    printCircles.setAttribute("data-slide-to",i);
    if(i==0)printCircles.setAttribute("class","active");
    circleGroup.appendChild(printCircles);
}
//List of all the circle stores
let circleStore = document.querySelectorAll("#wrapper-carousel .carousel-indicators li");
//number to target main screen
let currentScreen = 0;
//Animation Time
let animTime = 600;
let clicksArrow=0;
rightArrow.addEventListener("click", () => {
    clicksArrow++;
    if(clicksArrow<2){
        moveRight();
    }
});
leftArrow.addEventListener("click", () => {
    clicksArrow++;
    if(clicksArrow<2){
        moveLeft();
    }
});
//Sort positioning. Don't want images to overlap
function sortPositioning(mainScreen,leftScreen,rightScreen,direction) {
    //If right screen is undefined. We need to repeat first screen again
    if(rightScreen === undefined){
        rightScreen = screenStore[0];
    }
    //If left screen is undefined. We use the last screen
    if(leftScreen === undefined){
        leftScreen = screenStore[numOfScreens - 1];
    }
    screenStore.forEach(() => {
        if(numOfScreens>1)
        if(direction=="right"){
            leftScreen.style.width=leftScreen.parentElement.clientWidth+"px";
            mainScreen.setAttribute("class","item next");
            leftScreen.setAttribute("class","item active left");
            setTimeout(() => {//helper for blinking eyesight
                leftScreen.style.position="absolute";
                mainScreen.setAttribute("class","item active");//remove next left
            }, 50);
            setTimeout(() => {//helper for blinking eyesight
                leftScreen.setAttribute("class","item");//remove active left
                leftScreen.style.position="";
                leftScreen.style.width="100%";
                clicksArrow=0;
            }, animTime);
        }else{
            rightScreen.style.width=rightScreen.parentElement.clientWidth+"px";
            mainScreen.setAttribute("class","item prev");
            rightScreen.setAttribute("class","item active right");
            setTimeout(() => {//helper for blinking eyesight
                rightScreen.style.position="absolute";
                mainScreen.setAttribute("class","item active");//remove next left
            }, 50);
            setTimeout(() => {//helper for blinking eyesight
                rightScreen.setAttribute("class","item");//remove active left
                rightScreen.style.position="";
                rightScreen.style.width="100%";
                clicksArrow=0;
            }, animTime);
        }
    });
}
//Move to the right
function moveRight(){
    var nCount = 0;
    const idInterval=setInterval(()=>{
        if(nCount<50){
            nCount=nCount+50;
            if(nCount==50){
                //Move towards Next screen as usual
                if(currentScreen < numOfScreens - 1){
                    currentScreen++;
                }else{
                    currentScreen=0;
                }
                sortPositioning(screenStore[currentScreen], screenStore[currentScreen - 1], screenStore[currentScreen + 1],"right");
                highlightCircle(circleStore[currentScreen], "right");
            }
        }else if(nCount==100){
            nCount=0;
            clearInterval(idInterval);
        }
    },50)
}
//Move to the left
function moveLeft(){
    var nCount = 0;
    const idInterval=setInterval(()=>{
        if(nCount<50){
            nCount=nCount+50;
            if(nCount==50){
                //Move towards Next screen as usual
                if(currentScreen > 0){
                    currentScreen--;
                }else{
                    currentScreen = numOfScreens - 1;
                }
                sortPositioning(screenStore[currentScreen], screenStore[currentScreen - 1], screenStore[currentScreen + 1],"left");
                highlightCircle(circleStore[currentScreen], "left");
            }
        }else if(nCount==100){
            nCount=0;
            clearInterval(idInterval);
        }
    },50)
}
//User clicks on one of the circles
circleStore.forEach(circle => {
    circle.addEventListener("click", e => {
        if(circle.getAttribute("class")!="active"){//solution when press circles highLight and error stop
            clicksArrow++;
            if(clicksArrow<2){
                var nCount = 0;
                const idInterval=setInterval(()=>{
                    if(nCount<50){
                        nCount=nCount+50;
                        if(nCount==50){
                            //Convert NodeList to Array, to use 'indexOf' method.
                            let circleStoreArray = Array.prototype.slice.call(circleStore);
                            let circleIndex = circleStoreArray.indexOf(e.target);
                            //Configure circle styling
                            //Work out whether we need to move right or left, or nowhere.
                            if(circleIndex > currentScreen){
                                changeScreenCircleClick(circleIndex, "right");
                            }else if (circleIndex < currentScreen){
                                changeScreenCircleClick(circleIndex, "left");
                            }
                            currentScreen=circleIndex;
                        }
                    }else if(nCount==100){
                        nCount=0;
                        clearInterval(idInterval);
                    }
                },50)
            }
        }
    })
})
function changeScreenCircleClick(circleIndex, direction) {
    //Move towards Next screen as usual
    if(direction === "right"){
        sortPositioning(screenStore[circleIndex], screenStore[currentScreen], screenStore[circleIndex+1],"right");
        highlightCircle(circleStore[circleIndex], "right");
    }else if (direction === "left"){
        sortPositioning(screenStore[circleIndex], screenStore[circleIndex-1], screenStore[currentScreen],"left");
        highlightCircle(circleStore[circleIndex], "left");
    }
}
function highlightCircle(circleSelect, direction) {
    if(circleSelect === undefined && direction === "right"){
        circleSelect = circleStore[0];
    }else if (circleSelect === undefined && direction === "left"){
        circleSelect = circleStore[numOfScreens - 1];
    }
    circleStore.forEach((circle) => {
        if(circle === circleSelect){
            circle.classList.add("active");
        }else{
            circle.classList.remove("active");
        }
    })
}
//Auto Scroll feature
let carousel = document.querySelector("#wrapper-carousel");
let scrollTime = 5000;
let idInterval;
//Only implement the feature if the user has included the attribute 'auto-scroll'.
if(scrollTime){
    //Auto Scroll will be set up the very first time
    const autoWipe = setInterval(() => {
        rightArrow.click();
    }, scrollTime);
    //Clear the timer when they hover on carousel
    carousel.addEventListener("click", (e) => {
        clearInterval(autoWipe);
        //Re-initialise the timer when they just click of the carousel (mouseleave)
        if(e.type=="click")clearInterval(idInterval);
        idInterval = setInterval(() => {
            rightArrow.click();
        }, scrollTime+animTime*2);
    });
}