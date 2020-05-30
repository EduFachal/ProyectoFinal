// Funcion para pisar el onload previo si hubiera
var charge = window.onload;
window.onload = function () {
    if (charge) {
        charge();
    }
    document.getElementById("backgroundOpacity").style.display="none";
    document.getElementById("buttonProduct").addEventListener("click",this.getArticleJSON);
    document.addEventListener("click",closeFind);
};

function closeFind(){
    document.getElementById("backgroundOpacity").style.display="none";
    if(document.getElementsByClassName("articlesListMenu")[0]){
        document.getElementsByClassName("articlesListMenu")[0].style.display="none";
    }
    
}

function getArticleJSON() {
    var article =  document.getElementById("findProduct").value;
    
    var data = new FormData();

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            actualizarListado(JSON.parse(this.responseText))
        }
    });
    xhr.open("GET", "../Api/GetArticles.php?cadenaBusqueda="+article);

    xhr.send(data);
    
}
function actualizarListado(jsonArticles) {
    document.getElementById("backgroundOpacity").style.display="block";
    //co1nsole.log(jsonArticles);
    htmlArticulos = "<ul class='articlesListMenu'><h3>Elementos encontrados: </h3>";
    for (let index = 0; index < jsonArticles.length; index++) {
        const element = jsonArticles[index];
        htmlArticulos += "<li onclick='redirigir(\""+ element.url + "\")'>"+element.nombre+"<img src='"+ element.urlImg+"'/></li>";
    }
    htmlArticulos += '</ul>'
    document.getElementById('articlesButtonFind').innerHTML = htmlArticulos;
}
function redirigir(url){
    window.location.href = url
}
