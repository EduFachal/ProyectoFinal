<?php
// Funciones para pintar las vistas en los controllers
class printHtml
{
    public function printView($viewName , $model ){
        $content = file_get_contents(__DIR__."/../views/".$viewName.".html");
        if($model){
            foreach ($model as $key => $value) {
                $content = str_replace("%%$key%%",$value,$content);
            }
        }
        echo $content;
    }
    public function createView($viewName , $model ){
        $content = file_get_contents(__DIR__."/../Views/".$viewName.".html");
        if($model){
            foreach ($model as $key => $value) {
                $content = str_replace("%%$key%%",$value,$content);
            }
        }
        return $content;
    }
}


?>