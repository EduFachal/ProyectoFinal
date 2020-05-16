<?php

class Menu {
    private $menusRoutes = [
        'home' => '',
        'mujer' => '',
        'hombre' => '',
        'niño' => '',
        'perfil' => '',
        'cesta' => ''
    ];

    function __construct(){
        
    }
    function selection( $selectionName ){
        foreach ($this->menusRoutes as $key => $value) {
            if(strtoupper($key) == strtoupper($selectionName) ){
                $this->menusRoutes[$key] = 'activo';
            }
        }
        return $this->menusRoutes;
    }
}
