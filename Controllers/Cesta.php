<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Menu.php");
include_once("../Models/Offer.php");
include_once("../Models/Validate.php");
include_once("../Models/Users.php");

$validate = new Validate();
$menuPrint = new Menu();

// Funcion para validar si hay alguien logeado y en el caso de ser Admin le redirija a la de Admin -> Models/Validate.php
$dataControllerCesta;
if($validate -> checkConnect()){
    $buttonProfile= $menuPrint -> getMenu(1);
    $dataControllerCesta["botonMenu"] = $buttonProfile;
    if($_SESSION['rol']==0){
        header("Location: ../Controllers/Admin.php");
    }
}else{
    header("Location: ../Controllers/Login.php");
}
// Funcion para añadir el menu en la pagina -> Models/Funcion en PrintHtml.php
$printer = new PrintHtml();
$menuHtml = $printer->createView("Menu",$dataControllerCesta);

//Funcion para convertir en un string el array de facturas -> Models/Users.php
$users = new Users();
$reportBill = $users->getShoppingCart($_SESSION["cesta"]);

//Creamos la vista de la tabla pasandole el string en un array a createView para despues pintarla en el perfil -> Models/PrintlHtml.php
$datosPrintFacturas = ["datosTabla" => $reportBill["printDataProducts"],
                "tituloTabla" => "Cesta compra",
                "primeraColumna" => "Producto",
                "segundaColumna" => "Cantidad",
                "terceraColumna" => "Precio",
                "cuartaColumna" => "Eliminar"];
$reportBillHtml = $printer->createView("TablaFacturas",$datosPrintFacturas);

//Almacena el idUsuario
$dataControllerCesta["idUsuario"]=$_SESSION["idUsuario"];

//Crear vista del footer para pintarlo en Cesta.html
$footerHtml = $printer->createView("Footer",$dataControllerCesta);
$model=[
    "menu" => $menuHtml,
    "pedido" =>$reportBillHtml,
    "footer" => $footerHtml
];

// Funcion para pintar las vistas creadas en el Cesta.html
$printer->printView("Cesta", $model);
?>