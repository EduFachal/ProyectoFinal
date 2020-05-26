<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");

//Se crea la BBDD con unos valores predeterminados
//include_once("../Models/DBModel/DBCreation.php");

$validate = new Validate();
$menuPrint = new Menu();

// Funcion para comprobar si hay usuario logeado y pintar los botones en el menu de las acciones a realizar -> Models/Validate.php
if($validate -> checkConnect()){
    $buttonProfile= $menuPrint -> getMenu(1);
    $dataControllerIndex["botonMenu"] = $buttonProfile;
}else{
    $buttonProfile= $menuPrint -> getMenu(0);
    $dataControllerIndex["botonMenu"] = $buttonProfile;
}

// Funcion para crear la vista del menu y añadirla a Models/Index.php
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$dataControllerIndex);

// Funcion para crear la vista de offers y añadirla a Models/Index.php
$offers = new Offer();
$offersPrint = $offers -> getOffer("camiseta");
$htmlOffers = $offers->printOffer($offersPrint,25);

//Crear vista del footer para pintarlo en Index.html
$footerHtml = $printer->createView("Footer",$dataControllerIndex);
$model=[
    "menu" => $menuHtml,
    "offer" => $htmlOffers,
    "footer" => $footerHtml 
];

// Funcion para pintar las vistas creadas en el Index.html
$printer->printView("Index", $model);
?>