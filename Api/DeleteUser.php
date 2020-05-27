<?php
include_once("../Models/Admin.php");
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');
$arrayData = (array) $data;
$resp=["status" => false];
if(count($arrayData)>0){
    $deleteUser = new Admin();
    $resp["status"] = $deleteUser-> eliminarUsuario($arrayData["user"]);
}
echo json_encode($resp);