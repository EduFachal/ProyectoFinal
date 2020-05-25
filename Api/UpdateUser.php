<?php
include_once("../Models/Admin.php");
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');
$arrayDatos=(array)$data;
if(count($arrayDatos)>0){
    $modificar = new Admin();
    $validar = $modificar-> updateUser($arrayDatos);
    echo $validar;
}
