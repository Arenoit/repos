function littleTags(metatags,ul) {
    const input = ul.parentElement.querySelector(".content input"),
    tagNumb = ul.parentElement.parentElement.querySelector(".details span");
    let maxTags = 10;
    //let metatags = new Array(10);

    createTag();
    countTags();

    function countTags(){
        inputItem = input;
        inputItem.focus();
        tagItem = tagNumb;
        tagItem.innerText = maxTags - metatags.length;// subtracting max value with tags lengs
    }
    function createTag(){
        ul.querySelectorAll("li").forEach(li => li.remove());// removing all li tags before adding so there will be no duplicate tags
        metatags.slice().reverse().forEach(tagl =>{
            let liTag = `<li><input type="text" name="colpalabras[]" value="${tagl}" style="width:0px" form="usrform" readonly>${tagl}<i class="uit uit-multiply"></i></li>`;
            ul.insertAdjacentHTML("afterbegin", liTag);// inserting or adding li inside ul tag
        });
        countTags();
    }
    ul.addEventListener('click', function (e){
        if(e.target.tagName == 'I'){
            value = e.target.getAttribute('data-item');
            let index  = metatags.indexOf(value);// getting removing tag index
            aux = [...metatags.slice(0, index), ...metatags.slice(index + 1)];// removing or excluding selected tag from an array
            for (let i = 0; i < metatags.length; i++) {
                aux.shift();//slice update php input is needed an auxiliar, removing duplicates
            }
            metatags=aux;
            e.target.parentElement.remove();
            countTags();
        }
    });
    input.addEventListener('keydown',(event) =>{
        if(event.key=="Backspace" && input.value.length== 0 && metatags.length != 0){
            metatags.pop();
            let j = 0;
            const fetch_assoc = document.querySelectorAll("input[name^='colpalabras']");
            for(var i in fetch_assoc) {
                //pongo los valores de fetch_array en input type=text, donde se corresponden los índices.
                j++;
            }
            restul=j-ul.querySelectorAll("li").length;
        if(j!=restul)ul.querySelector("li:nth-child("+(j-restul)+")").remove();
            countTags();
        }
    });
    function addTag(e){
        if(e.key == "Enter"){
            let tagl = e.target.value.replace(/\s+/g, ' ');// removing unwanted spaces from user tag
                tagl.split(',').forEach(tagl => {// spliting each tag from comma (,)
                    if(metatags.length<10){
                        metatags.push(tagl.trim());// adding each tag inside array
                        createTag();
                    }
                });
            e.target.value = "";
        }
    }
    input.addEventListener("keyup", addTag);
    const removeBtn = ul.parentElement.parentElement.querySelector(".details button");
    removeBtn.addEventListener("click", () =>{
        metatags.length = 0;// making array empty
        ul.querySelectorAll("li").forEach(li => li.remove());// removing all li tags
        countTags();
    });
}
