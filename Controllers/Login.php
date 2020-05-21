<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
//include_once("../Models/DBModel/DBCreation.php");
session_start();
$printer = new PrintHtml();
$nameValue="";
$passValue="";


if (isset($_POST['enviar'])) {  
	$rol = new Validate();
	$rol = $rol->comprobar_usuario($_POST['usuario'], $_POST['clave']);
	$_SESSION['rol']=$rol;
	if($rol==0){	// Admin
		//header("Location: ../Controllers/Admin.php");
	}else if($rol==1){	//Users
		header("Location: ../Controllers/Index.php");	
	}else if($rol==null){
		echo "No se puede acceder";
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