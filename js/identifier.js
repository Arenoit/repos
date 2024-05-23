function sendIdent(valor){
    //let's start Ajax
    let XHR = new XMLHttpRequest(); //creating XML object
    XHR.open("POST","./meeting",true);
    XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    XHR.send("user="+valor);
    XHR.onreadystatechange = function() {
        if(XHR.readyState === XMLHttpRequest.DONE && XHR.status =="200"){
            window.location.href = '..';
        }
    }
}
(function(){
    var temporizador;
    //Timer reset function
    function inactivity() {
        clearTimeout(temporizador);
        temporizador = setTimeout(function() {
            //Activated when the user is inactive
            window.location.href="../session/meeting?exit=1";//Here you can take the actions you want when inactivity is detected
        },300000);//5 minutes to milliseconds
    }
    //Add event listeners to track user activity
    document.addEventListener("mousemove",inactivity);
    document.addEventListener("keypress",inactivity);
    document.addEventListener("click",inactivity);
    document.addEventListener("scroll",inactivity);
    inactivity();//Start timer
})();