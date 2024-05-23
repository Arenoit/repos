const submitRequired = document.getElementById("usrform"),
errorText = document.querySelector(".error-txt");
submitRequired.addEventListener("submit",()=>{
    const inputRequired = document.querySelector("input[required]");
    if (inputRequired.checkValidity()) {
        errorText.style.display="none";
    }
});
submitRequired.querySelector(".btn-save").addEventListener("click",()=>{
    errorText.style.display="block";
    errorText.textContent="Campos requeridos";
});