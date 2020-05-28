var charge = window.onload;
window.onload = function () {

    var buttonsMod = document.getElementsByClassName("updateButton");
    var buttondsDel = document.getElementsByClassName("deleteButton");
    
    for (let i = 0; i < buttonsMod.length; i++) {
        buttonsMod[i].addEventListener("click",this.updateUser);
        buttondsDel[i].addEventListener("click",this.deleteUser);
    }
}

function updateUser(e){
    var xmlhttp = new XMLHttpRequest();
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
                    window.alert("Modificado")
                    console.log(this.responseText);
                }
            }
        });

        xhr.open("POST", url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify(data));
    }
}

function deleteUser(e) {
    //console.log(e.currentTarget.getAttribute('data-id'));
    var user = e.currentTarget.getAttribute('data-id');
    const element = e.currentTarget.parentElement.parentElement;
    if (confirm("¿Estas seguro que deseas eliminar este usuario?")) {
        var data = new FormData();
        var url = "../Api/DeleteUser.php";
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
        xhr.send(JSON.stringify({ user }));
    }

}