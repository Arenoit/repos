// const taglist = document.querySelector('.wrapper .content ul'),
//


//* the taglist is the <div></div> ul where the tags will be
//* the tagNumb is the ubication <span></span> where the count tags will be
function littleTags(taglist){
    const indefact = taglist.parentElement.querySelector('input'),
    tagNumb = taglist.parentElement.parentElement.querySelector('.details p span');
    uptags=[];

    let maxTags = 10;

    countTags();
    function countTags(){
        inputItem = indefact;
        inputItem.focus();
        tagItem = tagNumb;
        tagItem.innerText = maxTags - uptags.length;// subtracting max value with tags lengs
    }
    function createsTag(label){
        const tag = document.createElement('li');
        tag.setAttribute('id','tutor');
        const input = document.createElement('input');
        input.setAttribute('type','text');
        input.setAttribute('name','colpalabras[]');
        input.setAttribute('value',label);
        input.setAttribute('style','width:0px');
        input.setAttribute('form','usrform');
        const span = document.createElement('span');
        span.innerHTML = label;
        const closeBtn = document.createElement('i');
        closeBtn.setAttribute('class','uit uit-multiply');
        closeBtn.setAttribute('data-item',label);
        closeBtn.innerHTML = '';
        tag.appendChild(input);
        tag.appendChild(span);
        tag.appendChild(closeBtn);
        return tag;
    }

    function reset(){
        taglist.querySelectorAll('li').forEach(function(tag){
            tag.parentElement.removeChild(tag);
            countTags();
        })
    }

    function addTags(){
        reset();
        uptags.slice().reverse().forEach(function(tag){
            const indefact = createsTag(tag);
            taglist.prepend(indefact);
        })
    }


    indefact.addEventListener('keyup', function(e){
        if(e.key === 'Enter'){
            let tagforbidden = e.target.value.replace(/\s+/g, ' ');
            if(tagforbidden.length > 1 && !uptags.includes(tagforbidden)){
                    tagforbidden.split(',').forEach(tagforbidden => {
                    uptags.push(tagforbidden.trim());
                    addTags();
                    indefact.value = '';
                    countTags();
                });
            }
        }
    })
    indefact.addEventListener('keydown', (e) =>{
        if(e.key=="Backspace" && indefact.value.length== 0 && uptags.length != 0){
            uptags.pop();
            longitud=uptags.length;
            taglist.querySelector("li:nth-child("+(longitud+1)+")").remove();
            countTags();
        }
    });


    document.addEventListener('click', function (e){
        if(e.target.tagName == 'I'){
            const value = e.target.getAttribute('data-item');
            const index = uptags.indexOf(value);
            uptags = [...uptags.slice(0, index),...uptags.slice(index+1)];
            addTags();
            countTags();
        }
    });
    const cliearTags = taglist.parentElement.parentElement.querySelector('button');
        cliearTags.addEventListener("click", function() {
        taglist.querySelectorAll('li').forEach(li => li.remove());
        uptags.length=0;//empty the memory space used by the array
        countTags();
    });
}