const onCheck = document.querySelectorAll('.check-solic i');

onCheck.forEach(check=>{
    check.addEventListener("click",function(){
        const XHR = new XMLHttpRequest();
        //Obtencion de respuesta de la otra pagina
        XHR.open('POST','../database/check',true);
        XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        XHR.send(check.dataset.href);
        XHR.onreadystatechange = function() {
            if(this.readyState == "4" && this.status =="200" ){
                //Requesting data
                document.querySelector('.check-solic p').innerHTML=this.responseText;
            }
        }
    })
});