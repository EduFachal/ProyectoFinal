<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");


$menuPrint = new Menu();
$var = $menuPrint-> selection("home");

$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$var);

$offers = new Offer();
$htmlOffers = $offers->printOffer();


$model=[
    "menu" => $menuHtml,
    "offer" => $htmlOffers
];

$printer->printView("Login", $model);
?>