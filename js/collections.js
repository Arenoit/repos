const collecModal = document.querySelector(".collection-projects");
//Edit Carers
collecModal.querySelectorAll('.btn.btn-success[name=edit]').forEach(showModal=>{
    showModal.addEventListener("click",function (e) {
        var direction=showModal.getAttribute("direction");
            elementModal=`<section class='modal'>
                <div class='modal-container'>
                    <h3 class='modal-title'>Editar Carrera</h3>
                    <form action="" method="POST" id="revcarer">
                        <label for="ecarer">Cambio de Nombre:</label>
                        <input type="text" id="ecollec" name="ecollec" value="${direction}" class="form-control">
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
            overlay.insertAdjacentHTML("afterbegin", elementModal);
            modal = document.querySelector(".modal");
            modal.classList.add("modal-show");
            const errorText = document.querySelector(".error-txt");
            document.querySelector(".modal-accept").addEventListener("click",function (e){
            e.preventDefault();
            const XHR = new XMLHttpRequest();
            //Obtencion de respuesta de la otra pagina
            XHR.open('POST',"../database/config",true);
            let formData = new FormData(document.querySelector("#revcarer"));
            formData.append('direction', direction);
            XHR.send(formData);
            XHR.onreadystatechange = function() {
                if(this.readyState == "4" && this.status =="200" ){
                    //Requesting data
                    data = this.responseText;
                    if(data=="success"){
                        window.location.href="./search?assortment";
                    }else{
                        errorText.textContent=data;
                        errorText.style.display="block";
                    }
                }
            }
        });
        document.querySelector(".modal-close").addEventListener("click",function (e){
            e.preventDefault();
            modal.classList.remove("modal-show");
        });
    })
});