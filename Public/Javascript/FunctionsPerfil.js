window.onload = function main(){
    document.getElementById("tablaPedidos").addEventListener("click",getFacturas);
    document.getElementById("formularioModificar").addEventListener("click",this.getArticleJSON);
}

function getFacturas(){
    var op = document.getElementById("resultadoPedidos");
    if(op.style.display === 'none'){
        op.style.display="block";
    }else{
        op.style.display="none";
    }
}

function visualizar(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var datos = JSON.parse(this.response);      
        document.getElementById("resultados").innerHTML+="Id  " + "Nombre  " + "Edad  " + "Salario  <br><br>";
        for(var i=0;i<datos.length;i++){
            document.getElementById("resultados").innerHTML+=datos[i].id + "  " +
            datos[i].nombre + "  " + datos[i].edad + "  " + datos[i].salario + "<br>";
        }
        document.getElementById("resultados").innerHTML="Se actualizo correctamente";
        }
    };
    xmlhttp.open("GET", "Consulta.php", true);
    xmlhttp.send();
}
