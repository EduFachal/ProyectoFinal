// Funcion al cargar la pagina, crea eventos asociados a los botones de borrado de cada producto y evento de finalizar la compra
window.onload = function () {
    this.calculateTotalPriceShopCart();
    var buttondsDel = document.getElementsByClassName("deleteButton");
    
    for (let i = 0; i < buttondsDel.length; i++) {
        buttondsDel[i].addEventListener("click",deleteProduct)
    }
    document.getElementById("buttonCesta").addEventListener("click",this.saveAndCheckOut);
};

/* Función para borrar el producto, recoge el idProducto(int), lo busca en ../Api/DeleteShopping cart, lo elimina en casa de encontrarlo 
y despues se elimina en el elemento de esa tabla */
function deleteProduct(e) {
    var product = e.currentTarget.getAttribute('data-id');
    const element = e.currentTarget.parentElement.parentElement;
    if (confirm("¿Estas seguro que deseas eliminar este producto?")) {
        var data = new FormData();
        var url = "../Api/DeleteShoppingCart.php";
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                var resp = JSON.parse(this.responseText)
                if (resp.status) {
                    element.remove()
                    calculateTotalPriceShopCart();
                }
                console.log(this.responseText);
            }
        });
    
        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify({ product }));
    }
}

/* Función para finalizar la compra, recoge el valor de la tienda para el destino y en caso de estar finaliza la compra, la almacena en 
    la base de datos, actualiza el stock y borra la cesta de la session.
    Todas estas funciónes se llaman en FinishShoppingCart.php */
function saveAndCheckOut(e){
    var shopDestiny = document.getElementById("selectShop").value;
    var totalPrice = document.getElementById("dineroTotal").innerHTML;
    if (confirm("¿Desea finalizar la compra?")) {
        if(shopDestiny != ""){
            var data = new FormData();
            var url = "../Api/FinishShoppingCart.php";
            var xhr = new XMLHttpRequest();
            xhr.withCredentials = true;
            xhr.addEventListener("readystatechange", function () {
                if (this.readyState === 4) {
                    var resp = JSON.parse(this.responseText)
                    if (resp.status) {
                        window.alert("Exito en la compra, ¡¡Hasta pronto!!");
                        window.location.href="../Controllers/Index.php";
                    }else{
                        window.alert("No se pudo completar la compra, contacte con soporte técnico. Disculpe las molestias");
                    }
                    console.log(this.responseText);
                }
            });
        
            xhr.open("POST", url);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(JSON.stringify({ shopDestiny,totalPrice }));  
        }else{
            window.alert("Escoja una tienda de envío");
        }
        
    }
}

/* Función para generar de manera dinamica y para pintarla, todo el precio final del coste de la compra */
function calculateTotalPriceShopCart(){
    var prices = document.getElementsByClassName("totalPrice");
    var totalPrice=0;
    for (let index = 0; index < prices.length; index++) {
        totalPrice=(parseFloat(totalPrice)+parseFloat(prices[index].innerText));
        console.log(index,totalPrice)
    }
    document.getElementById("impuestos").innerHTML=(parseFloat(totalPrice)*0.79).toFixed(2);
    document.getElementById("dineroTotal").innerHTML=parseFloat(totalPrice).toFixed(2);
}