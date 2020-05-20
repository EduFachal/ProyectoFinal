<?php
include_once("../Models/DBModel/DBConnection.php");

class Validate extends DBConection{

public function comprobar_usuario($name, $clave){
    $val=null;
    $con = $this ->conn;
    $stmt = $con ->prepare("SELECT pass FROM tienda2.users WHERE nombre=?");

    $stmt->bind_param("s",$name);
    $stmt -> execute();
    $stmt->bind_result($pass_con);  
   
    if($stmt->fetch()) {
        $stmt->close();
        
        if(password_verify($clave,$pass_con)){
            $val=true;
        }
    }
    $this->destruct();
    return $val;
}

}


?>