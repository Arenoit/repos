const openModal = document.querySelectorAll('.btn.btn-danger[name=delete]'),
overlay = document.querySelector(".home-content");

function deleteFile(ubication,tabndex) {
    openModal.forEach(showModal=>{
        showModal.addEventListener("click",function(){
            var direction=showModal.getAttribute("direction");
            direction=(tabndex=="yes")?showModal.tabIndex:direction.slice(3);//case in which the index is provided other than the table
            elementModal=`<section class='modal'>
                <div class='modal-container'>
                    <i class="fa-regular fa-circle-check"></i>
                    <h2 class='modal-title'>Verificación</h2>
                    <p class='modal-paragraph'>¿Seguro que quiere eliminar el proyecto (${direction})?</p>
                    <div class="buttons">
                        <a class="modal-accept" href=''>Aceptar</a>
                        <a href='#' class='modal-close'>Cancelar</a>
                    </div>
                </div>
            </section>`;
            overlay.insertAdjacentHTML("afterbegin", elementModal);
            //document.querySelector(".modal-accept").href=ubication+"?id="+direction;
            document.querySelector(".modal-accept").addEventListener("click",function (e) {
                const XHR = new XMLHttpRequest();
                //Obtencion de respuesta de la otra pagina
                XHR.open('POST',ubication,true);
                XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                XHR.send("id="+direction);
                XHR.onreadystatechange = function() {
                    if(this.readyState == "4" && this.status =="200" ){
                        //Requesting data
                        window.location.href=window.location.href;
                    }
                }
            });
            modal = document.querySelector(".modal");
            modal.classList.add("modal-show");
            document.querySelector(".modal-close").addEventListener("click",function (e){
                e.preventDefault();
                modal.classList.remove("modal-show");
            });
        })
    });
}
