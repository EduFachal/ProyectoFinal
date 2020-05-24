<?php
include_once("../Models/DBModel/DBConnection.php");

class Admin extends DBConection{

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
            $arr.="<tr><td>".$myrow["idUsuario"]."</td>"
                ."<td>".$myrow["usuario"]."</td>"
                ."<td><input type='checkbox' value='".$myrow["idUsuario"]."' class='checkMod'></td>"
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
        echo $intId;
        $stmt=$con->prepare("DELETE FROM usuarios WHERE idUsuario=?");
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
        $hash=password_hash($arrayDatos["pass"],PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO usuarios (rol,usuario,pass) VALUES (?,?,?)");
        $stmt->bind_param("sss",$rol,$arrayDatos["user"],$hash);
        if($stmt->execute()){
            $stmt->close();
            $intId= (int) $this->getUser($arrayDatos["user"]);
            $stmt = $con->prepare("INSERT INTO datosclientes (nombre,apellidos,fechaNacimiento,telefono,email,direccion,codigoPostal,localidad,provincia,idUsuario_user) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssi",$arrayDatos["nombre"],$arrayDatos["apellidos"],$arrayDatos["email"],$arrayDatos["direccion"],$arrayDatos["codigoPostal"],$arrayDatos["localidad"],$arrayDatos["provincia"],$arrayDatos["telefono"],$arrayDatos["nacimiento"],$intId);
            if($stmt->execute()){
                $val=true;
            }            
        }
        $stmt->close();
        return $val;
    }

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

    public function updateUser($cadena){
        $con = $this ->conn;
        $stmt = $con->prepare("UPDATE productos SET alimento=? WHERE alimento='caca'");
        $stmt->bind_param("s",$datos["alimento"]);
        $stmt -> execute(); 
        $stmt->close();
        $result = $stmt->get_result();  
        $arr="";
        while($myrow = $result->fetch_assoc()) {
          $arr=$myrow["idUsuario"];
        }
        $stmt->close();
        return $arr;
    }
}