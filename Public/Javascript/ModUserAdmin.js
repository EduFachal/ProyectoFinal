var charge = window.onload;

// Funciones para crear eventos asociados a los botones de modificación y borrado del usuario
window.onload = function () {

    var buttonsMod = document.getElementsByClassName("updateButton");
    var buttondsDel = document.getElementsByClassName("deleteButton");

    for (let i = 0; i < buttonsMod.length; i++) {
        buttonsMod[i].addEventListener("click", this.updateUser);
        buttondsDel[i].addEventListener("click", this.deleteUser);
    }
}

/* Funcion para modificar el usuario deseado, pasando todos los datos a un PHP (UpdateUser) para su 
    posterior modificación en la base de datos, recoge los valores en los distintos inputs(String) 
    y el idUsuario(int).
    Al realizarse el cambio se mostrará una alerta, dando a enteder que se modificó correctamente */
function updateUser(e) {
    var arrayInput = document.getElementsByTagName("input");
    var user = e.currentTarget.getAttribute('data-id');
    if (confirm("¿Estas seguro que deseas modificar este usuario?")) {
        var data = {}
        var url = "../Api/UpdateUser.php";
        for (let i = 0; i < arrayInput.length; i++) {
            if (arrayInput[i].value != "") {
                data[arrayInput[i].name] = arrayInput[i].value;
            }
        }
        data["idUsuario"] = user;
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                var resp = JSON.parse(this.responseText)
                if (resp.status) {
                    window.alert("Usuario modificado")
                    console.log(this.responseText);
                }
            }
        });

        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify(data));
    }
}

/* Funcion para borrar el usuario deseado, pasando el idUsuario  a un PHP (DeleteUser) para su posterior borrado
     en la base de datos.
    Al realizarse el cambio se mostrará una alerta, dando a enteder que se eliminó correctamente */

function deleteUser(e) {
    //console.log(e.currentTarget.getAttribute('data-id'));
    var user = e.currentTarget.getAttribute('data-id');
    const element = e.currentTarget.parentElement.parentElement;
    if (confirm("¿Estas seguro que deseas eliminar este usuario?")) {
        var url = "../Api/DeleteUser.php";
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                var resp = JSON.parse(this.responseText)
                if (resp.status) {
                    window.alert("Usuario eliminado")
                    element.remove()
                }
                console.log(this.responseText);
            }
        });

        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify({ user }));
    }

}