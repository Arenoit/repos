// Toggling password visibility
const passwordInput = document.getElementById("password"),
passToggleBtn = document.getElementById("pass-toggle-btn"),
successText = document.querySelector(".form-group .success-txt"),
errorText = document.querySelector(".form-group .error-txt");

passToggleBtn.addEventListener('click', () => {
    passToggleBtn.className = passwordInput.type === "password" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
});
const formSignup = document.querySelector(".boot-form"),
continueBtn = formSignup.querySelector(".submit-btn input");

formSignup.addEventListener('submit', (e)=>{
    e.preventDefault();//preventing form from submitting
});
function alertSession(rute){
    let exec=false;//ends function traversal
    continueBtn.addEventListener('click', ()=>{
        if(!exec){
            //let's start Ajax
            let xhr = new XMLHttpRequest(); //creating XML object
            xhr.open("POST",rute,true);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        if(data == "success"){
                            window.location.href="../session/login";
                        }else if(data == "validate"){
                            // La función se ejecutará después de que la imagen haya cargado correctamente
                            successText.textContent="Tu cuenta ha sido creada, por favor verifica haciendo click en el enlace que enviamos en tu correo";
                            successText.style.display="block";
                            errorText.style.display="none";
                            exec=true;
                        }else{
                            errorText.textContent=data;
                            if(successText.textContent!="")errorText.style.display="none";
                            else if(errorText.textContent!="")errorText.style.display="block";
                        }
                    }
                }
            }
            //we have send the form data throuh ajax to php
            let formData = new FormData(formSignup);//creating new formData Oject
            xhr.send(formData);//sending the form data to php
        }
    });
}
