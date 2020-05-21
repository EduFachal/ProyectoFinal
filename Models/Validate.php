<?php
include_once("../Models/DBModel/DBConnection.php");

class Validate extends DBConection{

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

}


?>