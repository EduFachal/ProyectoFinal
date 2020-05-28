<?php
include_once("../Models/Admin.php");
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');

$arrayData = (array) $data;
$resp=["status" => false];
if(count($arrayData)>0){
    $modificar = new Admin();
    $resp["status"] = $modificar-> updateUser($arrayData);
}
echo json_encode($resp);