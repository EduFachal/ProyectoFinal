// Funcion para pisar el onload previo si hubiera
var charge = window.onload;
window.onload = function () {
    this.calculateTotalPriceShopCart();
    var buttondsDel = document.getElementsByClassName("deleteButton");
    
    for (let i = 0; i < buttondsDel.length; i++) {
        buttondsDel[i].addEventListener("click",deleteProduct)
    }
    document.getElementById("buttonCesta").addEventListener("click",this.saveAndCheckOut);
};

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
                    //document.getElementById("impuestos").innerHTML="";
                   // document.getElementById("dineroTotal").innerHTML="";
                    this.calculateTotalPriceShopCart();
                }
                console.log(this.responseText);
            }
        });
    
        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify({ product }));
    }
}

function saveAndCheckOut(e){
    var shopDestiny = document.getElementById("selectShop").value;
    var totalPrice = document.getElementById("dineroTotal").innerHTML;
    if (confirm("¿Desea finalizar la compra?")) {
        var data = new FormData();
        var url = "../Api/FinishShoppingCart.php";
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                var resp = JSON.parse(this.responseText)
                if (resp.status) {
                    window.alert("Exito en la compra!! Hasta pronto!!")
                }
                console.log(this.responseText);
            }
        });
    
        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify({ shopDestiny,totalPrice }));
    }
}

function calculateTotalPriceShopCart(){
    var prices = document.getElementsByClassName("totalPrice");
    var totalPrice=0;
    for (let index = 0; index < prices.length; index++) {
        totalPrice=(parseFloat(totalPrice)+parseFloat(prices[index].innerText));
    }
    document.getElementById("impuestos").innerHTML=(parseFloat(totalPrice)*0.79).toFixed(2);
    document.getElementById("dineroTotal").innerHTML=parseFloat(totalPrice).toFixed(2);
}