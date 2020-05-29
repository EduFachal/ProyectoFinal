// Funcion para pisar el onload previo si hubiera
var charge = window.onload;
window.onload = function () {
    
    document.getElementById("buttonAddProduct").addEventListener("click",this.addProductSession);
};

// Funcion con AJAX para añadir un producto a la cesta
function addProductSession() {
    var xmlhttp = new XMLHttpRequest();
    var lotProduct = document.getElementById("quantity").value;
    var idProduct = document.getElementById("buttonAddProduct").getAttribute("data-id");
    var price = document.getElementById("valueProduct").innerText;
    price = price.substr(0,price.length-2)
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
}

