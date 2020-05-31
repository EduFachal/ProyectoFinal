<?php
include_once("../Models/DBModel/DBConnection.php");

class Validate extends DBConection{

    function __construct(){
        session_start();
        // Llamas al constructor del padre para establecer la conexion
        parent::__construct();
    }

    // Funcion para comprobar si un usuario existe en la BBDD y te saca su rol
    public function comprobar_usuario($name, $clave){
    $rol=null;
    $con = $this ->conn;
    $stmt = $con ->prepare("SELECT pass FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s",$name);
    $stmt -> execute();
    $stmt->bind_result($pass_con);  
    if($stmt->fetch()) {
        $stmt->close();
        if(password_verify($clave,$pass_con)){  // hay que añadir el rol para poder comprobarlo
            $stmt = $con->prepare("SELECT rol FROM usuarios WHERE usuario=?");
			$stmt->bind_param("s",$name);
			$stmt -> execute();
			$stmt->bind_result($rol_con);
					
			if($stmt->fetch()) {
                $rol=$rol_con;
            }
            $stmt->close();
        }
    }
    return $rol;
}

// Funcion para sacar el idUsuario a partir del usuario
public function getUser($user){
    $con = $this ->conn;
    $stmt = $con ->prepare("SELECT idUsuario FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s",$user);
    $stmt -> execute();
    $result = $stmt->get_result();  
    $arr="";
    while($myrow = $result->fetch_assoc()) {
      $arr=$myrow["idUsuario"];
    }
    $stmt->close();
    return $arr;
}


// SEGURIDAD WEB
    public function validateAdmin(){
        //Comprobar si es admin
        $this-> validateUser();
        // Reubicarle en el index
        if ($_SESSION['rol']!=0){
            header("Location: ../Controllers/Index.php");
        }
    }
    
    // Función para comprobar si el usuario conectado tiene rol asignado
    public function validateUser(){
        //Si no hay rol le echa
        if (!isset($_SESSION['rol'])){
            $this->destroySession();    
        }
    }

    // Función para destruir la sesion
    public function destroySession(){
        session_destroy(); 
        header("Location: ../Controllers/Login.php");
    }

    // Funcion para comprobar si el que está conectado es un usuario o no
    public function checkConnect(){
        if (isset($_SESSION['rol'])){
            return true;  
        }
        return false;
    }
}


?>