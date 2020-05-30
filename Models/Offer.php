<?php
include_once(__DIR__.'/DBModel/DBArticles.php');
class Offer{

    // Funcion para sacar toda la info de los productos que se pondrán en las ofertas del Index.html
    function getOffer($sentence){
        $article = new DBArticles();
        $articles = $article->getArticleByString($sentence);
        $ruta="";
        switch($sentence){
                case "hombre":
                $ruta="Man";
                break;
                case "mujer":
                    $ruta="Woman";
                break;
                case "kids":
                    $ruta="Kids";
                break;
        }
        for ($i=0; $i < count($articles); $i++) { 
            $articles[$i]['url'] = '../Controllers/Producto.php?idArticulo='.$articles[$i]['idArticulo'];
            $articles[$i]['urlImg'] = '../Public/Img/Articles/'.$ruta.'/'.$articles[$i]['idArticulo'].'.jpg';
        } 
       return $articles;
    }

    // Funcion para imprimir las ofertas, recoge la info de getOffer y las pinta en Index.html
    function printOffer($offersPrint,$limit){
        $htmlOffer="<ul class='offerList'>";
        for ($i=0; $i <count($offersPrint) ; $i++) { 
            if($offersPrint[$i]["precio"]<$limit && $i<3){
                $htmlOffer.="
                <li>
                   <a href='../Controllers/Producto.php?idArticulo=".$offersPrint[$i]['idArticulo']."'>
                   <img src='../Public/Img/Articles/Man/".$offersPrint[$i]['idArticulo'].".jpg'>
                   <p>".$offersPrint[$i]['nombre']."</p><p>".$offersPrint[$i]['precio']."</p></a>
                </li>"; 
            }     
        }
        $htmlOffer.="</ul>";
        return $htmlOffer;
    }

    //Funcion para  la ropa de la BBDD
    function printClothe($offersPrint,$sentence){
        $ruta="";
        $name="";
        switch($sentence){
                case "hombre":
                    $ruta="Man";
                    $name="Hombre";
                break;
                case "mujer":
                    $ruta="Woman";
                    $name="mujer";
                break;
                case "kids":
                    $ruta="Kids";
                    $name="infantil";
                break;
        }
        $htmlOffer="<div class='headClothes'>CAMISETAS  ".strtoupper($name)."</div><ul class='offerList'>";

        for ($i=0; $i <count($offersPrint) ; $i++) { 
                $htmlOffer.="
                <li>
                   <a href='../Controllers/Producto.php?idArticulo=".$offersPrint[$i]['idArticulo']."'>
                   <img src='../Public/Img/Articles/".$ruta."/".$offersPrint[$i]['idArticulo'].".jpg'>
                   <p>".$offersPrint[$i]['nombre']."</p><p>".$offersPrint[$i]['precio']."</p></a>
                </li>";
                if($i==2){
                    $htmlOffer.="<div class='headClothes'>PANTALONES  ".strtoupper($name)."</div>";
                }
                if($i==5){
                    $htmlOffer.="<div class='headClothes'>ZAPATILLAS  ".strtoupper($name)."</div>";
                }
        }
        $htmlOffer.="</ul>";
        return $htmlOffer;
    }
}
