<?php 
include_once("../Models/PrintHtml.php");
$printer = new PrintHtml();

$nameValue="";
$passValue="";

if (isset($_POST['enviar'])) {  
	//$valid=comprobar_usuario($_POST['usuario'], $_POST['clave']);
	$valid=false;
	$_SESSION['validar']=$valid;
	if($_POST['usuario']=="admin"){
		header("Location: Hola");
	}
	if($valid==true){	
		header("Location: sesiones1_principalUsuario_tienda2.php");	
	}else{
		$nameValue=$_POST['usuario'];
		$passValue=$_POST['clave'];
		echo "CACACA";
	}
}


$model=[
	"name" => $nameValue,
	"pass" => $passValue
];

$printer->printView("Login", $model);
?>