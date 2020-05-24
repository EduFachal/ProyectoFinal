<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/Users.php");

$validate = new Validate();
$menuPrint = new Menu();

// Funcion para validar si hay alguien logeado y en el caso de ser Admin le redirija a la de Admin -> Models/Validate.php
$datosController;
if($validate -> checkConnect()){
    $botones= $menuPrint -> getMenu(1);
    $datosController["botonMenu"] = $botones;
    if($_SESSION['rol']==0){
        header("Location: ../Controllers/Admin.php");
    }
}
// Funcion para añadir el menu en la pagina -> Models/Funcion en PrintHtml.php
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$datosController);

//Funcion para sacar en un array las facturas pasandole el ID usuario -> Models/Funcion en Users.php
$users = new Users();
$datosFacturas= $users->getFacturas($_SESSION["idUsuario"]);

//Funcion para convertir en un string el array de facturas -> Models/Users.php
$tablaFacturas = $users->stringFacturas($datosFacturas);

//Creamos la vista de la tabla pasandole el string en un array a createView para despues pintarla en el perfil -> Models/PrintlHtml.php
$datosPrintFacturas = ["datosTabla" => $tablaFacturas];
$tablaFacturasHtml = $printer->createView("TablaFacturas",$datosPrintFacturas);

$datosController["nombreFormularioCabecera"] = "Modificar Cuenta";
$datosController["nombreFormularioBoton"] = "Modificar";
$formHtml = $printer -> createView("FormMod",$datosController);

//Crear vista del footer para pintarlo en Perfil.html
$footerHtml = $printer->createView("Footer",$datosController);
$model=[
    "menu" => $menuHtml,
    "facturas" =>$tablaFacturasHtml,
    "modificarCuenta"=>$formHtml,
    "footer" => $footerHtml 
];

// Funcion para pintar las vistas creadas en el Index.html
$printer->printView("Perfil", $model);
?>