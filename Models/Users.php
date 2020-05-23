<?php
include_once("../Models/DBModel/DBConnection.php");

class Users extends DBConection{

    function __construct(){
        parent::__construct();
    }

    // Metodo para sacar un string con todos los usuarios de la BBDD y ponerlos en la tabla de Admin
    public function getUsers(){
        $rol=1;
        $con = $this ->conn;
        $stmt = $con ->prepare("SELECT idUsuario,usuario FROM usuarios WHERE rol=?");
        $stmt->bind_param("i",$rol);
        $stmt -> execute();
        $result = $stmt->get_result();  
        $arr="";
        while($myrow = $result->fetch_assoc()) {
           /* $arr.="<tr><td>".$myrow["idUsuario"]."</td>"
                ."<td>".$myrow["usuario"]."</td>"
                ."<td><input type='checkbox' value='".$myrow["idUsuario"]."' name='mod'".$myrow["idUsuario"]."'></td>"
                ."<td><input type='image' value='".$myrow["idUsuario"]."' name='".$myrow["idUsuari"]."' src='../Public/Img/x-icon.png' class='deleteButton'></td></tr>";*/
            $arr.="<tr><td>".$myrow["idUsuario"]."</td>"
                ."<td>".$myrow["usuario"]."</td>"
                ."<td><input type='checkbox' value='".$myrow["idUsuario"]."' name='mod'".$myrow["idUsuario"]."'></td>"
                ."<td><form method='POST' action='../Controllers/Admin.php'><input type='submit' value='".$myrow["idUsuario"]."' name='eliminar' class='deleteButton'></form></td></tr>";
        }
        $stmt->close();
        return $arr;

    }

    // Metodo para eliminar un Usuario por su iDUsuario, se genera con un form en getUsers()
    public function eliminarUsuario($id){
        $val=false;
        $con = $this ->conn;
        $intId= (int) $id;
        $stmt=$con->prepare("DELETE FROM usuarios WHERE idUsuario=? ");//ON DELETE CASCADE
        $stmt->bind_param("i",$intId);
        if($stmt->execute()){
            $val=true;
        }
        $stmt->close();
        return $val;
    }

    // Funcion para añadir cliente metiendole un array con todos los datos necesarios
    public function aniadirCliente($arrayDatos){
        $val=false;
        $con=$this -> conn;
        $rol="1";
        $stmt = $con ->prepare("SELECT MAX(idUsuario) FROM usuarios");
        $stmt -> execute();
        $stmt->bind_result($idUser);
        $stmt->fetch();
        $stmt->close();
        $idUser = $idUser + 1;
        $idUser = (int) $idUser;
        $hash=password_hash($arrayDatos[1],PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO usuarios VALUES (?,?,?,?)");
        $stmt->bind_param("isss",$idUser,$rol,$arrayDatos[0],$hash);
        if($stmt->execute()){

            
            $val=true;
            echo "se metioo";
        }
        $stmt->close();
        return $val;
    }
}