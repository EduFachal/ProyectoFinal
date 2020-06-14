// Función de evento asociado al boton añadir producto
window.onload = function () {
    document.getElementById("buttonAddProduct").addEventListener("click",this.addProductSession);
};

/* Funcion con AJAX para añadir un producto a la cesta, pasara un array con los distintos datos, ya sean cantidad(int),
   el idProducto(int) y precio(int) para mandarselos al PHP AddShoppingCart, el cual los almacenera en la sesion del usuario.
   Al finalizar la ejecución del PHP, redirigirá la pagina al Index
*/
function addProductSession() {
    var lotProduct = document.getElementById("quantity").value;
    var idProduct = document.getElementById("buttonAddProduct").getAttribute("data-id");
    var price = document.getElementById("valueProduct").innerText;
    price = price.substr(0,price.length-2)
    if(lotProduct>0){
         var data = {}
    var url = "../Api/AddShoppingCart.php";
    data["idProduct"]=idProduct;
    data["lotProduct"]=lotProduct;
    data["productPrice"]=price;
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            var resp = JSON.parse(this.responseText)
            if(!resp.status){
                window.location="../Controllers/Login.php"
            }
            window.history.back();
        }
    });

    xhr.open("POST", url);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(data)); 
    }else{
        window.alert("Escoja cantidad de producto");
    }
  
}

