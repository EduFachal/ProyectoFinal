<?php
/* PHP llamado desde FunctionsDeleteProductShoppingCart, recibe un idProducto, lo busca en la session y lo elimina si hay coincidencia,
   en el caso de haberla, modificará el array de session con la cesta sin ese producto */
include_once("../Models/Users.php");
$data = json_decode( file_get_contents('php://input') );
session_start();
header('Content-Type: application/json');
$arrayData =(array) $data;
$array=[];
$resp=["status" => false];
if(count($arrayData)>0){
    $deleteProduct = new Users();
    $arrayBackData = $deleteProduct-> deleteProductShoppingCart($arrayData["product"],$_SESSION["cesta"]);
    $_SESSION["cesta"]=$arrayBackData;
    $resp["status"]=true;
}

echo json_encode($resp);