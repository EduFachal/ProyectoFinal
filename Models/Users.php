<?php
include_once("../Models/DBModel/DBArticles.php");
class Users extends DBConection{
    function __construct(){
        parent::__construct();
    }
    // Funcion multitabla para sacar los datos de las facturas como una array pasandole el ID del usuario
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

  //Funcion para meter un array de facturas y sacar un string en forma de filas para pintarlo posteriormente
  public function stringFacturas($arrayFacturas){
    $facturas="";
    for ($i=0; $i < count($arrayFacturas); $i++) { 
        $facturas.="<tr><td>".$arrayFacturas[$i]["idFactura"]."</td>"
            ."<td>".$arrayFacturas[$i]["fecha"]."</td>"
            ."<td>".$arrayFacturas[$i]["precio"]."</td></tr>";
    }
    return $facturas;
  }

  public function getShoppingCart($arrayProducts){
    $price;
    $priceTotal=0;
    $cart="";
    $productName="";
    $article = new DBArticles();
    for ($i=0; $i < count($arrayProducts); $i++) { 
        $price=$arrayProducts[$i]["lotProduct"]*$arrayProducts[$i]["productPrice"];
        $priceTotal=$price+$priceTotal;
        $productName = $article -> getNameArticleById($arrayProducts[$i]["idProducto"]);
        $cart.="<tr><td>".$productName."</td>"
            ."<td>".$arrayProducts[$i]["lotProduct"]."</td>"
            ."<td>".$price."</td>"
            ."<td><i class='fas fa-times deleteButton' data-id='".$arrayProducts[$i]["idProducto"]."'></td></tr>";
    }
    $arrayDataShoppingCart=[
        "printDataProducts" => $cart,
        "priceTotal" => $priceTotal];
    return $arrayDataShoppingCart;
  }
  public function deleteProductShoppingCart($idProduct,$arrayProducts){
      $newArrayProduct=[];
     foreach ($arrayProducts as $key => $value) {
         if($value["idProducto"]!=$idProduct){
            $newArrayProduct[] = $value;
         }
     }
     return $newArrayProduct;
   }
}