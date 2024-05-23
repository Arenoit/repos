const formSignup = document.querySelector(".boot-form"),
continueBtn = formSignup.querySelector(".submit-btn input"),
successText = document.querySelector(".form-group .success-txt"),
errorText = document.querySelector(".form-group .error-txt"),
warningText = document.querySelector(".form-group .warning-txt");

formSignup.addEventListener('submit', (e)=>{
    e.preventDefault();//preventing form from submitting
    //let's start Ajax
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("POST","../database/reset",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("email="+formSignup.elements[0].value);
    xhr.onreadystatechange = function() {
        if(this.readyState == "4" && this.status =="200" ){
            let data = xhr.response;
            if(data == "validate"){
                // La función se ejecutará después de que la imagen haya cargado correctamente
                successText.textContent="Ha sido enviado un enlace en su dirección de correo electrónico para restablecer la contraseña";
                successText.style.display="block";
                errorText.style.display="none";
                warningText.style.display="none";
            }else{
                errorText.textContent=data;
                errorText.style.display="block";
                successText.style.display="none";
            }
        }
    }
});
