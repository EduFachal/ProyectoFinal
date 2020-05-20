<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");

session_start();
$printer = new PrintHtml();
$nameValue="";
$passValue="";


if (isset($_POST['enviar'])) {  
	$valid = new Validate();
	$valid = $valid->comprobar_usuario($_POST['usuario'], $_POST['clave']);
	$_SESSION['validar']=$valid;
	if($_POST['usuario']=="admin"){
		header("Location: ../Controllers/Admin.php");
	}
	if($valid==true){	
		header("Location: ../Controllers/Index.php");	
	}else{
		$nameValue=$_POST['usuario'];
		$passValue=$_POST['clave'];
	}
}


$model=[
	"name" => $nameValue,
	"pass" => $passValue
];

$printer->printView("Login", $model);
?>