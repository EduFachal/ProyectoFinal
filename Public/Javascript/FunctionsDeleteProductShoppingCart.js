// Funcion para pisar el onload previo si hubiera
var charge = window.onload;
window.onload = function () {
    
    var buttondsDel = document.getElementsByClassName("deleteButton");
    
    for (let i = 0; i < buttondsDel.length; i++) {
        buttondsDel[i].addEventListener("click",deleteProduct)
    }
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
                }
                console.log(this.responseText);
            }
        });
    
        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify({ product }));
    }
}