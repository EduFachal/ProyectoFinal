<?php
include_once(__DIR__.'/DBControllers/DBArticles.php');
class Offer{

    function getOffer(){
        $a = new DBArticles();
       // echo "aaa";
        $a->getArticle(1);
        return [
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
        ];
    }
    

    // Funcion para imprimir las ofertas, recoge la info de getOffer
    function printOffer(){
        $arr = $this->getOffer();
        $htmlOffer="<ul>";

        for ($i=0; $i <count($arr) ; $i++) { 
            $htmlOffer.="
                <li>
                    <a href='../public/articulo.php?id=".$arr[$i]['id']."'>".$arr[$i]['nombre']."</a>
                </li>";    
        }
        $htmlOffer.="</ul>";
        return $htmlOffer;
    }
}
