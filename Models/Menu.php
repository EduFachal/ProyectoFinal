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
    
    // Función que muestra los distintos tipos de enlace del boton perfil, segun si estas logeado o no
    public function getMenu($logged){
        if($logged == 0 ){
            return "<a class='dropdown-item' href='../Controllers/Login.php' longdesc='Enlace a iniciar sesion'>Iniciar Sesión</a>"
                    ."<div class='dropdown-divider'></div>"
                    ."<a class='dropdown-item' href='../Controllers/Alta.php' longdesc='Enlace a iniciar registrarse'>Registrarse</a>"; 

        }
        if($logged == 1){
            return "<a class='dropdown-item' href='../Controllers/Perfil.php' longdesc='Enlace al perfil del usuario'>Mi perfil</a>"
                ."<div class='dropdown-divider'></div>"
                ."<a class='dropdown-item' href='../Controllers/Logout.php' longdesc='Enlace a salir de la sesion'>Salir</a>"; 
        }
       
    }
}
