<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/Users.php");

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
    $register=new Users();
    $arrayDatosCliente= array(
        $_POST['usuario'],
        $_POST['clave']/*,
        $_POST['nombre'],
        $_POST['apellidos'],
        $_POST['email'],
        $_POST['direccion'],
        $_POST['codigoPostal'],
        $_POST['localidad'],
        $_POST['provincia'],
        $_POST['telefono'],
        $_POST['nacimiento']*/
    );
    if($register -> aniadirCliente($arrayDatosCliente)){
        echo "Exito";
    }
}


$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$var);


$model=[
    "menu" => $menuHtml
];

$printer->printView("Alta", $model);

?>