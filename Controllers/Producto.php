<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/DBModel/DBArticles.php");

$validate = new Validate();
$menuPrint = new Menu();

//Funcion para comprobar si estas conectado, en caso de estarlo apareceran unos botones u otros en el boton de perfil
$var = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $botones= $menuPrint -> getMenu(1);
    $var["botonMenu"] = $botones;
}else{
    $botones= $menuPrint -> getMenu(0);
    $var["botonMenu"] = $botones;
}

// Funcion para crear la vista del menu en el Producto.html
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$var);

// Funcion para recoger los datos del articulo por ID
$articles = new DBArticles();
$articleData = $articles -> getArticleById($_GET['idArticulo']);


// Comprobacion para cambiar la raiz de las imagenes
$raiz="";
if($_GET['idArticulo']<10){
    $raiz="Man";
}else if($_GET['idArticulo']>9 && $_GET['idArticulo']<19){
    $raiz="Woman";
}else{
    $raiz="Kids";
}

// Funcion para pintar el footer
$footerHtml = $printer->createView("Footer",null);


// Array con todos los valores que se pintarane en Producto.html
$model=[
    "menu" => $menuHtml,
    'nombre' => $articleData['nombre'],
    'precio' => $articleData['precio'],
    'idArticulo'=>$articleData['idArticulo'],
    'imagen' => '../Public/Img/Articles/'.$raiz.'/'.$articleData['idArticulo'].'.jpg',
    'footer' => $footerHtml
];


// Funcion para pintar las vistas creadas en el Producto.html
$menuHtml = $printer->printView("Producto",$model);

?>