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
    public function selection( $selectionName ){
        foreach ($this->menusRoutes as $key => $value) {
            if(strtoupper($key) == strtoupper($selectionName) ){
                $this->menusRoutes[$key] = 'activo';
            }
        }
        return $this->menusRoutes;
    }
    
    public function getMenu($logged){
        if($logged == 0 ){
            return "<a class='dropdown-item' href='../Controllers/Login.php'>Iniciar Sesión</a>"
                    ."<div class='dropdown-divider'></div>"
                    ."<a class='dropdown-item' href='../Controllers/Alta.php'>Registrarse</a>"; 

        }
        if($logged == 1){
            return "<a class='dropdown-item' href='../Controllers/Perfil.php'>Mi perfil</a>"
                ."<div class='dropdown-divider'></div>"
                ."<a class='dropdown-item' href='../Controllers/Logout.php'>Salir</a>"; 
        }
       
    }
}
