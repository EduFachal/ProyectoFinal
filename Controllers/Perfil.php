<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/Users.php");

$validate = new Validate();
$menuPrint = new Menu();

// Funcion para validar si hay alguien logeado y en el caso de ser Admin le redirija a la de Admin -> Models/Validate.php
$dataControllerPerfil;
if($validate -> checkConnect()){
    $buttonProfile= $menuPrint -> getMenu(1);
    $dataControllerPerfil["botonMenu"] = $buttonProfile;
    if($_SESSION['rol']==0){
        header("Location: ../Controllers/Admin.php");
    }
}
// Funcion para añadir el menu en la pagina -> Models/Funcion en PrintHtml.php
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$dataControllerPerfil);

//Funcion para sacar en un array las facturas pasandole el ID usuario -> Models/Funcion en Users.php
$users = new Users();
$dataBill= $users->getFacturas($_SESSION["idUsuario"]);

//Funcion para convertir en un string el array de facturas -> Models/Users.php
$reportBill = $users->stringFacturas($dataBill);

//Creamos la vista de la tabla pasandole el string en un array a createView para despues pintarla en el perfil -> Models/PrintlHtml.php
$dataBillPrint = ["datosTabla" => $reportBill,
                "tituloTabla" => "Facturas",
                "primeraColumna" => "Id Factura",
                "segundaColumna" => "Fecha",
                "terceraColumna" => "Precio",
                "cuartaColumna" => "Descargar factura"];
$reportBillHtml = $printer->createView("TablaFacturas",$dataBillPrint);

//Rescatamos todos los valores del usuario para que se pinten en la modificación del usuario
$valuesUser = $users -> getValuesUser($_SESSION["idUsuario"]);

$dataControllerPerfil=[
    "userName"=> $valuesUser["usuario"],
    "name"=> $valuesUser["nombre"],
    "firstName"=> $valuesUser["apellidos"],
    "userEmail"=> $valuesUser["email"],
    "address"=> $valuesUser["direccion"],
    "cp"=> $valuesUser["codigoPostal"],
    "local"=> $valuesUser["localidad"],
    "province"=> $valuesUser["provincia"],
    "phoneNumber"=> $valuesUser["telefono"],
    "birthDay"=> $valuesUser["fechaNacimiento"]
];
$dataControllerPerfil["nombreFormularioCabecera"] = "Modificar Cuenta";
$dataControllerPerfil["nombreFormularioBoton"] = "Modificar";
$dataControllerPerfil["idUsuario"]=$_SESSION["idUsuario"];
$formHtml = $printer -> createView("FormMod",$dataControllerPerfil);

//Crear vista del footer para pintarlo en Perfil.html
$footerHtml = $printer->createView("Footer",$dataControllerPerfil);
$model=[
    "menu" => $menuHtml,
    "facturas" =>$reportBillHtml,
    "modificarCuenta"=>$formHtml,
    "footer" => $footerHtml 
];

// Funcion para pintar las vistas creadas en el Index.html
$printer->printView("Perfil", $model);
?>