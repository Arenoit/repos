const uploadBox = document.querySelector(".upload-box"),
previewImg = uploadBox.querySelector("img"),
fileInput = uploadBox.querySelector("input"),
uploadBtn = uploadBox.querySelector(".upload-btn"),
updateData = document.querySelector(".user-update"),
updateImg = uploadBox.querySelector(".fa-solid.fa-pencil"),
editImg = uploadBox.querySelectorAll(".edit-img ul"),
namenav1 = document.querySelector("nav .profile-details span"),
namenav2 = document.querySelector("nav .user-info h4"),
imguser = document.querySelectorAll("nav img"),
changePassword = document.querySelector("#changepass");
let loading=0;

if(previewImg.src!=window.location.href){
    updateImg.classList.add("active");
}else{
    uploadBox.classList.add("active");
    previewImg.src="../images/upload-icon.svg";
}
let validExtensions = ["image/jpeg","image/jpg","image/png"];//adding some valid image extensions in array
function showFile(){
    if(loading==0){
        const canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        const zoom = previewImg.naturalHeight;
        inicioX=(previewImg.naturalWidth-zoom)*2/4;
        inicioY=0;
        canvas.width = "200";
        canvas.height = "200";
        ctx.fillStyle = '#ffffff'; // Establece el fondo en blanco
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        //drawing user selected image onto the canvas
        ctx.drawImage(previewImg,inicioX,inicioY,zoom,zoom,0,0,canvas.width,canvas.height);
        if(!uploadBox.classList.contains("active")){
            previewImg.src = canvas.toDataURL("image/jpeg", 1);
            //PETICION AJAX
            var imgBase64 = previewImg.src.split(',')[1];// elimina el encabezado extra del base64
            var binaryData = atob(imgBase64);// Convierte la cadena Base64 en datos binarios
            
            var arrayBuffer = new ArrayBuffer(binaryData.length);//Crea un ArrayBuffer para almacenar los datos binarios
            var uint8Array = new Uint8Array(arrayBuffer);//Crea una vista de 8 bits (Uint8Array) para trabajar con el ArrayBuffer
            for (var i = 0; i < binaryData.length; i++) {// Copia los datos binarios en el Uint8Array
                uint8Array[i] = binaryData.charCodeAt(i);
            }
            // Crea una instancia de XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open("POST","../database/photouser",true);
            xhr.setRequestHeader("Content-Type", "application/octet-stream");//Configura el encabezado para indicar que estás enviando datos binarios
            xhr.send(arrayBuffer);//Envía los datos binarios en el cuerpo de la solicitud
            xhr.onload = function () {//Define la función de devolución de llamada cuando se complete la solicitud
                if(xhr.status === 200){
                    updateImg.classList.add("active");
                    fileInput.value="";
                    imguser[0].src=previewImg.src;
                    imguser[1].src=previewImg.src;
                }
            };
        }
        loading=1;
    }
}

