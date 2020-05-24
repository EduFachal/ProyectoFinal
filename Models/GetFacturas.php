<?php
header('Content-Type: application/json');
include_once("../Models/DBModel/DBArticles.php");

$validate = new Admin();
$article = new DBArticles();

// Funcion para rescatar la info del articulo en el buscador
$articles = $article -> getArticleByString($_GET['cadenaBusqueda']);
for ($i=0; $i < count($articles); $i++) { 
    $articles[$i]['url'] = '../Controllers/Producto.php?idArticulo='.$articles[$i]['idArticulo'];
    $articles[$i]['urlImg'] = '../Public/Img/Articles/'.$articles[$i]['idArticulo'].'.jpg';
}
echo json_encode($articles);
