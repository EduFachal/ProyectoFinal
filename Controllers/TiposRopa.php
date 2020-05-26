<?php
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Validate.php");
include_once("../Models/Offer.php");
$validate = new Validate();
$menuPrint = new Menu();

// Funcion para validar si hay alguien logeado y en el caso de ser Admin le redirija a la de Admin -> Models/Validate.php
$dataTiposRopaPhp = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $buttonProfile= $menuPrint -> getMenu(1);
    $dataTiposRopaPhp["botonMenu"] = $buttonProfile;
}else{
    $buttonProfile= $menuPrint -> getMenu(0);
    $dataTiposRopaPhp["botonMenu"] = $buttonProfile;
}


$offers = new Offer();
$offersPrint = $offers -> getOffer($_POST["redirigirRopa"]);
$clotheHtml = $offers->printClothe($offersPrint,$_POST["redirigirRopa"]);

// Funcion para añadir el menu en la pagina -> Models/Funcion en PrintHtml.php
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$dataTiposRopaPhp);


//Crear vista del footer para pintarlo en Ropa.html
$footerHtml = $printer->createView("Footer",null);

//Array de datods que se van a pintar en los html
$model=[
    "menu" => $menuHtml,
    "ropa" => $clotheHtml,
    "footer" => $footerHtml 
];

// Funcion para pintar las vistas creadas en el Ropa.html
$printer->printView("Ropa", $model);
?>