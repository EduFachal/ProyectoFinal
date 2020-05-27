var charge = window.onload;
window.onload = function () {
    if (charge) {
        charge();
    }
    document.getElementById("formUpdate").style.display="none";
    var buttonsMod = document.getElementsByClassName("checkMod");
    var buttondsDel = document.getElementsByClassName("deleteButton");
    for (let i = 0; i < buttonsMod.length; i++) {
        buttonsMod[i].addEventListener("click",formUpdate);
        buttondsDel[i].addEventListener("click",this.modificarDatos);
    }
}

function formUpdate(){
    var displayForm = document.getElementById("formUpdate");
    if(displayForm.style.display == 'none'){
        displayForm.style.display = "block";
    }else{
        displayForm.style.display = "none";
    }
}

function modificarDatos(e) {

    //console.log(e.currentTarget.getAttribute('data-id'));
    var user = e.currentTarget.getAttribute('data-id');
    const element = e.currentTarget.parentElement.parentElement;
    if (confirm("Estas seguro")) {
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