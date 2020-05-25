<?php
include_once(__DIR__.'/DBModel/DBArticles.php');
class Offer{

    function getOffer($cadena){
        $article = new DBArticles();
        $articles = $article->getArticleByString($cadena);
       /* return [
            "0"=>[
                'id'=>21,
                "nombre"=>"Camiseta"],
            "1"=>[
                'id'=>22,
                "nombre"=>"Pantalon"
            ],
            "2"=>[
                'id'=>23,
                "nombre"=>"Sudadera"
            ],
            "3"=>[
                'id'=>24,
                "nombre"=>"edufeo"
            ]
        ];*/
        for ($i=0; $i < count($articles); $i++) { 
            $articles[$i]['url'] = '../Controllers/Producto.php?idArticulo='.$articles[$i]['idArticulo'];
            $articles[$i]['urlImg'] = '../Public/Img/Articles/'.$articles[$i]['idArticulo'].'.jpg';
        } 
       return $articles;
    }

    
    

    // Funcion para imprimir las ofertas, recoge la info de getOffer
    function printOffer($offersPrint){
        $htmlOffer="<ul>";

        for ($i=0; $i <count($offersPrint) ; $i++) { 
           /* $htmlOffer.="
                <li>
                   <a href='../Controllers/Producto.php?idArticulo=".$offersPrint[$i]['idArticulo']."'>".$offersPrint[$i]['nombre']."</a>
                </li>";    */
                $htmlOffer.="
                <li>
                   <a href='../Controllers/Producto.php?idArticulo=".$offersPrint[$i]['idArticulo']."'><img src='../Public/Img/Articles/".$offersPrint[$i]['idArticulo'].".jpg'></a>
                </li>";  
        }
        $htmlOffer.="</ul>";
        return $htmlOffer;
    }
}
