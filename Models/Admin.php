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
                ."<td><i class='fas fa-user-edit updateButton' data-id='".$myrow["idUsuario"]."'></td>"
                ."<td><i class='fas fa-times deleteButton' data-id='".$myrow["idUsuario"]."'></td></tr>";
        }
        $stmt->close();
        return $arr;
    }

    // Metodo para eliminar un Usuario por su iDUsuario, se genera con un form en getUsers()
    public function eliminarUsuario($id){
        $val=false;
        $con = $this ->conn;
        $intId= (int) $id;
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
            $stmt->bind_param("sssssssssi",$arrayDatos["nombre"],$arrayDatos["apellidos"],$arrayDatos["nacimiento"],$arrayDatos["telefono"],$arrayDatos["email"],$arrayDatos["direccion"],$arrayDatos["codigoPostal"],$arrayDatos["localidad"],$arrayDatos["provincia"],$intId);
            if($stmt->execute()){
                $val=true;
            }            
        }
        $stmt->close();
        return $val;
    }

    // Funcion para rescatar el idUsuario de un user, pasandole su nick por parametro
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

    // Funcion dinamica para modificar user en funcion de los parametros que le pases en el formulario
    public function updateUser($cadena){
        $con = $this ->conn;
        $sql ="UPDATE usuarios, datosclientes SET ";
        $keys="";
        $count=1;
        $params=array();
        $cadenaDeStrings="";
        for ($i=0; $i <count($cadena) ; $i++) { 
            $cadenaDeStrings.="s";
        }
        $cadenaDeStrings = substr($cadenaDeStrings,0,-1);
        $cadenaDeStrings.="i";
        $params[0]=$cadenaDeStrings;
        foreach ($cadena as $key => $value) {
            if($key!="idUsuario"){
                $keys.=$key."=?,";
            }
            if($key != "pass"){
                    $params[$count]=&$cadena[$key];
            }else{
                    $hash=password_hash($value,PASSWORD_DEFAULT);
                    $params[$count]=&$hash;
            }
            $count++;
        }
        $keys = substr($keys,0,-1);
        $idUser=intval($params[count($params)-1]);
        $sql = $sql.$keys." WHERE usuarios.idUsuario=?";
        $stmt = $con->prepare($sql);
        $params[count($params)-1]= $idUser;
        call_user_func_array(array($stmt,"bind_param"), $params);
        $validar = false;
        if($stmt->execute()){
            $validar=true;
        }
        $stmt->close();
        return $validar;
    }
}