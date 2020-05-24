<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
//include_once("../Models/DBModel/DBCreation.php");

$validate = new Validate();
$menuPrint = new Menu();

// Funcion para comprobar si hay usuario logeado y pintar los botones en el menu de las acciones a realizar -> Models/Validate.php
$var = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $botones= $menuPrint -> getMenu(1);
    $var["botonMenu"] = $botones;
}else{
    $botones= $menuPrint -> getMenu(0);
    $var["botonMenu"] = $botones;
}

// Funcion para crear la vista del menu y añadirla a Models/Index.php
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$var);

// Funcion para crear la vista de offers y añadirla a Models/Index.php
$offers = new Offer();
$htmlOffers = $offers->printOffer();

//Crear vista del footer para pintarlo en Index.html
$footerHtml = $printer->createView("Footer",$var);
$model=[
    "menu" => $menuHtml,
    "offer" => $htmlOffers,
    "footer" => $footerHtml 
];

// Funcion para pintar las vistas creadas en el Index.html
$printer->printView("Index", $model);
?>