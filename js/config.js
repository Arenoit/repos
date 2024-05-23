const carerModal = document.querySelector('.separador:nth-child(1)'),
dateModal = document.querySelector('.separador:nth-child(3)'),
overlay = document.querySelector(".home-content");
//New Carers
carerModal.querySelector(".title a").addEventListener("click",function (e) {
        elementModal=`<section class='modal'>
            <div class='modal-container'>
                <h3 class='modal-title'>Agregar Carrera</h3>
                <form action="" method="POST" id="revcarer">
                    <label for="carer">Nueva Carrera:</label>
                    <input type="text" id="carer" name="carer" autocomplete="off" class="form-control">
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
        XHR.send(formData);
        XHR.onreadystatechange = function() {
            if(this.readyState == "4" && this.status =="200" ){
                //Requesting data
                data = this.responseText;
                if(data=="success"){
                    window.location.href="./config";
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
});
//Edit Carers
carerModal.querySelectorAll('.btn.btn-success[name=edit]').forEach(showModal=>{
    showModal.addEventListener("click",function (e) {
        var direction=showModal.getAttribute("direction");
            elementModal=`<section class='modal'>
                <div class='modal-container'>
                    <h3 class='modal-title'>Editar Carrera</h3>
                    <form action="" method="POST" id="revcarer">
                        <label for="ecarer">Cambio de Nombre:</label>
                        <input type="text" id="ecarer" name="ecarer" autocomplete="off" value="${direction}" class="form-control">
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
                        window.location.href="./config";
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
//Delete Carers
carerModal.querySelectorAll('.btn.btn-danger[name=delete]').forEach(showModal=>{
    showModal.addEventListener("click",function (e) {
        var direction=showModal.getAttribute("direction");
        elementModal=`<section class='modal'>
            <div class='modal-container'>
                <i class="fa-regular fa-circle-check"></i>
                <h2 class='modal-title'>Verificación</h2>
                <p class='modal-paragraph'>¿Seguro que quiere eliminar la carrera ${direction}?</p>
                <div class="error-txt" style="display:none"></div>
                <div class="buttons">
                    <a class="modal-accept" href=''>Aceptar</a>
                    <a href='#' class='modal-close'>Cancelar</a>
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
            XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            XHR.send("dcarer="+direction);
            XHR.onreadystatechange = function() {
                if(this.readyState == "4" && this.status =="200" ){
                    //Requesting data
                    data = this.responseText;
                    if(data=="success"){
                        window.location.href="./config";
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
//New Dates
dateModal.querySelector(".title a").addEventListener("click",function (e) {
        elementModal=`<section class='modal'>
            <div class='modal-container'>
                <h3 class='modal-title'>Agregar Fecha</h3>
                <form action="" method="POST" id="revcarer">
                    <label>Nueva Fecha:</label>
                    <div style="display:flex">
                        Desde:&nbsp<input type="number" min="1900" max="2099" step="1" id="idate" name="idate" class="form-control">
                        &nbspHasta:&nbsp<input type="number" min="1900" max="2099" step="1" id="fdate" name="fdate" class="form-control">
                    </div>
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
        formData.append('newdate','1');
        XHR.send(formData);
        XHR.onreadystatechange = function() {
            if(this.readyState == "4" && this.status =="200" ){
                //Requesting data
                data = this.responseText;
                if(data=="success"){
                    window.location.href="./config";
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
});
//Edit Dates
dateModal.querySelectorAll('.btn.btn-success[name=edit]').forEach(showModal=>{
    showModal.addEventListener("click",function (e) {
            var direction=showModal.getAttribute("direction"),
            parts=direction.split(" - ");

            elementModal=`<section class='modal'>
                <div class='modal-container'>
                    <h3 class='modal-title'>Editar Fecha</h3>
                    <form action="" method="POST" id="revcarer">
                        <label>Cambio de Fecha:</label>
                        <div style="display:flex">
                            Desde:&nbsp<input type="number" min="1900" max="2099" step="1" id="idate" name="idate" value="${parts[0]}" class="form-control">
                            &nbspHasta:&nbsp<input type="number" min="1900" max="2099" step="1" id="fdate" name="fdate" value="${parts[1]}" class="form-control">
                        </div>
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
            formData.append('editdate','1');
            formData.append('direction', direction);
            XHR.send(formData);
            XHR.onreadystatechange = function() {
                if(this.readyState == "4" && this.status =="200" ){
                    //Requesting data
                    data = this.responseText;
                    if(data=="success"){
                        window.location.href="./config";
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
//Delete Carers
dateModal.querySelectorAll('.btn.btn-danger[name=delete]').forEach(showModal=>{
    showModal.addEventListener("click",function (e) {
        var direction=showModal.getAttribute("direction");
        elementModal=`<section class='modal'>
            <div class='modal-container'>
                <i class="fa-regular fa-circle-check"></i>
                <h2 class='modal-title'>Verificación</h2>
                <p class='modal-paragraph'>¿Seguro que quiere eliminar la fecha ${direction}?</p>
                <div class="buttons">
                    <a class="modal-accept" href=''>Aceptar</a>
                    <a href='#' class='modal-close'>Cancelar</a>
                </div>
            </div>
        </section>`;
        overlay.insertAdjacentHTML("afterbegin", elementModal);
        modal = document.querySelector(".modal");
        modal.classList.add("modal-show");
        document.querySelector(".modal-accept").addEventListener("click",function (e){
            e.preventDefault();
            const XHR = new XMLHttpRequest();
            //Obtencion de respuesta de la otra pagina
            XHR.open('POST',"../database/config",true);
            XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            XHR.send("deletedate="+direction);
            XHR.onreadystatechange = function() {
                if(this.readyState == "4" && this.status =="200" ){
                    //Requesting data
                    data = this.responseText;
                    if(data=="success"){
                        window.location.href="./config";
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