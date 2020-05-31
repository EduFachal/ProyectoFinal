// Funcion para pisar el onload previo si hubiera
var charge = window.onload;
window.onload = function () {
    if (charge) {
        charge();
    }
    // Funciones d eenveto asociados al boton de busqueda del producto y cuando quieres salir de los datos encontrados
    document.getElementById("backgroundOpacity").style.display="none";
    document.getElementById("buttonProduct").addEventListener("click",this.getArticleJSON);
    document.addEventListener("click",closeFind);
};

// Función para cerrar el div con los datos encontrados de la busqueda
function closeFind(){
    document.getElementById("backgroundOpacity").style.display="none";
    if(document.getElementsByClassName("articlesListMenu")[0]){
        document.getElementsByClassName("articlesListMenu")[0].style.display="none";
    }
    
}

// Función para rescatar los productos asociados a la cadena puesta en el buscador al PHP GetArticles
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

/* Función para listar los datos recogidos en la función getArticleJSON() y mostrar en el menu principal */
function actualizarListado(jsonArticles) {
    document.getElementById("backgroundOpacity").style.display="block";
    htmlArticulos = "<ul class='articlesListMenu'><h3>Elementos encontrados: </h3>";
    for (let index = 0; index < jsonArticles.length; index++) {
        const element = jsonArticles[index];
        htmlArticulos += "<li onclick='redirigir(\""+ element.url + "\")'>"+element.nombre+"<img src='"+ element.urlImg+"' alt='Este es el producto "+element.nombre+"'/></li>";
    }
    htmlArticulos += '</ul>'
    document.getElementById('articlesButtonFind').innerHTML = htmlArticulos;
}

// Función para redirigir a la url pasada por parametro(String)
function redirigir(url){
    window.location.href = url
}
