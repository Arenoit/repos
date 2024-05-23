/* changePassword.addEventListener("click",(e)=>{
    elementModal=`<section class='modal'>
            <div class='modal-container'>
                <h3 class='modal-title'>Cambiar la contraseÃ±a</h3>
                <p class='modal-paragraph'>Recomendado cambiar contraseÃ±a cada cierto periodo de tiempo</p>
                <form action="" method="POST" id="passrev">
                    <label for="ipassword">ContraseÃ±a Actual:</label>
                    <input type="password" id="ipassword" name="ipassword" class="form-control">
                    <label for="opassword">Nueva contraseÃ±a:</label>
                    <input type="password" id="opassword" name="opassword" class="form-control">
                    <label for="password">Vuelve a escribir la contraseÃ±a:</label>
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

            XHR.onreadystatechange = function() {
                if(this.readyState == "4" && this.status =="200" ){
                    let data = XHR.response;
                    if(data=="ContraseÃ±a cambiada correctamente"){
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
}); */