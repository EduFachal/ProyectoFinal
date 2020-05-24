<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
//include_once("../Models/DBModel/DBCreation.php");

$printer = new PrintHtml();
$nameValue="";
$passValue="";

// Funcion para loguearte en la web, ademas guarda el rol y el idUsuario en Sesion -> Models/Validate.php
if (isset($_POST['enviar'])) {  
	$rol = new Validate();
	//Comprueba si existe el usuario
	$valorRol = $rol->comprobar_usuario($_POST['usuario'], $_POST['clave']);
	//Devuelve el idUsuario pasandole el usuario
	$idUser = $rol->getUser($_POST['usuario']);
	$_SESSION['idUsuario']=$idUser;
	$_SESSION['rol']=$valorRol;
	if($valorRol===0){	// Admin
		header("Location: ../Controllers/Admin.php");
	}else if($valorRol===1){	//Users
		header("Location: ../Controllers/Index.php");	
	}else if($valorRol==null || $valorRol==""){
		//Variables para el repintado en el login
		$nameValue=$_POST['usuario'];
		$passValue=$_POST['clave'];
	}
}

/*Crear vista del footer para pintarlo en Perfil.html
$footerHtml = $printer->createView("Footer",$var);
*/
$model=[
	"name" => $nameValue,
	"pass" => $passValue/*,
	"footer" => $footerHtml */
];

// Funcion para pintar las vistas creadas en el Login.html
$printer->printView("Login", $model);
?>
