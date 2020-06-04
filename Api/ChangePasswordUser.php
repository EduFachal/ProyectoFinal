<?php
/* Recibe del JavaScript FunctionsLogin los parametros de pass(String),pass-rep(String) y usuario(String)
   Recoge en la funcion getEmail el email correspondiente al usuario, en el caso que tenga y las contraseñas normal 
   y repetida coincidan, se genera un id encriptado que sirva de identificador (funcion -> generateRandomString) y se 
   recoge el idUsuario (funcion -> getUser) para despues guardar esa info en una tabla temporal. Ya que el identificador 
   se le enviara al correo electronico para despues recogerlo en el archivo Password.php que se ejecutara cambiando por la 
   password nueva que estaba guardada en la tabla temporal
 */

include_once("../Models/SendEmail.php");
include_once("../Models/Users.php");
include_once("../Models/Admin.php");
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');

$arrayData =(array) $data;
$email="";
if(count($arrayData)>0){
    $userEmail = new Users();
    $email = $userEmail-> getEmail($arrayData["usuario"]);
}
if($email!="" && $arrayData["pass"]==$arrayData["pass-rep"]){
    $userObj = new Admin();
    $idUser = $userObj-> getUser($arrayData["usuario"]);
    $idStr = $userObj-> generateRandomString();

    if($userObj->insertUserStrNewPass($idStr,$idUser,$arrayData["pass"])){
        $sendMail = new EMail();
        $sendMail-> sendMailValidateChangePassword($email, $idStr); 
    }
}

echo json_encode($resp);