fileInput.addEventListener("change",(e)=>{//detect changes when click Button but not released
    // Código del segundo evento
    if(previewImg.src=="http://"+window.location.href.split('https://')[0].split('/steward')[0]+"/images/upload-icon.svg")previewImg.src="";
    const file = e.target.files[0]; // Obteniendo el primer archivo seleccionado por el usuario
    let fileType = file.type;
    if(validExtensions.includes(fileType)) {
        previewImg.onload = () => {
            // La función se ejecutará después de que la imagen haya cargado correctamente
            showFile();
        };
        uploadBox.setAttribute("class","upload-box");
        previewImg.src = URL.createObjectURL(file); // Estableciendo la URL del archivo seleccionado en la imagen
        loading=0;
    }
    if(!file){return};//return if user hasn't selected any file
});
uploadBtn.addEventListener("click",()=>{
    fileInput.click();
});
//If user Drag File Over DragArea
let eventAux1=[];
document.body.addEventListener("dragover",(e)=>{
    e.preventDefault();//Prevent from default behavior
    if(uploadBox.contains(e.target)){
        uploadBox.querySelector("p").innerHTML = "Soltar para subir";
        eventAux1=uploadBox.contains(e.target);
    }else{
        eventAux1="false";
    }
});
uploadBox.addEventListener("dragleave",()=>{
    setInterval(() => {//helper for crop image
        if(eventAux1=="false"){
            uploadBox.querySelector("p").innerHTML = "Arrastre una imagen para subir";
        }
    },400);
});
document.body.addEventListener("drop",(e)=>{
    e.preventDefault();//Prevent from default behavior
    if(uploadBox.contains(e.target)&&previewImg.src.indexOf("images/upload-icon.svg") != -1){
        const file = e.dataTransfer.files[0];
        let fileType = file.type;
        if(validExtensions.includes(fileType)){
            uploadBox.querySelector("p").style.display="none";
            uploadBtn.style.display="none";
            //Nuevo arreglo para que funcione sin problemas de cache
            previewImg.onload = () => {
                // La función se ejecutará después de que la imagen haya cargado correctamente
                showFile();
            };
            uploadBox.setAttribute("class","upload-box");
            previewImg.src = URL.createObjectURL(file);//passing selected file url to preview img src
            loading=0;
        }
    }
});
document.body.addEventListener("click",(e)=>{
    if(updateImg.contains(e.target))editImg[0].parentElement.classList.toggle("active");
    else editImg[0].parentElement.setAttribute("class","edit-img");
});
editImg[0].addEventListener("click",()=>{//edit img
    fileInput.click();
    editImg[0].parentElement.setAttribute("class","edit-img");
});
editImg[1].addEventListener("click",(e)=>{//delete img
    elementModal=`<section class='modal'>
            <div class='modal-container'>
                <i class="fa-regular fa-circle-check"></i>
                <h2 class='modal-title'>Verificación</h2>
                <p class='modal-paragraph'>¿Seguro que quieres eliminar la foto de perfil?</p>
                <div class="buttons">
                    <a class="modal-accept" href=''>Aceptar</a>
                    <a href='' class='modal-close'>Cancelar</a>
                </div>
            </div>
        </section>`;
    updateData.parentElement.insertAdjacentHTML("afterbegin", elementModal);
    e.preventDefault();
    modal = document.querySelector(".modal");
    modal.classList.add("modal-show");
    modal.addEventListener("click",function (e){
        if(modal.querySelector(".modal-accept").contains(e.target)){
            e.preventDefault();
            //Peticcion Ajax
            const XHR = new XMLHttpRequest();
            //Obtencion de respuesta de la otra pagina
            XHR.open('POST',"../database/photouser",true);
            XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            XHR.send("deleteimg="+1);
            XHR.onreadystatechange = function() {
                if(this.readyState == "4" && this.status =="200" ){
                    previewImg.src="";
                    updateImg.classList.remove("active");
                    editImg[0].parentElement.setAttribute("class","edit-img");
                    uploadBox.classList.add("active");
                    uploadBox.querySelector("p").style.display="";
                    uploadBtn.style.display="";
                    uploadBox.querySelector("p").innerHTML="Arrastre una imagen para subir";
                    previewImg.src="../images/upload-icon.svg";
                    imguser[0].src="../images/default-user.jpeg";
                    imguser[1].src="../images/default-user.jpeg";
                }
            }
            modal.classList.remove("modal-show");
        }
        if(modal.querySelector(".modal-close").contains(e.target)){
            e.preventDefault();
            modal.classList.remove("modal-show");
        }
    });
});
updateData.addEventListener("submit",(e)=>{
    e.preventDefault();
    errorText = document.querySelector(".error-txt");
    successText = document.querySelector(".success-txt");
    var data = {
        name: updateData.elements[0].value,
        email: updateData.elements[1].value,
        user: updateData.elements[2].value,
        bio: updateData.elements[4].value,
        occupation: updateData.elements[5].value
      };
    //Peticcion Ajax
    const XHR = new XMLHttpRequest();
    //Obtencion de respuesta de la otra pagina
    XHR.open('POST',"../database/account",true);
    XHR.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    // Convertir el objeto en una cadena JSON
    var jsonData = JSON.stringify(data);
    XHR.send(jsonData);//sending the form data to php
    XHR.onreadystatechange = function() {
        if(this.readyState == "4" && this.status =="200"){
            dataAJax = JSON.parse(this.responseText);
            namenav1.innerHTML=dataAJax[0]['user'];
            namenav2.innerHTML=dataAJax[0]['user'];
            updateData.elements[1].value=dataAJax[0]['email'];
            updateData.elements[2].value=dataAJax[0]['user'];
            if(dataAJax[0]['menssage']=="datos guardados correctamente"){
                successText.textContent=dataAJax[0]['menssage'];
                successText.style.display="block";
                errorText.style.display="none";
            }else{
                errorText.textContent=dataAJax[0]['menssage'];
                errorText.style.display="block";
                successText.style.display="none";
            }
        }
    }
});



changePassword.addEventListener("click",(e)=>{
    elementModal=`<section class='modal'>
            <div class='modal-container'>
                <h3 class='modal-title'>Cambiar la contraseña</h3>
                <p class='modal-paragraph'>Recomendado cambiar contraseña cada cierto periodo de tiempo</p>
                <form action="" method="POST" id="passrev">
                    <label for="ipassword">Contraseña Actual:</label>
                    <input type="password" id="ipassword" name="ipassword" class="form-control">
                    <label for="opassword">Nueva contraseña:</label>
                    <input type="password" id="opassword" name="opassword" class="form-control">
                    <label for="password">Vuelve a escribir la contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control">
                </form>
                <br>
                <div class="error-txt" style="display:none"></div>
                <br>
                <div class="buttons">
                    <a class="modal-accept" href=''>Aceptar</a>
                    <a href='' class='modal-close'>Cancelar</a>
                </div>
            </div>
        </section>`;
    updateData.parentElement.insertAdjacentHTML("afterbegin", elementModal);
    e.preventDefault();
    modal = document.querySelector(".modal"),
    errorText = document.querySelector(".error-txt");
    successText = document.querySelector(".success-txt");
    modal.classList.add("modal-show");
    modal.addEventListener("click",function (e){
        if(modal.querySelector(".modal-accept").contains(e.target)){
            e.preventDefault();
            //Peticcion Ajax
            const XHR = new XMLHttpRequest();
            //Obtencion de respuesta de la otra pagina
            XHR.open('POST',"../database/changepass",true);
            let formData = new FormData(document.querySelector("#passrev"));
            //formData.append('varfile', varFile);
            XHR.send(formData);
            XHR.onreadystatechange = function(){
                if(this.readyState == "4" && this.status =="200" ){
                    let data = XHR.response;
                    if(data=="Contraseña cambiada correctamente"){
                        modal.classList.remove("modal-show");
                        successText.textContent=data;
                        successText.style.display="block";
                    }
                    else{
                        errorText.textContent=data;
                        errorText.style.display="block";
                    }
                }
            }
        }
        if(modal.querySelector(".modal-close").contains(e.target)){
            e.preventDefault();
            modal.classList.remove("modal-show");
        }
    });
});
