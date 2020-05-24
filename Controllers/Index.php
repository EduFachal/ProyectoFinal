<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
//include_once("../Models/DBModel/DBCreation.php");

$validate = new Validate();
$menuPrint = new Menu();

$var = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $botones= $menuPrint -> getMenu(1);
    $var["botonMenu"] = $botones;
}else{
    $botones= $menuPrint -> getMenu(0);
    $var["botonMenu"] = $botones;
}

$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$var);

$offers = new Offer();
$htmlOffers = $offers->printOffer();


$bodyHtml ="<h1>Hola mundo</h1>";

$model=[
    "menu" => $menuHtml,
    "body" => $bodyHtml,
    "offer" => $htmlOffers
];

$printer->printView("Index", $model);
?>