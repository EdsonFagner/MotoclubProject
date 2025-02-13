var c = (el)=>document.querySelector(el);


c('.buttonCopy').addEventListener('click', (e)=>{
    e.preventDefault();
    c('.buttonCopy').innerHTML = 'Copiado';
    c('.buttonCopy').style.color = 'green';
    c('.buttonCopy').style.background = 'white';
    c('.buttonCopy').style.border = 'green 3px solid';

})


function copiarTexto() {
    var copyText = document.getElementById("codeArray");
    copyText.select();
    copyText.setSelectionRange(0, 99999); 
    navigator.clipboard.writeText(copyText.innerHTML);
}