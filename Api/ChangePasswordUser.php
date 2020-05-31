<?php
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
if($email!=""){
    $userObj = new Admin();
    $idUser = $userObj-> getUser($arrayData["usuario"]);
    print_r($email);
    print_r($idUser);
    $sendMail = new EMail();
    $sendMail-> sendMailValidateChangePassword($email, $idUser);
}

echo json_encode($resp);

