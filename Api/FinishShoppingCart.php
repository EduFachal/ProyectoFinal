<?php
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
