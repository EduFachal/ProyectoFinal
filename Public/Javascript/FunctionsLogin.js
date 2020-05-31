/* Funciones de eventos asociados a los botones disponibles, ya sea mostrar recuperar contraseña,
   voler a mostrar el formulario de login, volver a la pagina de Index o la función para cambiar contraseña */

window.onload = function () {
    document.getElementById("buttonPass").addEventListener("click", getFormChangePass);
    document.getElementById("buttonNewPass").addEventListener("click", validateNewPass);
    document.getElementById("backLogin").addEventListener("click", getBackLogin);
    document.getElementById("backIndex").addEventListener("click", getBackIndex);
    document.getElementById("formNewPass").style.display = "none";
}

// Función para mostrar formulario de recuperar contraseña y ocultar el de Login
function getFormChangePass(){
    document.getElementById("cover-caption").style.display = "none";
    document.getElementById("formNewPass").style.display = "block";
}

// Función para mostrar formulario de Login y ocultar el de recuperar contraseña
function getBackLogin(){
    document.getElementById("formNewPass").style.display = "none";
    document.getElementById("cover-caption").style.display = "block";
}

// Función para volver a la página de Index
function getBackIndex(){
    window.location="../Controllers/Index.php";
}

/* Función que manda el usuario(String) y la pass nueva(String) al PHP ChangePasswordUser, el cual enviará
   un email para validar el cambio realizado a la cuenta de email asociada al usuario */
function validateNewPass(){
    var arrayInput = document.getElementsByTagName("input");
    if (confirm("¿Estas seguro que desea cambiar la contraseña?")) {
        var data = {};
        var url = "../Api/ChangePasswordUser.php";
        for (let i = 0; i < arrayInput.length; i++) {
            if (arrayInput[i].value != "Enviar solicitud" && arrayInput[i].name != "clave") { 
                data[arrayInput[i].name] = arrayInput[i].value;
            }
        }
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                var resp = JSON.parse(this.responseText)
                if (resp.status) {
                    window.alert("¡Hecho!")
                }
                console.log(this.responseText);
            }
        });
    
        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify(data));
    }
}