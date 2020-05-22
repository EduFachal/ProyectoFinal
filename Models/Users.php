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
        $this->destruct();
        return $arr;

    }

    // Metodo para eliminar un Usuario por su iDUsuario, se genera con un form en getUsers()
    public function eliminarUsuario($id){
        $val=false;
        $con = $this ->conn;
        $stmt=$con->prepare("DELETE FROM usuarios WHERE idUsuario=? ON DELETE CASCADE");
        $stmt->bind_param("i",$id);
        if($stmt->execute()){
            $val=true;
        }
        $stmt->close();
        $con->close();
        return $val;
    }

    public function aniadirCliente($arrayDatos){
        $val=false;
        $con=conect();
        $hash=password_hash($arrayDatos[1],PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO usuarios VALUES (?,?,?)");
        $stmt->bind_param("sss",1 , $arrayDatos[0],$hash);
        if($stmt->execute()){
            $val=true;
        }
        $stmt->close();
        $con->close();
        return $val;
    }
    /*$hash=password_hash($pass[$i],PASSWORD_DEFAULT);
            $connex->query("INSERT INTO usuarios VALUES ('($i+1)',1,'$usuarios[$i]','$hash')");
            echo "//////////////////";
            print_r($connex);*/
}