<?php 
include_once("../Controllers/PrintHtml.php");
include_once("../Controllers/Menu.php");
include_once("../Controllers/Offer.php");


$menuPrint = new Menu();
$var = $menuPrint-> selection("home");

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