<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/Admin.php");

$validate = new Validate();
$menuPrint = new Menu();

$var = $menuPrint-> selection("home");
if($validate -> checkConnect()){
    $botones= $menuPrint -> getMenu(1);
    $var["botonMenu"] = $botones;
    
}else{
    $botones= $menuPrint -> getMenu(0);
    $var["botonMenu"] = $botones;
}

/* Metodo para registrar un usuario en Alta, instanciando un objeto de Users para luego 
    llamar a un metodo suyo que es 'registrarUsuario' */

if(isset($_POST['registrar'])){
    $register=new Admin();
    $arrayDatosCliente= array(
        "user" => $_POST['usuario'],
        "pass" => $_POST['clave'],
        "nombre" => $_POST['nombre'],
        "apellidos" => $_POST['apellidos'],
        "email" => $_POST['email'],
        "direccion" => $_POST['direccion'],
        "codigoPostal" => $_POST['codigoPostal'],
        "localidad" => $_POST['localidad'],
        "provincia" => $_POST['provincia'],
        "telefono" => $_POST['telefono'],
        "nacimiento" => $_POST['nacimiento']
    );
    $register -> aniadirCliente($arrayDatosCliente);  
}
$printer = new PrintHtml();
$formulario = $printer->createView("Form",$var);

$menuHtml = $printer->createView("Menu",$var);


$model=[
    "menu" => $menuHtml,
    "formulario" => $formulario
];

$printer->printView("Alta", $model);

?>