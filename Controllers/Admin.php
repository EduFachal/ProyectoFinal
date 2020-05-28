<?php 
include_once("../Models/PrintHtml.php");
include_once("../Models/Validate.php");
include_once("../Models/Admin.php");

// Funcion para validar que es un admin el que se esta metiendo en esta url
$validate= new Validate();
$validate -> validateAdmin();


// Funcion para pintar los datos de los usuarios almacenados en la Base de Datos
$printer = new PrintHtml();
$users = new Admin();
$values = $users -> getUsers();

// Información que se va a pintar en Admin.html
$model=[
    "valores" => $values
];

// Funcion para pintar esa información en Admin.html
$printer->printView("Admin", $model);
?>