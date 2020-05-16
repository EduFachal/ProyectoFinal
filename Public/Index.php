<?php 
include_once("../Controllers/PrintHtml.php");
include_once("../Controllers/Menu.php");


$printer = new PrintHtml();
$menuPrint = new Menu();
$var = $menuPrint-> selection("home");

$menuHtml = $printer->createView("Menu",$var);

$bodyHtml ="<h1>Hola mundo</h1>";

$model=[
    "menu" => $menuHtml,
    "body" => $bodyHtml
];

$printer->printView("Index", $model);
?>