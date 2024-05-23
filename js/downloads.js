function downloadViewer(rute){
    const nfile=document.querySelectorAll(".download-posts a");
    nfile.forEach((file) => {
        file.addEventListener("click",()=>{
            const XHR = new XMLHttpRequest();
            //Obtencion de respuesta de la otra pagina
            XHR.open('POST',rute,true);
            XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            XHR.send("file="+file.href);
        });
    });
}