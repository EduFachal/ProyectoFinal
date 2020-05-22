<?php
include_once("../Models/DBModel/DBConnection.php");

class Validate extends DBConection{

    function __construct(){
        session_start();
        // Llamas al constructor del padre para establecer la conexion
        parent::__construct();
    }

    public function comprobar_usuario($name, $clave){
    
    $rol=null;
    $con = $this ->conn;
    $stmt = $con ->prepare("SELECT pass FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s",$name);
    $stmt -> execute();
    $stmt->bind_result($pass_con);  
    if($stmt->fetch()) {
        $stmt->close();
        echo "1º";
        if(password_verify($clave,$pass_con)){  // hay que añadir el rol para poder comprobarlo
            echo "2º";
            $stmt = $con->prepare("SELECT rol FROM usuarios WHERE usuario=?");
			$stmt->bind_param("s",$name);
			$stmt -> execute();
			$stmt->bind_result($rol_con);
					
			if($stmt->fetch()) {
                $rol=$rol_con;
                echo "3º";
            }
            $stmt->close();
        }
    }
    $this->destruct();
    return $rol;
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

    public function validateUser(){
        //Si no hay rol le echa
        if (!isset($_SESSION['rol'])){
            $this->destroySession();    
        }
    }

    public function destroySession(){
        session_destroy(); 
        header("Location: ../Controllers/Login.php");
    }

    public function checkConnect(){
        if (isset($_SESSION['rol'])){
            return true;  
        }
        return false;
    }
}


?>