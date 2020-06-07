<?php
include_once("../Models/Users.php");
include_once("../Models/Bill.php");
$data = json_decode( file_get_contents('php://input') );
$arrayData =(array) $data;
$user = new Users();

$arrayDataUsers = $user -> getValuesUser($arrayData["idUsuario"]);

$arrayDataBill = $user -> getProductsBill($arrayData["idFactura"]);
$objBill = new Bill();

$fileName = $objBill->getBill($arrayData["idFactura"],$arrayDataUsers,$arrayDataBill);
echo $fileName;