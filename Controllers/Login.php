<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
//include_once("../Models/DBModel/DBCreation.php");

$printer = new PrintHtml();
$nameValue="";
$passValue="";


if (isset($_POST['enviar'])) {  
	$rol = new Validate();
	$valorRol = $rol->comprobar_usuario($_POST['usuario'], $_POST['clave']);
	$idUser = $rol->getUser($_POST['usuario']);
	$_SESSION['idUsuario']=$idUser;
	$_SESSION['rol']=$valorRol;
	if($valorRol===0){	// Admin
		header("Location: ../Controllers/Admin.php");
	}else if($valorRol===1){	//Users
		header("Location: ../Controllers/Index.php");	
	}else if($valorRol==null || $valorRol==""){
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
