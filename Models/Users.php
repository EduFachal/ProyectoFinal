<?php

class Users extends DBConection{
    function __construct(){
        parent::__construct();
    }
    // Funcion multitabla para sacar los datos de las facturas pasandole el ID del usuario
    public function getFacturas($id){
        $con= $this->conn;
        $intId= (int) $id;
        $stmt = $con->prepare("SELECT idFactura,fecha,precio FROM facturas,datosclientes WHERE datosclientes.idCliente=facturas.idCliente_datos AND datosclientes.idUsuario_user=?");
        $stmt->bind_param("i",$intId);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $arrayDatos=[];
        while($myrow = $result->fetch_assoc()) {
            $articleArray= [];
            $articleArray["idFactura"] = $myrow["idFactura"];
            $articleArray["fecha"] = $myrow["fecha"];
            $articleArray["precio"] = $myrow["precio"];
            $arrayDatos[] = $articleArray;
        }
        $stmt->free_result();
        $stmt->close();
        return $arrayDatos;
  }

  public function stringFacturas($arrayFacturas){
    $facturas="";
    for ($i=0; $i < count($arrayFacturas); $i++) { 
        $facturas.="<tr><td>".$arrayFacturas[$i]["idFactura"]."</td>"
            ."<td>".$arrayFacturas[$i]["fecha"]."</td>"
            ."<td>".$arrayFacturas[$i]["precio"]."</td></tr>";
    }
    return $facturas;
  }
}