<?php
/* PHP que llama a la funcion getArticleByString para sacar todos los productos asociados a la cadena(String) recibida por metodo GET 
   del Javascript FunctionsApi, devuelve un array formado con las url de destino y de las imagenes, para poder hacer el pintado mas facil */
header('Content-Type: application/json');
include_once("../Models/DBModel/DBArticles.php");
include_once("../Models/Offer.php");
$article = new DBArticles();
$articles = $article -> getArticleByString($_GET['cadenaBusqueda']);

for ($i=0; $i < count($articles); $i++) { 
    if($articles[$i]['idArticulo']<10){
        $raiz="Man";
    }else if($articles[$i]['idArticulo']>9 && $articles[$i]['idArticulo']<19){
        $raiz="Woman";
    }else{
        $raiz="Kids";
    }
    $articles[$i]['url'] = '../Controllers/Producto.php?idArticulo='.$articles[$i]['idArticulo'];
    $articles[$i]['urlImg'] = '../Public/Img/Articles/'.$raiz.'/'.$articles[$i]['idArticulo'].'.jpg';
}
echo json_encode($articles);
