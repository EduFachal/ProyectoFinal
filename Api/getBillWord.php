<?php
include_once("../Models/Users.php");
include_once("../Models/Bill.php");
$data = json_decode( file_get_contents('php://input') );
$arrayData =(array) $data;
$user = new Users();

$arrayDataUsers = $user -> getValuesUser($arrayData["idUsuario"]);

$arrayDataBill = $user -> getProductsBill($arrayData["idFactura"]);
print_r($arrayData);
print_r($arrayDataUsers);
$objBill = new Bill();

$pr = $objBill->getBill($arrayData["idFactura"],$arrayDataUsers,$arrayDataBill);
echo json_decode($pr);