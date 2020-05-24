window.onload = function(){
    document.getElementById("modificarButton").addEventListener("click",modificarDatos);
}

function modificarDatos() {
    var das;
    
    console.log(document.getElementsByClassName("checkMod").value);
    /*var article =  document.getElementById("findProduct").value;
    
    var data = new FormData();

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            actualizarListado(JSON.parse(this.responseText))
        }
    });
    xhr.open("GET", "../Api/GetArticles.php?cadenaBusqueda="+article);

    xhr.send(data);*/
    
}