<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");


$validate = new Validate();
$menuPrint = new Menu();

$var = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $botones= $menuPrint -> getMenu(1);
    $var["botonMenu"] = $botones;
    if($_SESSION['rol']==0){
        header("Location: ../Controllers/Admin.php");
    }
}

$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$var);



$model=[
    "menu" => $menuHtml
];

$printer->printView("Perfil", $model);
?>