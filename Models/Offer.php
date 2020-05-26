<?php
include_once(__DIR__.'/DBModel/DBArticles.php');
class Offer{

    // Funcion para sacar toda la info de los productos que se pondrán en las ofertas del Index.html
    function getOffer($cadena){
        $article = new DBArticles();
        $articles = $article->getArticleByString($cadena);
        for ($i=0; $i < count($articles); $i++) { 
            $articles[$i]['url'] = '../Controllers/Producto.php?idArticulo='.$articles[$i]['idArticulo'];
            $articles[$i]['urlImg'] = '../Public/Img/Articles/Man/'.$articles[$i]['idArticulo'].'.jpg';
        } 
       return $articles;
    }

    // Funcion para imprimir las ofertas, recoge la info de getOffer y las pinta en Index.html
    function printOffer($offersPrint,$limite){
        $htmlOffer="<ul class='offerList'>";
        for ($i=0; $i <count($offersPrint) ; $i++) { 
            if($offersPrint[$i]["precio"]<$limite && $i<3){
                $htmlOffer.="
                <li>
                   <a href='../Controllers/Producto.php?idArticulo=".$offersPrint[$i]['idArticulo']."'><img src='../Public/Img/Articles/Man/".$offersPrint[$i]['idArticulo'].".jpg'></a>
                </li>"; 
            }     
        }
        $htmlOffer.="</ul>";
        return $htmlOffer;
    }
}
