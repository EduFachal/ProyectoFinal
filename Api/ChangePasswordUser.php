<?php
include_once("../Models/SendEmail.php");
include_once("../Models/Users.php");
$data = json_decode( file_get_contents('php://input') );
header('Content-Type: application/json');
$arrayData =(array) $data;
$email="";
if(count($arrayData)>0){
    $userEmail = new Users();
    $email = $userEmail-> getEmail($arrayData["usuario"]);
}
if($email!=""){
    print_r($email);
    $sendMail = new EMail();
    $sendMail-> sendMailValidateChangePassword($email);
}

echo json_encode($resp);

