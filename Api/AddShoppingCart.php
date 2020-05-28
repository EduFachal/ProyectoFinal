<?php
header('Content-Type: application/json');
include_once("../Models/Validate.php");
include_once("../Models/DBModel/DBArticles.php");
$data = json_decode( file_get_contents('php://input') );
$validateAdd = new Validate();
$arrayData = (array) $data;
$resp=["status" => false];
$article = new DBArticles();

if($validateAdd -> checkConnect()){

    $_SESSION["cesta"] = $article 
                -> addShopCart($_SESSION["cesta"],
        ["idProducto" => $arrayData["idProduct"],
        "lotProduct" => $arrayData["lotProduct"],
        "productPrice" => $arrayData["productPrice"]]);
  
    $resp["status"]=true;
}
echo json_encode($resp);