<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/DBModel/DBArticles.php");

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

// Pintar los productos
$articles = new DBArticles();
$articleData = $articles -> getArticleById($_GET['idArticulo']);
$menuHtml = $printer->printView("Producto",[
    "menu" => $menuHtml,
    'nombre' => $articleData['nombre'],
    'precio' => $articleData['precio'],
    'imagen' => '../Public/Img/Articles/'.$articleData['idArticulo'].'.jpg',
    'descripcion' => ''
]);

?>