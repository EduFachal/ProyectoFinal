var charge = window.onload;
window.onload = function () {
 
    document.getElementById("tablaPedidos").addEventListener("click", getFacturas);
    document.getElementById("formularioModificar").addEventListener("click", getFormCuenta);
    document.getElementById("modificar").addEventListener("click", modificarCuentaUsuario);
    document.getElementById("resultadoPedidos").style.display = "none";
    document.getElementById("modificarCuenta").style.display = "none";
}

//Funcion para pintar la tabla de pedidos del usuario
function getFacturas() {
    var espacio = document.getElementById("resalto");
    var botonPedidos = document.getElementById("resultadoPedidos");
    var botonCuenta = document.getElementById("modificarCuenta");
    if (botonPedidos.style.display === 'none') {
        botonPedidos.style.display = "block";
        botonCuenta.style.display = "none";
        espacio.style.display = "none";
    } else {
        botonPedidos.style.display = "none";
        if (botonCuenta.style.display === "none" && botonPedidos.style.display === "none") {
            espacio.style.display = "block";
        }
    }
}

//Funcion para pintar el formulario de modificacion de la cuenta
function getFormCuenta() {
    var espacio = document.getElementById("resalto");
    var botonCuenta = document.getElementById("modificarCuenta");
    var botonPedidos = document.getElementById("resultadoPedidos");
    if (botonCuenta.style.display === 'none') {
        botonCuenta.style.display = "block";
        botonPedidos.style.display = "none";
        espacio.style.display = "none";
    } else {
        botonCuenta.style.display = "none";
        if (botonCuenta.style.display === "none" && botonPedidos.style.display === "none") {
            espacio.style.display = "block";
        }
    }
}

// Funcion con Ajax para enviarle los inputs con los datos a modificar en el usuario
function modificarCuentaUsuario() {
    var xmlhttp = new XMLHttpRequest();
    var arrayInput = document.getElementsByTagName("input");
    var idUsuario = document.getElementById("modificar").getAttribute("data-id");
    
    var data = {}
    var url = "../Api/UpdateUser.php";
    for (let i = 0; i < arrayInput.length; i++) {
        if (arrayInput[i].value != "") {
            data[arrayInput[i].name] = arrayInput[i].value;
        }
    }
    data["idUsuario"]=idUsuario;
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            console.log(this.responseText);
        }
    });

    xhr.open("POST", url);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(data));
}
