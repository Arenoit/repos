const uploadForm = document.querySelector(".wrapper-file form")
fileinput = uploadForm.querySelector(".file-input"),
progressArea = document.querySelector(".progress-area"),
uploadedArea = document.querySelector(".uploaded-area");

uploadForm.addEventListener("click",()=>{
    fileinput.click();
});
fileinput.onchange = ({target}) =>{
    let file = target.files[0];//getting file and [0] this means if user has selected multiples files then get first one only
    if(file){//if file is selected
      let fileName = file.name;
      if(fileName.length >= 12){//if fileName length is greather or equal to 12 the split the name and add ...
        let splitName = fileName.split('.');
        fileName = splitName[0].substring(0,12) + "... ." + splitName[1];
      }
      uploadFile(fileName);//calling uploadFile with passing file name as an argument
    }
}
function uploadFile(name){
    var url = window.location.href,//Get current URL
    urlObj = new URL(url),//Create a URL object
    varFile = urlObj.searchParams.get("id");//Get parameter values URL

    let xhr = new XMLHttpRequest();
    xhr.open("POST","../database/upload");
    xhr.upload.addEventListener("progress", ({loaded,total}) =>{
        let fileLoaded = Math.floor((loaded/total)*100),//getting percentage of loaded file size
        fileTotal = Math.floor(total/1000),
        fileSize;
        //if file size is less than 1024 then add only KB else convert size into KB to MB
        (fileTotal < 1024) ? fileSize = fileTotal + " KB": fileSize = (loaded/(1024*1024)).toFixed(2) + " MB";
        let progressHTML = `<li class="row">
        <i class="fas fa-file-alt"></i>
        <div class="content">
          <div class="details">
            <span class="name">${name}</span>
            <span class="percent">${fileLoaded}</span>
          </div>
          <div class="progress-bar">
            <div class="progress" style="width: ${fileLoaded}%"></div>
          </div>
        </div>
      </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if(loaded == total){
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row">
        <div class="content">
          <i class="fas fa-cloud-upload-alt"></i>
          <div class="details">
            <span class="name">${name} • Subida</span>
            <span class="size">${fileSize}</span>
          </div>
        </div>
        <i class="fas fa-check"></i>
      </li>`;
          uploadedArea.classList.remove("onprogress");
          uploadedArea.innerHTML=uploadedHTML;
        }
        /* if(this.readyState == "4"&&this.status =="200"){
          //Requesting data
          data=this.responseText;
          console.log(data);
        } */
    });
    let formData = new FormData(uploadForm);
    formData.append('varfile', varFile);
    xhr.send(formData);
}
//If user Drag File Over DragArea
let eventAux1=[];
document.body.addEventListener("dragover",(e)=>{
    e.preventDefault();//Prevent from default behavior
    if(uploadForm.contains(e.target)){
        uploadForm.querySelector("p").innerHTML = "Soltar para subir";
        eventAux1=uploadForm.contains(e.target);
    }else{
        eventAux1="false";
    }
});
uploadForm.addEventListener("dragleave",()=>{
    setInterval(() => {//helper for crop image
        if(eventAux1=="false"){
          uploadForm.querySelector("p").innerHTML = "Arrastre un archivo para subir";
        }
    },400);
});
document.body.addEventListener("drop",(e)=>{
    e.preventDefault();//Prevent from default behavior
    if(eventAux1!="false"){
      var file = e.dataTransfer.files[0];
      uploadForm.querySelector("p").innerHTML = "Arrastre un archivo para subir";
      if(file.type==='application/pdf'){//if file is selected
        var listFiles = new DataTransfer();
        listFiles.items.add(file);
        fileinput.files = listFiles.files;
        let fileName = file.name;
        if(fileName.length >= 12){//if fileName length is greather or equal to 12 the split the name and add ...
          let splitName = fileName.split('.');
          fileName = splitName[0].substring(0,12) + "... ." + splitName[1];
        }
        uploadFile(fileName);//calling uploadFile with passing file name as an argument
      }
    }
});