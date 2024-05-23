(function(){
  const sidebar = document.querySelector(".sidebar"),
  sidebarBtn = document.querySelector(".sidebarBtn"),
  userOptions = document.querySelector("nav .profile-details")
  subOptions = userOptions.querySelector(".user-options"),

  notifications = document.querySelector(".notifications"),
  notify = notifications.querySelector(".notify"),
  notifyOptions = notifications.querySelector(".notify-options"),
  usersList = document.querySelector(".wrapper-box .users-list"),
  searchBar = document.querySelector(".wrapper-box .search input");
  let incoming = document.querySelector("input[name=incoming_id]");

  sidebarBtn.addEventListener("click",()=>{
    sidebar.classList.toggle("active");
    if(sidebar.classList.contains("active"))sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
    else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
  });
  document.addEventListener("click",(e)=>{
    if(subOptions.contains(e.target))subOptions.setAttribute("class","user-options active");
    else if(userOptions.contains(e.target))subOptions.classList.toggle("active");
    else subOptions.setAttribute("class","user-options");

    if(notifications.contains(e.target))notifyOptions.classList.toggle("active");
    else notifyOptions.setAttribute("class","notify-options");
  });
  //Agregar event listener para detectar cuando la ventana pierde foco
  let windowFocused = 1;
  window.addEventListener('blur',()=>{windowFocused=0;});
  document.addEventListener('visibilitychange',()=>{windowFocused = 3;});
  window.addEventListener('focus',()=>{windowFocused = 3;});
  function printNotify(container,data){
    listData = `<a class='' id="${(container==usersList)?'s-':'n-'}${data['cod']}" href="./menssages?chat=${data['cod']}">
    <div class="content">
        <img src="${data['image']}" alt="">
        <div class="details">
            <span>${data['usr']}</span>
            <p>${(container==usersList)?data['usr']:'Nuevo mensaje'}</p>
        </div>
    </div>
    <div class="status-dot">
        ${(data['read']!=0)?`<div class="vineta"><p class="globo">${data['read']}</p></div>`:''}
    </div>
    </a>`;
    container.insertAdjacentHTML("afterbegin",listData);
  }
  var nCount=0;
  function notifyBell(){
    const idInterval=setInterval(()=>{
      if(nCount<50){
          nCount=nCount+50;
          if(nCount==50){
            let xhr = new XMLHttpRequest(); //creating XML object
            xhr.open("POST","../database/allnotify",true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send("");
            xhr.onreadystatechange = function(){
              if(xhr.readyState === XMLHttpRequest.DONE && xhr.status =="200"){
                if(xhr.response!=""){
                  let data=JSON.parse(xhr.response);order = [];j=0;
                  for(let i=data.length-1;i>=0;i--){
                    order[i]=data[j];
                    j++;
                  }
                  for(let i=0;i<order.length;i++){
                    loadNotify(order[i]);
                  }
                }
              }
            }
          }
      }else if(nCount>99){
          nCount=0;
          clearInterval(idInterval);
      }
  },50);
  }
  function voidNotify(){
    if(!notifyOptions.querySelector("a"))notifyOptions.querySelector(".unmessage").innerHTML="No hay mensajes";
    if(usersList){
      if(!usersList.querySelector("a")&&(usersList.innerHTML!="No hay usuarios disponibles para chatear"&&searchBar.value==""))usersList.innerHTML="No hay usuarios disponibles para chatear";
    }
  }
  function loadNotify(data){
    let notification=notifyOptions.querySelectorAll(".notify-options > a");
    notify.innerHTML=data['nth'];
    if(notification.length<3&&!notifyOptions.querySelector("#n-"+data['cod']+"")){
      if(data['read']>0)printNotify(notifyOptions,data);
    }
    notifies=notifyOptions.querySelectorAll("a");
    if(notifies[2])notifies[2].remove();
    if(!document.querySelector(".notify-options div a")&&notification.length>1)
      notifyOptions.insertAdjacentHTML("beforeend",`<div><a id="pulse" href="./menssages" style="padding:5px">Ver más</a></div>`);
    let globo=notifyOptions.querySelector("#n-"+data['cod']+"");
    if(globo)notifyOptions.insertBefore(globo, notifyOptions.firstChild);
    let listData=`<div class="vineta"><p class="globo">${data['read']}</p></div>`;
    if(notifyOptions.querySelector("#n-"+data['cod']+"")&&data['read']==0)notifyOptions.querySelector("#n-"+data['cod']+"").remove();
    if(notifyOptions.querySelector("#n-"+data['cod']+""))globo.querySelector(".status-dot").innerHTML=listData;
    if(data['nth']>0)notifyOptions.querySelector(".unmessage").innerHTML="";
  }
  notifyBell();
  setInterval(()=>{
    if(windowFocused==1){
      let xhr = new XMLHttpRequest(); //creating XML object
      xhr.open("POST","../database/notify",true);
      xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      if(incoming)xhr.send("incoming="+incoming.value);
      else xhr.send("0");
      xhr.onreadystatechange = function(){
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status =="200"){
          if(xhr.response!=""){
            let data=JSON.parse(xhr.response);
            if(data[0]&&data[0]['nth']!==undefined){
              //Notifications
              loadNotify(data[0]);
              //Users List
              if(usersList&&searchBar.value==""&&data[0]['read']>0){
                if(usersList.innerHTML=="No hay usuarios disponibles para chatear")usersList.innerHTML='';
                if(!usersList.querySelector("#s-"+data[0]['cod']+"")){
                  printNotify(usersList,data[0]);
                }
                let globo = usersList.querySelector(".void-chat[id*='s-"+data[0]['cod']+"']");
                let normal = usersList.querySelector("#s-"+data[0]['cod']+"");
                let listData=`<div class="vineta"><p class="globo">${data[0]['read']}</p></div>${(data['sts']!=0)?'<i class="fas fa-circle"></i>':''}`;
                if(globo){
                  globo.querySelector(".details p").innerHTML=data[0]['msg'];
                  if(globo.querySelector(".globo"))
                    if(globo.querySelector(".globo").innerHTML!=data[0]['read'])usersList.insertBefore(globo, usersList.firstChild);
                  if(!globo.querySelector(".globo")&&data[0]['read']>0)usersList.insertBefore(globo, usersList.firstChild);
                  globo.querySelector(".status-dot").innerHTML=listData;
                  globo.classList.remove();
                }else if(normal&&data[0]['read']>0){
                  normal.querySelector(".details p").innerHTML=data[0]['msg'];
                  normal.querySelector(".status-dot").innerHTML=listData;
                  usersList.insertBefore(normal, usersList.firstChild);
                }
              }
              if(usersList.querySelector("#s-"+data[0]['cod']+"")&&data[0]['read']==0)usersList.querySelector("#s-"+data[0]['cod']+"").remove();
            }else{
              voidNotify();
            }
            if(incoming)
            for(let i=0;i<data.length;i++){
              if(data[i]&&data[i]['imsg']!==null&&data[i]['imsg']!==undefined){
                listData = `<div class='chat incoming'>
                    <img src='${document.querySelector("header img").src}' alt=''>
                    <div class='details'>
                        <p>${data[i]['imsg']}</p>
                    </div>
                </div>`;
                document.querySelector(".chat-box").insertAdjacentHTML("beforeend",listData);
              }
            }
          }else{
            voidNotify();
          }
        }
      }
    }else if(windowFocused==3){
      windowFocused=1;
    }
  },1000);//this function will run frequently after 1s
  var temporizador;
  //Timer reset function
  function inactivity(){
      clearTimeout(temporizador);
      temporizador = setTimeout(function(){
        //Activated when the user is inactive
        if(windowFocused==1)window.location.href="../session/meeting?exit=1";//Here you can take the actions you want when inactivity is detected
      },300000);//5 minutes to milliseconds
  }
  //Add event listeners to track user activity
  document.addEventListener("mousemove",inactivity);
  document.addEventListener("keypress",inactivity);
  document.addEventListener("click",inactivity);
  document.addEventListener("scroll",inactivity);
  inactivity();//Start timer
})();