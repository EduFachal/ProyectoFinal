<?php
/* PHP llamado desde FunctionsDeleteProductShoppingCart, recibe distintos datos, tienda de destino(String), precio total(Int),
   cesta de la compra con los productos deseados(Array) y el idUsuario(String).
   Verifica todos los datos, comprobacion exitencia del producto almacenado, el stock, y precio, los busca en la base de datos.
   En caso de ser todo positivo, actualiza la base de datos con el stock y elimina la cesta con todos los productos */
include_once("../Models/Users.php");
$data = json_decode( file_get_contents('php://input') );
session_start();
header('Content-Type: application/json');
$arrayData =(array) $data;
$resp=["status" => false];
if(count($arrayData)>0){
    $addDataDBPurchase = new Users();
    $resp["status"] = $addDataDBPurchase-> finishPurchase($arrayData["shopDestiny"],$arrayData["totalPrice"],$_SESSION["cesta"],$_SESSION["idUsuario"]);
    unset($_SESSION["cesta"]);
}

echo json_encode($resp);
