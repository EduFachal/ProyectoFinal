// Funcion para pisar el onload previo si hubiera
var charge = window.onload;
window.onload = function () {
    if (charge) {
        charge();
    }
    document.getElementById("buttonProduct").addEventListener("click",this.getArticleJSON);
};



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
    console.log(jsonArticles);
    htmlArticulos = ''
    for (let index = 0; index < jsonArticles.length; index++) {
        const element = jsonArticles[index];
        htmlArticulos += "<p onclick='redirigir(\""+ element.url + "\")'>"+element.nombre+"<img src='"+ element.urlImg+"'/></p>";
    }
    document.getElementById('articulos').innerHTML = htmlArticulos;
}
function redirigir(url){
    window.location.href = url
}
